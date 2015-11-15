<?php

set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/' . PATH_SEPARATOR . 'template/');

include_once("aur.inc");
set_lang();
check_sid();

include_once('stats.inc');

html_header( __("Home") );

include('pkg_search_form.php');

$dbh = db_connect();

?>
<div class="pgbox">
<div class="pgboxtitle">
<span class="f3">CCR <?php print __("Home"); ?></span>
</div>
<br />
<div class="frontpgboxbody">

<p>
<?php
echo __("Welcome to the Chakra Community Repo. Please read the %hCCR User Guidelines%h and %hCCR TU Guidelines%h for more information.",
	"<a href=\"../wiki/index.php?title=Chakra_Community_Repository\">",
	"</a>",
	"<a href=\"../wiki/index.php?title=How_to_become_a_packager#CCR_Trusted_User\">",
	"</a>"
        );
?>

<br />

<?php
echo __("Contributed PKGBUILDs and PKGINFOs %hmust%h conform to the %hChakra Packaging Standards%h otherwise they will be deleted!",
	"<b>", "</b>",
	"<a href=\"../wiki/index.php?title=Packaging_Standards\">",
	"</a>"
        );
?>

</p>
<p>

<?php
echo __("In order to install packages from CCR you should install %hccr%h and %hbase-devel%h first.","<b>","</b>","<b>","</b>");
?>
</p>

<p>
<?php echo __("Remember to vote for your favourite packages!"); ?>
<br />
<?php echo __("Some packages with no Gtk dependences may be provided as binaries in [apps] or [platform]"); ?>
</p>

<!-- <div class="important">
	<b>THE CCR IS UNDER MAINTENANCE AND WILL REMAIN READ-ONLY</b>
</div> -->

<table border='0' cellpadding='0' cellspacing='3' width='90%'>
<tr>
<td class='boxSoft' valign='top'>
<?php updates_table($dbh); ?>
</td>
<td class='boxSoft' valign='top'>
<?php
if (!empty($_COOKIE["AURSID"])) {
	$user = username_from_sid($_COOKIE["AURSID"]);
	user_table($user, $dbh);
	echo '<br />';
}

general_stats_table($dbh);
?>

</td>
</tr>
</table>

<br />
<div class="important" align="right">
	<img src="images/alert.png" align="center" />
	<?php echo __("The CCR files are user produced content. Any use of the provided files is at your own risk."); ?>
</div>
<br />
</div>
</div>

<?php
html_footer(AUR_VERSION);

