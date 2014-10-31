<?php
//---------------------------------------------------------------------
// 
//  Functions for The Chakra Packages Viewer
//
//---------------------------------------------------------------------

// Return quoted string for JavaScript usage
function quoteJS($str) {
    return str_replace("'", "\\&#39;", $str);
}

// Checks and rebuilds a sub-directory
function extractSubdir($d) {
    global $basedir;
    $tmp = "";
    if ($d != "") {
        $rp = @ereg_replace("((.*)\/.*)\/\.\.$", "\\2", $d);
        $tmp = strtr(str_replace($basedir, "", $rp), "\\", "/");
        $recur = true;
        while ($recur) {
            if(isset($tmp[0])) {
                if($tmp[0] == '/') { 
                    $tmp = substr($tmp, 1);
                } else {
                    $recur = false;
                }
            } else {
                $recur = false;
            }
        }
    }
    return $tmp;
}

// Returns full file path
function getFilePath($f, $sd = "") {
    global $basedir, $subdir;
    if ($f == ".") {
        return $basedir."/".$subdir;
    } else {
        return $basedir."/".(($sd != "") ? $sd : $subdir)."/".@basename($f);
    }
}

// Checks file name
function checkFileName($f) {
    global $subdir, $thisfile, $hidedotfiles, $hidefilepattern, $trashcan, $trashcaninfofileext, $showimagesdir, $imagesdir, $readmefile, $showreadmefile, $filealiases, $filealiasext;
    $f = @basename($f);
    return !(   (($subdir == "") && (strtolower($f) == $thisfile))
    || ($f == "..")
    || ($f == "any")
    || ($f == "staging")
    || ($f == "kde-next")
    || ($f == "bundles")
    || (!$showimagesdir && ((($subdir == "") && ($f == $imagesdir)) || ($subdir == $imagesdir)))
    || ($hidedotfiles && ($f[0] == '.'))
    || (($hidefilepattern != "") && @ereg($hidefilepattern, $f)));
}

// Checks for package details
function checkExtension($f) {
    global $viewextensions;
    if (count($viewextensions) != 0) {
        foreach ($viewextensions as $ext) {
            if (@ereg(".*\.".strtolower($ext)."$", strtolower($f))) return true;
        }
        return false;
    } else {
        return true;
    }
}

// Returns the extension of a pkgfile
function getExtension($f) {
    global $viewextensions;
    foreach ($viewextensions as $ext) {
        if (@ereg(".*\.".strtolower($ext)."$", strtolower($f))) return $ext;
    }
}

// Find files matching a regexp pattern
function searchFiles($sd, $searchpattern, $level = 0) {
    global $basedir, $subdir, $searchmaxlevels, $hidefilepattern, $hidefolders, $order;
    $count = 0;
    if (    ($searchmaxlevels == 0)
        || ($level < $searchmaxlevels)) {
        $dir = $basedir."/".$sd;
        if ($level == 0) {
            // Make last packages & build logs a search
            $searchpattern = str_replace("last packages","*",$searchpattern);
            $searchpattern = str_replace("build logs","-log-",$searchpattern);
            $searchpattern = str_replace("+","\+",$searchpattern);
            $searchpattern = "^".str_replace("*", ".*", str_replace("?", ".", str_replace(".", "\.", $searchpattern)))."$";
        }
        $d = @opendir($dir); 
        while (($file = @readdir($d))) { 
            if (@is_dir($dir."/".$file) && ($file != ".") && ($file != "..") && ($file != "i686") && ($file != "bundles") && ($file != "kde-next") && ($file != "staging")) {
                $count += searchFiles($sd."/".$file, $searchpattern, $level + 1); 
            } else if (@ereg(strtolower($searchpattern), strtolower($file)) && !@ereg($hidefilepattern, $file)) {
                $fp = getFilePath($file, $sd);
                if ($order == "ascending") {
                    addFileToList($file, $fp, ($subdir != "") ? str_replace($subdir."/", "", extractSubdir($fp)) : extractSubdir($fp), 8);
                } else {
                    addFileToList($file, $fp, ($subdir != "") ? str_replace($subdir."/", "", extractSubdir($fp)) : extractSubdir($fp), 2);
                }
                $count++;
            }
        } 
        @closedir($d); 
    }
    return $count;
}

