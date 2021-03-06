<?php

include_once("config.inc");

# define variables used during pkgsearch
#
$pkgsearch_vars = array("O", "L", "C", "K", "SB", "SO", "PP", "do_Orphans", "SeB");

# Make sure this visitor can delete the requested package comment
# They can delete if they were the comment submitter, or if they are a TU/Dev
#
function canDeleteComment($comment_id=0, $atype="", $uid=0) {
	if ($atype == "Trusted User" || $atype == "Developer") {
		# A TU/Dev can delete any comment
		return TRUE;
	}
	$dbh = db_connect();
	$q = "SELECT COUNT(ID) AS CNT ";
	$q.= "FROM PackageComments ";
	$q.= "WHERE ID = " . intval($comment_id);
	$q.= " AND UsersID = " . $uid;
	$result = db_query($q, $dbh);
	if ($result != NULL) {
		$row = mysql_fetch_assoc($result);
		if ($row['CNT'] > 0) {
			return TRUE;
		}
	}
	return FALSE;
}

# Make sure this visitor can delete the requested package comment
# They can delete if they were the comment submitter, or if they are a TU/Dev
#
function canDeleteCommentArray($comment, $atype="", $uid=0) {
	if ($atype == "Trusted User" || $atype == "Developer") {
		# A TU/Dev can delete any comment
		return TRUE;
	} else if ($comment['UsersID'] == $uid) {
		# User's own comment
		return TRUE;
	}
	return FALSE;
}

# see if this Users.ID can manage the package
#
function canManagePackage($uid=0,$AURMUID=0, $MUID=0, $SUID=0, $managed=0) {
	if (!$uid) {return 0;}

	# The uid of the TU/Dev that manages the package
	#
	if ($uid == $AURMUID) {return 1;}

	# If the package isn't maintained by a TU/Dev, is this the user-maintainer?
	#
	if ($uid == $MUID && !$managed) {return 1;}

	# If the package isn't maintained by a TU/Dev, is this the user-submitter?
	#
	if ($uid == $SUID && !$managed) {return 1;}

	# otherwise, no right to manage this package
	#
	return 0;
}

# grab the current list of PackageCategories
#
function pkgCategories() {
	$cats = array();
	$dbh = db_connect();
	$q = "SELECT * FROM PackageCategories WHERE ID != 1 ";
	$q.= "ORDER BY Category ASC";
	$result = db_query($q, $dbh);
	if ($result) {
		while ($row = mysql_fetch_row($result)) {
			$cats[$row[0]] = $row[1];
		}
	}
	return $cats;
}

# check to see if the package name exists
#
function package_exists($name="") {
	if (!$name) {return NULL;}
	$dbh = db_connect();
	$q = "SELECT ID FROM Packages ";
	$q.= "WHERE Name = '".mysql_real_escape_string($name)."' ";
	$result = db_query($q, $dbh);
	if (!$result) {return NULL;}
	$row = mysql_fetch_row($result);
	return $row[0];
}

# grab package dependencies
#
function package_dependencies($pkgid=0) {
	$deps = array();
	$pkgid = intval($pkgid);
	if ($pkgid > 0) {
		$dbh = db_connect();
		$q = "SELECT pd.DepName, pd.DepCondition, p.ID FROM PackageDepends pd ";
		$q.= "LEFT JOIN Packages p ON pd.DepName = p.Name ";
		$q.= "WHERE pd.PackageID = ". $pkgid . " ";
		$q.= "ORDER BY pd.DepName";
		$result = db_query($q, $dbh);
		if (!$result) {return array();}
		while ($row = mysql_fetch_row($result)) {
			$deps[] = $row;
		}
	}
	return $deps;
}

function package_required($name="") {
	$deps = array();
	if ($name != "") {
		$dbh = db_connect();
		$q = "SELECT p.Name, PackageID FROM PackageDepends pd ";
		$q.= "JOIN Packages p ON pd.PackageID = p.ID ";
		$q.= "WHERE DepName = '".mysql_real_escape_string($name)."' ";
		$q.= "ORDER BY p.Name";;
		$result = db_query($q, $dbh);
		if (!$result) {return array();}
		while ($row = mysql_fetch_row($result)) {
			$deps[] = $row;
		}
	}
	return $deps;
}

# Return the number of comments for a specified package
function package_comments_count($pkgid = 0) {
	$pkgid = intval($pkgid);
	if ($pkgid > 0) {
		$dbh = db_connect();
		$q = "SELECT COUNT(*) FROM PackageComments ";
		$q.= "WHERE PackageID = " . $pkgid;
		$q.= " AND DelUsersID IS NULL";
	}
	$result = db_query($q, $dbh);

	if (!$result) {
		return;
	}

	return mysql_result($result, 0);
}

