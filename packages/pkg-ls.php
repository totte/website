<?php

//
//   The Chakra Packages Viewer - Package-ls module
//

error_reporting(E_ALL);
include 'include/config.php';
include 'func.php';
include 'messages.php';
include 'common.php';
date_default_timezone_set('Europe/Berlin');
cpHeader();
echo "<br><br>";
echo "<table class=listtable border=0 cellspacing=2 cellpadding=2;>";
echo "<tr><th class=tdhp><b>Package ".onlyName($_GET['package']).":</b></th></tr>";
echo "<tr><td><br></td></tr>";
if(file_exists("$basedir/".$_GET['subdir']."/".$_GET['package'])) {
    exec("tar -tf $basedir/".$_GET['subdir']."/".$_GET['package'],$filename);
    $fl = array_values($filename);
    if ( isset($_GET['mode']) && ($_GET['mode'] == "log") ) {
        $fl = preg_grep("/\.log/", $fl);
    }
    foreach ($fl as $file) {
        if (($file != ".PKGINFO") && ($file != ".INSTALL")) {
            if ( isset($_GET['mode']) && ($_GET['mode'] == "log") ) {
                echo "<tr><td><a href=\"viewlog.php?log=".$file."&package=".$_GET['package']."&subdir=".rawurlencode($_GET['subdir'])."\">".end(explode("/",$file))."</a></td></tr>";
            } else {
                echo "<tr><td>/".$file."</td></tr>";
            }
        }
    }
    echo "</table>";
} else {
    echo "<tr><td>The package ".$_GET['package']." does not exists anymore.</td></tr>";
    echo "<br><br>";
}

// Return to packages link
echo "<br><br>";
echo "<table class=listtable border=0 cellspacing=2 cellpadding=2;>";
echo "<tr><td><a href=\"index.php?subdir=".rawurlencode($_GET['subdir'])."&act=show&file=".rawurlencode($_GET['package'])."\">".$messages["edt12"]."</a></td></tr>";
echo "</table>";
cpFooter();
?>