// Return the list of the directories
function listDirs($bd) {
    $d = @opendir($bd);
    // get each entry
    $r = array();
    while($entryName = @readdir($d)) {
        if( ($entryName != ".") && ($entryName != "..") && @is_dir($bd."/".$entryName) ) {
            $r[] = $entryName;
        }
    }
    // close directory
    @closedir($d);
    sort($r);
    return($r);
}

// Check if a package exist in a repo and return the complete pkgname-pkgver-arch-ext
function searchInRepo($repo, $arch, $pkg) {
    global $basedir;
        $ret = array();
        if(is_dir($basedir."/".$repo."/".$arch)) {
        exec("ls ".$basedir."/".$repo."/".$arch." | grep \"$pkg\"",$ret); 
    }
    return ($ret); 
}

// Complete check for email inputs
function isEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex+1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen-1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots  
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
            // character not valid in local part unless local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain,"MX") ||  checkdnsrr($domain,"A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}

// Convert a email name to be usable with mailto
function mailConv($mail) {
    $m = str_replace("[at]","@",$mail);
    $m = str_replace("[dot]",".",$m);
    $m = str_replace("Unknown Packager","<noreply@chakraos.org>",$m);
    return ($m);
}

// Adds a file to file list
function addFileToList($file, $fp, $alias, $level, $image = "", $msg = "") {
    global $files, $subdir, $sortby, $dateformat, $imagesdir, $dirimage, $fileimage, $messages, $basedir, $act;
    if ($alias == "") $alias = $file;
    $date = @filemtime($fp);
    $size = (@is_dir($fp)) ? -1 : @filesize($fp); // negative size for directories
    if ($sortby == "size") {
        $key = $level." ".str_pad($size, 20, "0", STR_PAD_LEFT)." ".$alias;
    } else if ($sortby == "date") {
        $key = $level." ".date("YmdHis", $date)." ".$alias;
    } else {
        $key = $level." ".$alias;
    }
    $repoclean = array ($file,$basedir."//",$basedir."/");
    $repo = str_replace($repoclean,"",$fp);
    $files[$key] = array(
        "name" => $file,
        "alias" => "<img src=\"$imagesdir/".(($image != "") ? $image : ((@is_dir($fp)) ? $dirimage : $fileimage))."\" border=0 align=center>&nbsp;".$alias,
        "level" => $level,
        "path" => $fp,
        "size" => $size,
        "date" => date($dateformat, $date),
        "dir" => @is_dir($fp),
        "link" => @is_link($fp),
        "statusmsg" => (($msg != "") ? $msg : ((@is_dir($fp)) ? $messages["inf4"] : $messages["inf5"])),
        "repo" => substr($repo,0,-1)
    );
}

// Generates full message
function getMsg($class, $msgcode, $msgparam1 = "", $msgparam2 = "") {
    global $messages;
    $msg = str_replace("%VAR1%", $msgparam1, str_replace("%VAR2%", $msgparam2, $messages[$msgcode]));
        $msg = str_replace("-[0-9]","",$msg);
        $msg = str_replace("^","",$msg);
    return (($class != "") ? "<p class=$class>" : "").htmlspecialchars($msg);
}

// Manages redirections
function redirectWithMsg($class, $msgcode, $msgparam1 = "", $msgparam2 = "", $extraparams = "") {
    global $thisscript, $subdir, $sortby;
    $msg = getMsg($class, $msgcode, $msgparam1, $msgparam2);
    header("Location: $thisscript?subdir=".rawurlencode($subdir)."&sortby=$sortby&msg=".rawurlencode($msg).$extraparams);
    exit;
}

// Removes the parent folder
function noParent($s) {
    $r = array ("archive/",
            "development/",
            "newbase/");
    $ps = Str_replace($r,"",$s);
    return $ps;
}

