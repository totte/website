<?php
# NOTE: modify these variables if your MySQL setup is different
#
define( "AUR_db_host", "" );
define( "AUR_db_name", "" );
define( "AUR_db_user", "" );
define( "AUR_db_pass", "" );

# Configuration of directories where things live
define( "UPLOAD_DIR", "" );
define( "INCOMING_DIR", "" );
define( "URL_DIR", "" );

define( "USERNAME_MIN_LEN", 3 );
define( "USERNAME_MAX_LEN", 16 );
define( "PASSWD_MIN_LEN", 4 );
define( "PASSWD_MAX_LEN", 128 );

# Language that messages are initially written in.
# This should never change.
define("DEFAULT_LANG", "en");

# Languages we have translations for
$SUPPORTED_LANGS = array(
	"ar" => "Arabic",
	"ca" => "Català",
	"cs" => "česky",
	"da" => "Dansk",
	"de" => "Deutsch",
	"en" => "English",
	"el_GR" => "Ελληνικά",
	"es" => "Español",
	"fr" => "Français",
	"gl" => "Galego",
	"he" => "עברית",
	"hr" => "Hrvatski",
	"hu" => "Magyar",
	"it" => "Italiano",
	"nb_NO" => "Norsk",
	"nl" => "Nederlands",
	"pl" => "Polski",
	"pt" => "Português",
	"ro" => "Română",
	"ru" => "Русский",
	"sr" => "Srpski",
	"tr" => "Türkçe",
	"uk" => "Українська",
	"uz" => "O'zbek",
	"zh_CN" => "简体中文",
	"zh_TW" => "正體中文"
);

# Idle seconds before timeout
$LOGIN_TIMEOUT = 7200;

# Session timeout when using "Remember me" cookies
$PERSISTENT_COOKIE_TIMEOUT = 60 * 60 * 24 * 30;

# Uncompressed file size limit for submitted tarballs (ZIP bomb protection) -
# please ensure "upload_max_filesize" is additionally set to no more than 3M,
# otherwise this check might be easy to bypass (FS#22991 for details)
$MAX_FILESIZE_UNCOMPRESSED = 1024 * 1024 * 8;

# Wether to use Geshi for highlight the PKGBUILD
define ( "USE_GESHI", true);
#define ( "USE_GESHI", false);
$GESHI_PATH = "/usr/share/php-geshi/";

date_default_timezone_set('Europe/Berlin');

# Mail data
$SMTPINFO = array(
 'host'     => "",
 'port'     => "",
 'auth'     => "",
 'username' => "",
 'password' => ""
);
