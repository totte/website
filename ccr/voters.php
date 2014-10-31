<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/' . PATH_SEPARATOR . 'template/');
include('aur.inc');
include('pkgfuncs.inc');

function getvotes($pkgid) {
	$dbh = db_connect();
	$pkgid = mysql_real_escape_string($pkgid);

	$result = db_query("SELECT UsersID,Username FROM PackageVotes LEFT JOIN Users on (UsersID = ID) WHERE PackageID = $pkgid ORDER BY Username", $dbh);
	return $result;
}

$SID = $_COOKIE['AURSID'];

$pkgid = $_GET['ID'];
$votes = getvotes($pkgid);
$account = account_from_sid($SID);

html_header(); ?>
<html>
<body>
<div class="pgbox">
    <?php if ($account == 'Trusted User' || $account == 'Developer') { ?>
	<div class="pgboxtitle">
	    <span class="f3"><?php echo htmlentities(account_from_sid($SID)); ?></span>
	</div>
</div>

<div class="pgbox">
	<div class="pgboxtitle">
		<span class="f3"><? print __("Votes for") ?>  <a href="packages.php?ID=<?php echo urlencode($pkgid); ?>"><?php echo htmlentities(pkgname_from_id($pkgid)); ?></a></span>
	</div>
	<div class="pgboxbody"><?php
		while ($row = mysql_fetch_assoc($votes)) {
			$uid = $row['UsersID'];
			$username = $row['Username']; ?>
			<a href="account.php?Action=AccountInfo&ID=<?php echo urlencode($uid); ?>">
			<?php print htmlentities($username); ?></a><br /> <?php
		}
		?>
	</div>
</div>
<?php 
html_footer(AUR_VERSION);
?>
</body>
</html>
<?php
}