# Return an array of package comments
function package_comments($pkgid = 0) {
	$comments = array();
	$pkgid = intval($pkgid);
	if ($pkgid > 0) {
		$dbh = db_connect();
		$q = "SELECT PackageComments.ID, UserName, UsersID, Comments, CommentTS ";
		$q.= "FROM PackageComments, Users ";
		$q.= "WHERE PackageComments.UsersID = Users.ID";
		$q.= " AND PackageID = " . $pkgid;
		$q.= " AND DelUsersID IS NULL"; # only display non-deleted comments
		$q.= " ORDER BY CommentTS DESC";

		if (!isset($_GET['comments'])) {
			$q.= " LIMIT 10";
		}

		$result = db_query($q, $dbh);

		if (!$result) {
			return;
		}

		while ($row = mysql_fetch_assoc($result)) {
			$comments[] = $row;
		}
	}
	return $comments;
}

# grab package sources
#
function package_sources($pkgid=0) {
	$sources = array();
	if ($pkgid) {
		$dbh = db_connect();
		$q = "SELECT Source FROM PackageSources ";
		$q.= "WHERE PackageID = ".mysql_real_escape_string($pkgid);
		$q.= " ORDER BY Source";
		$result = db_query($q, $dbh);
		if (!$result) {return array();}
		while ($row = mysql_fetch_row($result)) {
			$sources[] = $row[0];
		}
	}
	return $sources;
}


# grab array of Package.IDs that I've voted for: $pkgs[1234] = 1, ...
#
function pkgvotes_from_sid($sid="") {
	$pkgs = array();
	if (!$sid) {return $pkgs;}
	$dbh = db_connect();
	$q = "SELECT PackageID ";
	$q.= "FROM PackageVotes, Users, Sessions ";
	$q.= "WHERE Users.ID = Sessions.UsersID ";
	$q.= "AND Users.ID = PackageVotes.UsersID ";
	$q.= "AND Sessions.SessionID = '".mysql_real_escape_string($sid)."'";
	$result = db_query($q, $dbh);
	if ($result) {
		while ($row = mysql_fetch_row($result)) {
			$pkgs[$row[0]] = 1;
		}
	}
	return $pkgs;
}

# array of package ids that you're being notified for
# *yoink*
#
function pkgnotify_from_sid($sid="") {
	$pkgs = array();
	if (!$sid) {return $pkgs;}
	$dbh = db_connect();
	$q = "SELECT PkgID ";
	$q.= "FROM CommentNotify, Users, Sessions ";
	$q.= "WHERE Users.ID = Sessions.UsersID ";
	$q.= "AND Users.ID = CommentNotify.UserID ";
	$q.= "AND Sessions.SessionID = '".mysql_real_escape_string($sid)."'";
	$result = db_query($q, $dbh);
	if ($result) {
		while ($row = mysql_fetch_row($result)) {
			$pkgs[$row[0]] = 1;
		}
	}
	return $pkgs;
}

# get name of package based on pkgid
#
function pkgname_from_id($id="") {
	if (!empty($id)) {
		$dbh = db_connect();
		$id = intval($id);
		$q = "SELECT Name FROM Packages WHERE ID = " . mysql_real_escape_string($id);
		$result = db_query($q, $dbh);
		if (mysql_num_rows($result) > 0) {
			$id = mysql_result($result, 0);
		} else {
			$id = "";
		}
	}
	return $id;
}

# display package details
#
function package_details($id=0, $SID="") {
	global $pkgsearch_vars;
	$atype = account_from_sid($SID);
	$uid = uid_from_sid($SID);

	$q = "SELECT Packages.*,Category ";
	$q.= "FROM Packages,PackageCategories ";
	$q.= "WHERE Packages.CategoryID = PackageCategories.ID ";
	$q.= "AND Packages.ID = " . intval($id);
	$dbh = db_connect();
	$results = db_query($q, $dbh);

	if (!$results) {
		print __("Error retrieving package details.") . "<br />\n";
	}
	else {
		$row = mysql_fetch_assoc($results);
		if (empty($row)) {
			print __("Package details could not be found.") . "<br />\n";

		}
		else {
			include('pkg_details.php');

			# Actions Bar
			if ($SID) {
				include('actions_form.php');
				include('pkg_comment_form.php');
			}
			
			# Print Comments
			$comments = package_comments($id);
			if (!empty($comments)) {
				include('pkg_comments.php');
			}
		}
	}
	return;
}


