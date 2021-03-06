(uiop:define-package #:lw2.hash-utils
  (:use #:cl)
  (:import-from #:flexi-streams #:string-to-octets #:octets-to-string)
  (:export #:city-hash-128-vector #:hash-string #:hash-printable-object #:hash-file-list)
  (:recycle #:lw2.lmdb))

(in-package #:lw2.hash-utils)

(defun city-hash-128-vector (data)
  (apply #'concatenate
         (cons 'vector (map 'list #'bit-smasher:int->octets
                            (multiple-value-list
                              (city-hash:city-hash-128 data))))))

(defun hash-string (string)
  (city-hash-128-vector (string-to-octets string :external-format :utf-8)))

(defun hash-printable-object (object)
  (hash-string (write-to-string object :circle nil :escape nil :pretty nil)))

(defun hash-file-list (file-list)
  (city-hash-128-vector
    (apply #'concatenate
           `((vector character)
             ,@(map 'list (lambda (f) (uiop:read-file-string (uiop:subpathname (asdf:system-source-directory "lw2-viewer") f))) file-list)))))
