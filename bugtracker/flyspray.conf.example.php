; <?php die( 'Do not access this page directly.' ); ?>

      ; This is the Flysplay configuration file. It contains the basic settings
      ; needed for Flyspray to operate. All other preferences are stored in the
      ; database itself and are managed directly within the Flyspray admin interface.
      ; You should consider putting this file somewhere that isn't accessible using
      ; a web browser, and editing header.php to point to wherever you put this file.
[database]
dbtype = ""					; Type of database ("mysql", "mysqli" or "pgsql" are currently supported)
dbhost = ""				; Name or IP of your database server
dbname = ""					; The name of the database
dbuser = ""				; The user to access the database
dbpass = ""				; The password to go with that username above
dbprefix = ""				; The prefix to the Flyspray tables


[general]
cookiesalt = ""			; Randomisation value for cookie encoding
output_buffering = ""				; Available options: "on" or "gzip"
passwdcrypt = ""					; Available options: "crypt", "md5", "sha1" (Deprecated, do not change the default)
dot_path = "" ; Path to the dot executable (for graphs either dot_public or dot_path must be set)
dot_format = "" ; "png" or "svg"
address_rewriting = ""	; Boolean. 0 = off, 1 = on.
reminder_daemon = ""		; Boolean. 0 = off, 1 = on (cron job), 2 = on (PHP).
doku_url = ""      ; URL to your external wiki for [[dokulinks]] in FS
syntax_plugin = ""                               ; Plugin name for Flyspray's syntax (use any non-existing plugin name for deafult syntax)
update_check = ""                               ; Boolean. 0 = off, 1 = on.


[attachments]
zip = "application/zip" ; MIME-type for ZIP files
