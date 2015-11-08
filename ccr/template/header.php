<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print "$LANG\" lang=\"$LANG"; ?>">

<head>
    <title>Chakra | CCR (<?php print htmlspecialchars($LANG); ?>)<?php if ($title != "") { print " - " . htmlspecialchars($title); } ?></title>
	<link rel='stylesheet' type='text/css' href='css/fonts.css' />
	<link rel='stylesheet' type='text/css' href='css/containers.css' />
	<link rel='stylesheet' type='text/css' href='css/chakra.css' />
	<link rel='shortcut icon' href='images/favicon.ico' type='image/x-icon'  />
	<link rel="icon" href="images/favicon.ico" type='image/x-icon' />
	<link rel='alternate' type='application/rss+xml' title='Newest Packages RSS' href='rss.php' />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
<body>
<div id="shadow_left"><div id="shadow_right">
    <div id="head_container">
	<div id="title">
	    <div id="logo"><h1 id="chakratitle"><a href="http://www.chakraos.org/" title="Chakra">Chakra</a></h1></div>
	</div>
      <div id="main_nav">
        <ul>
                        <li><a href="../?donations">Donate</a></li>
                        <li><a href="http://git.chakraos.org">Git</a></li>
                        <li><a href="../reviewboard/">Review Board</a></li>
			<li><a href="../bugtracker/">Bugtracker</a></li>
			<li class="selected"><a href="../ccr/">CCR</a></li>
                        <!-- <li><a href="../packages/">Packages</a></li> -->
                        <li><a href="http://rsync.chakraos.org">Packages</a></li>
			<li><a href="../wiki/">Wiki</a></li>
			<li><a href="../forum/">Forum</a></li>
			<li><a href="../news/">News</a></li>
			<li><a href="../?get">Download</a></li>
			<li><a href="../">Home</a></li>
        </ul>
      </div>
      <div id="sub_nav">
        <ul>
<?php
if (isset($_COOKIE["AURSID"])) {
?>
	  <li><a href="pkgsubmit.php"><?php print __("Submit"); ?></a></li>
          <li><a href="packages.php?SeB=m&K=<?php print username_from_sid($_COOKIE["AURSID"]); ?>"><?php print __("My Packages"); ?></a></li>
<?php
	$SID = $_COOKIE['AURSID'];
	$atype = account_from_sid($SID);
	if ($atype == "Trusted User" || $atype == "Developer") { 
?>
	      <li><a href="account.php?Action=DisplayAccount&ID=<?php print uid_from_sid($_COOKIE["AURSID"]); ?>"><?php print __("My Account"); ?></a></li>
	      <li><a href="tu.php"><?php print __("Trusted User"); ?></a></li> 
<?php
	}
}
?>
          <li><a href="http://groups.google.com/group/chakra-packagers"><?php print __("Discussion"); ?></a></li>
          <li><a href="packages.php"><?php print __("Packages"); ?></a></li>
          <li><a href="account.php"><?php print __("Accounts"); ?></a></li> 
          <li><a href="index.php">CCR <?php print __("Home"); ?></a></li>
        </ul>
      </div>
<    <div id="lang_login_sub">
	<?php

	# language selection
	reset($SUPPORTED_LANGS);
	$select_lang = "<form method='get' action='".htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES)."'>\n";
	if (isset($_GET['ID'])) {
		  $select_lang.= "<input type='hidden' name='ID' value='".htmlspecialchars($_GET['ID'])."'>\n";
	}
	if (isset($_GET['p'])) {
		  $select_lang.= "<input type='hidden' name='p' value='".urlencode($_GET['p'])."'>\n";
	}
	$select_lang.= "<select name='setlang'>\n";
	foreach ($SUPPORTED_LANGS as $lang => $lang_name) {
		if ($lang == $LANG) {
			$select_lang.= "<option selected='selected' value='$lang'>".htmlspecialchars($SUPPORTED_LANGS[$lang])."</option>";
		}
		else {
			$select_lang.= "<option value='$lang'>".htmlspecialchars($SUPPORTED_LANGS[$lang])."</option>";
		}
	}
	$select_lang.= "</select>&nbsp;<input class='button' type='submit' value=' ".__("Go")." ' />";
	$select_lang.= "</form>";

        echo "<div id='lang_bar'>".$select_lang."</div>";

        ?>
	<br />
        <?php  include_once("login_form.php"); ?>

    </div>
    <div id="maincontent"> 
	  <!-- Start of main content -->
