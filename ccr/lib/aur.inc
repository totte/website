<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../lib' . PATH_SEPARATOR . '../template');
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Tue, 11 Oct 1988 22:00:00 GMT'); // quite a special day
header('Pragma: no-cache');

include_once('translator.inc');
set_lang();

include_once("config.inc");
include_once("version.inc");
include_once("acctfuncs.inc");

# TODO do we need to set the domain on cookies?  I seem to remember some
# security concerns about not using domains - but it's not like
# we really care if another site can see what language/SID a user
# is using...


# see if the visitor is already logged in
#
function check_sid() {
	global $_COOKIE;
	global $LOGIN_TIMEOUT;

	if (isset($_COOKIE["AURSID"])) {
		$failed = 0;
		# the visitor is logged in, try and update the session
		#
		$dbh = db_connect();
		$q = "SELECT LastUpdateTS, UNIX_TIMESTAMP() FROM Sessions ";
		$q.= "WHERE SessionID = '" . mysql_real_escape_string($_COOKIE["AURSID"]) . "'";
		$result = db_query($q, $dbh);
		if (mysql_num_rows($result) == 0) {
			# Invalid SessionID - hacker alert!
			#
			$failed = 1;
		} else {
			$row = mysql_fetch_row($result);
			$last_update = $row[0];
			if ($last_update + $LOGIN_TIMEOUT <= $row[1]) {
				$failed = 2;
			}
		}

		if ($failed == 1) {
			# clear out the hacker's cookie, and send them to a naughty page
			# why do you have to be so harsh on these people!?
			#
			setcookie("AURSID", "", time() - (60*60*24*30), "/");
			unset($_COOKIE['AURSID']);
		} elseif ($failed == 2) {
			# visitor's session id either doesn't exist, or the timeout
			# was reached and they must login again, send them back to
			# the main page where they can log in again.
			#
			$q = "DELETE FROM Sessions WHERE SessionID = '";
			$q.= mysql_real_escape_string($_COOKIE["AURSID"]) . "'";
			db_query($q, $dbh);

			setcookie("AURSID", "", time() - (60*60*24*30), "/");
			unset($_COOKIE['AURSID']);
		} else {
			# still logged in and haven't reached the timeout, go ahead
			# and update the idle timestamp

			# Only update the timestamp if it is less than the
			# current time plus $LOGIN_TIMEOUT.
			#
			# This keeps 'remembered' sessions from being
			# overwritten.
			if ($last_update < time() + $LOGIN_TIMEOUT) {
				$q = "UPDATE Sessions SET LastUpdateTS = UNIX_TIMESTAMP() ";
				$q.= "WHERE SessionID = '".mysql_real_escape_string($_COOKIE["AURSID"])."'";
				db_query($q, $dbh);
			}
		}
	}
	return;
}

/**
 * Verify the supplied CSRF token matches expected token
 *
 * @return bool True if the CSRF token is the same as the cookie SID, otherwise false
 */
function check_token() {
	if (isset($_POST['token'])) {
		return ($_POST['token'] == $_COOKIE['AURSID']);
	} else {
		return false;
	}
}

# verify that an email address looks like it is legitimate
#
function valid_email($addy) {
	return strpos($addy, '@');
}

# sends and email using some special settings suitable for sourceforge
# 
function send_mail($recipients, $headers, $body) {
        global $SMTPINFO;

	/* Create the mail object using the Mail::factory method */
	$mail_object = Mail::factory("smtp", $SMTPINFO);
	/* Ok send mail */
	$mail_object->send($recipients, $headers, $body);		
}


# a new seed value for mt_srand()
#
function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 10000);
}

# generate a (hopefully) unique session id
#
function new_sid() {
	return md5($_SERVER['REMOTE_ADDR'] . uniqid(mt_rand(), true));
}