/* pkg_search_page(SID)
 * outputs the body of search/search results page
 *
 * parameters:
 *  SID - current Session ID
 * preconditions:
 *  package search page has been accessed
 *  request variables have not been sanitized
 *
 *  request vars:
 *    O  - starting result number
 *    PP - number of search hits per page
 *    C  - package category ID number
 *    K  - package search string
 *    SO - search hit sort order:
 *          values: a - ascending
 *                  d - descending
 *    SB - sort search hits by:
 *          values: c - package category
 *                  n - package name
 *                  v - number of votes
 *                  m - maintainer username
 *    SeB- property that search string (K) represents
 *          values: nd - package name&description
 *                  m  - package maintainer's username
 *                  s  - package submitter's username
 *    do_Orphans    - boolean. whether to search packages
 *                     without a maintainer
 *
 *
 *    These two are actually handled in packages.php.
 *
 *    IDs- integer array of ticked packages' IDs
 *    action - action to be taken on ticked packages
 *             values: do_Flag   - Flag out-of-date
 *                     do_UnFlag - Remove out-of-date flag
 *                     do_Adopt  - Adopt
 *                     do_Disown - Disown
 *                     do_Delete - Delete (requires confirm_Delete to be set)
 *                     do_Notify - Enable notification
 *                     do_UnNotify - Disable notification
 */
function pkg_search_page($SID="") {
	// establish a db connection
	$dbh = db_connect();

	// get commonly used variables...
	// TODO: REDUCE DB HITS.
	// grab info for user if they're logged in
	if ($SID)
		$myuid = uid_from_sid($SID);
	// get a list of package categories
	$cats = pkgCategories(); //meow

	// sanitize paging variables
	//
	if (isset($_GET['O'])) {
		$_GET['O'] = intval($_GET['O']);
		if ($_GET['O'] < 0)
			$_GET['O'] = 0;
	}
	else {
		$_GET['O'] = 0;
	}

	if (isset($_GET["PP"])) {
		$_GET["PP"] = intval($_GET["PP"]);
		if ($_GET["PP"] < 25)
			$_GET["PP"] = 25;
		else if ($_GET["PP"] > 100)
			$_GET["PP"] = 100;
	}
	else {
		$_GET["PP"] = 25;
	}

	// FIXME: pull out DB-related code. all of it.
	//        this one's worth a choco-chip cookie,
	//        one of those nice big soft ones

	// build the package search query
	//
	$q = "SELECT SQL_CALC_FOUND_ROWS ";
	if ($SID) {
		$q .= "CommentNotify.UserID AS Notify,
		       PackageVotes.UsersID AS Voted, ";
	}
	$q .= "Users.Username AS Maintainer,
	PackageCategories.Category,
	Packages.Name, Packages.Version, Packages.Description, Packages.NumVotes,
	Packages.ID, Packages.OutOfDate

	FROM Packages
	LEFT JOIN Users ON (Packages.MaintainerUID = Users.ID) ";
	if ($SID) {
		$q .= "LEFT JOIN PackageVotes
		ON (Packages.ID = PackageVotes.PackageID AND PackageVotes.UsersID = $myuid)
		LEFT JOIN CommentNotify
		ON (Packages.ID = CommentNotify.PkgID AND CommentNotify.UserID = $myuid) ";
	}
	$q .= "LEFT JOIN PackageCategories
	ON (Packages.CategoryID = PackageCategories.ID)
	WHERE 1 = 1 ";

	// TODO: possibly do string matching on category and
	//       location to make request variable values more sensible
	if (isset($_GET["C"])) {
		if (intval($_GET["C"])) {
			$q.= "AND Packages.CategoryID = ".intval($_GET["C"])." ";
		}
	}

	if (isset($_GET['K'])) {
		$_GET['K'] = mysql_real_escape_string(trim($_GET['K']));
		if (isset($_GET["SeB"])) {
			# Search by maintainer
			if ($_GET["SeB"] == "m") {
				$q.= "AND Users.Username = '".$_GET['K']."' ";
			}
			# Search by submitter
			elseif ($_GET["SeB"] == "s") {
				$q.= "AND SubmitterUID = ".uid_from_username($_GET['K'])." ";
			}
			# Search by name
			elseif ($_GET["SeB"] == "n") {
				$q.= "AND (Name LIKE '%".$_GET['K']."%') ";
			}
			# Search by name and description
			else {
				$q.= "AND (Name LIKE '%".$_GET['K']."%' OR ";
				$q.= "Description LIKE '%".$_GET['K']."%') ";
			}
		}
		# Default, search by name and description
		else {
			$q.= "AND (Name LIKE '%".$_GET['K']."%' OR ";
			$q.= "Description LIKE '%".$_GET['K']."%') ";
		}
	}

	if (isset($_GET["do_Orphans"])) {
		$q.= "AND MaintainerUID = 0 ";
	}

	if (isset($_GET['outdated'])) {
		$q .= "AND OutOfDate = 1 ";
	}

	if (isset($_GET["SO"])) {
		$order = $_GET["SO"] == 'd' ? 'DESC' : 'ASC';
	} else {
		$order = "ASC";
	}  
	$q_sort = "ORDER BY Name ".$order." ";
	
	if (isset($_GET["SB"])) {
		switch ($_GET["SB"]) {
		case 'c':
			$q_sort = "ORDER BY CategoryID ".$order.", Name ASC ";
			break;
		case 'v':
			$q_sort = "ORDER BY NumVotes ".$order.", Name ASC ";
			break;
		case 'w':
			if ($SID) {
				$q_sort = "ORDER BY Voted ".$order.", Name ASC ";
			}
			break;
		case 'o':
			if ($SID) {
				$q_sort = "ORDER BY Notify ".$order.", Name ASC ";
			}
			break;
		case 'm':
			$q_sort = "ORDER BY Maintainer ".$order.", Name ASC ";
			break;
		case 'a':
			$q_sort = "ORDER BY GREATEST(SubmittedTS,ModifiedTS) ".$order.", Name ASC ";
			break;
		default:
			break;
		}
	}

	$q.= $q_sort;

	$q.= "LIMIT ".$_GET["O"].", ".$_GET["PP"];

	$result = db_query($q, $dbh);
	$total = mysql_result(db_query('SELECT FOUND_ROWS() AS Total', $dbh), 0);

	if ($result && $total > 0) {
		if ($_GET["SO"] == "d"){
			$SO_next="a";
			$_GET["SO"] = 'd';
		}
		else {
			$SO_next="d";
			$_GET["SO"] = 'a';
		}
	}

	// figure out the results to use
	$first = $_GET['O'] + 1;

	if (($_GET['PP'] + $_GET['O']) > $total) {
		$last = $total;
	} else {
		$last = $_GET['PP'] + $_GET['O'];
	}

	include('pkg_search_form.php');
	include('pkg_search_results.php');

	return;
}

