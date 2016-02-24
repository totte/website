<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="../../static/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../../static/css/chakra.css"/>
	<link rel='stylesheet' type='text/css' href='../css/fonts.css' />
	<link rel='stylesheet' type='text/css' href='../css/containers.css' />
	<link rel='stylesheet' type='text/css' href='../css/chakra.css' />
	<link rel="icon" href="../../static/img/favicon.ico" type="image/x-icon"/>
	<link rel="search" href="opensearch_ssl.xml" type="application/opensearchdescription+xml" title="DuckDuckGo (Chakra)"/>
	<link rel='alternate' type='application/rss+xml' title='Newest Packages RSS' href='rss.php' />
	<script type="text/javascript" src="../../static/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../../static/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../static/js/jquery-ui.js"></script>
	<script type="text/javascript" src="../../static/js/jquery.animated.innerfade.js"></script>
	<script type="text/javascript">
		$(function () {
			$("#tabs").tabs();
		});
	</script>
	<script type="text/javascript">
		/* <![CDATA[ */
		(function () {
			var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
			s.type = 'text/javascript';
			s.async = true;
			s.src = 'https://api.flattr.com/js/0.5.0/load.js?mode=auto';
			t.parentNode.insertBefore(s, t);
		})();
		/* ]]> */
	</script>
	<title>Chakra | CCR (<?php print htmlspecialchars($LANG); ?>)<?php if ($title != "") { print " - " . htmlspecialchars($title); } ?></title>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="../../static/js/html5shiv.js"></script>
	<script type="text/javascript" src="../../static/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="https://chakraos.org"><img src="static/img/logotype.png" style="max-width: 24px" />&nbsp;Chakra</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="news/">News</a></li>
				<li><a href="http://rsync.chakraos.org/packages">Packages</a></li>
				<li><a href="ccr/">CCR</a></li>
				<li><a href="forum/">Forum</a></li>
				<li><a href="wiki/">Wiki</a></li>
				<li><a href="bugtracker/">Bugtracker</a></li>
				<li><a href="http://git.chakraos.org">Source code</a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>
<div class="container">
	<div class="row">
		<div id="sub_nav">
			<ul>
				<?php if (isset($_COOKIE["AURSID"])) { ?>
					<li><a href="pkgsubmit.php"><?php print __("Submit"); ?></a></li>
					<li><a href="packages.php?SeB=m&K=<?php print username_from_sid($_COOKIE["AURSID"]); ?>"><?php print __("My Packages"); ?></a></li>
					<?php
					$SID = $_COOKIE['AURSID'];
					$atype = account_from_sid($SID);
					if ($atype == "Trusted User" || $atype == "Developer") {
						?>
						<li><a href="account.php?Action=DisplayAccount&ID=<?php print uid_from_sid($_COOKIE["AURSID"]); ?>"><?php print __("My Account"); ?></a></li>
						<li><a href="tu.php"><?php print __("Trusted User"); ?></a></li>
					<?php } } ?>
				<li><a href="http://groups.google.com/group/chakra-packagers"><?php print __("Discussion"); ?></a></li>
				<li><a href="packages.php"><?php print __("Packages"); ?></a></li>
				<li><a href="account.php"><?php print __("Accounts"); ?></a></li>
				<li><a href="index.php">CCR <?php print __("Home"); ?></a></li>
			</ul>
		</div>
		<div id="lang_login_sub">
			<?php
			# Language selection
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
			<?php include_once("login_form.php"); ?>
		</div>
		<div id="maincontent">
			<!-- Start of main content -->
