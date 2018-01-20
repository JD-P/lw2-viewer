(defpackage #:lw2-viewer
  (:use #:cl #:sb-thread #:flexi-streams #:lw2-viewer.config #:lw2.lmdb #:lw2.backend #:lw2.links #:lw2.clean-html #:lw2.login))

(in-package #:lw2-viewer) 

(defvar *current-auth-token*) 

(defvar *memory-intensive-mutex* (sb-thread:make-mutex :name "memory-intensive-mutex")) 

(defun logged-in-userid (&optional is-userid)
  (let ((current-userid (and *current-auth-token* (cache-get "auth-token-to-userid" *current-auth-token*))))
    (if is-userid
      (string= current-userid is-userid)
      current-userid))) 
(defun logged-in-username ()
  (and *current-auth-token* (cache-get "auth-token-to-username" *current-auth-token*))) 

(defun pretty-time (timestring &key format)
  (let ((time (local-time:parse-timestring timestring)))
  (values (local-time:format-timestring nil time :timezone local-time:+utc-zone+ :format (or format '(:day #\  :short-month #\  :year #\  :hour #\: (:min 2) #\  :timezone)))
	  (* (local-time:timestamp-to-unix time) 1000))))

(defun post-headline-to-html (post)
  (multiple-value-bind (pretty-time js-time) (pretty-time (cdr (assoc :posted-at post))) 
    (format nil "<h1 class=\"listing\"><a href=\"~A\">~A</a></h1><div class=\"post-meta\"><div class=\"author\">~A</div> <div class=\"date\" data-js-date=\"~A\">~A</div><div class=\"karma\">~A point~:P</div><a class=\"comment-count\" href=\"~A#comments\">~A comment~:P</a><a class=\"lw2-link\" href=\"~A\">LW2 link</a>~A</div>"
	    (plump:encode-entities (or (cdr (assoc :url post)) (generate-post-link post))) 
	    (plump:encode-entities (clean-text (cdr (assoc :title post))))
	    (plump:encode-entities (get-username (cdr (assoc :user-id post))))
	    js-time
	    pretty-time
	    (cdr (assoc :base-score post))
	    (generate-post-link post) 
	    (or (cdr (assoc :comment-count post)) 0) 
	    (cdr (assoc :page-url post))
	    (if (cdr (assoc :url post)) (format nil "<div class=\"link-post\">(~A)</div>" (plump:encode-entities (puri:uri-host (puri:parse-uri (cdr (assoc :url post)))))) "")))) 

(defun posts-to-rss (posts out-stream)
  (with-recursive-lock (*memory-intensive-mutex*) 
    (xml-emitter:with-rss2 (out-stream :encoding "UTF-8")
      (xml-emitter:rss-channel-header "LessWrong 2 viewer" *site-uri*
				      :description "LessWrong 2 viewer") 
      (dolist (post posts)
	(xml-emitter:rss-item
	  (clean-text (cdr (assoc :title post)))
	  :link (generate-post-link post nil t)
	  :author (get-username (cdr (assoc :user-id post)))
	  :pubDate (pretty-time (cdr (assoc :posted-at post)) :format local-time:+rfc-1123-format+)
	  :description (clean-html (or (cdr (assoc :html-body (get-post-body (cdr (assoc :--id post)) :revalidate nil))) "") :post-id (cdr (assoc :--id post)))))))) 

(defun post-body-to-html (post)
  (multiple-value-bind (pretty-time js-time) (pretty-time (cdr (assoc :posted-at post))) 
    (format nil "<div class=\"post\"><h1>~A</h1><div class=\"post-meta\"><div class=\"author\">~A</div> <div class=\"date\" data-js-date=\"~A\">~A</div><div class=\"karma\" data-post-id=\"~A\">~A point~:P</div><a class=\"comment-count\" href=\"#comments\">~A comment~:P</a><a class=\"lw2-link\" href=\"~A\">LW2 link</a><a href=\"#bottom-bar\"></a></div><div class=\"post-body\">~A</div></div>"
	    (plump:encode-entities (clean-text (cdr (assoc :title post))))
	    (plump:encode-entities (get-username (cdr (assoc :user-id post))))
	    js-time
	    pretty-time
	    (cdr (assoc :--id post)) 
	    (cdr (assoc :base-score post))
	    (or (cdr (assoc :comment-count post)) 0) 
	    (cdr (assoc :page-url post)) 
	    (format nil "~A~A"
		    (if (cdr (assoc :url post)) (format nil "<p><a href=\"~A\">Link post</a></p>" (plump:encode-entities (cdr (assoc :url post)))) "")
		    (clean-html (or (cdr (assoc :html-body post)) "") :with-toc t :post-id (cdr (assoc :--id post))))))) 

(defun comment-to-html (comment &key with-post-title)
  (multiple-value-bind (pretty-time js-time) (pretty-time (cdr (assoc :posted-at comment))) 
    (format nil "<div class=\"comment\"><div class=\"comment-meta\"><div class=\"author\">~A</div> <a class=\"date\" href=\"~A\" data-js-date=\"~A\">~A</a><div class=\"karma\">~A point~:P</div><a class=\"lw2-link\" href=\"~A#~A\">LW2 link</a>~A</div><div class=\"comment-body\"~@[ data-markdown-source=\"~A\"~]>~A</div></div>"
	    (get-username (cdr (assoc :user-id comment))) 
	    (generate-post-link (cdr (assoc :post-id comment)) (cdr (assoc :--id comment)))
	    js-time
	    pretty-time
	    (cdr (assoc :base-score comment))
	    (cdr (assoc :page-url comment)) 
	    (cdr (assoc :--id comment)) 
	    (if with-post-title
	      (format nil "<div class=\"comment-post-title\">on: <a href=\"~A\">~A</a></div>"
		      (generate-post-link (cdr (assoc :post-id comment)))
		      (plump:encode-entities (clean-text (get-post-title (cdr (assoc :post-id comment))))))
	      (format nil "~@[<a class=\"comment-parent-link\" href=\"#comment-~A\">Parent</a>~]" (cdr (assoc :parent-comment-id comment)))) 
	    (if (logged-in-userid (cdr (assoc :user-id comment)))
	      (plump:encode-entities
		(or (cache-get "comment-markdown-source" (cdr (assoc :--id comment))) 
		    (cdr (assoc :html-body comment)))))
	    (clean-html (cdr (assoc :html-body comment)))))) 

(defun make-comment-parent-hash (comments)
  (let ((hash (make-hash-table :test 'equal)))
    (dolist (c comments)
      (let* ((parent-id (cdr (assoc :parent-comment-id c)))
	     (old (gethash parent-id hash)))
	(setf (gethash parent-id hash) (cons c old))))
    (maphash (lambda (k old)
	       (setf (gethash k hash) (nreverse old)))
	     hash)
    (labels
      ((count-children (parent)
	(let ((children (gethash (cdr (assoc :--id parent)) hash)))
	  (+ (length children) (apply #'+ (map 'list #'count-children children))))) 
       (add-child-counts (comment-list) 
	(loop for c in comment-list
	      as id = (cdr (assoc :--id c)) 
	      do (setf (gethash id hash) (add-child-counts (gethash id hash))) 
	      collecting (cons (cons :child-count (count-children c)) c))))
      (setf (gethash nil hash) (add-child-counts (gethash nil hash)))) 
    hash)) 

(defun comment-tree-to-html (comment-hash &optional (target nil) (level 0))
  (let ((comments (gethash target comment-hash)))
    (if comments 
      (format nil "<ul class=\"comment-thread\">~{~A~}</ul>"
	      (map 'list (lambda (c)
			   (let ((c-id (cdr (assoc :--id c)))) 
			   (format nil "<li id=\"comment-~A\" class=\"comment-item\">~A~A~A</li>"
				   c-id
				   (comment-to-html c)
				   (if (and (= level 10) (gethash c-id comment-hash))
				     (format nil "<input type=\"checkbox\" id=\"expand-~A\"><label for=\"expand-~:*~A\" data-child-count=\"~A comment~:P\">Expand this thread</label>"
					     c-id
					     (cdr (assoc :child-count c)))
				     "") 
				   (comment-tree-to-html comment-hash c-id (1+ level)))))
		   comments))
      ""))) 

(defparameter *html-head*
"<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<link rel=\"stylesheet\" href=\"//fonts.greaterwrong.com/?fonts=Charter,Concourse,a_Avante\">")

(defun generate-versioned-link (file)
  (format nil "~A?v=~A" file (sb-posix:stat-mtime (sb-posix:stat (format nil "www~A" file))))) 

(defun search-bar-to-html ()
  (declare (special *current-search-query*))
  (let ((query (and (boundp '*current-search-query*) (hunchentoot:escape-for-html *current-search-query*))))
    (format nil "<form action=\"/search\" class=\"nav-inner\"><input name=\"q\" type=\"search\" ~@[value=\"~A\"~] autocomplete=\"off\"><button>Search</button></form>" query)))  

(defparameter *primary-nav* '(("home" "/" "Home" :description "Latest frontpage posts" :accesskey "h")
			      ("featured" "/index?view=featured" "Featured" :description "Latest featured posts" :accesskey "f")
			      ("all" "/index?view=new&all=t" "All" :description "Latest frontpage posts and userpage posts" :accesskey "a") 
			      ("meta" "/index?view=meta&all=t" "Meta" :description "Latest meta posts" :accesskey "m")
			      ("recent-comments" "/recentcomments" "<span>Recent </span>Comments" :description "Latest comments" :accesskey "c"))) 

(defparameter *secondary-nav* `(("archive" "/archive" "Archive")
				("search" "/search" "Search" :html ,#'search-bar-to-html)
				("login" "/login" "Log In"))) 

(defun nav-bar-to-html (&optional current-uri)
  (let ((primary-bar "primary-bar")
	(secondary-bar "secondary-bar")
	active-bar) 
    (labels ((nav-bar-inner (bar-id items) 
			    (format nil "~{~A~}"
				    (maplist (lambda (items)
					       (let ((item (first items))) 
						 (destructuring-bind (id uri name &key description html accesskey) item
						   (if (string= uri current-uri)
						     (progn (setf active-bar bar-id) 
							    (format nil "<span id=\"nav-item-~A\" class=\"nav-item nav-current\" ~@[title=\"~A\"~]>~:[<span class=\"nav-inner\">~A</span>~;~:*~A~]</span>"
								    id description (and html (funcall html)) name)) 
						     (format nil "<span id=\"nav-item-~A\" class=\"nav-item nav-inactive~:[~; nav-item-last-before-current~]\" ~@[title=\"~A\"~]>~:[<a href=\"~A\" class=\"nav-inner\" ~@[accesskey=\"~A\"~]>~A</a>~;~:*~A~]</span>"
							     id (string= (nth 1 (cadr items)) current-uri) (if accesskey (format nil "~A [~A]" description accesskey) description) (and html (funcall html)) uri accesskey name)))))
					 items)))
	     (nav-bar-outer (id class html)
			    (format nil "<div id=\"~A\" class=\"nav-bar ~A\">~A</div>" id class html)))
      (let ((primary-html (nav-bar-inner primary-bar *primary-nav*))
	    (secondary-html (nav-bar-inner secondary-bar *secondary-nav*)))
	(if (eq active-bar secondary-bar) 
	  (format nil "~A~A" (nav-bar-outer primary-bar "inactive-bar" primary-html) (nav-bar-outer secondary-bar "active-bar" secondary-html))
	  (format nil "~A~A" (nav-bar-outer secondary-bar "inactive-bar" secondary-html) (nav-bar-outer primary-bar "active-bar" primary-html))))))) 

(defun user-nav-bar (&optional current-uri)
  (let* ((username (logged-in-username)))
    (let ((*secondary-nav* `(("archive" "/archive" "Archive")
			     ("search" "/search" "Search" :html ,#'search-bar-to-html)
			     ,(if username
				`("login" "/login" ,(plump:encode-entities username))
				`("login" ,(format nil "/login?return=~A" (url-rewrite:url-encode current-uri)) "Log In")))))
      (nav-bar-to-html current-uri)))) 

(defparameter *bottom-bar*
"<div id=\"bottom-bar\" class=\"nav-bar\"><a class=\"nav-item nav-current nav-inner\" href=\"#top\">Back to top</a></div>") 

(defun make-csrf-token (session-token &optional (nonce (ironclad:make-random-salt)))
  (if (typep session-token 'string) (setf session-token (base64:base64-string-to-usb8-array session-token)))
  (let ((csrf-token (concatenate '(vector (unsigned-byte 8)) nonce (ironclad:digest-sequence :sha256 (concatenate '(vector (unsigned-byte 8)) nonce session-token)))))
    (values (base64:usb8-array-to-base64-string csrf-token) csrf-token))) 

(defun check-csrf-token (session-token csrf-token)
  (let* ((session-token (base64:base64-string-to-usb8-array session-token))
	 (csrf-token (base64:base64-string-to-usb8-array csrf-token))
	 (correct-token (nth-value 1 (make-csrf-token session-token (subseq csrf-token 0 16)))))
    (assert (ironclad:constant-time-equal csrf-token correct-token) nil "CSRF check failed.")
    t)) 

(defun begin-html (out-stream &key title description current-uri content-class)
  (let* ((session-token (hunchentoot:cookie-in "session-token"))
	 (csrf-token (and session-token (make-csrf-token session-token)))) 
    (format out-stream "<!DOCTYPE html><html lang=\"en-US\"><head><title>~@[~A - ~]LessWrong 2 viewer</title>~@[<meta name=\"description\" content=\"~A\">~]~A<link rel=\"stylesheet\" href=\"~A\"><link rel=\"shortcut icon\" href=\"~A\"><script src=\"~A\" async></script><script src=\"~A\" async></script>~@[<script>var csrfToken=\"~A\"</script>~]</head><body><div id=\"content\"~@[ class=\"~A\"~]>~A"
	    title description
	    *html-head* (generate-versioned-link "/style.css") (generate-versioned-link "/favicon.ico") (generate-versioned-link "/script.js") (generate-versioned-link "/guiedit.js")
	    csrf-token
	    content-class
	    (user-nav-bar (or current-uri (hunchentoot:request-uri*)))))
  (force-output out-stream)) 

(defun end-html (out-stream)
  (format out-stream "~A</div></body></html>" *bottom-bar*)) 

(defun map-output (out-stream fn list)
  (loop for item in list do (write-string (funcall fn item) out-stream))) 

(defmacro with-outputs ((out-stream) &body body) 
  (alexandria:with-gensyms (stream-sym) 
			   (let ((out-body (map 'list (lambda (x) `(princ ,x ,stream-sym)) body)))
			     `(let ((,stream-sym ,out-stream)) 
				,.out-body)))) 

(defmacro emit-page ((out-stream &key title description current-uri content-class (return-code 200)) &body body)
  `(ignore-errors
     (log-conditions
       (setf (hunchentoot:content-type*) "text/html; charset=utf-8"
	     (hunchentoot:return-code*) ,return-code)
       (let ((,out-stream (make-flexi-stream (hunchentoot:send-headers) :external-format :utf-8)))
	 (begin-html ,out-stream :title ,title :description ,description :current-uri ,current-uri :content-class ,content-class)
	 ,@body
	 (end-html ,out-stream)))))

(defmacro with-error-page (&body body)
  `(let ((*current-auth-token* (hunchentoot:cookie-in "lw2-auth-token")))
     (handler-case
       (log-conditions 
	 (progn ,@body))
       (serious-condition (condition)
			  (emit-page (out-stream :title "Error" :return-code 500) 
				     (format out-stream "<h1>Error</h1><p>~A</p>"
					     condition)))))) 

(defun view-posts-index (posts)
  (alexandria:switch ((hunchentoot:get-parameter "format") :test #'string=)
		     ("rss" 
		      (setf (hunchentoot:content-type*) "application/rss+xml; charset=utf-8")
		      (let ((out-stream (hunchentoot:send-headers)))
			(posts-to-rss posts (make-flexi-stream out-stream :external-format :utf-8))))
		     (t
		       (emit-page (out-stream :description "A faster way to browse LessWrong 2.0") 
				  (format out-stream "<a class=\"rss\" rel=\"alternate\" type=\"application/rss+xml\" href=\"~A?~@[~A&~]format=rss\">RSS</a>"
					  (hunchentoot:script-name*) (hunchentoot:query-string*)) 
				  (map-output out-stream #'post-headline-to-html posts))))) 

(hunchentoot:define-easy-handler (view-root :uri "/") ()
				 (with-error-page (view-posts-index (get-posts))))

(hunchentoot:define-easy-handler (view-index :uri "/index") (view all meta before after)
				 (with-error-page
				   (let ((posts (lw2-graphql-query (make-posts-list-query :view (or view "new") :frontpage (not all) :meta (not (not meta)) :before before :after after))))
				     (view-posts-index posts)))) 

(hunchentoot:define-easy-handler (view-post :uri "/post") (id)
				 (with-error-page
				   (unless (and id (not (equal id ""))) (error "No post ID.")) 
				   (setf (hunchentoot:return-code*) 301
					 (hunchentoot:header-out "Location") (generate-post-link id)))) 

(hunchentoot:define-easy-handler (view-post-lw1-link :uri (lambda (r) (match-lw1-link (hunchentoot:request-uri r)))) ()
				 (with-error-page
				   (let ((location (convert-lw1-link (hunchentoot:request-uri*)))) 
				     (setf (hunchentoot:return-code*) 301
					   (hunchentoot:header-out "Location") location)))) 

(hunchentoot:define-easy-handler (view-feed :uri "/feed") (view all meta before after)
				 (setf (hunchentoot:content-type*) "application/rss+xml; charset=utf-8")
				 (let ((posts (lw2-graphql-query (make-posts-list-query :view (or view "new") :frontpage (not all) :meta (not (not meta)) :before before :after after)))
				       (out-stream (hunchentoot:send-headers)))
				   (posts-to-rss posts (make-flexi-stream out-stream :external-format :utf-8)))) 

(hunchentoot:define-easy-handler (view-post-lw2-link :uri (lambda (r) (declare (ignore r)) (match-lw2-link (hunchentoot:request-uri*)))) ((csrf-token :request-type :post) (text :request-type :post) (parent-comment-id :request-type :post) (edit-comment-id :request-type :post))
				 (with-error-page
				   (cond
				     (text
				       (check-csrf-token (hunchentoot:cookie-in "session-token") csrf-token)
				       (let ((lw2-auth-token (hunchentoot:cookie-in "lw2-auth-token"))
					     (post-id (match-lw2-link (hunchentoot:request-uri*)))) 
					 (assert (and lw2-auth-token (not (string= text ""))))
					 (let* ((comment-data `(("body" . ,text) ,(if (not edit-comment-id) `("postId" . ,post-id)) ,(if parent-comment-id `("parentCommentId" . ,parent-comment-id)) ("content" . ("blocks" . nil)))) 
						(new-comment-id
						  (if edit-comment-id
						    (prog1 edit-comment-id
						      (do-lw2-comment-edit lw2-auth-token edit-comment-id comment-data))
						    (do-lw2-comment lw2-auth-token comment-data))))
					   (cache-put "comment-markdown-source" new-comment-id text)
					   (setf (hunchentoot:return-code*) 303
						 (hunchentoot:header-out "Location") (generate-post-link (match-lw2-link (hunchentoot:request-uri*)) new-comment-id)))))
				     (t 
				       (multiple-value-bind (post-id comment-id) (match-lw2-link (hunchentoot:request-uri*))
					 (if comment-id 
					   (setf (hunchentoot:return-code*) 303
						 (hunchentoot:header-out "Location") (generate-post-link post-id comment-id))
					   (let ((post (get-post-body post-id))
						 (lw2-auth-token (hunchentoot:cookie-in "lw2-auth-token")))
					     (emit-page (out-stream :title (clean-text (cdr (assoc :title post)))) 
							(with-outputs (out-stream) (post-body-to-html post))
							(if lw2-auth-token
							  (format out-stream "<script>postVote=~A</script>" (json:encode-json-to-string (get-post-vote post-id lw2-auth-token)))) 
							(force-output out-stream) 
							(format out-stream "<div id=\"comments\">~A</div>"
								(let ((comments (get-post-comments post-id)))
								  (comment-tree-to-html (make-comment-parent-hash comments))))
							(if lw2-auth-token
							  (format out-stream "<script>commentVotes=~A</script>" (json:encode-json-to-string (get-post-comments-votes post-id lw2-auth-token)))))))))))) 

(hunchentoot:define-easy-handler (view-karma-vote :uri "/karma-vote") ((csrf-token :request-type :post) (target :request-type :post) (target-type :request-type :post) (vote-type :request-type :post))
				 (check-csrf-token (hunchentoot:cookie-in "session-token") csrf-token)
				 (let ((lw2-auth-token (hunchentoot:cookie-in "lw2-auth-token")))
				   (multiple-value-bind (points vote-type) (do-lw2-vote lw2-auth-token target target-type vote-type)
				     (json:encode-json-to-string (list (format nil "~A point~:P" points) vote-type)))))

(hunchentoot:define-easy-handler (view-recent-comments :uri "/recentcomments") ()
				 (with-error-page
				   (let ((recent-comments (get-recent-comments)))
				     (emit-page (out-stream :title "Recent comments" :description "A faster way to browse LessWrong 2.0") 
						(with-outputs (out-stream) "<ul class=\"comment-thread\">") 
						(map-output out-stream (lambda (c) (format nil "<li class=\"comment-item\" id=\"comment-~A\">~A</li>"
											   (cdr (assoc :--id c)) (comment-to-html c :with-post-title t))) recent-comments)
						(with-outputs (out-stream) "</ul>")))))

(defun search-result-markdown-to-html (item)
  (cons (cons :html-body (markdown:parse (cdr (assoc :body item)))) item)) 

(hunchentoot:define-easy-handler (view-search :uri "/search") (q)
				 (with-error-page
				   (let ((*current-search-query* q)) 
				     (declare (special *current-search-query*)) 
				     (multiple-value-bind (posts comments) (lw2-search-query q)
				       (emit-page (out-stream :title "Search" :current-uri "/search" :content-class "search-results-page")
						  (map-output out-stream #'post-headline-to-html posts)
						  (with-outputs (out-stream) "<ul class=\"comment-thread\">") 
						  (map-output out-stream (lambda (c) (format nil "<li class=\"comment-item\">~A</li>" (comment-to-html (search-result-markdown-to-html c) :with-post-title t))) comments)
						  (with-outputs (out-stream) "</ul>")))))) 

(defun output-form (out-stream method action id class csrf-token fields button-label)
  (format out-stream "<form method=\"~A\" action=\"~A\" id=\"~A\" class=\"~A\"><div>" method action id class)
  (loop for (id label type autocomplete) in fields
	do (format out-stream "<div><label for=\"~A\">~A:</label><input type=\"~A\" name=\"~A\" autocomplete=\"~A\"></div>" id label type id autocomplete))
  (format out-stream "<div><input type=\"hidden\" name=\"csrf-token\" value=\"~A\"><input type=\"submit\" value=\"~A\"></div></div></form>" csrf-token button-label)) 

(hunchentoot:define-easy-handler (view-login :uri "/login") (return cookie-check (csrf-token :request-type :post) (login-username :request-type :post) (login-password :request-type :post)
								    (signup-username :request-type :post) (signup-email :request-type :post) (signup-password :request-type :post) (signup-password2 :request-type :post))
				 (with-error-page
				   (labels
				     ((emit-login-page (&key error-message)
					(let ((csrf-token (make-csrf-token (hunchentoot:cookie-in "session-token"))))
					  (emit-page (out-stream :title "Log in" :current-uri "/login" :content-class "login-page")
						     (when error-message
						       (format out-stream "<div class=\"error-box\">~A</div>" error-message)) 
						     (with-outputs (out-stream) "<div class=\"login-container\"><div id=\"login-form-container\"><h1>Log in</h1>")
						     (output-form out-stream "post" (format nil "/login~@[?return=~A~]" (if return (url-rewrite:url-encode return))) "login-form" "aligned-form" csrf-token
								  '(("login-username" "Username" "text" "username")
								    ("login-password" "Password" "password" "current-password"))
								  "Log in")
						     (with-outputs (out-stream) "</div><div id=\"create-account-form-container\"><h1>Create account</h1>")
						     (output-form out-stream "post" (format nil "/login~@[?return=~A~]" (if return (url-rewrite:url-encode return))) "signup-form" "aligned-form" csrf-token
								  '(("signup-username" "Username" "text" "username")
								    ("signup-email" "Email" "text" "email")
								    ("signup-password" "Password" "password" "new-password")
								    ("signup-password2" "Confirm password" "password" "new-password"))
								  "Create account")
						     (with-outputs (out-stream) "</div></div>"))))) 
				     (cond
				       ((not (or cookie-check (hunchentoot:cookie-in "session-token")))
					(hunchentoot:set-cookie "session-token" :max-age (- (expt 2 31) 1) :value (base64:usb8-array-to-base64-string (ironclad:make-random-salt)))
					(setf (hunchentoot:return-code*) 303
					      (hunchentoot:header-out "Location") (format nil "/login?~@[return=~A&~]cookie-check=y" (if return (url-rewrite:url-encode return))))) 
				       (cookie-check
					 (if (hunchentoot:cookie-in "session-token")
					   (setf (hunchentoot:return-code*) 303
						 (hunchentoot:header-out "Location") (format nil "/login~@[?return=~A~]" (if return (url-rewrite:url-encode return))))
					   (emit-page (out-stream :title "Log in" :current-uri "/login")
						      (format out-stream "<h1>Enable cookies</h1><p>Please enable cookies in your browser and <a href=\"/login~@[?return=~A~]\">try again</a>.</p>" (if return (url-rewrite:url-encode return)))))) 
				       (login-username
					 (check-csrf-token (hunchentoot:cookie-in "session-token") csrf-token)
					 (cond
					   ((or (string= login-username "") (string= login-password "")) (emit-login-page :error-message "Please enter a username and password")) 
					   (t (multiple-value-bind (user-id auth-token error-message) (do-lw2-login "username" login-username login-password) 
						(cond
						  (auth-token
						    (hunchentoot:set-cookie "lw2-auth-token" :value auth-token :max-age (- (expt 2 31) 1)) 
						    (cache-put "auth-token-to-userid" auth-token user-id)
						    (cache-put "auth-token-to-username" auth-token login-username)
						    (setf (hunchentoot:return-code*) 303
							  (hunchentoot:header-out "Location") (if (and return (ppcre:scan "^/[^/]" return)) return "/")))
						  (t
						    (emit-login-page :error-message error-message))))))) 
				       (signup-username
					 (check-csrf-token (hunchentoot:cookie-in "session-token") csrf-token)
					 (cond
					   ((not (every (lambda (x) (not (string= x ""))) (list signup-username signup-email signup-password signup-password2)))
					    (emit-login-page :error-message "Please fill in all fields"))
					   ((not (string= signup-password signup-password2))
					    (emit-login-page :error-message "Passwords do not match"))
					   (t (multiple-value-bind (user-id auth-token error-message) (do-lw2-create-user signup-username signup-email signup-password)
						(cond
						  (error-message (emit-login-page :error-message error-message))
						  (t
						    (hunchentoot:set-cookie "lw2-auth-token" :value auth-token :max-age (- (expt 2 31) 1))
						    (cache-put "auth-token-to-userid" auth-token user-id)
						    (cache-put "auth-token-to-username" auth-token signup-username)
						    (setf (hunchentoot:return-code*) 303
							  (hunchentoot:header-out "Location") (if (and return (ppcre:scan "^/[~/]" return)) return "/"))))))))
				       (t
					 (emit-login-page)))))) 

(defparameter *earliest-post* (local-time:parse-timestring "2005-01-01")) 

(hunchentoot:define-easy-handler (view-archive :uri (lambda (r) (ppcre:scan "^/archive(/|$)" (hunchentoot:request-uri r)))) () 
				 (with-error-page
				   (destructuring-bind (year month day) (map 'list (lambda (x) (if x (parse-integer x)))
									     (nth-value 1 (ppcre:scan-to-strings "^/archive(?:/(\\d{4})|/?$)(?:/(\\d{1,2})|/?$)(?:/(\\d{1,2})|/?$)"
														 (hunchentoot:request-uri*)))) 
				     (labels ((link-if-not (stream linkp url-elements class text)
						       (declare (dynamic-extent linkp url-elements text)) 
						       (if (not linkp)
							 (format stream "<a href=\"/~{~A~^/~}\" class=\"~A\">~A</a>" url-elements class text)
							 (format stream "<span class=\"~A\">~A</span>" class text)))) 
				       (local-time:with-decoded-timestamp (:day current-day :month current-month :year current-year) (local-time:now)
				         (local-time:with-decoded-timestamp (:day earliest-day :month earliest-month :year earliest-year) *earliest-post* 
					   (let ((posts (lw2-graphql-query (format nil "{PostsList (terms:{view:\"~A\",limit:~A~@[,after:\"~A\"~]~@[,before:\"~A\"~]}) {title, _id, slug, userId, postedAt, baseScore, commentCount, pageUrl, url}}"
										   "best" 50
										   (if year (format nil "~A-~A-~A" (or year earliest-year) (or month 1) (or day 1)))
										   (if year (format nil "~A-~A-~A" (or year current-year) (or month 12) (or day (local-time:days-in-month (or month 12) (or year current-year))))))))) 
					     (emit-page (out-stream :title "Archive" :current-uri "/archive" :content-class "archive-page")
							(with-outputs (out-stream) "<div class=\"archive-nav\"><div class=\"archive-nav-years\">")
							(link-if-not out-stream (not (or year month day)) '("archive") "archive-nav-item-year" "All") 
							(loop for y from earliest-year to current-year
							      do (link-if-not out-stream (eq y year) (list "archive" y) "archive-nav-item-year" y))
							(format out-stream "</div>")
							(when year
							  (format out-stream "<div class=\"archive-nav-months\">")
							  (link-if-not out-stream (not month) (list "archive" year) "archive-nav-item-month" "All") 
							  (loop for m from (if (= (or year current-year) earliest-year) earliest-month 1) to (if (= (or year current-year) current-year) current-month 12)
								do (link-if-not out-stream (eq m month) (list "archive" (or year current-year) m) "archive-nav-item-month" (elt local-time:+short-month-names+ m)))
							  (format out-stream "</div>"))
							(when month
							  (format out-stream "<div class=\"archive-nav-days\">")
							  (link-if-not out-stream (not day) (list "archive" year month) "archive-nav-item-day" "All")
							  (loop for d from (if (and (= (or year current-year) earliest-year) (= (or month current-month) earliest-month)) earliest-day 1)
								to (if (and (= (or year current-year) current-year) (= (or month current-month) current-month)) current-day (local-time:days-in-month (or month current-month) (or year current-year)))
								do (link-if-not out-stream (eq d day) (list "archive" (or year current-year) (or month current-month) d) "archive-nav-item-day" d))
							  (format out-stream "</div>")) 
							(format out-stream "</div>") 
							(map-output out-stream #'post-headline-to-html posts))))))))) 

(hunchentoot:define-easy-handler (view-css :uri "/style.css") (v)
				 (when v (setf (hunchentoot:header-out "Cache-Control") (format nil "public, max-age=~A, immutable" (- (expt 2 31) 1)))) 
				 (hunchentoot:handle-static-file "www/style.css" "text/css")) 

(defmacro define-versioned-resource (uri content-type)
  `(hunchentoot:define-easy-handler (,(alexandria:symbolicate "versioned-resource-" uri) :uri ,uri) (v)
				    (when v (setf (hunchentoot:header-out "Cache-Control") (format nil "public, max-age=~A, immutable" (- (expt 2 31) 1)))) 
				    (hunchentoot:handle-static-file ,(concatenate 'string "www" uri) ,content-type))) 

(define-versioned-resource "/style.css" "text/css") 
(define-versioned-resource "/script.js" "text/javascript") 
(define-versioned-resource "/guiedit.js" "text/javascript") 
(define-versioned-resource "/favicon.ico" "image/x-icon") 
(define-versioned-resource "/fa-regular-400.ttf" "application/x-font-ttf; charset=binary") 
(define-versioned-resource "/fa-solid-900.ttf" "application/x-font-ttf; charset=binary") 
