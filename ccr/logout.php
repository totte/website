<?php

set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/');

include_once("aur.inc");         # access AUR common functions
include_once("acctfuncs.inc");         # access AUR common functions


# if they've got a cookie, log them out - need to do this before
# sending any HTML output.
#
if (isset($_COOKIE["AURSID"])) {
	$dbh = db_connect();
	$q = "DELETE FROM Sessions WHERE SessionID = '";
	$q.= mysql_real_escape_string($_COOKIE["AURSID"]) . "'";
	db_query($q, $dbh);
	setcookie("AURSID", "", time() - (60*60*24*30), "/");
	setcookie("AURLANG", "", time() - (60*60*24*30), "/");
}

clear_expired_sessions();

header('Location: index.php');