# obtain the username if given their Users.ID
#
function username_from_id($id="") {
	if (!$id) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT Username FROM Users WHERE ID = " . mysql_real_escape_string($id);
	$result = db_query($q, $dbh);
	if (!$result) {
		return "None";
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}


# obtain the username if given their current SID
#
function username_from_sid($sid="") {
	if (!$sid) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT Username ";
	$q.= "FROM Users, Sessions ";
	$q.= "WHERE Users.ID = Sessions.UsersID ";
	$q.= "AND Sessions.SessionID = '" . mysql_real_escape_string($sid) . "'";
	$result = db_query($q, $dbh);
	if (!$result) {
		return "";
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}

# obtain the email address if given their current SID
#
function email_from_sid($sid="") {
	if (!$sid) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT Email ";
	$q.= "FROM Users, Sessions ";
	$q.= "WHERE Users.ID = Sessions.UsersID ";
	$q.= "AND Sessions.SessionID = '" . mysql_real_escape_string($sid) . "'";
	$result = db_query($q, $dbh);
	if (!$result) {
		return "";
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}

# obtain the account type if given their current SID
# Return either "", "User", "Trusted User", "Developer"
#
function account_from_sid($sid="") {
	if (!$sid) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT AccountType ";
	$q.= "FROM Users, AccountTypes, Sessions ";
	$q.= "WHERE Users.ID = Sessions.UsersID ";
	$q.= "AND AccountTypes.ID = Users.AccountTypeID ";
	$q.= "AND Sessions.SessionID = '" . mysql_real_escape_string($sid) . "'";
	$result = db_query($q, $dbh);
	if (!$result) {
		return "";
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}

# obtain the Users.ID if given their current SID
#
function uid_from_sid($sid="") {
	if (!$sid) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT Users.ID ";
	$q.= "FROM Users, Sessions ";
	$q.= "WHERE Users.ID = Sessions.UsersID ";
	$q.= "AND Sessions.SessionID = '" . mysql_real_escape_string($sid) . "'";
	$result = db_query($q, $dbh);
	if (!$result) {
		return 0;
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}

# connect to the database
#
function db_connect() {
	$handle = mysql_connect(AUR_db_host, AUR_db_user, AUR_db_pass);
	if (!$handle) {
		die("Error connecting to CCR database: " . mysql_error());
	}

	mysql_select_db(AUR_db_name, $handle) or
		die("Error selecting CCR database: " . mysql_error());

	return $handle;
}

# disconnect from the database
# this won't normally be needed as PHP/reference counting will take care of
# closing the connection once it is no longer referenced
#
function db_disconnect($db_handle="") {
	if ($db_handle) {
		mysql_close($db_handle);
		return TRUE;
	}
	return FALSE;
}

# wrapper function around db_query in case we want to put
# query logging/debugging in.
#
function db_query($query="", $db_handle="") {
	if (!$query) {
		return FALSE;
	}
	if (!$db_handle) {
		die("DB handle was not provided to db_query");
	}
	$result = @mysql_query($query, $db_handle);
	return $result;
}

# set up the visitor's language
#
function set_lang() {
	global $LANG;
	global $SUPPORTED_LANGS;
	global $streamer, $l10n;

	$update_cookie = 0;
	if (isset($_REQUEST['setlang'])) {
		# visitor is requesting a language change
		#
		$LANG = $_REQUEST['setlang'];
		$update_cookie = 1;

	} elseif (isset($_COOKIE['AURLANG'])) {
		# If a cookie is set, use that
		#
		$LANG = $_COOKIE['AURLANG'];

	} elseif (isset($_COOKIE["AURSID"])) {
		$dbh = db_connect();
		$q = "SELECT LangPreference FROM Users, Sessions ";
		$q.= "WHERE Users.ID = Sessions.UsersID ";
		$q.= "AND Sessions.SessionID = '";
		$q.= mysql_real_escape_string($_COOKIE["AURSID"])."'";
		$result = db_query($q, $dbh);

		if ($result) {
			$row = mysql_fetch_array($result);
			$LANG = $row[0];
		}
		$update_cookie = 1;
	}

	# Set $LANG to default if nothing is valid.
	if (!array_key_exists($LANG, $SUPPORTED_LANGS)) {
		$LANG = DEFAULT_LANG;
	}

	if ($update_cookie) {
		setcookie("CCRLANG", $LANG, 0, "/");
	}

	$streamer = new FileReader('locale/' . $LANG .
		'/LC_MESSAGES/ccr.mo');
	$l10n = new gettext_reader($streamer, true);

	return;
}


# common header
#
function html_header($title="") {
	global $_SERVER;
	global $_COOKIE;
	global $_POST;
	global $LANG;
	global $SUPPORTED_LANGS;

	$login = try_login();
	$login_error = $login['error'];

	$title = htmlspecialchars($title, ENT_QUOTES);

	include('header.php');
	return;
}


# common footer
#
function html_footer($ver="") {
	include('footer.php');
	return;
}

# check to see if the user can submit a package
#
function can_submit_pkg($name="", $sid="") {
	if (!$name || !$sid) {return 0;}
	$dbh = db_connect();
	$q = "SELECT MaintainerUID ";
	$q.= "FROM Packages WHERE Name = '".mysql_real_escape_string($name)."'";
	$result = db_query($q, $dbh);
	if (mysql_num_rows($result) == 0) {return 1;}
	$row = mysql_fetch_row($result);
	if ($row[1] == "1") { return 1; }
	$my_uid = uid_from_sid($sid);

	if (!$row[0] || $row[0] == $my_uid) {
		return 1;
	}

	return 0;
}

# recursive delete directory
#
function rm_rf($dirname="") {
	if ($dirname != "") {
		exec('rm -rf ' . escapeshellcmd($dirname));
	}

	return;
}

# Recursive chmod to set group write permissions
#
function chmod_group($path) {
	if (!is_dir($path))
		return chmod($path, 0664);

	$d = dir($path);
	while ($f = $d->read()) {
		if ($f != '.' && $f != '..') {
			$fullpath = $path.'/'.$f;
			if (is_link($fullpath))
				continue;
			elseif (!is_dir($fullpath)) {
				if (!chmod($fullpath, 0664))
					return FALSE;
			}
			elseif(!chmod_group($fullpath))
				return FALSE;
		}
	}
	$d->close();

	if(chmod($path, 0775))
		return TRUE;
	else
		return FALSE;
}

# obtain the uid given a Users.Username
#
function uid_from_username($username="")
{
	if (!$username) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT ID FROM Users WHERE Username = '".mysql_real_escape_string($username)
				."'";
	$result = db_query($q, $dbh);
	if (!$result) {
		return "None";
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}

# obtain the uid given a Users.Email
#
function uid_from_email($email="")
{
	if (!$email) {
		return "";
	}
	$dbh = db_connect();
	$q = "SELECT ID FROM Users WHERE Email = '".mysql_real_escape_string($email)
				."'";
	$result = db_query($q, $dbh);
	if (!$result) {
		return "None";
	}
	$row = mysql_fetch_row($result);

	return $row[0];
}

# check user privileges
#
function check_user_privileges()
{
	$type = account_from_sid($_COOKIE['AURSID']);
	return ($type == 'Trusted User' || $type == 'Developer');
}

/**
 * Generate clean url with edited/added user values
 *
 * Makes a clean string of variables for use in URLs based on current $_GET and
 * list of values to edit/add to that. Any empty variables are discarded.
 *
 * ex. print "http://example.com/test.php?" . mkurl("foo=bar&bar=baz")
 *
 * @param string $append string of variables and values formatted as in URLs
 * ex. mkurl("foo=bar&bar=baz")
 * @return string clean string of variables to append to URL, urlencoded
 */
function mkurl($append) {
	$get = $_GET;
	$append = explode('&', $append);
	$uservars = array();
	$out = '';

	foreach ($append as $i) {
		$ex = explode('=', $i);
		$uservars[$ex[0]] = $ex[1];
	}

	foreach ($uservars as $k => $v) { $get[$k] = $v; }

	foreach ($get as $k => $v) {
		if ($v !== '') {
			$out .= '&amp;' . urlencode($k) . '=' . urlencode($v);
		}
	}

	return substr($out, 5);
}

function get_salt($user_id)
{
	$dbh = db_connect();
	$salt_q = "SELECT Salt FROM Users WHERE ID = '$user_id'";
	$salt_result = mysql_fetch_row(db_query($salt_q, $dbh));
	return $salt_result[0];
}

function save_salt($user_id, $passwd)
{
	$dbh = db_connect();
	$salt = generate_salt();
	$hash = salted_hash($passwd, $salt);
	$salting_q = "UPDATE Users SET Salt = '$salt'" .
		", Passwd = '$hash' WHERE ID = '$user_id'";
	return db_query($salting_q, $dbh);
}

function generate_salt()
{
	return md5(uniqid(mt_rand(), true));
}

function salted_hash($passwd, $salt)
{
	if (strlen($salt) != 32) {
		trigger_error('Salt does not look like an md5 hash', E_USER_WARNING);
	}
	return md5($salt . $passwd);
}
