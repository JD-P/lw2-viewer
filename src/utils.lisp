(uiop:define-package #:lw2.utils
  (:use #:cl #:alexandria)
  (:export #:alist #:get-unix-time #:substring #:to-boolean #:map-plist #:alist-bind #:list-cond)
  (:recycle #:lw2-viewer))

(in-package #:lw2.utils)

(declaim (inline alist))
(defun alist (&rest parms) (plist-alist parms))

(defun get-unix-time ()
  (- (get-universal-time) #.(encode-universal-time 0 0 0 1 1 1970 0)))

(deftype array-dimension-type () `(integer 0 ,(- array-dimension-limit 1)))

(declaim (inline substring)
         (ftype (function (string array-dimension-type &optional array-dimension-type) string) substring))
(defun substring (string start &optional (end (length string)))
  (make-array (- end start) :element-type 'character :displaced-to string :displaced-index-offset start))

(declaim (inline to-boolean))
(defun to-boolean (value)
  (and value t))

(defun map-plist (fn plist)
  (loop for (key val . rest) = plist then rest
        while key
        nconc (funcall fn key val)))

(defmacro alist-bind (bindings alist &body body)
  "Binds elements of ALIST so they can be used as if they were lexical variables.

Syntax: alist-bind (binding-entry*) alist forms*
=> result*
binding-entry ::= (variable-name &optional type alist-key)

Each VARIABLE-NAME is bound to the corresponding datum in ALIST. Modifying these
bindings with SETF will also update the ALIST.
TYPE: type designator, not evaluated.
ALIST-KEY: the alist key, as in the first argument to ASSOC. If it is not
specified, the KEYWORD symbol with the same name as VARIABLE-NAME is used."
  (once-only (alist)
    (let ((inner-bindings (loop for x in bindings collect
                                (destructuring-bind (bind &optional type key) (if (consp x) x (list x))
                                  (list (gensym (string bind)) (gensym (string bind)) (gensym (string bind)) bind (or type t) (or key (intern (string bind) '#:keyword)))))))
      (macrolet ((inner-loop (&body body)
                   `(loop for (fn-gensym cons-gensym value-gensym bind type key) in inner-bindings collect
                          (progn fn-gensym cons-gensym value-gensym bind type key ,@body))))
        `(let* (,@(inner-loop `(,cons-gensym (assoc ,key ,alist)))
                ,@(inner-loop `(,value-gensym (cdr ,cons-gensym))))
             (declare ,@(inner-loop `(type ,type ,value-gensym)))
             (flet (,@(inner-loop `(,fn-gensym () ,value-gensym))
                    ,@(inner-loop `((setf ,fn-gensym) (new) (setf (cdr ,cons-gensym) new ,value-gensym new))))
               (declare (inline ,@(inner-loop fn-gensym)))
               (symbol-macrolet ,(inner-loop `(,bind (,fn-gensym)))
                 ,@body)))))))

(defmacro list-cond (&body clauses)
  (labels ((expand (clauses)
	     (when clauses
	       (destructuring-bind (predicate-form data-form &optional value-form) (first clauses)
		 (with-gensyms (predicate value rest)
		   `(let* ((,predicate ,predicate-form)
			   (,value (if ,predicate ,(if value-form `(cons ,data-form ,value-form) data-form)))
			   (,rest ,(expand (rest clauses))))
		      (declare (dynamic-extent ,predicate))
		      (if ,predicate
			  (cons ,value ,rest)
			  ,rest)))))))
    (expand clauses)))
