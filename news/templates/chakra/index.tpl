{if $is_embedded != true}
{if $is_xhtml}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{else}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
           "http://www.w3.org/TR/html4/loose.dtd">
{/if}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang}" lang="{$lang}">
<head>
    <title>{$head_title|@default:$blogTitle} {if $head_subtitle} | {$head_subtitle}{/if}</title>
    <meta http-equiv="Content-Type" content="text/html; charset={$head_charset}" />
    <meta name="Powered-By" content="Serendipity v.{$head_version}" />
    <link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}" />
    <link rel="alternate"  type="application/rss+xml" title="{$blogTitle} RSS feed" href="{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/index.rss2" />
    <link rel="alternate"  type="application/x.atom+xml"  title="{$blogTitle} Atom feed"  href="{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/atom.xml" />
{if $entry_id}
    <link rel="pingback" href="{$serendipityBaseURL}comment.php?type=pingback&amp;entry_id={$entry_id}" />
{/if}

{serendipity_hookPlugin hook="frontend_header"}
</head>

<body>
{else}
{serendipity_hookPlugin hook="frontend_header"}
{/if}

{if $is_raw_mode != true}

<div class="bcontentwrap"><div class="rbcontent">
<div id="head_container">
	<div id="main_nav">
            <ul>
                <li><a href="../?donations">Donate</a></li>
                <li><a href="http://git.chakraos.org">Git</a></li>
				<!--<li><a href="../reviewboard/">Review Board</a></li>-->
                <li><a href="../bugtracker/">Bugtracker</a></li>
                <li><a href="../ccr/">CCR</a></li>
                <!--<li><a href="../packages/">Packages</a></li> -->
                <li><a href="http://rsync.chakraos.org">Packages</a></li>
                <li><a href="../wiki/">Wiki</a></li>
                <li><a href="../forum/">Forum</a></li>
                <li class="selected"><a href="../news/">News</a></li>
                <li><a href="../?get">Download</a></li>
                <li><a href="../">Home</a></li>
            </ul>
	</div>

	<table id="mainpane">
	<tr>
{if $leftSidebarElements > 0}
		<td id="serendipityLeftSideBar" valign="top">{serendipity_printSidebar side="left"}</td>
{/if}
		<td id="content" valign="top">{$CONTENT}</td>
{if $rightSidebarElements > 0}
		<td id="serendipityRightSideBar" valign="top">{serendipity_printSidebar side="right"}</td>
{/if}
	</tr>
	</table>

{/if}
{$raw_data}
{serendipity_hookPlugin hook="frontend_footer"}
{if $is_embedded != true}

	<div id="foot">
	<script language = "JavaScript">
		var now = new Date();
		document.write("Copyright &copy; 2006-" + now.getFullYear() + " <a href='../team.html'>The Chakra Developers</a> | <a href='../disclaimer.html'>Disclaimer</a>");
	</script>
	</div>
</div></div>
</div></div>
</body>
</html>
{/if}