/**
 * Flag and un-flag packages out-of-date
 *
 * @param string $atype Account type, output of account_from_sid
 * @param array $ids Array of package IDs to flag/unflag
 * @param boolean $action True flags out-of-date, false un-flags. Flags by
 * default
 *
 * @return string Translated success or error messages
 */
function pkg_flag ($atype, $ids, $action = true) {
	if (!$atype) {
		if ($action) {
			return __("You must be logged in before you can flag packages.");
		} else {
			return __("You must be logged in before you can unflag packages.");
		}
	}

	if (empty($ids)) {
		if ($action) {
			return __("You did not select any packages to flag.");
		} else {
			return __("You did not select any packages to unflag.");
		}
	}

	foreach ($ids as $pid) {
		if (!is_numeric($pid)) {
			if ($action) {
				return __("You did not select any packages to flag.");
			} else {
				return __("You did not select any packages to unflag.");
			}
		}
	}

	$dbh = db_connect();

	$ood = $action ? 1 : 0;
	$q = "UPDATE Packages SET OutOfDate = " . $ood;
	$q.= " WHERE ID IN (" . implode(",", $ids) . ")";

	db_query($q, $dbh);

	if ($action) {
		# Notify of flagging by email
		$f_name = username_from_sid($_COOKIE['AURSID']);
		$f_email = email_from_sid($_COOKIE['AURSID']);
		$f_uid = uid_from_sid($_COOKIE['AURSID']);
		$q = "SELECT Packages.Name, Users.Email, Packages.ID ";
		$q.= "FROM Packages, Users ";
		$q.= "WHERE Packages.ID IN (" . implode(",", $ids) .") ";
		$q.= "AND Users.ID = Packages.MaintainerUID ";
		$q.= "AND Users.ID != " . $f_uid;
		$result = db_query($q, $dbh);
		if (mysql_num_rows($result)) {
			while ($row = mysql_fetch_assoc($result)) {
			
				# construct email
				$body = "Your package {$row['Name']} has been flagged out of date by ".
				        "{$f_name}. You may view your package at:\n".
					"http://chakraos.org/ccr/packages.php?ID={$row['ID']}";
				$body = wordwrap($body, 70);	
				$email = $row['Email'];	
				$headers = "To: {$email}\nReply-to: noreply@chakraos.org\nFrom:noreply@chakraos.org\nX-Mailer: PHP\nX-MimeOLE: Produced By CCR";
				$subject = "CCR Out-of-date Notification for {$row['Name']}";
	
				@mail("", $subject, $body, $headers);
			}
		}

	}

	if ($action) {
		return __("The selected packages have been flagged out-of-date.");
	} else {
		return __("The selected packages have been unflagged.");
	}
}

