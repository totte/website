<?php
/*
 * This is a hardly modified version for Chakra Linux of the
 * 'GuMax' style sheet for CSS2-capable browsers.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 * ----------------------------------------------------------------------------
 */

if( !defined( 'MEDIAWIKI' ) )
    die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @addtogroup Skins
 */
class SkinGuMax extends SkinTemplate {
    /** Using GuMax */
    function initPage( &$out ) {
        SkinTemplate::initPage( $out );
        $this->skinname  = 'gumax';
        $this->stylename = 'gumax';
        $this->template  = 'GuMaxTemplate';
    }
}

/**
 * @todo document
 * @addtogroup Skins
 */
class GuMaxTemplate extends QuickTemplate {
    /**
     * Template filter callback for GuMax skin.
     * Takes an associative array of data set from a SkinTemplate-based
     * class, and a wrapper for MediaWiki's localization database, and
     * outputs a formatted page.
     *
     * @access private
     */
    function execute() {
		global $wgUser;
		$skin = $wgUser->getSkin();

        // Suppress warnings to prevent notices about missing indexes in $this->data
        wfSuppressWarnings();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php
    foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
        ?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
    } ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
<head>
    <meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
    <?php $this->html('headlinks') ?>
    <title><?php $this->text('pagetitle') ?></title>
    <style type="text/css" media="screen,projection">/*<![CDATA[*/
		@import "<?php $this->text('stylepath') ?>/common/shared.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";
		@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/gumax_main.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";
	/*]]>*/</style>
    <link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/common/commonPrint.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
	<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/gumax_print.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
    <!--[if lt IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE50Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
    <!--[if IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE55Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
    <!--[if IE 6]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE60Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
    <!--[if IE 7]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE70Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
    <!--[if lt IE 7]><script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
    <meta http-equiv="imagetoolbar" content="no" /><![endif]-->

    <?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

    <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
    <?php    if($this->data['jsvarurl'  ]) { ?>
        <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
    <?php    } ?>
    <?php    if($this->data['pagecss'   ]) { ?>
        <style type="text/css"><?php $this->html('pagecss'   ) ?></style>
    <?php    }
        if($this->data['usercss'   ]) { ?>
        <style type="text/css"><?php $this->html('usercss'   ) ?></style>
    <?php    }
        if($this->data['userjs'    ]) { ?>
        <script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
    <?php    }
        if($this->data['userjsprev']) { ?>
        <script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
    <?php    }
    if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
    <!-- Head Scripts -->
    <?php $this->html('headscripts') ?>
</head>

<body <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload'    ]) { ?>onload="<?php     $this->text('body_onload')     ?>"<?php } ?>
 class="mediawiki <?php $this->text('nsclass') ?> <?php $this->text('dir') ?> <?php $this->text('pageclass') ?>">
<!-- ##### gumax-wrapper ##### -->



<div class="gumax-rbcontentwrap"><div class="gumax-rbcontent">
<div id="gumax-wrapper" align="center">


<!-- ===== gumax-page ===== -->
<div class="gumax-page">

    <!-- ///// gumax-header ///// -->
    <div id="gumax-header">
        <a name="top" id="contentTop"></a>

		<!-- Chakra navigation bar -->
		<div id="main_nav">
			<ul>
				<li><a href="../../../?donations">Donate</a></li>
                                <li><a href="http://git.chakraos.org">Git</a></li>
                                <li><a href="../../../reviewboard/">Review Board</a></li>
				<li><a href="../../../bugtracker/">Bugtracker</a></li>
				<li><a href="../../../ccr/">CCR</a></li>
				<!-- <li><a href="../packages/">Packages</a></li> -->
                                <li><a href="http://rsync.chakraos.org">Packages</a></li>
				<li class="selected"><a href="../../../wiki/">Wiki</a></li>
				<li><a href="../../../forum/">Forum</a></li>
				<li><a href="../../../news/">News</a></li>
				<li><a href="../../../?get">Download</a></li>
				<li><a href="../../../">Home</a></li>
			</ul>
		</div>
		<!-- end of Chakra navigation bar -->

        <!-- Search -->
        <div id="gumax-p-search" class="gumax-portlet">
            <div id="gumax-searchBody" class="gumax-pBody">
                <form action="<?php $this->text('searchaction') ?>" id="searchform"><div>
                    <input id="searchInput" name="search" type="text" <?php
                        if($this->haveMsg('accesskey-search')) {
                            ?>accesskey="<?php $this->msg('accesskey-search') ?>"<?php }
                        if( isset( $this->data['search'] ) ) {
                            ?> value="<?php $this->text('search') ?>"<?php } ?> />
                    <input type='submit' name="go" class="searchButton" id="searchGoButton" value="<?php $this->msg('searcharticle') ?>" />
                    <input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
                </div></form>
            </div>
        </div>
        <!-- end of Search -->

        <!-- Login -->
        <div id="gumax-p-login">
            <ul>
              <?php $lastkey = end(array_keys($this->data['personal_urls'])) ?>
              <?php foreach($this->data['personal_urls'] as $key => $item) /* if($this->data['loggedin']==1) */ {
              ?><li id="gumax-pt-<?php echo htmlspecialchars($key) ?>"><a href="<?php
               echo htmlspecialchars($item['href']) ?>"<?php
              if(!empty($item['class'])) { ?> class="<?php
               echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
               echo htmlspecialchars($item['text']) ?></a>
               <?php /* if($key != $lastkey) echo "|" */ ?></li>
             <?php } ?>
            </ul>
        </div>
        <!-- end of Login -->


    </div></div>
	<!-- ///// end of gumax-header ///// -->

    <!-- Navigation Menu -->
    <div id="gumax-p-navigation-wrapper">
        <?php foreach ($this->data['sidebar'] as $bar => $cont) { ?>
            <div class='gumax-portlet' id='gumax-p-navigation'>
                <h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
                    <ul>
                        <?php foreach($cont as $key => $val) { ?>
                            <li id="<?php echo htmlspecialchars($val['id']) ?>"<?php
                            if ( $val['active'] ) { ?> class="active" <?php }
                            ?>><a href="<?php echo htmlspecialchars($val['href']) ?>"><?php echo htmlspecialchars($val['text']) ?></a></li>
                        <?php } ?>
                    </ul>
            </div>
        <?php } ?>
    </div>
    <!-- end of Navigation Menu -->

    <div id="gumax_mainmenu_spacer"></div>

    <!-- gumax-content-actions -->
	<div class="gumax-firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></div>
	<div class="visualClear"></div>
	<?php //if($this->data['loggedin']==1) { ?>
    <div id="gumax-content-actions" class="gumax-content-actions-top">
        <ul>
			<?php $lastkey = end(array_keys($this->data['content_actions']))
			?><?php foreach($this->data['content_actions'] as $key => $action) {
			?><li id="ca-<?php echo htmlspecialchars($key) ?>" <?php
                   if($action['class']) { ?>class="<?php echo htmlspecialchars($action['class']) ?>"<?php }
			?>><a href="<?php echo htmlspecialchars($action['href']) ?>"<?php echo $skin->tooltipAndAccesskeyAttribs('ca-'.$key) ?>><?php
                   echo htmlspecialchars($action['text']) ?></a><?php // if($key != $lastkey) echo "&#8226;" ?></li>
            <?php } ?>
        </ul>
    </div>
	<?php //} ?>
    <!-- end of gumax-content-actions -->

    <!-- gumax-content-body -->
    <div id="gumax-content-body">
    <!-- content -->
    <div id="content">
        <a name="top" id="top"></a>
        <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
        <h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>
        <div id= "bodyContent" class="gumax-bodyContent">
            <h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
            <div id="contentSub"><?php $this->html('subtitle') ?></div>
            <?php if($this->data['undelete']) { ?><div id="contentSub2"><?php $this->html('undelete') ?></div><?php } ?>
            <?php if($this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html('newtalk')  ?></div><?php } ?>
            <?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
            <!-- start content -->
            <?php $this->html('bodytext') ?>
            <?php if($this->data['catlinks']) { ?><div id="catlinks"><?php $this->html('catlinks') ?></div><?php } ?>
            <!-- end content -->
            <div class="visualClear"></div>
        </div>
    </div>
    <!-- end of content -->
    </div>
    <!-- end of gumax-content-body -->

    <div id="gumax_footer_spacer"></div>

	<!-- ///// gumax-footer ///// -->
	<div id="gumax-footer">
		<!-- personal tools  -->
		<div id="gumax-personal-tools">
			<ul>
	<?php
		if($this->data['loggedin']==1) {
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"><?php $this->msg('whatlinkshere') ?></a></li>
	<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"><?php $this->msg('recentchangeslinked') ?></a></li>
	<?php 		}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"><?php $this->msg('trackbacklink') ?></a></li>
	<?php 	}
		if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
					?><span id="feed-<?php echo htmlspecialchars($key) ?>"><a href="<?php
					echo htmlspecialchars($feed['href']) ?>"><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
					<?php } ?></li><?php
		}

