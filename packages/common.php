<?php

//
//  Chakra webpage common stuff
//
 
// Page header
function cpHeader() {
    global $imagesdir, $titleimg, $subdir, $hiddeninfo, $title, $windowtitle, $msg, $charset, $defaultstatusmsg;
    if ($hiddeninfo != "") {
        echo "\n<!--\nINFO :$hiddeninfo\n-->\n";
    }
    echo "\n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    echo "\n<html xmlns=\"http://www.w3.org/1999/xhtml\">";
    echo "\n<head>";
    echo "\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
    echo "\n<title>Chakra | Packages</title>";
    echo "\n<style type=\"text/css\">";
    echo "\n@import url(../static/css/chakra.css);";
    echo "\n@import url(../static/css/chakra-packages.css);";
    echo "\n</style>";
    echo "\n<script type=\"text/javascript\" src=\"../static/js/highslide/highslide.js\"><</script>";
    echo "\n<link rel=\"stylesheet\" href=\"../static/js/highslide/highslide.css\" type=\"text/css\" media=\"screen\" />";
    echo "\n<script type=\"text/javascript\">";
    echo "\n    hs.graphicsDir = '../static/js/highslide/graphics/';";
    echo "\n    hs.wrapperClassName = 'wide-border';";
    echo "\n</script>";
    echo "\n</head>";
    echo "\n<script language=\"javascript\">";
    echo "\n<!--";
    echo "\nfunction statusMsg(txt) {";
    echo    "\nif (txt == '') txt = '$defaultstatusmsg';";
    echo    "\nwindow.status = txt;";
    echo    "\nreturn true;";
    echo "\n}";
    echo "\n//-->";
    echo "\n</script>";
    echo "\n<body onLoad='return statusMsg(\"\")'>\n";
    echo "\n<div class=\"bcontentwrap\"><div class=\"rbcontent\">";
    echo "\n    <div id=\"wrapper\">";
    echo "\n        <h1>Packages</h1>";
    echo "\n        <div id=\"main_nav\">";
    echo "\n              <ul>";
    echo "\n                <li><a href=\"../bugtracker/\">Bugtracker</a></li>";
    echo "\n                <li><a href=\"../ccr/\">CCR</a></li>";
    echo "\n                <li class=\"selected\"><a href=\"../packages/\">Packages</a></li>";
    echo "\n                <li><a href=\"../wiki/\">Wiki</a></li>";
    echo "\n                <li><a href=\"../forum/\">Forum</a></li>";
    echo "\n                <li><a href=\"../news/\">News</a></li>";
    echo "\n                <li><a href=\"../home/?get\">Download</a></li>";
    echo "\n                <li><a href=\"../home/\">Home</a></li>";
    echo "\n            </ul>";
    echo "\n        </div>";
    echo "\n<div id=\"chakra_nav\">";
    echo "\n    <ul>";
    if (onlyRepo($subdir) != "") {
        echo "\n        <li>&nbsp;<a href=\"http://groups.google.com/group/chakra-packagers\">Discussion</a></li>";
        #if((onlyRepo(prunedRepo($subdir)) != "bundles") && (onlyRepo(prunedRepo($subdir)) != "lib32")) {
        #     echo "\n      <li>&nbsp;<a href=\"repo-diff.php?&diff=".prunedSubdir($subdir)."&mode=archfiles\">Files Diff</a></li>";;
        #}
        #if(onlyRepo(prunedRepo($subdir)) == "lib32") {
        #     echo "\n      <li>&nbsp;<a href=\"repo-diff.php?&diff=".prunedRepo(prunedSubdir($subdir))."&mode=branch\">Branch Diff</a></li>";
        #}
        #if(onlyRepo(prunedRepo($subdir)) != "lib32") {
        #     echo "\n      <li>&nbsp;<a href=\"repo-diff.php?&diff=".prunedSubdir($subdir)."\">Arch Diff</a></li>";
        #}
        echo "\n    <p><h2><img src=\"$imagesdir/$titleimg\" align=center>$title</h2></p>";
        echo "\n    </ul>";
        echo "\n</div>";
        echo "\n        <div id=\"content\">";
    } else {
        echo "\n        <li>&nbsp;<a href=\"http://groups.google.com/group/chakra-packagers\">Discussion</a></li>";     
        echo "\n        <p><h2><img src=\"$imagesdir/$titleimg\" align=center>$title</h2></p>";
        echo "\n    </ul>";
        echo "\n</div>";
        echo "\n        <div id=\"content\">";
    }
}

// Page footer
date_default_timezone_set('Europe/Berlin');
function cpFooter() {
                ?></div>
                    <div id="footer">
                        <script type="text/javascript">
                            var now = new Date();
                            document.write("Copyright &copy; 2006-" + now.getFullYear());
                        </script>
                        <a href="mailto:chakra-devel@googlegroups.com">The Chakra Developers</a>
                        &nbsp;
                        &middot;
                        &nbsp;
                        Sponsored by <a href="http://www.host1plus.com">Host1Plus</a>
                    </div><!-- /#footer -->
                </div><!-- /#wrapper -->
            </div><!-- /.right_shadow -->
        </div><!-- /.left_shadow -->
    </body>
</html><?php
}
?>