# Removes a directory recursively
function remove_dir($sDir) {
	if (is_dir($sDir)) {
		$sDir = rtrim($sDir, '/');
		$oDir = dir($sDir);
		while (($sFile = $oDir->read()) !== false) {
			if ($sFile != '.' && $sFile != '..') {
				(!is_link("$sDir/$sFile") && is_dir("$sDir/$sFile")) ? remove_dir("$sDir/$sFile") : unlink("$sDir/$sFile");
			}
		}
		$oDir->close();
		rmdir($sDir);
	}
	return;
}

/**
 * Delete packages
 *
 * @param string $atype Account type, output of account_from_sid
 * @param array $ids Array of package IDs to delete
 *
 * @return string Translated error or success message
 */
function pkg_delete ($atype, $ids) {
	if (!$atype) {
		return __("You must be logged in before you can disown packages.");
	}

	if (empty($ids)) {
		return __("You did not select any packages to delete.");
	}

	# Delete the packages in $ids array (but only if they are Unsupported)
	#
	$dbh = db_connect();

	# Delete the packages in $ids array
	#
	$first = 1;
	foreach ($ids as $pid) {
		if ($first) {
			$first = 0;
			$delete = $pid;
		} else {
			$delete .= ", ".$pid;
		}
	}

	$field = "MaintainerUID";

	# Only grab Unsupported packages that "we" own or are not owned at all
	$ids_to_delete = array();
	$q = "SELECT Packages.ID,Packages.Name FROM Packages ";
	$q.= "WHERE Packages.ID IN (" . $delete . ") ";

	# If they're a TU or dev, can delete
	if ($atype == "Trusted User" || $atype == "Developer") {
		$result = db_query($q, $dbh);
	}

	if ($result != Null && mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$ids_to_delete[] = $row['ID'];
                        $folders_to_delete[] = $row['Name'];
		}
	}

	if (empty($ids_to_delete)) {
		return __("None of the selected packages could be deleted.");
	}

	# These are the packages that are safe to delete
	foreach ($ids_to_delete as $id) {
		$q = "DELETE FROM PackageVotes WHERE PackageID = " . $id;
		$result = db_query($q, $dbh);

		$q = "DELETE FROM PackageDepends WHERE PackageID = " . $id;
		$result = db_query($q, $dbh);

		$q = "DELETE FROM PackageSources WHERE PackageID = " . $id;
		$result = db_query($q, $dbh);

		$q = "DELETE FROM PackageComments WHERE PackageID = " . $id;
		$result = db_query($q, $dbh);

		$q = "DELETE FROM Packages WHERE ID = " . $id;
		$result = db_query($q, $dbh);

		$q = "DELETE FROM CommentNotify WHERE PkgID = " . $id;
		$result = db_query($q, $dbh);
	}

	# Actually remove the folder
	#foreach ($folders_to_delete as $folder) {
        #        $folder_uri = INCOMING_DIR . substr($folder, 0, 2) . "/" . $folder;
        #        remove_dir($folder_uri);
        #}      

	return __("The selected packages have been deleted.");
}

/**
 * Adopt or disown packages
 *
 * @param string $atype Account type, output of account_from_sid
 * @param array $ids Array of package IDs to adopt/disown
 * @param boolean $action Adopts if true, disowns if false. Adopts by default
 *
 * @return string Translated error or success message
 */