// Removes the arch and the extension from a pkg
function onlyName($f) {
    $r = array ("-i686","-x86_64","-any",".pkg.tar.gz",".pkg.tar.xz",".cb");
    $pn = str_replace($r,"",$f);
    return $pn;
}

// Removes the arch and the parent from a subdir
// must include any parent folder, any arch and /
function onlyRepo($s) {
    $r = array ("archive",
            "development",
            "newbase",
            "i686",
            "x86_64",
            "/");
    $ps = Str_replace($r,"",$s);
    return $ps;
}

// Removes the branch from a repo
// used mainly for Git
function prunedRepo($s) {
    $r = array ("-testing","-unstable");
    $pr = Str_replace($r,"",$s);
    return $pr;
}

// Removes the arch from a subdir
function prunedSubdir($s) {
    $r = array ("/i686","/x86_64");
    $ps = Str_replace($r,"",$s);
    return $ps;
}

// Get the package details from a pacman db.tar.gz database
function dbPackageDetails($p) {
    global $basedir,$subdir;
    $pn=prunedName($p);
    $ps=onlyRepo($subdir);
    $ar = array();
    if(file_exists("$basedir/$subdir/$ps.db.tar.gz")) {
        exec("tar xf $basedir/$subdir/$ps.db.tar.gz $pn/desc -O",$pd);
        $pkgname = array_search("%NAME%" , $pd)+2;
        $pkgarch = array_search("%ARCH%" , $pd)+1;
        $pkgdesc = array_search("%DESC%" , $pd)+1;
        $pkglic = array_search("%LICENSE%" , $pd)+1;
        $pkgmds = array_search("%MD5SUM%" , $pd)+1;
        $pkgurl = array_search("%URL%" , $pd)+1;
        $pkgcsize = array_search("%CSIZE%" , $pd)+1;
        $pkgisize = array_search("%ISIZE%" , $pd)+1;
        $pkgpkgr = array_search("%PACKAGER%" , $pd)+1;
        $pkgbdat = array_search("%BUILDDATE%" , $pd)+1;
        $ar = array (
            "NAME"=>$pd[$pkgname],
            "ARCH"=>$pd[$pkgarch],
            "DESC"=>$pd[$pkgdesc],
            "LICE"=>$pd[$pkglic],
            "MD5S"=>$pd[$pkgmds],
            "UURL"=>$pd[$pkgurl],
            "CSIZ"=>$pd[$pkgcsize],
            "ISIZ"=>$pd[$pkgisize],
            "PKGR"=>$pd[$pkgpkgr],
            "BDAT"=>$pd[$pkgbdat],
        );
        return $ar;
    } else {
        return $ar;
    }
}

// Get the package details from a pkg.tar.xz package
function getPackageDetails($p) {
    global $basedir,$subdir;
    $pd = array();
    $deps = "";
    $grps = "";
    if(file_exists("$basedir/$subdir/$p")) {
        exec("tar xf $basedir/$subdir/$p .PKGINFO -O",$pd);
        $gitf = "";
        foreach ($pd as $line) {
            $sch = explode(" = ",$line,2);
            if ($sch[0] == "pkgname") $name = $sch[1];
            if ($sch[0] == "pkgver") $vers = $sch[1];
            if ($sch[0] == "arch") $arch = $sch[1];
            if ($sch[0] == "pkgdesc") $desc = $sch[1];
            if ($sch[0] == "url") $uurl = $sch[1];
            if ($sch[0] == "license") $lice = $sch[1];
            if ($sch[0] == "size") $size = $sch[1];
            if ($sch[0] == "packager") $pkgr = $sch[1];
            if ($sch[0] == "builddate") $bdat = $sch[1];
            if ($sch[0] == "gitrepo") $gitr = $sch[1];
            if ($sch[0] == "gitfolder") $gitf = $sch[1];
            if ($sch[0] == "group") $grps = $grps."[".str_replace("group = ","",$line)."] ";
            if ($sch[0] == "depend") $deps = $deps.str_replace("depend = ","",$line)."|";
        }
        $ar = array (
            "NAME"=>$name,
            "VERS"=>$vers,
            "ARCH"=>$arch,
            "DESC"=>$desc,
            "UURL"=>$uurl,
            "LICE"=>$lice,
            "SIZE"=>$size,
            "PKGR"=>$pkgr,
            "BDAT"=>$bdat,
            "DEPS"=>$deps,
            "GITR"=>$gitr,
            "GRPS"=>$grps,
            "GITF"=>$gitf
        );
        return $ar;
    } else {
        return false;
    }
}

