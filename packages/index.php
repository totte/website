<?php
//======================================================================
//
// The Chakra Packages Viewer
//
// (C) 2010 - Manuel Tortosa <manutortosa[at]chakra-project.org>
// (C) 2014 - H W Tovetjärn (totte) <totte@tott.es>
//
//
// This program uses snippets of code from:
//
// Web-File-Browser by David AZOULAY // http://www.webfilebrowser.org/
// Sanitize plugin http://wordpress.org/extend/plugins/wp-utf8-sanitize/
// dimpleDiff - http://svn.kd2.org/svn/misc/libs/diff/
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
//======================================================================

// Report any error
error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');

// Config, functions and messages
include 'include/config.php';
include 'func.php';
include 'messages.php';
include 'common.php';

// Open the flags database
$database = "repo-lck/packages.sqlite";

$hiddeninfo = "";

// Getting variables
$subdir = (isset($_GET['subdir'])) ? $_GET['subdir'] : "";
if ($subdir == ".") $subdir = "";
if (($subdir != "") && (strstr($subdir, ".."))) {
    $subdir = "";
    $hiddeninfo .= "\nRedirected to base directory";
}
$subdir = extractSubdir($basedir."/".$subdir);

$act = (isset($_GET['act'])) ? $_GET['act'] : "";
$order = (isset($_GET['order'])) ? $_GET['order'] : "";
$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : $defaultsortby;
$searchpattern = (isset($_GET['searchpattern'])) ? $_GET['searchpattern'] : "";
if(isset($_GET['last'])) $last=$_GET['last'];
if(isset($_POST['msg'])) $last=$_POST['msg'];

$file = (isset($_GET['file'])) ? $_GET['file'] : "";
if($file == "") {
    if (isset($selfiles) && is_array($selfiles)) {
        $file = $selfiles[0];
    }
}

// Try to inhibate error reporting setting
if (function_exists("ini_set")) {
    @ini_set("display_errors", 0);
}

// Prevents from seeing this file
$thisfile = strtolower(@basename(__FILE__));

// Turns antislashes into slashes for base directory
$basedir = strtr($basedir, "\\", "/");

// This script URI
$thisscript = $_SERVER["PHP_SELF"];

// General HTTP directives
header("Expires: -1");
header("Pragma: no-cache");
header("Cache-Control: max-age=0");
header("Cache-Control: no-cache");
header("Cache-Control: no-store");
header("Content-Type: text/html; charset=$charset");

// Array for file lists
$files = array();

// Processes actions and redirects to pages
if ($act != "show") {
    if ($act == "") {
        @clearstatcache();
        if ($d = @opendir($basedir."/".$subdir)) {
            // builds an indexed array for files
            if ($order == "") $order = "ascending";
            if ($order == "descending") {
                if ($subdir != "") {
                    addFileToList("", $basedir, "[".$messages["dir2"]."]", 9, $upperdirimage, $messages["inf6"]);
                }
                addFileToList("..", getFilePath(".."), "[".$messages["dir3"]."]", 5, $upperdirimage, $messages["inf7"]);
                while ($file = @readdir($d)) {
                    if (checkFileName($file)) {
                        $fp = getFilePath($file);
                        $alias = "";
                        addFileToList($file, $fp, $alias, 2);
                    }
                }
                @closedir($d);
                krsort($files);
                $order = "ascending";
            } else {
                if ($subdir != "") {
                    addFileToList("", $basedir, "[".$messages["dir2"]."]", 1, $upperdirimage, $messages["inf6"]);
                }
                addFileToList("..", getFilePath(".."), "[".$messages["dir3"]."]", 5, $upperdirimage, $messages["inf7"]);
                while ($file = @readdir($d)) {
                    if (checkFileName($file)) {
                        $fp = getFilePath($file);
                        $alias = "";
                        addFileToList($file, $fp, $alias, 8);
                    }
                }
                @closedir($d);
                ksort($files);
                $order = "descending";
            }
        } else {
            cpHeader();
            echo getMsg("error", "dir1", $subdir);
            cpFooter();
            exit;
        }
    } else if ($act == "search") {
        $searchpattern = trim($searchpattern);
        $searchpatternmatchall = "*".$searchpattern."*";
        if ($searchpattern != "") {
            @clearstatcache();
            if ($order == "ascending") {
                addFileToList($subdir, getFilePath("."), "[".$messages["sch5"]."]", 1, $upperdirimage);
            } else {
                addFileToList($subdir, getFilePath("."), "[".$messages["sch5"]."]", 9, $upperdirimage);
            }
            if (searchFiles($subdir, $searchpatternmatchall) == 0) {
                redirectWithMsg("warning", "sch3", $searchpattern, "", "&searchpattern=".rawurlencode($searchpattern)."");
            }
            if ($order == "") $order = "descending";
            if ($order == "ascending") {
                ksort($files);
                $order = "descending";
            } else {
                krsort($files);
                $order = "ascending";
            }
        } else {
            redirectWithMsg("error", "sch6");
        }
    } else if ($act == "download") {
        if (isset($file) && ($file != "")) {
            $subdir = @dirname($file);
            if (!checkFileName($file) || (($subdir == "") && ($file == $trashcan))) {
                redirectWithMsg("warning", "dwn2");
            } else {
                $fp = getFilePath($file);
                if (@is_readable($fp)) {
                    @clearstatcache();
                    header("Content-Type: application/force-download");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length: ".@filesize($fp));
                    header("Content-Disposition: attachment; filename=\"".@basename($file)."\"");
                    @readfile($fp);
                    exit;
                } else {
                    redirectWithMsg("error", "dwn3", $file);
                }
            }
        } else {
            redirectWithMsg("warning", "dwn4");
        }
    } else {
        redirectWithMsg("error", "act1");
    }
}