function pkg_adopt ($atype, $ids, $action = True) {
	if (!$atype) {
		if ($action) {
			return __("You must be logged in before you can adopt packages.");
		} else {
			return __("You must be logged in before you can disown packages.");
		}
	}

	if (empty($ids)) {
		if ($action) {
			return __("You did not select any packages to adopt.");
		} else {
			return __("You did not select any packages to disown.");
		}
	}

	$dbh = db_connect();

	$first = 1;
	foreach ($ids as $pid) {
		if ($first) {
			$first = 0;
			$pkg = $pid;
		} else {
			$pkg .= ", ".$pid;
		}
	}

	$field = "MaintainerUID";
	$q = "UPDATE Packages ";

	if ($action) {
		$user = uid_from_sid($_COOKIE["AURSID"]);
	} else {
		$user = 0;
	}

	$q.= "SET $field = $user ";
	$q.= "WHERE ID IN ($pkg) ";

	if ($action && $atype == "User") {
		$q.= "AND $field = 0 ";
	} else if ($atype == "User") {
		$q.= "AND $field = " . uid_from_sid($_COOKIE["AURSID"]);
	}

	db_query($q, $dbh);

	if ($action) {
		return __("The selected packages have been adopted.");
	} else {
		return __("The selected packages have been disowned.");
	}
}

/**
 * Vote and un-vote for packages
 *
 * @param string $atype Account type, output of account_from_sid
 * @param array $ids Array of package IDs to vote/un-vote
 * @param boolean $action Votes if true, un-votes if false. Votes by default
 *
 * @return string Translated error or success message
 */
function pkg_vote ($atype, $ids, $action = True) {
	if (!$atype) {
		if ($action) {
			return __("You must be logged in before you can vote for packages.");
		} else {
			return __("You must be logged in before you can un-vote for packages.");
		}
	}

	if (empty($ids)) {
		if ($action) {
			return __("You did not select any packages to vote for.");
		} else {
			return __("Your votes have been removed from the selected packages.");
		}
	}

	$dbh = db_connect();
	$my_votes = pkgvotes_from_sid($_COOKIE["AURSID"]);
	$uid = uid_from_sid($_COOKIE["AURSID"]);

	$first = 1;
	foreach ($ids as $pid) {
		if ($action) {
			$check = !isset($my_votes[$pid]);
		} else {
			$check = isset($my_votes[$pid]);
		}

		if ($check) {
			if ($first) {
				$first = 0;
				$vote_ids = $pid;
				if ($action) {
					$vote_clauses = "($uid, $pid)";
				}
			} else {
				$vote_ids .= ", $pid";
				if ($action) {
					$vote_clauses .= ", ($uid, $pid)";
				}
			}
		}
	}

	# only vote for packages the user hasn't already voted for
	#
	$op = $action ? "+" : "-";
	$q = "UPDATE Packages SET NumVotes = NumVotes $op 1 ";
	$q.= "WHERE ID IN ($vote_ids)";

	db_query($q, $dbh);

	if ($action) {
		$q = "INSERT INTO PackageVotes (UsersID, PackageID) VALUES ";
		$q.= $vote_clauses;
	} else {
		$q = "DELETE FROM PackageVotes WHERE UsersID = $uid ";
		$q.= "AND PackageID IN ($vote_ids)";
	}

	db_query($q, $dbh);

	if ($action) {
		$q = "UPDATE Users SET LastVoted = UNIX_TIMESTAMP() ";
		$q.= "WHERE ID = $uid";

		db_query($q, $dbh);
	}

	if ($action) {
		return __("Your votes have been cast for the selected packages.");
	} else {
		return __("Your votes have been removed from the selected packages.");
	}
}

/**
 * Toggle notification of packages
 *
 * @param string $atype Account type, output of account_from_sid
 * @param array $ids Array of package IDs to toggle, formatted as $package_id
 * @return string Translated error or success message
 */
function pkg_notify ($atype, $ids, $action = True) {
	if (!$atype) {
#		return __("You must be logged in before you can get notifications on comments.");
		return;
	}

	if (empty($ids)) {
		return __("Couldn't add to notification list.");
	}

	$dbh = db_connect();
	$uid = uid_from_sid($_COOKIE["AURSID"]);

	$output = "";

	$first = True;

	# There currently shouldn't be multiple requests here, but the
	# format in which it's sent requires this.
	foreach ($ids as $pid) {
		$q = "SELECT Name FROM Packages WHERE ID = $pid";
		$pkgname = mysql_result(db_query($q, $dbh), 0);

		if ($first)
			$first = False;
		else
			$output .= ", ";


		if ($action) {
			$q = "SELECT * FROM CommentNotify WHERE UserID = $uid";
			$q .= " AND PkgID = $pid";

			# Notification already added. Don't add again.
			if (!mysql_num_rows(db_query($q, $dbh))) {
				$q = "INSERT INTO CommentNotify (PkgID, UserID) VALUES ($pid, $uid)";
				db_query($q, $dbh);
			}

			$output .= $pkgname;
		}
		else {
			$q = "DELETE FROM CommentNotify WHERE PkgID = $pid";
			$q .= " AND UserID = $uid";
			db_query($q, $dbh);

			$output .= $pkgname;
		}
	}

	if ($action) {
		$output = __("You have been added to the comment notification list for %s.", $output);
	}
	else {
		$output = __("You have been removed from the comment notification list for %s.", $output);
	}

	return $output;
}

