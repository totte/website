<?php
//
//   The Chakra Packages Viewer - viewlog module
//   (c) 2011 - Manuel Tortosa <manutortosa[at]chakra-project.org
//

error_reporting(E_ALL);
include 'include/config.php';
include 'common.php';
include 'func.php';
include 'messages.php';

// Perform special syntax highlight for our logs, faster and lighter than geshi,
// and never overflows, fits our needs here :)
function doNice($line) {
    // Remove Chakra buildsys color codes
    $ret = str_replace("[1m","",$line);
    $ret = str_replace("[32m","",$ret);
    $ret = str_replace("(B","",$ret);
    $ret = str_replace("[m","",$ret);
    $ret = str_replace("[33m","",$ret);
    // Arrows
    $ret = str_replace("==>","<arrow>==></arrow>",$ret);
    $ret = str_replace("starting build ...","<b>Starting Build ...</b>",$ret);
    // Quotes
    $ret = preg_replace('#".*"#', '<squot>$0</squot>', $ret);
    $ret = preg_replace('#"(\.|[0-9]).+"#', '<quotes>$0</quotes>', $ret);
    $ret = preg_replace("#'.*'#", "<lquot>$0</lquot>", $ret);
    // Warnings
    $ret = preg_replace('#(warning:).*#', '<warn>$0</warn>', $ret);
    $ret = str_replace("Warning:","<warn>Warning:</warn>",$ret);
    $ret = str_replace("WARNING:","<warn>WARNING:</warn>",$ret);
    $ret = preg_replace('#(\#warning).*#', '<warncom>$0</warncom>', $ret);
    $ret = str_replace("warn:","<litwarn>warn:</litwarn>",$ret);
    $ret = str_replace("Warn:","<litwarn>Warn:</litwarn>",$ret);
    $ret = str_replace("- not found","- <litwarn>not found</litwarn>",$ret);
    $ret = str_replace("- found","- <oks>found</oks>",$ret);
    $ret = str_replace("- Failed","- <litwarn>Failed</litwarn>",$ret);
    $ret = str_replace("- Success","- <oks>Success</oks>",$ret);
    // Progress
    $ret = preg_replace('#\[( |[0-9]|%).*\]#', '<prgrs>$0</prgrs>', $ret);
    // Install
    $ret = str_replace("-- Installing:","<dblue>-- Installing:</dblue>",$ret);
    return($ret);
}

cpHeader();
echo "<div id='content'>";
echo "<div class='logtable'>";
echo "<table>";
unset($data);
if(file_exists("$basedir/".$_GET['subdir']."/".$_GET['package'])) {
      exec("tar xf $basedir/".$_GET['subdir']."/".$_GET['package']." ".$_GET['log']." -O",$data);
      echo "<tr><th class=tdhp><b>Viewing ".end(explode("/",$_GET['log'])).":</b></th></tr>";
      echo "<tr><td><br></td></tr>";
      $contents="false";
      foreach($data as $text) {
          echo "<tr><td><pre>".doNice($text)."</pre></td></tr>";
          if($text != "") $contents="true";
      }
      if($contents == "false") {
          echo "<tr><td><br></td></tr>";
          echo "<tr><td><warn>This build log is empty !</warn></td></tr>";
          echo "<tr><td><br></td></tr>";
      }
      echo "</table></div></div>";
} else {
    echo "<tr><td>The package ".$_GET['package']." does not exists anymore.</td></tr>";
    echo "<br><br>";
}
// Return to packages link
echo "<br><br>";
echo "<table class=listtable border=0 cellspacing=2 cellpadding=2;>";
echo "<tr><td><a href=\"pkg-ls.php?subdir=".rawurlencode($_GET['subdir'])."&act=show&mode=log&package=".$_GET['package']."\">Return to logs</a> :: <a href=\"index.php?subdir=".rawurlencode($_GET['subdir'])."&act=show&file=".$_GET['package']."\">".$messages["edt12"]."</a></td></tr>";
echo "</table>";
cpFooter();
?>