cpHeader();
// Displays message after redirection if required
if (isset($_GET['msg'])) {
    if ( reset(explode(":",$_GET['msg'])) == "<p class=warning>No packages found matching" ) {
        if ( $subdir != "" ) {
            echo $_GET['msg']." in ".$subdir." - <a href=\"http://chakraos.org/packages/index.php?act=search&subdir=&sortby=date&order=descending&searchpattern=".str_replace(" ","",end(explode(":",$_GET['msg'])))."\">global search</a> - <a href=\"http://chakraos.org/ccr/packages.php?O=0&K=".str_replace("^","",str_replace("-[0-9]","",str_replace(" ","",end(explode(":",$_GET['msg'])))))."&do_Search=Go\">  search for results in CCR</a>";
        } else {
            echo $_GET['msg']." -<a href=\"http://chakraos.org/ccr/packages.php?O=0&K=". str_replace(" ","",end(explode(":",$_GET['msg'])))."&do_Search=Go\">  search for «".str_replace(" ","",end(explode(":",$_GET['msg'])))."» in CCR</a>";
        }
    } else {
        echo $_GET['msg']; 
    }
}

echo "<a name=\"top\"></a>";
echo "<table class=stable border=0>";
echo "<tr><td><b>";
if ($act != "show") {
    // Show the upper folders images
    if ($act == "search") {
        echo "<img src=\"$imagesdir/$searchimage\" align=center>  ";
    } else {
            echo "<img src=\"$imagesdir/$opendirimage\" align=center>  ";
    }
    if ($act == "search") {
        // Format a bit the output
        if ($searchpattern == "*") {
            $searchtext = "all";
        } else {
            $searchtext = str_replace("*.cb"," bundles",str_replace("-[0-9]","",str_replace("^","",($searchpattern))));
        }
        echo getMsg("", "sch4", $searchtext)." [";
    }
    if ($subdir == "") {
        echo $messages["dir2"];
    } else {
        if ($act == "search") {
            echo htmlspecialchars($subdir);
        } else {
            echo $messages["dir5"]." : ".htmlspecialchars($subdir);
        }
    }
    if ($act == "search") echo "]";
    // Print the repo description string
    if ($act != "search") {
        echo "</b><br>";
        if(!isset($messages[onlyRepo($subdir)])) {
            echo "&nbsp;";
        } else {
            echo $messages[onlyRepo($subdir)];
        }
    } else {
        echo "</b><br>";
        echo "&nbsp;";
    }
    echo "</td>";
    /* Clean the search pattern on errors and the search page */
    echo "<td width=28 class=tdrt>&nbsp;</td>";
    echo "<td class=tdrt>";
    echo "<form action=$thisscript method=get name=searchForm>";
    echo    "<input name=act type=hidden value=search>";
    echo    "<input name=subdir type=hidden value=$subdir>";
    echo    "<input name=sortby type=hidden value=$searchsortby>";
    echo    "<input name=order type=hidden value=$order>";
    echo    "<input name=searchpattern type=text size=20 value=\"\"> ";
    echo    "<input type=submit value=\"".$messages["sch2"]."\" onClick='submitActForm(document.searchForm, \"searchpattern\", \"".quoteJS($messages["sch6"])."\")'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
    // Last packages form
    if ($act != "search") {
        echo "<tr>";
        echo "<td></td><td></td>";
        echo "<td class=tdrt>";
        echo "<form class=tdrt2 action=$thisscript name=searchForm>";
        echo    "<input name=act type=hidden value=search>";
        echo    "<input name=subdir type=hidden value=$subdir>";
        echo    "<input name=sortby type=hidden value=name>";
        echo    "<input name=order type=hidden value=ascending>";
        echo    "<input name=searchpattern type=hidden value=\"build logs\"> ";
        echo    "<input type=submit value=\"   Build Logs   \" onClick='submitActForm(document.searchForm, \"searchpattern\", \"".quoteJS($messages["sch6"])."\")'>";
        echo "</form>";
        echo "<form class=tdrt2 action=$thisscript name=searchForm>";
        echo    "<input name=act type=hidden value=search>";
        echo    "<input name=subdir type=hidden value=$subdir>";
        echo    "<input name=sortby type=hidden value=date>";
        echo    "<input name=order type=hidden value=descending>";
        echo    "<input name=last type=hidden value=20>";
        echo    "<input name=searchpattern type=hidden value=\"last packages\"> ";
        echo    "<input type=submit value=\"   Last Packages   \" onClick='submitActForm(document.searchForm, \"searchpattern\", \"".quoteJS($messages["sch6"])."\")'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
}
echo "</table>";
// Details page
if ($act == "show") {
    if (isset($file) && ($file != "")) {
        if (!checkExtension($file)) {
            echo getMsg("warning", "edt4");
        } else {
            $pkgdata = getPackageDetails($file);
            if(!$pkgdata) {
                echo "<p>Error on retrieving package details</p>";
                cpFooter();
                exit;
            }
            $dbfiles = getDatabaseFiles($subdir);
            $isflagged=false;
;
            // Right toolbar
            echo "<div class=\"rightpkgs\">";
            // Show Git details if available
                $show_git_info="false";
            switch(prunedSubdir($subdir)) {
                case "testing":
                    if($pkgdata["GITR"]!="") {
                          $show_git_info="true";
                    }
                    break;
                case "unstable":
                    if($pkgdata["GITR"]!="") {
                          $show_git_info="true";
                    }
                    break;
                default:
                    if($pkgdata["GITF"]!="") {
                          $show_git_info="true";
                    }
                    break;
            }
            if($show_git_info=="true") {
                echo    "<h6><img src=\"$imagesdir/$infoimage\" alt=\"download\" border=\"0\" class=\"pkglinks\" /> Git(orious)</h6>";
                echo    "<ul class=\"pkglinks\">";
                echo        "<li>&nbsp;<a href=\"".gitFolder($pkgdata["GITR"],$pkgdata["GITF"])."\">Entries</a></li>";
                echo        "<li>&nbsp;<a href=\"".gitPkgbuild($pkgdata["GITR"],$pkgdata["GITF"])."\">PKGBUILD</a></li>";
                echo        "<li>&nbsp;<a href=\"".gitLog($pkgdata["GITR"],$pkgdata["GITF"])."\">Log</a></li>";
                echo    "</ul>";
            }
            // Download and Files list links
            echo    "<h6><img src=\"$imagesdir/$pkgimg\" alt=\"download\" border=\"0\" class=\"pkglinks\" /> Package</h6>";
            echo    "<ul class=\"pkglinks\">";
            echo        "<li>&nbsp;<a href=$basedir/".str_replace("%2F", "/", $subdir)."/".rawurlencode($file).">Download</a></li>";
            if (preg_match('/Build Logs/', $pkgdata['DESC'])) {
                    echo        "<li>&nbsp;<a href=pkg-ls.php?package=".rawurlencode($file)."&subdir=".$subdir."&mode=log>View Logs</a></li>";
            } else {
                echo        "<li>&nbsp;<a href=pkg-ls.php?package=".rawurlencode($file)."&subdir=".$subdir.">File listing</a></li>";
            }
            // Check if the package is flagged
            $flagtype = search_flags($database,$pkgdata['NAME'],$pkgdata['VERS']);
            if($flagtype != false){
              $isflagged=true;
            }
            echo    "</ul>";
            // Screenshot
            $sshowimage = "./screenshots/".$pkgdata["NAME"];
            $sshowimage = str_replace($cleanshot,"",$sshowimage);
            $tshowimage = $sshowimage."_thumb.jpeg";
            $sshowimage = $sshowimage.".jpeg";
            if (is_file($sshowimage)) {
                echo    "<ul>";
                echo        "<table class=\"floated-img-rightpkgs\" width=\"420px\" border=\"0\" valign=\"middle\" align=\"right\">";
                echo        "<tr height=\"200px\"><td width=\"280px\" align=\"right\">";
                echo        "<a href=\"".$sshowimage."\" class=\"highslide\" border=\"0\" onclick=\"return hs.expand(this,{wrapperClassName: 'borderless floating-caption', dimmingOpacity: 0.75, align: 'center'})\">";
                echo        "<img src=\"".$tshowimage."\" alt=\"Highslide JS\" border=\"0\"";
                echo        "title=\"Click to enlarge\" height=\"200\" width=\"280\" /></a>";
                echo        "</td></tr></table>";
                echo    "</ul>";
            }
            echo "</div>";
            // Package details and dependencies links
            echo "<p><table class=ltable width=60% border=0 cellspacing=10 cellpadding=2>";
            echo "<tr><td height=0 class=tdpk></td></tr>";
            echo "<tr><th class=tdhp><b>".onlyName(htmlspecialchars($file))."</b></th></tr>";
            echo "<tr><td>Architecture: ".$pkgdata["ARCH"]."</td></tr>";
            echo "<tr><td>Repository: ".onlyRepo($subdir)."</td></tr>";
            echo "<tr><td>Description: ".htmlspecialchars(sanitize($pkgdata["DESC"]))."</td></tr>";
            echo "<tr><td>Upstream Url: <a href=\"".$pkgdata["UURL"]."\">".htmlspecialchars($pkgdata["UURL"])."</a></td></tr>";
            echo "<tr><td>License: ".$pkgdata["LICE"]."</td></tr>";
            echo "<tr><td>Package Size: ".round($pkgdata["SIZE"]/1024)." Kb</td></tr>";
            if($pkgdata["PKGR"] != "Unknown Packager") {
                  echo "<tr><td>Last Packager: <a href='mailto:".mailConv(htmlspecialchars($pkgdata["PKGR"]))."'>".htmlspecialchars($pkgdata["PKGR"])."</a></td></tr>";
            } else {
                  echo "<tr><td>Last Packager: ".$pkgdata["PKGR"]."</td></tr>";
            }
            echo "<tr><td>Build Date: ".date("D M d H:i:s A", $pkgdata["BDAT"])."</td></tr>";
            if (isset($pkgdata["GRPS"])) {
                if ($pkgdata["GRPS"] != "") echo "<tr><td>Package Groups: ".$pkgdata["GRPS"]."</td></tr>";
            }
            
            // Check for signature
            if (!preg_match('/Build Logs/', $pkgdata['DESC'])) {
                unset($checknew);
                $checknew = searchInRepo(onlyRepo($subdir),end(explode("/",$subdir)),$file.".sig");
                if (isset($checknew[0])) {
                    echo "<tr><td><img src=\"$imagesdir/kgpg_16.png\" border=0><a href=$basedir/".reset(explode("/",($subdir)))."/".end(explode("/",$subdir))."/".rawurlencode($checknew[0])." onMouseOver='return statusMsg(\"".quoteJS($messages["edt9"])."\");' onMouseOut='return statusMsg(\"\");'> ".onlyName(htmlspecialchars($file))." signature</a></td></tr>";
                } else {
                    echo "<tr><td class=nosign>This package does not provide signature</td></tr>";
                }
            }
            // Check for other versions
            unset($checknew,$available_repos);
            $available_repos = listDirs($basedir);
            foreach($available_repos as $current_repo) {
                if($current_repo != reset(explode("/",($subdir)))) {
                    $checknew = searchInRepo($current_repo,end(explode("/",$subdir)),"^".$pkgdata["NAME"]."-[[:digit:]].*z$");
                    if (isset($checknew[0])) {
                          echo "<tr><td>Version in [$current_repo]: <a href=$thisscript?act=show&subdir=$current_repo/".end(explode("/",$subdir))."&sortby=$sortby&file=".rawurlencode($checknew[0])." onMouseOver='return statusMsg(\"".quoteJS($messages["edt9"])."\");' onMouseOut='return statusMsg(\"\");'>".onlyName(htmlspecialchars($checknew[0]))."</a></td></tr>";
                    }
                    unset($checknew);
                }
            }
            // Check if the file belong to the database
            echo "<tr><td></td></tr>";
            if ($isflagged) {
                if ($flagtype == "broken") {
                    echo "<tr><td class=pkgerror><img src=\"$imagesdir/$flagimage\" border=0> This package has been flagged as ".$flagtype."</td></tr>";
                } else {
                    echo "<tr><td class=pkgwarning><img src=\"$imagesdir/$flagimage\" border=0> This package has been flagged as ".$flagtype."</td></tr>";
                }
            }
            if (!in_array(onlyName($file),$dbfiles)) {
                echo "<tr><td class=pkgerror><img src=\"$imagesdir/$unallowimage\" border=0> This package does not belong to the database, it is advised to not use it</td></tr>";
            }
            echo "<tr><td></td></tr>";
                if(!$isflagged) {
                    echo "<br />";
                    echo "<tr><td class=ltable align=center>";
                    if ( (prunedRepo(prunedSubdir($subdir))=="apps") || (prunedRepo(prunedSubdir($subdir))=="games") || (prunedRepo(prunedSubdir($subdir))=="extra") ) {
                        echo" <form class=tdlt2 method=post action=flags.php name=flagForm>";
                        echo    "<input name=p type=hidden value=".$pkgdata['NAME'].">";
                        echo    "<input name=v type=hidden value=".$pkgdata['VERS'].">";
                        echo    "<input name=s type=hidden value=$subdir>";
                        echo    "<input name=f type=hidden value=$file>";
                        echo    "<input name=t type=hidden value=\"outdated\">";
                        echo    "<input type=submit value=\"  Flag as outdated  \" onClick='submitActForm(document.flagForm)'>";
                        echo "</form>";
                    }
                    echo" <form class=tdlt2 method=post action=flags.php name=flagForm>";
                    echo    "<input name=p type=hidden value=".$pkgdata['NAME'].">";
                    echo    "<input name=v type=hidden value=".$pkgdata['VERS'].">";
                    echo    "<input name=s type=hidden value=$subdir>";
                    echo    "<input name=f type=hidden value=$file>";
                    echo    "<input name=t type=hidden value=\"broken\">";
                    echo    "<input type=submit value=\"  Flag as broken  \" onClick='submitActForm(document.flagForm)'>";
                    echo "</form>";  
                    echo "<br /><br /></td></tr>";
                }
            echo "<tr><th class=tdhd>Dependencies: </th></tr>";
            $pkgdepends = explode("|",htmlspecialchars($pkgdata["DEPS"]));
            foreach ($pkgdepends as $depelement) {
                echo "<tr><td>";
                // a dep version like package=1.2.3 need HTML translation
                $cleanequals = str_replace("=","&",$depelement);
                $noversion = explode ("&",$cleanequals,2);
                $cleanequals = "^".$noversion[0]."-[0-9]";
                echo "<a href=$thisscript?act=search&subdir&sortdy=name&searchpattern=".urlencode($cleanequals).">".$depelement."</a>";
                echo "</td></tr>";
            }
            echo "<tr><td></td></tr>";
            echo "<tr><td class=tdpk><a href=$thisscript?subdir=".rawurlencode($subdir)."&sortby=$sortby onMouseOver='return statusMsg(\"".quoteJS($messages["edt12"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["edt12"]."</a></td></tr>";
            echo "</table>";
        }
    } else {
        echo getMsg("warning", ($act == "edit") ? "edt6" : "edt7");
    }
// File list page
} else {
    echo "\n<script language=javascript>";
    echo "\n<!--";
    echo "\nfunction submitActForm(f, n, m) {";
    echo    "\nif (f.elements[n].value == f.elements[n].defaultValue) {";
    echo       "\nalert(m);";
    echo    "\n} else {";
    echo       "\nf.submit();";
    echo    "\n}";
    echo "\n}";
    echo "\n//-->";
    echo "\n</script>\n";
    if (!empty($files)) {
        // Search form setup
        echo "<p><table class=ctable border=0 cellspacing=10 cellpadding=2>";
        echo "<form action=$thisscript method=get name=listForm>";
        echo "<input name=act type=hidden value=''>";
        echo "<input name=subdir type=hidden value=\"$subdir\">";
        echo "<input name=sortby type=hidden value=$searchsortby>";
        echo "<input name=order type=hidden value=$order>";
        echo "<tr>";
        echo "<td width=500 height=0 class=tdrt></td>";
        // Repo column in the search action
        if ($act == "search") {
            echo "<td width=180 height=0 class=tdcc></td>";
            $nbcols = 6;
        } else {
            $nbcols = 5;
        }
        // Main explorer table
        echo "<td width=100 height=0 class=tdcc></td>";
        echo "<td width=200 height=0 class=tdcc></td>";
        echo "<td width=25 height=0 class=tdlt></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>";
        echo "<a href=$thisscript?subdir=".rawurlencode($subdir)."&sortby=name&order=$order".(($act == "search") ? "&act=search&searchpattern=".rawurlencode($searchpattern) : "")." onMouseOver='return statusMsg(\"".quoteJS($messages["inf1"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["tab3"]."</a>";
        echo "</th>";
        if ($act=="search") {
            echo "<th>";
            echo "<a href=$thisscript?subdir=".rawurlencode($subdir)."&sortby=repo&order=$order".(($act == "search") ? "&act=search&searchpattern=".rawurlencode($searchpattern) : "")." onMouseOver='return statusMsg(\"".quoteJS($messages["inf1"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["tab15"]."</a>";
            echo "</th>";
        }
        echo "<th>";
        echo "<a href=$thisscript?subdir=".rawurlencode($subdir)."&sortby=size&order=$order".(($act == "search") ? "&act=search&searchpattern=".rawurlencode($searchpattern) : "")." onMouseOver='return statusMsg(\"".quoteJS($messages["inf2"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["tab4"]."</a>";
        echo "</th>";
        echo "<th>";
        echo "<a href=$thisscript?subdir=".rawurlencode($subdir)."&sortby=date&order=$order".(($act == "search") ? "&act=search&searchpattern=".rawurlencode($searchpattern) : "")." onMouseOver='return statusMsg(\"".quoteJS($messages["inf3"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["tab5"]."</a>";
        echo "</th>";
        echo "<th>".$messages["tab10"]."</th>";
        echo "</tr>";
        // Files and directories
        $total = 0;
        $nbfiles = 0;
        $nbdirs = 0;
                $notindb = 0;
        $nbfilesi686 = 0;
                $totali686 = 0;
        $nbfilesx86_64 = 0;
                $totalx86_64 = 0;
        $dbfiles = getDatabaseFiles($subdir);
        reset($files);
        if(!isset($last)) $last = 0;
        while (list($key, $file) = each($files)) {
            if(($last == 0) || ($last > $nbfiles)) {
            // Directory section
            if ($file["dir"]) {
                if (($subdir != "") || ($file["name"] != "..")) {
                    echo "<tr>";
                    echo "<td>";
                    if ($file["link"]) {
                        echo "<i><b>".htmlspecialchars($file["name"])."</b></i>";
                    } else {
                        echo "<a href=$thisscript?subdir=".rawurlencode(extractSubdir($file["path"]))."&sortby=$sortby onMouseOver='return statusMsg(\"".quoteJS($file["statusmsg"])."\");' onMouseOut='return statusMsg(\"\");'>";
                        echo "<b>".$file["alias"]."</b>";
                        echo "</a>";
                    }
                    echo "</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "</tr>";
                    if ($file["level"] == 8) $nbdirs++;
                }
            // File section
            } else {
                echo "<tr>";
                echo "<td>".(($file["link"]) ? "<i>" : "");
                if ( ( checkExtension($file["name"]) ) && ( getExtension ($file["name"]) != "cb") ) {
                    echo "<a href=$thisscript?act=show&subdir=".$file["repo"]."&sortby=$sortby&file=".rawurlencode($file["name"])." onMouseOver='return statusMsg(\"".quoteJS($messages["edt9"])."\");' onMouseOut='return statusMsg(\"\");'>".onlyName(htmlspecialchars($file["name"]))."</a> ";   
                } else {
                    echo "<a href=$basedir/". $file["repo"] ."/". rawurlencode($file["name"]).">".onlyName(htmlspecialchars($file["name"]));
                }
                echo (($file["link"]) ? "</i>" : "")."</td>";
                // Show repo in Search
                if ($act=="search") echo "<td align=letf>".noParent($file["repo"])."</td>";
                echo "<td align=right>".$file["size"]."</td>";
                echo "<td align=right>".$file["date"]."</td>";
                echo "<td align=center>&nbsp;";
                if ($act == "search") {
                    echo "<a href=$thisscript?subdir=".rawurlencode($file["repo"])."&sortby=$sortby onMouseOver='return statusMsg(\"".quoteJS($messages["edt9"])."\");' onMouseOut='return statusMsg(\"\");'><img src=\"$imagesdir/$dirimage\" border=0></a> ";
                } else {
                    if (prunedRepo(onlyRepo($subdir)) == "bundles") {
                        echo "<a href=$basedir/".str_replace("%2F", "/", rawurlencode(extractSubdir($file["path"])))." onMouseOver='return statusMsg(\"".quoteJS($messages["dwn5"])."\");' onMouseOut='return statusMsg(\"\");'><img src=\"$imagesdir/$downloadimage\" border=0></a>";
                    } else {
                        if (in_array(onlyName($file["name"]),$dbfiles)) {
                            echo "<a href=$basedir/".str_replace("%2F", "/", rawurlencode(extractSubdir($file["path"])))." onMouseOver='return statusMsg(\"".quoteJS($messages["dwn5"])."\");' onMouseOut='return statusMsg(\"\");'><img src=\"$imagesdir/$downloadimage\" border=0></a>";
                        } else {
                            $notindb++;
                            echo "<img src=\"$imagesdir/$unallowimage\" border=0>";
                        }
                    }
                }
                echo "</td></tr>";
                // Compute statistics data
                $total += $file["size"];
                $nbfiles++;
                if (end(explode("/",$file["repo"])) == "i686") {
                     $nbfilesi686++;
                     $totali686 += $file["size"];
                } else {
                     $nbfilesx86_64++;
                     $totalx86_64 += $file["size"];
                }
            }
            }
        }
        echo "<tr></tr>";
        if ($act == "search") {
            echo "<tr><td><img src=\"$imagesdir/$searchimage\" align=center><a href=\"http://chakra.sourceforge.net/ccr/packages.php?O=0&K=".str_replace("^","",str_replace("-[0-9]","",$searchpattern))."&do_Search=Go\">  Search for results in CCR</a></td></tr>";
            echo "<tr></tr>";
        }
        // Show statistics data
        if ($act != "search") {
            if ( ($subdir == "") || ((end(explode("/",$subdir)) != "i686") && (end(explode("/",$subdir)) != "x86_64")) ) {
                echo "<th colspan=".($nbcols-1).">$nbdirs ".$messages["tab11"].", $nbfiles ".$messages["tab12"]." (".round($total/1024)." ".$messages["tab13"].")</th>";
            } else {
                echo "<th colspan=".($nbcols-1).">$nbfiles ".$messages["tab12"]." (".round($total/1024)." ".$messages["tab13"].") - ".$notindb." ".$messages["tab9"]."</th>";
            }
        } else {
            echo "<th colspan=".($nbcols-1).">".$messages["tab6"]." - ".$nbfilesi686." ".$messages["tab12"]." (".round($totali686/1024)." ".$messages["tab13"].") | ".$messages["tab7"]." - ".$nbfilesx86_64." ".$messages["tab12"]." (".round($totalx86_64/1024)." ".$messages["tab13"].")<br>";
            echo "<colspan=".($nbcols-1).">".$messages["tab8"]." $nbfiles ".$messages["tab12"]." (".round($total/1024)." ".$messages["tab13"].")</th>";
        } 
        echo "</tr>";
        // Back to top link
        echo "<tr><td class=tdrt colspan=$nbcols>&nbsp;</td></tr>";
        if ($nbfiles > 20) echo "<tr><td class=tdrt colspan=".($nbcols-1)."><a href=\"#top\"><b>".$messages["nav1"]."</b></a></td></tr>";
        echo "<tr><td class=tdrt colspan=$nbcols>&nbsp;</td></tr>";
        echo "</table>";
    }
}
cpFooter();
?>