/**
 * Delete comment
 *
 * @param string $atype Account type, output of account_from_sid
 * @return string Translated error or success message
 */
function pkg_delete_comment($atype) {
	if (!$atype) {
		return __("You must be logged in before you can edit package information.");
	}

	# Get ID of comment to be removed
	if (isset($_POST["comment_id"])) {
		$comment_id = $_POST["comment_id"];
	} else {
		return __("Missing comment ID.");
	}

	$uid = uid_from_sid($_COOKIE["AURSID"]);
	if (canDeleteComment($comment_id, $atype, $uid)) {

		   $dbh = db_connect();
		   $q = "UPDATE PackageComments ";
		   $q.= "SET DelUsersID = ".$uid." ";
		   $q.= "WHERE ID = ".intval($comment_id);
		   db_query($q, $dbh);
		   return __("Comment has been deleted.");
	} else {
		   return __("You are not allowed to delete this comment.");
	}
}

function current_action($action) {
	return (isset($_POST['action']) && $_POST['action'] == $action) ||
		isset($_POST[$action]);
}

/**
 * Change package category
 *
 * @param string $atype Account type, output of account_from_sid
 * @return string Translated error or success message
 */
function pkg_change_category($atype) {
	if (!$atype)  {
		return __("You must be logged in before you can edit package information.");
	}

	# Get ID of the new category
	if (isset($_POST["category_id"])) {
		$category_id = $_POST["category_id"];
	} else {
		return __("Missing category ID.");
	}

	$catArray = pkgCategories();
	if (!array_key_exists($category_id, $catArray)) {
		return __("Invalid category ID.");
	}

	if (isset($_GET["ID"])) {
		$pid = $_GET["ID"];
	} else {
		return __("Missing package ID.");
	}

	# Verify package ownership
	$dbh = db_connect();
	$q = "SELECT Packages.MaintainerUID ";
	$q.= "FROM Packages ";
	$q.= "WHERE Packages.ID = ".$pid;
	$result = db_query($q, $dbh);
	if ($result) {
		$pkg = mysql_fetch_assoc($result);
	}
	else {
		return __("You are not allowed to change this package category.");
	}

	$uid = uid_from_sid($_COOKIE["AURSID"]);
	if ($uid == $pkg["MaintainerUID"] or
	($atype == "Developer" or $atype == "Trusted User")) {
		$q = "UPDATE Packages ";
		$q.= "SET CategoryID = ".intval($category_id)." ";
		$q.= "WHERE ID = ".intval($pid);
		db_query($q, $dbh);
		return __("Package category updated.");
	} else {
		return __("You are not allowed to change this package category.");
	}
}

// Form FluxBB, some awesome functions
//-----------------------------------------------------------------------------

//
// Equivalent to htmlspecialchars(), but allows &#[0-9]+ (for unicode)
//
function ccr_htmlspecialchars($str)
{
	$str = preg_replace('/&(?!#[0-9]+;)/s', '&amp;', $str);
	$str = str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $str);

	return $str;
}


//
// Convert a series of smilies to images
//
function do_smilies($text)
{
	// Here you can add additional smilies if you like (please note that you must escape singlequote and backslash)
	$smiley_text = array(':)', '=)', ':|', '=|', ':(', '=(', ':D', '=D', ':o', ':O', ';)', ':/', ':P', ':lol:', ':mad:', ':rolleyes:', ':cool:');
	$smiley_img = array('smile.png', 'smile.png', 'neutral.png', 'neutral.png', 'sad.png', 'sad.png', 'big_smile.png', 'big_smile.png', 'yikes.png', 'yikes.png', 'wink.png', 'hmm.png', 'tongue.png', 'lol.png', 'mad.png', 'roll.png', 'cool.png');
	$text = ' '.$text.' ';
	$num_smilies = count($smiley_text);
	for ($i = 0; $i < $num_smilies; ++$i)
		$text = preg_replace("#(?<=.\W|\W.|^\W)".preg_quote($smiley_text[$i], '#')."(?=.\W|\W.|\W$)#m", '$1<img src="images/smilies/'.$smiley_img[$i].'" width="15" height="15" alt="'.substr($smiley_img[$i], 0, strrpos($smiley_img[$i], '.')).'" />$2', $text);
	return substr($text, 1, -1);
}