// Return an array containing all the packages in the Pacman database
function getDatabaseFiles($s) {
    global $basedir;
    $ps=onlyRepo($s);
    $pd = array();
    if(file_exists("$basedir/$s/$ps.db.tar.gz")) {
        exec("tar -ztf $basedir/$s/$ps.db.tar.gz | cut -d/ -f1",$pd);
    }
    $cl = array_unique($pd);
    $ca = array_values($cl);
    return $ca;
}

function getBundles($s) {
    global $basedir;
    exec("ls $basedir/$s/*.cb -1 | cut -d/ -f5 | sed \"s/-i686.cb//g\" | sed \"s/-x86_64.cb//g\"",$pd);
    $cl = array_unique($pd);
    $ca = array_values($cl);
    return $ca;
}

function getPackages($s) {
    global $basedir;
    exec("ls $basedir/$s/*.pkg.tar.*z -1 | cut -d/ -f5 | sed \"s/.pkg.tar.xz//g\" | sed \"s/.pkg.tar.gz//g\" | sed \"s/-any//g\" | sed \"s/-i686//g\" | sed \"s/-x86_64//g\"",$pd);
    $cl = array_unique($pd);
    $ca = array_values($cl);
    return $ca;
}

function getSign($s) {
    global $basedir;
    exec("ls $basedir/$s/*.pkg.tar.*z.sig -",$pd);
    $cl = array_unique($pd);
    $ca = array_values($cl);
    return $ca;
}

// Return a git(orious) URL pointing to the package folder
function gitFolder($repo,$app) {
    global $gitbasedir,$subdir;
    $branch="master";
    if ($repo != "") {
        $sd = reset(explode("-",$repo));
        $sf = end(explode("-",$repo));
    } else {
        $sd = reset(explode("-",$subdir));
        $sf = end(explode("-",$subdir));
    }
    $sd = prunedSubdir($sd);
    $sf = prunedSubdir($sf);
    if($sf == "testing") $branch="testing";
    if($sf == "unstable") $branch="unstable";
    $gitfolder = $gitbasedir."/".prunedRepo($sd)."/trees/".$branch."/".$app;
    return $gitfolder;
}

// Return a git(orious) URL pointing to the pkgbuild
function gitPkgbuild($repo,$app) {
    global $gitbasedir,$subdir;
    $branch="master";
    if ($repo != "") {
        $sd = reset(explode("-",$repo));
        $sf = end(explode("-",$repo));
    } else {
        $sd = reset(explode("-",$subdir));
        $sf = end(explode("-",$subdir));
    }
    $sd = prunedSubdir($sd);    
    $sf = prunedSubdir($sf);
    if($sf == "testing") $branch="testing";
    if($sf == "unstable") $branch="unstable";
    $gitfolder = $gitbasedir."/".prunedRepo($sd)."/blobs/".$branch."/".$app."/PKGBUILD";
    return $gitfolder;
}

// Return a git(orious) URL pointing to the package ChangeLog
function gitLog($repo,$app) {
    global $gitbasedir,$subdir;
    $branch="master";
    if ($repo != "") {
        $sd = reset(explode("-",$repo));
        $sf = end(explode("-",$repo));
    } else {
        $sd = reset(explode("-",$subdir));
        $sf = end(explode("-",$subdir));
    }
    $sd = prunedSubdir($sd);
    $sf = prunedSubdir($sf);
    if($sf == "testing") $branch="testing";
    if($sf == "unstable") $branch="unstable";
    $gitfolder = $gitbasedir."/".prunedRepo($sd)."/history/".$branch.":".$app."/PKGBUILD";
    return $gitfolder;
}

