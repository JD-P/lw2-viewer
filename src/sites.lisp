(uiop:define-package #:lw2.sites
  (:use #:cl #:lw2.utils #:lw2.context #:lw2.backend-modules)
  (:import-from #:sb-ext #:defglobal)
  (:export
    #:*sites*
    #:site #:alternate-frontend-site #:lesswrong-viewer-site #:ea-forum-viewer-site
    #:site-uri #:site-host #:site-secure #:site-backend #:site-title #:site-description #:background-loader-enabled
    #:main-site-title #:main-site-abbreviation
    #:host-matches #:find-site
    #:call-with-site-context #:with-site-context
    #:reset-site-definitions
    #:define-site))

(in-package #:lw2.sites)

(defglobal *sites* nil)

(defclass site ()
  ((uri :accessor site-uri :initarg :uri :type simple-string)
   (host :accessor site-host :initarg :host :type simple-string)
   (secure :accessor site-secure :initarg :secure)
   (backend :accessor site-backend :initarg :backend :type backend-base)
   (title :accessor site-title :initarg :title :type simple-string)
   (description :accessor site-description :initarg :description :type simple-string)
   (background-loader-enabled :accessor background-loader-enabled :initarg :use-background-loader :initform nil :type boolean)))

(defmethod main-site-title ((s site)) nil)

(defmethod main-site-abbreviation ((s site)) nil)

(defclass alternate-frontend-site (site)
  ((main-site-title :accessor main-site-title :initarg :main-site-title :type simple-string)
   (main-site-abbreviation :accessor main-site-abbreviation :initarg :main-site-abbreviation :type simple-string)))

(defclass lesswrong-viewer-site (alternate-frontend-site) ())

(defclass ea-forum-viewer-site (alternate-frontend-site) ())

(defmethod host-matches ((site site) host)
  (let ((site-host (site-host site)))
    (and site-host (string-equal site-host host))))

(defun find-site (host)
  (find-if (lambda (site) (host-matches site host))
           *sites*))

(defmethod call-with-site-context ((site site) fn)
  (let ((*current-site* site)
        (*current-backend* (site-backend site)))
    (funcall fn)))

(defmacro with-site-context ((site) &body body)
  `(call-with-site-context ,site (lambda () ,@body)))

(defun reset-site-definitions ()
  (setf *sites* nil))

(defmacro define-site (&rest args)
  (let* ((class 'site)
         (args2
           (map-plist (lambda (key val)
                        (cond
                          ((eq key :class)
                           (setf class val)
                           nil)
                          ((eq key :backend)
                           (list key `(make-backend ,@val)))
                          ((eq key :uri)
                           (let* ((uri (quri:uri val))
                                  (scheme (quri:uri-scheme uri))
                                  (host (quri:uri-host uri))
                                  (port (quri:uri-port uri))
                                  (default-port (quri.port:scheme-default-port scheme)))
                             (list key val
                                   :host (format nil "~A~@[:~A~]"
                                                 host
                                                 (if (/= default-port port) port))
                                   :secure (string-equal "https" scheme))))
                          (t (list key val))))
                      args)))
    `(push (make-instance ',class ,.args2) *sites*)))
