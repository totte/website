<?php

//
//   The Chakra Packages Viewer - check-repos module
//

error_reporting(E_ALL);
include 'include/config.php';
include 'func.php';

// Available repos
$repos = listDirs($basedir);
$repolist = "ok+ ".implode(" ",$repos);
echo $repolist;
?>
