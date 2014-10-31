<?php

set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/' . PATH_SEPARATOR . 'template/');

include_once('aur.inc');         # access AUR common functions
include_once('acctfuncs.inc');   # access Account specific functions

set_lang();                 # this sets up the visitor's language
check_sid();                # see if they're still logged in´

# Make sure we are comparing a proper index
if(!isset($_REQUEST["Action"])) $_REQUEST["Action"] = "";

html_header(__('Accounts'));

# Main page processing here
#
echo "<div class=\"pgbox\">\n";
echo "  <div class=\"pgboxtitle\"><span class=\"f3\">".__("Accounts")."</span></div>\n";
echo "  <div class=\"pgboxbody\">\n";

if (isset($_COOKIE["AURSID"])) {
	# visitor is logged in
	#
	$dbh = db_connect();
	$atype = account_from_sid($_COOKIE["AURSID"]);

	if ($_REQUEST["Action"] == "SearchAccounts") {

		# security check
		#
		if ($atype == "Trusted User" || $atype == "Developer") {
			# the user has entered search criteria, find any matching accounts
			#
			search_results_page($atype, $_REQUEST["O"], $_REQUEST["SB"],
					$_REQUEST["U"], $_REQUEST["T"], $_REQUEST["S"],
					$_REQUEST["E"], $_REQUEST["R"], $_REQUEST["I"]);

		} else {
			# a non-privileged user is trying to access the search page
			#
			print __("You are not allowed to access this area.")."<br />\n";
		}

	} elseif ($_REQUEST["Action"] == "DisplayAccount") {
		# the user has clicked 'edit', display the account details in a form
		#
		$q = "SELECT Users.*, AccountTypes.AccountType ";
		$q.= "FROM Users, AccountTypes ";
		$q.= "WHERE AccountTypes.ID = Users.AccountTypeID ";
		$q.= "AND Users.ID = ".intval($_REQUEST["ID"]);
		$result = db_query($q, $dbh);
		if (!mysql_num_rows($result)) {
			print __("Could not retrieve information for the specified user.");

		} else {
			$row = mysql_fetch_assoc($result);

			# double check to make sure logged in user can edit this account
			#
			if ($atype == "User" || ($atype == "Trusted User" && $row["AccountType"] == "Developer")) {
				print __("You do not have permission to edit this account.");
			} else {

				display_account_form($atype, "UpdateAccount", $row["Username"],
						$row["AccountType"], $row["Suspended"], $row["Email"],
						"", "", $row["RealName"], $row["LangPreference"],
						$row["IRCNick"], $row["ID"]);
			}
		}

	} elseif ($_REQUEST["Action"] == "AccountInfo") {
		# no editing, just looking up user info
		#
		$q = "SELECT Users.*, AccountTypes.AccountType ";
		$q.= "FROM Users, AccountTypes ";
		$q.= "WHERE AccountTypes.ID = Users.AccountTypeID ";
		$q.= "AND Users.ID = ".intval($_REQUEST["ID"]);
		$result = db_query($q, $dbh);
		if (!mysql_num_rows($result)) {
			print __("Could not retrieve information for the specified user.");
		} else {
			$row = mysql_fetch_assoc($result);
			display_account_info($row["Username"],
						$row["AccountType"], $row["Email"], $row["RealName"],
						$row["IRCNick"]);
		}
		
	} elseif ($_REQUEST["Action"] == "UpdateAccount") {
		# user is submitting their modifications to an existing account
		#
                $uid = uid_from_sid($_COOKIE['AURSID']);

		/* Details for account being updated */
		$acctinfo = account_details(in_request('ID'), in_request('U'));

		/* Verify user permissions and that the request is a valid POST */
		if (can_edit_account($atype, $acctinfo, $uid)) {
			process_account_form($atype, "edit", "UpdateAccount",
				$_REQUEST["U"], $_REQUEST["T"], $_REQUEST["S"],
				$_REQUEST["E"], $_REQUEST["P"], $_REQUEST["C"],
				$_REQUEST["R"], $_REQUEST["L"], $_REQUEST["I"],
				$_REQUEST["ID"]);
		}

	} else {
		if ($atype == "Trusted User" || $atype == "Developer") {
			# display the search page if they're a TU/dev
			#
			print __("Use this form to search existing accounts.")."<br />\n";
			search_accounts_form();

		} else {
			# A normal user, give them the ability to edit
			# their own account
			#
			$q = "SELECT Users.*, AccountTypes.AccountType ";
			$q.= "FROM Users, AccountTypes, Sessions ";
			$q.= "WHERE AccountTypes.ID = Users.AccountTypeID ";
			$q.= "AND Users.ID = Sessions.UsersID ";
			$q.= "AND Sessions.SessionID = '";
			$q.= mysql_real_escape_string($_COOKIE["AURSID"])."'";
			$result = db_query($q, $dbh);
			if (!mysql_num_rows($result)) {
				print __("Could not retrieve information for the specified user.");

			} else {
				$row = mysql_fetch_assoc($result);
				# don't need to check if they have permissions, this is a
				# normal user editing themselves.
				#
				print __("Use this form to update your account.");
				print "<br />";
				print __("Leave the password fields blank to keep your same password.");
				display_account_form($atype, "UpdateAccount", $row["Username"],
						$row["AccountType"], $row["Suspended"], $row["Email"],
						"", "", $row["RealName"], $row["LangPreference"],
						$row["IRCNick"], $row["ID"]);
			}
		}
	}

} else {
	# visitor is not logged in
	#
	if ($_REQUEST["Action"] == "AccountInfo") {
		print __("You must log in to view user information.");
	}	elseif ($_REQUEST["Action"] == "NewAccount") {
		# process the form input for creating a new account
		#
		process_account_form("","new", "NewAccount",
				$_REQUEST["U"], 1, 0, $_REQUEST["E"],
				$_REQUEST["P"], $_REQUEST["C"], $_REQUEST["R"],
				$_REQUEST["L"], $_REQUEST["I"], $_REQUEST["N"]);

	} else {
		# display the account request form
		#
		print __("Use this form to create an account.");
		display_account_form("", "NewAccount");
	}
}

echo "  </div>";
echo "</div>";

html_footer(AUR_VERSION);

?>
