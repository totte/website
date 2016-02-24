<?php
	require_once 'functions.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="static/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="static/css/chakra.css"/>
		<link rel="icon" href="static/img/favicon.ico" type="image/x-icon"/>
		<link rel="search" href="opensearch_ssl.xml" type="application/opensearchdescription+xml" title="DuckDuckGo (Chakra)"/>
		<script type="text/javascript" src="static/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="static/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="static/js/jquery-ui.js"></script>
		<script type="text/javascript" src="static/js/jquery.animated.innerfade.js"></script>
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
		<title>Chakra - Stable core, bleeding edge applications!</title>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="static/js/html5shiv.js"></script>
		<script type="text/javascript" src="static/js/respond.min.js"></script>
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
<!--						<li><a href="?donations">Donate</a></li>-->
						<li><a href="http://git.chakraos.org">Source code</a></li>
						<!--<li><a href="reviewboard/">Review Board</a></li>-->
<!--						<li><a href="?get">Download</a></li>-->
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		<div class="container">
			<div class="row">
				<?php
				if (isset($_GET['get'])) {
					require_once('get.html');
				} elseif (isset($_GET['what'])) {
					require_once('what.html');
				} elseif (isset($_GET['contributors'])) {
					require_once('contributors.php');
				} elseif (isset($_GET['welcome'])) {
					require_once('welcome.html');
				} elseif (isset($_GET['donate'])) {
					require_once('donate.html');
				} elseif (isset($_GET['mirrorstatus'])) {
					require_once('mirrors.html');
				} elseif (isset($_GET['codeofconduct'])) {
					require_once('codeofconduct.html');
				} elseif (isset($_GET['legal'])) {
					require_once('legal.html');
				} else {
					require_once('home.html');
				}
				?>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<div class="row-footer">
				<div class="col-md-6">
					<ul class="footer-links">
						<li><strong>Mailing lists&nbsp;</strong></li>
						<li><a href="mailto:chakra-devel@googlegroups.com">Developers</a></li>
						<li class="muted">·</li>
						<li><a href="mailto:chakra-packagers@googlegroups.com">Packagers</a></li>
					</ul>
					<ul class="footer-links">
						<li><strong>IRC channels&nbsp;</strong></li>
						<li><a href="http://webchat.freenode.net/?channels=chakra">Users</a></li>
						<li class="muted">·</li>
						<li><a href="http://webchat.freenode.net/?channels=chakra-devel">Developers & Packagers</a></li>
					</ul>
					<ul class="footer-links">
						<li><strong>Social networks&nbsp;</strong></li>
						<li><a href="https://www.reddit.com/r/chakra">Reddit</a></li>
						<li class="muted">·</li>
						<li><a href="https://www.facebook.com/chakraos">Facebook</a></li>
						<li class="muted">·</li>
						<li><a href="https://plus.google.com/+chakraosorg">Google+</a></li>
						<li class="muted">·</li>
						<li><a href="https://twitter.com/chakraos">Twitter</a></li>
						<li class="muted">·</li>
						<li><a href="https://joindiaspora.com/people/bbe1261d580884b3">Diaspora</a></li>
						<li class="muted">·</li>
						<li><a href="https://www.identi.ca/thechakraproject">Identi.ca</a></li>
						<li class="muted">·</li>
						<li><a href="https://telegram.me/joinchat/ANIPGQZo-N4_5u0zveXBjg">Telegram</a></li>
					</ul>
					<ul class="footer-links">
						<li><strong>About&nbsp;</strong></li>
						<li><a href="?aboutchakra">About Chakra</a></li>
						<li class="muted">·</li>
						<li><a href="?contributors">Contributors</a></li>
						<li class="muted">·</li>
						<li><a href="?acknowledgements">Acknowledgements</a></li><!-- Former contributors, sponsors, donors, mirror providers etc. -->
						<li class="muted">·</li>
						<li><a href="?contact">Contact us</a></li>
						<li class="muted">·</li>
						<li><a href="?donate">Donate</a></li>
						<li class="muted">·</li>
						<li><a href="?getinvolved">Get involved</a></li>
					</ul>
					<ul class="footer-links">
						<li><strong>Miscellaneous&nbsp;</strong></li>
						<li><a href="?legal">Legal information</a></li>
						<li class="muted">·</li>
						<li><a href="?codeofconduct">Code of Conduct</a></li>
						<li class="muted">·</li>
						<li><a href="?mirrorstatus">Mirror status</a></li>
					</ul>
					<ul class="footer-links">
						<li><strong>Hosted by&nbsp;</strong></li>
						<li><a href="http://www.host1plus.com">Host1Plus</a></li>
					</ul>
				</div>
				<div class="col-md-6">
					<ul class="footer-copyright">
						<li><a href="https://co.clickandpledge.com/advanced/default.aspx?wid=92751"><img src="static/img/click_and_pledge.png" alt="Donate via Click&Pledge to Chakra" /></a></li>
						<li>Copyright &copy; 2006-<?php echo date("Y"); ?> <a href="http://spi-inc.org/">Software in the Public Interest, Inc.</a></li>
						<li>KDE® and the K Desktop Environment® logo are registered trademarks of <a href="http://ev.kde.org/">KDE e.V.</a> The registered trademark Linux® is used pursuant to a sublicense from LMI, the exclusive licensee of Linus Torvalds, owner of the mark on a world-wide basis. All other trademarks and copyrights are property of their respective owners and are only mentioned for informative purposes.</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
