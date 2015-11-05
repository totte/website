<?php
require_once 'functions.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="static/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="static/css/chakra.css"/>
	<link rel="icon" href="static/img/favicon.ico" type="image/x-icon"/>
	<link rel="search" href="opensearch_ssl.xml"
		  type="application/opensearchdescription+xml"
		  title="DuckDuckGo (Chakra)"/>
	<script type="text/javascript" src="static/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="static/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="static/js/jquery-ui.js"></script>
	<script type="text/javascript"
			src="static/js/jquery.animated.innerfade.js"></script>
	<script type="text/javascript">
		$(function () {
			$("#tabs").tabs();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(
			function () {
				$('ul#animated-portfolio').animatedinnerfade({
					speed: 2000,
					timeout: 6000,
					type: 'random',
					containerheight: '255px',
					containerwidth: '340px',
					animationSpeed: 5000,
					animationtype: 'fade',
					bgFrame: 'none',
					controlBox: 'none',
					displayTitle: 'none'
				});
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
	<title>Chakra | Home</title>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="static/js/html5shiv.js"></script>
	<script type="text/javascript" src="static/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="shadow_left">
	<div class="shadow_right">
		<div id="wrapper">
			<div id="navigation">
				<ul>
					<li><a href="?donations">Donate</a></li>
					<li><a href="http://git.chakraos.org">Git</a></li>
					<li><a href="reviewboard/">Review Board</a></li>
					<li><a href="bugtracker/">Bugtracker</a></li>
					<li><a href="ccr/">CCR</a></li>
					<!-- <li><a href="../packages/">Packages</a></li> -->
					<li><a href="http://rsync.chakraos.org">Packages</a></li>
					<li><a href="wiki/">Wiki</a></li>
					<li><a href="forum/">Forum</a></li>
					<li><a href="news/">News</a></li>
					<li><a href="?get">Download</a></li>
					<li class="selected"><a href="index.php">Home</a></li>
				</ul>
			</div>
			<!-- /#navigation -->
			<div id="content">
				<div class="row">
					<div id="chakra_nav">
						<ul>
							<li><a href="https://twitter.com/chakraos"
								   target="_blank"><img
										src="static/img/twitter32.png"
										border="0" alt="" width="22" height="22"
										style="margin-top: -3px;"/></a></li>
							<li>
								<a href="https://www.facebook.com/chakraos"
								   target="_blank"><img
										src="static/img/facebook32.png"
										border="0" alt="" width="22" height="22"
										style="margin-top: -3px;"/></a></li>
							<li>
								<a href="https://plus.google.com/+chakraos"
								   target="_blank"><img
										src="static/img/googleplus32.png"
										border="0" alt="" width="22" height="22"
										style="margin-top: -3px;"/></a></li>
							<li><a href="https://www.reddit.com/r/chakra"
								   target="_blank"><img
										src="static/img/logotype_reddit_32x32.png"
										border="0" alt="" width="22" height="22"
										style="margin-top: -3px;"/></a></li>
							<li><a href="https://www.identi.ca/thechakraproject"
								   target="_blank"><img
										src="static/img/logotype_identica_32x32.png"
										border="0" alt="" width="22" height="22"
										style="margin-top: -3px;"/></a></li>
							<li>
								<a href="https://joindiaspora.com/people/bbe1261d580884b3"
								   target="_blank"><img
										src="static/img/logotype_diaspora_32x32.png"
										border="0" alt="" width="22" height="22"
										style="margin-top: -3px;"/></a></li>
						</ul>
					</div>
					<?php
					if (isset($_GET['get'])) {
						require_once('get.php');
					} elseif (isset($_GET['what'])) {
						require_once('what.php');
					} elseif (isset($_GET['who'])) {
						require_once('who.php');
					} elseif (isset($_GET['welcome'])) {
						require_once('welcome.php');
					} elseif (isset($_GET['donations'])) {
						require_once('donations.php');
					} elseif (isset($_GET['campaign'])) {
						require_once('campaign.php');
                    } elseif (isset($_GET['mirrors'])) {
                        require_once('mirrors.php');
					} elseif (isset($_GET['infrastructure'])) {
						require_once('infrastructure.php');
					} else {
						require_once('home.php');
					}
					?>
				</div>
			</div>
			<!-- /#content -->

			<div id="footer">
				<script type="text/javascript">
					var now = new Date();
					document.write("Copyright &copy; 2006-" + now.getFullYear());
				</script>
				<a href="mailto:administrator@chakraos.org">Chakra</a>
				&nbsp;
				&middot;
				&nbsp;
				Sponsored by <a href="http://www.host1plus.com">Host1Plus</a>
			</div>
			<!-- /#footer -->
		</div>
		<!-- /#wrapper -->
	</div>
	<!-- /.right_shadow -->
</div>
<!-- /.left_shadow -->
</body>
</html>
