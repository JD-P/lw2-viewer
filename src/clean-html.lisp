(defpackage #:lw2.clean-html
  (:use #:cl #:lw2.lmdb #:lw2.links)
  (:export #:clean-text #:clean-html))

(in-package #:lw2.clean-html)

(defun file-get-contents (filename)
  (with-open-file (stream filename)
    (let ((contents (make-string (file-length stream))))
      (read-sequence contents stream)
      contents)))

(defun grab-from-rts (url)
  (let* ((root (plump:parse (drakma:http-request url :close t)))
	 (post-body (plump:get-element-by-id root "wikitext")))
    (loop for cls in '("div.nav_menu" "div.imgonly" "div.bottom_nav") do
	  (loop for e across (clss:select cls post-body)
		do (plump:remove-child e))) 
    (plump:remove-child (elt (clss:select "h1" post-body) 0))
    (plump:remove-child (elt (clss:select "p" post-body) 0))
    (with-open-file (stream (merge-pathnames "./rts-content/" (subseq (puri:uri-path (puri:parse-uri url)) 1)) :direction :output :if-does-not-exist :create :external-format :utf-8) 
		 (plump:serialize post-body stream))))

(defun rts-to-html (file)
  (concatenate 'string
	       "<style>"
	       (file-get-contents "./rts-content/rts.css")
	       "</style>"
	       (file-get-contents (merge-pathnames "./rts-content/" file)))) 

(defparameter *html-overrides* (make-hash-table :test 'equal))
(loop for (id file) in '(("XTXWPQSEgoMkAupKt" "An-Intuitive-Explanation-Of-Bayess-Theorem") 
			 ("afmj8TKAqH6F2QMfZ" "A-Technical-Explanation-Of-Technical-Explanation")
			 ("7ZqGiPHTpiDMwqMN2" "The-Twelve-Virtues-Of-Rationality"))
      do (let ((file* file)) (setf (gethash id *html-overrides*) (lambda () (rts-to-html file*)))))

(eval-when (:compile-toplevel :load-toplevel :execute) 
  (defparameter *text-clean-regexps*
    (let ((data (destructuring-bind (* ((* (* inner))))
		  (with-open-file (stream "text-clean-regexps.js") (parse-js:parse-js stream))
		  inner)))
      (loop for input in data
	    collecting (destructuring-bind (* ((* regex flags) (* replacement))) input
			 (list regex flags (ppcre:regex-replace-all "\\$(\\d)" replacement "\\\\\\1"))))))) 

(defun clean-text (text)
  (macrolet ((inner () `(progn ,@(loop for (regex flags replacement) in *text-clean-regexps*
				       collecting `(setf text (ppcre:regex-replace-all
								(ppcre:create-scanner ,regex
										      ,@(loop for (flag sym) in '((#\i :case-insensitive-mode)
														  (#\m :multi-line-mode)
														  (#\s :single-line-mode)
														  (#\x :extended-mode))
											      when (find flag flags)
											      append (list sym t)))
								text ,replacement))))))
    (inner)))

(define-lmdb-memoized clean-html (in-html &key with-toc post-id)
  (labels ((tag-is (node &rest args)
		   (declare (type plump:node node)
			    (dynamic-extent args))
		   (let ((tag (plump:tag-name node)))
		     (some (lambda (x) (string= tag x))
			   args))) 
	   (only-child-is (node &rest args)
			  (declare (type plump:node node)
				   (dynamic-extent args)) 
			  (and (= 1 (length (plump:children node)))
			       (let ((child (plump:first-child node))) 
				 (and 
				   (typep child 'plump:element)
				   (apply #'tag-is (cons child args)))))) 
	   (text-node-is-not (node &rest args)
			     (declare (type plump:node node) 
				      (dynamic-extent args)) 
			     (or
			       (typep (plump:parent node) 'plump:root)
			       (every (lambda (x) (string/= (plump:tag-name (plump:parent node)) x)) args))) 
	   (string-is-whitespace (string)
				 (every (lambda (c) (cl-unicode:has-binary-property c "White_Space")) string))
	   (scan-for-urls (text-node)
			  (declare (type plump:text-node text-node)) 
			  (let ((text (plump:text text-node)))
			    (multiple-value-bind (url-start url-end) (ppcre:scan "(https?://[-a-zA-Z0-9]+\\.[-a-zA-Z0-9.]+|[-a-zA-Z0-9.]+\\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk))(\\:[0-9]+){0,1}(/[-a-zA-Z0-9.,;?'\\\\+&%$#=~_/]*)?" text)
			      (when url-start
				(let* ((url-raw (subseq text url-start url-end))
				       (url (if (mismatch "http" url-raw :end2 4) (concatenate 'string "http://" url-raw) url-raw)) 
				       (family (plump:family text-node)) 
				       (other-children (prog1
							 (subseq family (1+ (plump:child-position text-node)))
							 (setf (fill-pointer family) (1+ (plump:child-position text-node))))) 
				       (new-a (plump:make-element (plump:parent text-node) "a"))
				       (new-text (unless (= url-end (length text)) (plump:make-text-node (plump:parent text-node) (subseq text url-end))))) 
				  (setf (plump:text text-node) (subseq text 0 url-start)
					(plump:attribute new-a "href") (or (convert-lw2-link url) (convert-lw1-link url) url))
				  (plump:make-text-node new-a (clean-text url-raw))
				  (when new-text
				    (scan-for-urls new-text)
				    (setf (plump:text new-text) (clean-text (plump:text new-text))))
				  (loop for item across other-children
					do (plump:append-child (plump:parent text-node) item)))))))
	   (contents-to-html (contents min-header-level)
			     (declare (type cons contents)) 
			     (format nil "<div class=\"contents\"><div class=\"contents-head\">Contents</div><ul class=\"contents-list\">~{~A~}</ul></div>"
				     (map 'list (lambda (x) (destructuring-bind (elem-level text id) x
							      (format nil "<li class=\"toc-item-~A\"><a href=\"#~A\">~A</a></li>"
								      (- elem-level (- min-header-level 1)) id text)))
					  contents)))
	   (style-hash-to-html (style-hash)
			       (declare (type hash-table style-hash))
			       (let ((style-list (alexandria:hash-table-keys style-hash)))
				 (if style-list
				   (format nil "<style>~{~A~}</style>" style-list)
				   ""))))
    (handler-bind
      (((or plump:invalid-xml-character plump:discouraged-xml-character) #'abort))
      (alexandria:if-let
	(override (gethash post-id *html-overrides*))
	(funcall override) 
	(let ((root (plump:parse (string-trim '(#\Space #\Newline #\Tab #\Return #\Linefeed #\Page) in-html)))
	      (contents nil)
	      (section-count 0)
	      (min-header-level 6) 
	      (aggressive-deformat nil) 
	      (style-hash (make-hash-table :test 'equal)))
	  (loop while (and (= 1 (length (plump:children root))) (typep (plump:first-child root) 'plump:element) (tag-is (plump:first-child root) "div"))
		do (setf (plump:children root) (plump:children (plump:first-child root)))) 
	  (plump:traverse root (lambda (node)
				 (typecase node
				   (plump:text-node 
				     (when (text-node-is-not node "a" "style" "pre")
				       (scan-for-urls node))
				     (when (text-node-is-not node "style" "pre" "code")
				       (setf (plump:text node) (clean-text (plump:text node)))))
				   (plump:element
				     (alexandria:when-let (style (plump:attribute node "style"))
							  (when (or aggressive-deformat (search "font-family" style))
							    (setf aggressive-deformat t) 
							    (plump:remove-attribute node "style"))) 
				     (when (and aggressive-deformat (tag-is node "div"))
				       (setf (plump:tag-name node) "p")) 
				     (when (tag-is node "a")
				       (let ((href (plump:attribute node "href")))
					 (when href
					   (let ((new-link (or (convert-lw2-link href) (convert-lw1-link href))))
					     (when new-link
					       (setf (plump:attribute node "href") new-link)))))
				       (when (only-child-is node "u")
					 (setf (plump:children node) (plump:children (plump:first-child node)))))
				     (when (tag-is node "p" "blockquote" "div")
				       (when (string-is-whitespace (plump:text node))
					 (plump:remove-child node)))
				     (when (tag-is node "u")
				       (when (only-child-is node "a")
					 (plump:replace-child node (plump:first-child node)))) 
				     (when (tag-is node "ul" "ol")
				       (loop for n across (plump:child-elements node)
					     when (tag-is n "ul" "ol")
					     do (let ((ps (or (plump:previous-sibling n) (let ((ps (plump:make-element node "li")))
											   (plump:remove-child ps)
											   (plump:insert-before (plump:first-child node) ps)
											   ps))))
						  (plump:remove-child n)
						  (plump:append-child ps n))))
				     (when (and (tag-is node "li") (let ((c (plump:first-child node))) (or (if (plump:text-node-p c) (not (string-is-whitespace (plump:text c))) (not (tag-is c "p" "ul" "ol"))))))
				       (let ((p (plump:make-element node "p")))
					 (plump:remove-child p)
					 (setf (plump:children p) (plump:clone-children node t p)
					       (plump:children node) (plump:ensure-child-array (vector)))
					 (plump:append-child node p)))
				     (when (and with-toc (ppcre:scan "^h[1-6]$" (plump:tag-name node)))
				       (incf section-count) 
				       (unless (plump:attribute node "id") (setf (plump:attribute node "id") (format nil "section-~A" section-count))) 
				       (let ((header-level (parse-integer (subseq (plump:tag-name node) 1))))
					 (setf min-header-level (min min-header-level header-level)) 
					 (push (list header-level
						     (plump:text node)
						     (plump:attribute node "id"))
					       contents)))
				     (when (tag-is node "style")
				       (setf (gethash (plump:text node) style-hash) t)
				       (plump:remove-child node)))))) 
	  (concatenate 'string (if (> section-count 3) (contents-to-html (nreverse contents) min-header-level) "") 
		       (style-hash-to-html style-hash) 
		       (plump:serialize root nil)))))))