//
// Truncate URL if longer than 55 characters (add http:// or ftp:// if missing)
//
function handle_url_tag($url, $link = '') {	
$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
	if (strpos($url, 'www.') === 0)			// If it starts with www, we add http://
		$full_url = 'http://'.$full_url;
	else if (strpos($url, 'ftp.') === 0)	// Else if it starts with ftp, we add ftp://
		$full_url = 'ftp://'.$full_url;
	else if (!preg_match('#^([a-z0-9]{3,6})://#', $url, $bah)) 	// Else if it doesn't start with abcdef://, we add http://
		$full_url = 'http://'.$full_url;

	// Ok, not very pretty :-)
	$link = ($link == '' || $link == $url) ? ((strlen($url) > 55) ? substr($url, 0 , 39).' &hellip; '.substr($url, -10) : $url) : stripslashes($link);

	return '<a href="'.$full_url.'">'.$link.'</a>';
}

//
// Turns an URL from the [img] tag into an <img> tag or a <a href...> tag
//
function handle_img_tag($url) {
	$img_tag = '<a href="'.$url.'">&lt;'.__("Image link").'&gt;</a>';
	$img_tag = '<img style="width:98%" src="'.$url.'" alt="'.htmlspecialchars($url).'" />';
	return $img_tag;
}

//
// Make hyperlinks clickable
//
function do_clickable($text) {
	$text = ' '.$text;

	$text = preg_replace('#([\s\(\)])(https?|ftp|news){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2://$3\')', $text);
	$text = preg_replace('#([\s\(\)])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2.$3\', \'$2.$3\')', $text);

	return substr($text, 1);
}

// Check for a remote file
function RemoteFileExists($path) {
	if ($path == "") {
		return false;
	} else {
		return (@fopen($path,"r")==true);
	}
}

//
//  Pkgbuild Checks
//

// Removes comments from a pkgdesc line 
function strip_comments($text) {

	# TODO: That should be improved a lot to fit any variable

	$pass1 = preg_replace('/(".*"|\s*#.*|\'.*\')/', '', $text);
	if ( $pass1 != '' ) {
		$pass2 = str_replace($pass1,'', $text);
		$pass3 = preg_replace('/(".*"|\'.*\')/', '', $pass2);
		$final = str_replace($pass3,'', $text);
	} 
	else {
		$final = '';
	}
	return $final;
}

// Allow some use cases for pkgver
// used for direct values like pkgver=$(date -u +%Y%m%d)
function parse_pkgver_input($text) {

	# The user sets pkgver as the daily date
	$text = preg_replace('/(`|\$\()date.*\+%Y%m%d(`|\))/','ccr_pkgver_daily_build', $text);

	return $text;
}

// Use for indirect values like pkgver=${myvar//a/b}
function post_parse_pkgver_input($text) {

	if (!preg_match('/\}/',$text)) return $text;

	$parts = explode("}",$text);
	$result = '';
	foreach ($parts as $part) {
		# Basic bash replace ${myvar//a/b}
		if (preg_match('#\/\/.*\/.*#', $part)) {
		$process = explode("/", $part);
		$part = str_replace($process[2], $process[3], $process[0]);
		$result.= $part;
		}
		# Basic bash single replace ${myvar/a/b}
		else if (preg_match('#\/.*\/.*#', $part)) {
			$process = explode("/", $part);
			$part = preg_replace("/$process[1]/", $process[2], $process[0], 1);
			$result.= $part;
		}
		# Basic bash explode ${myvar%.*}
		else if (preg_match('#\%.*#', $part)) {
			$process = explode("%", $part);
			$part = implode(str_replace("*", "", $process[1]),explode(str_replace("*", "", $process[1]), $process[0], -1));
			$result.= $part;
		}
		else {
			$result.= $part;
		}
        }
	return $result;
}

// Restore direct values special replacements
function parse_pkgver_output($text) {

	# The user sets pkgver as the daily date
	$text = str_replace ("ccr_pkgver_daily_build", gmdate("Ymd"), $text);
  
	return $text;
}

// Trims any spaces to maximum one space
function trim_spaces($what) {
        $str = preg_replace("/[ \t\n\r]+/", " ", $what);
        return $str;
}

function url_good($url) {

    if ($url == "") return false;

    if (fopen($url, "r")) {
	return true;
    } else {
        return false;
    }
}