// Clean utf-8 strings encodings
function sanitize($content) {
    // &hellip; , &#8230;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xC2\xA6~', '&hellip;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x82\xC2\xA6~', '&hellip;', $content);
    $content = preg_replace('~\xD0\xB2\xD0\x82\xC2\xA6~', '&hellip;', $content);
    // &mdash; , &#8212;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xE2\x80\x9D~', '&mdash;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x82\xAC\xC2\x9D~', '&mdash;', $content);
    $content = preg_replace('~\xD0\xB2\xD0\x82\xE2\x80\x9D~', '&mdash;', $content);
    // &ndash; , &#8211;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xE2\x80\x9C~', '&ndash;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x82\xAC\xC5\x93~', '&ndash;', $content);
    $content = preg_replace('~\xD0\xB2\xD0\x82\xE2\x80\x9C~', '&ndash;', $content);
    // &rsquo; , &#8217;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xE2\x84\xA2~', '&rsquo;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x80\x9E\xC2\xA2~', '&rsquo;', $content);
    $content = preg_replace('~\xD0\xB2\xD0\x82\xE2\x84\xA2~', '&rsquo;', $content);
    $content = preg_replace('~\xD0\xBF\xD1\x97\xD0\x85~', '&rsquo;', $content);
    // &lsquo; , &#8216;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xCB\x9C~', '&lsquo;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x8B\xC5\x93~', '&lsquo;', $content);
    // &rdquo; , &#8221;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xC2\x9D~', '&rdquo;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x82\xC2\x9D~', '&rdquo;', $content);
    $content = preg_replace('~\xD0\xB2\xD0\x82\xD1\x9C~', '&rdquo;', $content);
    // &ldquo; , &#8220;
    $content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xC5\x93~', '&ldquo;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x85\xE2\x80\x9C~', '&ldquo;', $content);
    $content = preg_replace('~\xD0\xB2\xD0\x82\xD1\x9A~', '&ldquo;', $content);
    // &trade; , &#8482;
    $content = preg_replace('~\xC3\xA2\xE2\x80\x9E\xC2\xA2~', '&trade;', $content);
    $content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x82\xAC\xC5\xBE\xC3\x82\xC2\xA2~', '&trade;', $content);
    // th
    $content = preg_replace('~t\xC3\x82\xC2\xADh~', 'th', $content);
    // .
    $content = preg_replace('~.\xD0\x92+~', '.', $content);
    $content = preg_replace('~.\xD0\x92~', '.', $content);
    // ,
    $content = preg_replace('~\x2C\xD0\x92~', ',', $content);
    return $content;
}

// Returns the last modified time value from a given remote file
function rfilemtime($file) { 
    $curl = curl_init($file);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_FILETIME, true);
    $result = curl_exec($curl);
    if ($result === false) {
        return false;
    }
    $timestamp = curl_getinfo($curl, CURLINFO_FILETIME);
    if ($timestamp != -1) {
        return date("d-m-Y H:i:s", $timestamp);
    } 
    else {
        return "unknown";
    }
}

// Performs a query to the database
function db_query($query="", $db_handle="") {
    if (!$query) {
        return FALSE;
    }
    if (!$db_handle) {
        echo __("The DB handler was not provided to db_query");
        die;
    }
    $result = $db_handle->query($query);
    return $result;
}

// Search for flags
function search_flags($database, $pkg, $ver) {
    try {
        $dbh = new PDO("sqlite:$database");
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        if (isset($error)) echo $error;
        include 'templates/footer.php';
        die;
    }
    $q = "SELECT Name,Version,Flag FROM Flags WHERE Name='{$pkg}' AND Version='{$ver}'";
    $result = db_query($q,$dbh);
    if($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['Flag'];
    }
    else {
        return false;
    }
}
?>