		foreach( array('contributions', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) {
				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"><?php $this->msg($special) ?></a></li>
	<?php		}
		}

		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>"><?php $this->msg('printableversion') ?></a></li><?php
		}

		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"><?php $this->msg('permalink') ?></a></li><?php
		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"><?php $this->msg('permalink') ?></li><?php
		}
		} // if loggedin
		wfRunHooks( 'GuMaxTemplateToolboxEnd', array( &$this ) ); ?>
			</ul>
		</div>
		<!-- end of personal tools  -->
		<!-- gumax-f-message -->
		<div id="gumax-f-message">
			<?php if($this->data['lastmod']) { ?><span id="f-lastmod"><?php $this->html('lastmod') ?></span>
			<?php } ?><?php if($this->data['viewcount']) { ?><span id="f-viewcount"><?php  $this->html('viewcount') ?> </span>
			<?php } ?>
		</div>
		<!-- end of gumax-f-message -->
		<!-- gumax-f-list -->
		<div id="gumax-f-list">
			<ul>
				<?php
						$footerlinks = array(
							'numberofwatchingusers', 'credits',
							'privacy', 'about', 'disclaimer', 'tagline',
						);
						foreach( $footerlinks as $aLink ) {
							if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
				?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
				<?php 		}
						}
				?>
				<li id="f-poweredby"><a href="http://mediawiki.org">Powered by MediaWiki</a></li>
			</ul>
		</div>
		<!-- end of gumax-f-list -->
		<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
	</div>
	<!-- ///// end of gumax-footer ///// -->

	<!-- Chakra footer -->
	<div id="foot">
		<script language = "JavaScript">
			var now = new Date();
			document.write("Copyright &copy; 2006-" + now.getFullYear() + " <a href='http://chakraos.org/?who'>The Chakra Developers</a>");
		</script>
		&nbsp;
	</div>
	<!-- end of Chakra footer -->
</div>
<!-- ===== end of gumax-page ===== -->

</div></div>
<div class="gumax-rbbot"><div><div></div></div></div></div>
</div>
</div> <!-- ##### end of gumax-wrapper ##### -->

<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>

-->
<?php endif; ?>
</body></html>
<?php
	wfRestoreWarnings();
	} // end of execute() method
} // end of class
?>
