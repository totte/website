<?php
$title = "Chakra | Packages";
$windowtitle = $title;
$defaultstatusmsg = $title;
$defaultsortby = "name";           // Default sort mode (name/size/date)
$defaultorder = "ascending";       // Default sort order (ascending/descending)
$searchsortby = "date";            // Default search sort mode (name/size/date)
$hidedotfiles = true;              // All files matching that pattern will be hidden
$hidefilepattern = "^(\..*|staging|systemd)$|(.db)$|(.db.tar.xz)$|(.db.tar.gz)$|(.db.tar.gz.old)$|(.sig)$|i686";
$imagesdir = "images";             // Images directory (must be located in base directory)
$upperdirimage = "go-up.png";      // Image for upper and main directory
$opendirimage = "folder-open.png"; // Image for open directory
$dirimage = "folder.png";          // Image for simple directory
$fileimage = "folder.png";         // Image for file directory
$viewimage = "package-view.png";   // Image for view action
$mainfolderimage = "chakra.png";   // Image for the main folder
$searchimage = "search.png";       // Image for the search action
$unallowimage = "unallow.png";     // Image for package non-existing in the db
$infoimage = "information.png";    // Image for the information in the right bar
$downloadimage = "download.png";   // Image for download action
$pkgimg = "icon_repos.png";        // Image for pkg actions
$titleimg = "package.png";         // Image for the title
$flagimage = "flag-red.png";       // Image for the flags
$cleanshot = array(
    "kdebase-",
    "kde-baseapps-",
    "kdepim-",
    "kde-workspace-",
    "kdegames-",
    "kdegraphics-",
    "kdemultimedia-",
    "extragear-",
    "playground-",
    "chakra-",
    "-debug",
    "-git",
    "-svn",
    "-dev",
    "-cvs",
    "_bin",
    "-bin"
);
$searchmaxlevels = 3;
$viewextensions = array(
    "pkg.tar.gz",
    "pkg.tar.xz",
);
$basedir = "";
$rsync_users = array("username:password");
$semaphore_key = "" ; 
$gitbasedir = "";
$dateformat = "Y-m-d H:i:s";
$charset = "utf-8";
$recaptcha_public_key = '';
$recaptcha_private_key = '';
?>
