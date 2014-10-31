<?php

//
//   The Chakra Packages Viewer - Repo diff module
//

error_reporting(E_ALL);

require dirname(__FILE__) . '/class.simplediff.php';
include 'config.php';
include 'func.php';
include 'messages.php';
include 'common.php';

// Getting variables
if (!empty($HTTP_POST_VARS)) extract($HTTP_POST_VARS);
if (!empty($HTTP_GET_VARS)) extract($HTTP_GET_VARS);
if (!isset($returnto)) $returnto = "index.php";
if (!isset($mode)) $mode = "arch";
cpHeader();
// Retrive the list of packages to diff and the diff data
if ($mode == "branch") {
    if(noParent(prunedRepo($diff))=="bundles") {
        $i686_master_files = getBundles($diff."/i686");
        $i686_testing_files = getBundles($diff."-testing/i686");
        $x86_64_master_files = getBundles($diff."/x86_64");
        $x86_64_testing_files = getBundles($diff."-testing/x86_64");
    } else {
        $i686_master_files = getDatabaseFiles($diff."/i686");
        $i686_testing_files = getDatabaseFiles("testing/i686");
        $x86_64_master_files = getDatabaseFiles($diff."/x86_64");
        $x86_64_testing_files = getDatabaseFiles("testing/x86_64");
    }
        sort($i686_master_files);
    sort($i686_testing_files);
    sort($x86_64_master_files);
    sort($x86_64_testing_files);
    $i686_diffcells = html_diff($i686_master_files,$i686_testing_files);
    $x86_64_diffcells = html_diff($x86_64_master_files,$x86_64_testing_files);
    $diffcells = "";
}
if ($mode == "archfiles") {
    $x86_files = getPackages($diff."/i686");
    $x64_files = getPackages($diff."/x86_64");
    sort($x86_files);
    sort($x64_files);
    $diffcells = html_diff($x86_files,$x64_files);
    $i686_diffcells = "";
    $x86_64_diffcells = "";
};
if ($mode == "arch") {
    if(noParent(prunedRepo($diff))=="bundles") {
        $x86_files = getBundles($diff."/i686");
        $x64_files = getBundles($diff."/x86_64");
    } else {
        $x86_files = getDatabaseFiles($diff."/i686");
        $x64_files = getDatabaseFiles($diff."/x86_64");
    }
    sort($x86_files);
    sort($x64_files);
    $diffcells = html_diff($x86_files,$x64_files);
    $i686_diffcells = "";
    $x86_64_diffcells = "";
};
echo "<br><br>";
// Check the databases and drawn the diff if both are available
if (($diffcells == "")  && ($i686_diffcells == "") && ($x86_64_diffcells == "")) {
    if (is_dir($basedir."/".$diff)) {
        if (noParent(prunedRepo($diff))=="bundles") {
            echo "<table class=cctable border=0;>";
            echo "<tr><td class=diffwarning>Error parsing the repo ".noParent($diff)."</td></tr>";
            echo "</table>";
        } else {
            if ($mode == "arch") {
                if (is_file($basedir."/".$diff."/i686/".noParent($diff).".db.tar.gz") &&
                    is_file($basedir."/".$diff."/x86_64/".noParent($diff).".db.tar.gz")) {
                    echo "<table class=cctable border=0;>";
                    echo "<tr><td class=diffinfo>There's no info to display, ".noParent($diff)." is 100% synced.</td></tr>";
                    echo "</table>";
                } else {
                    echo "<p>";
                    if (!is_file($basedir."/".$diff."/i686/".noParent($diff).".db.tar.gz")) {
                        echo "<table class=cctable border=0;>";
                        echo "<tr><td class=differror>The repo ".noParent($diff)."/i686 does not have database!</td>";
                        echo "</table>";
                    }
                    if (!is_file($basedir."/".$diff."/x86_64/".noParent($diff).".db.tar.gz")) { 
                        echo "<table class=cctable border=0;>";
                        echo "<tr><td class=differror>The repo ".noParent($diff)."/x86_64 does not have database!</td></tr>";
                        echo "</table>";
                    }
                    echo "</p>";
                }
            }
            if ($mode == "archfiles") {
                    echo "<table class=cctable border=0;>";
                    echo "<tr><td class=diffinfo>There's no info to display, ".noParent($diff)." is 100% synced.</td></tr>";
                    echo "</table>";
            }
            if ($mode == "branch") {
                if (is_file($basedir."/".$diff."/i686/".noParent($diff).".db.tar.gz") &&
                    is_file($basedir."/".$diff."-testing/i686/".noParent($diff).".db.tar.gz") &&
                    is_file($basedir."/".$diff."/x86_64/".noParent($diff).".db.tar.gz") &&
                    is_file($basedir."/".$diff."-testing/x86_64/".noParent($diff).".db.tar.gz")) {
                    echo "<table class=cctable border=0;>";
                    echo "<tr><td class=diffinfo>There's no info to display, ".noParent($diff)." is 100% synced.</td></tr>";
                    echo "</table>";
                } else {
                    echo "<p>";
                    if (!is_file($basedir."/".$diff."/i686/".noParent($diff).".db.tar.gz")) {
                        echo "<table class=cctable border=0;>";
                        echo "<tr><td class=differror>The repo ".noParent($diff)."/i686 does not have database!</td>";
                        echo "</table>";
                    }
                    if (!is_file($basedir."/".$diff."/x86_64/".noParent($diff).".db.tar.gz")) { 
                        echo "<table class=cctable border=0;>";
                        echo "<tr><td class=differror>The repo ".noParent($diff)."/x86_64 does not have database!</td></tr>";
                        echo "</table>";
                    }
                    if (!is_file($basedir."/".$diff."-testing/i686/".noParent($diff)."-testing.db.tar.gz")) {
                        echo "<table class=cctable border=0;>";
                        echo "<tr><td class=differror>The repo ".noParent($diff)."/i686 does not have database!</td>";
                        echo "</table>";
                    }
                    if (!is_file($basedir."/".$diff."-testing/x86_64/".noParent($diff)."-testing.db.tar.gz")) { 
                        echo "<table class=cctable border=0;>";
                        echo "<tr><td class=differror>The repo ".noParent($diff)."/x86_64 does not have database!</td></tr>";
                        echo "</table>";
                    }
                    echo "</p>";
                }
            }
        }
    } else {
        echo "<p><h5 class=error>The repo ".noParent($diff)." does not exist!</h5></p>";
    }
} else {
    echo "<table class=difftable border=0 cellspacing=2 cellpadding=2;>";
    if ($mode == "branch") {
        if ($i686_diffcells != "") {
            echo "<tr><th><b>".$diff." i686</b></th><th><b>".$diff."-testing i686</b></th></tr>";
            echo $i686_diffcells;
        }
        if ($x86_64_diffcells != "") {
            echo "<tr><th><b>".$diff." x86_64</b></th><th><b>".$diff."-testing x86_64</b></th></tr>";
            echo $x86_64_diffcells;
        }
        echo "</table>";
    } else {
        echo "<tr><th><b>i686</b></th><th><b>x86_64</b></th></tr>";
        echo $diffcells;
        echo "</table>";
    };
    
}
// Return to packages link
echo "<br /><br />";
echo "<table class=cctable border=0;>";
echo "<tr><td><a href=".$returnto."?subdir=".rawurlencode($diff)." onMouseOver='return statusMsg(\"".quoteJS($messages["edt12"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["edt12"]."</a></td></tr>";
echo "</table>";
cpFooter();
?>
