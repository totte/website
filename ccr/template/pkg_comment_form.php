<?php
# Add a comment to this package
if (isset($_REQUEST['comment'])) {

	# Insert the comment
	$dbh = db_connect();
	$q = 'INSERT INTO PackageComments ';
	$q.= '(PackageID, UsersID, Comments, CommentTS) VALUES (';
	$q.= intval($_REQUEST['ID']) . ', ' . uid_from_sid($_COOKIE['AURSID']) . ', ';
	$q.= "'" . mysql_real_escape_string($_REQUEST['comment']) . "', ";
	$q.= 'UNIX_TIMESTAMP())';
	db_query($q, $dbh);

	# Send email notifications
	$q = 'SELECT CommentNotify.*, Users.Email ';
	$q.= 'FROM CommentNotify, Users ';
	$q.= 'WHERE Users.ID = CommentNotify.UserID ';
	$q.= 'AND CommentNotify.UserID != ' . uid_from_sid($_COOKIE['AURSID']) . ' ';
	$q.= 'AND CommentNotify.PkgID = ' . intval($_REQUEST['ID']);
	$result = db_query($q, $dbh);
	$bcc = array();

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$bcc[] = $row['Email'];
		}

		$q = 'SELECT Packages.Name ';
		$q.= 'FROM Packages ';
		$q.= 'WHERE Packages.ID = ' . intval($_REQUEST['ID']);
		$result = db_query($q, $dbh);
		$row = mysql_fetch_assoc($result);

		# TODO: native language emails for users, based on their prefs
		# Simply making these strings translatable won't work, users would be
		# getting emails in the language that the user who posted the comment was in
		$tobcc = implode(',', $bcc);
		$body =	'from http://chakraos.org/ccr/packages.php?ID=' . $_REQUEST['ID'] . "\n".
		        username_from_sid($_COOKIE['AURSID']) . " wrote:\n\n".
		        $_POST['comment'] . "\n\n---\n".
		        "If you no longer wish to receive notifications about this package, please go the the above package page and click the UnNotify button.\n";
		$body = wordwrap($body, 70);

		$headers = "To: {$email}\nReply-to: noreply@chakraos.org\nFrom:noreply@chakraos.org\nX-Mailer: PHP\nX-MimeOLE: Produced By CCR";

		$subject = "CCR Comment for {$row['Name']}";

		@mail($tobcc, $subject, $body, $headers);
	}
}

	# Prompt visitor for comment
?>
<div class="pgbox">
	<form action='<?php echo $_SERVER['PHP_SELF'] . '?ID=' . $_REQUEST['ID'] ?>' method='post'>
	<div style="padding: 1%">
<?php
if (isset($_REQUEST['comment'])) {
	echo '<b>' . __("Comment has been added.") . '</b>';
}
?>
	<input type='hidden' name='ID' value="<?php echo $_REQUEST['ID'] ?>">
	<?php echo __("Enter your comment below.") ?><br />
	<textarea name='comment' rows='10' style="width: 100%"></textarea><br />
	<input type='submit' class='button' value="<?php echo __("Submit") ?>">
	<input type='reset' class='button' value="<?php echo __("Reset") ?>">
	</div>
	</form>
</div>

