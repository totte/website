<?php

//
//   The Chakra Packages Viewer - query-pkgs module
//

error_reporting(E_ALL);
include 'include/config.php';
include 'func.php';
// Available repos
$repos = listDirs($basedir);
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( (isset($_POST['r'])) && (isset($_POST['a'])) && (isset($_POST['u'])) && (isset($_POST['n'])) ) {
        // Check the repo
        if(!in_array($_POST['r'],$repos)) {
            echo "error: the repo «".$_POST['r']."» does not exist";
            exit;
        }
        // Check the arch
        if( ($_POST['a'] != 'i686') && ($_POST['a'] != 'x86_64') ) {
            echo 'error: incorrect arch';
            exit;
        }
        // Check the user, the collected data gets destroyed asap
        $user_exist = false;
        $users = $rsync_users;
        date_default_timezone_set('UTC');
        foreach ($users as $user) {
            $usr_data=explode(":",$user);
            $cyp_up=sha1(gmstrftime("%W") . $usr_data[0] . sha1($usr_data[1]));
            if($_POST['u'] == $cyp_up) {
                $user_exist = true;
            }
            unset($usr_data);
        }
        if(!$user_exist) {
            echo 'error: invalid user or password';
            exit;
        }
        unset($users,$usr_data);
        // Query packages
        $final_list=array();
        $searches=explode(",",$_POST['n']);
        foreach($searches as $dosearch) {
            // TODO: Glob returns matching shell wildcards, we need a more complex function for regular expressions
            //$lst = glob("$basedir/".$_POST['r']."/".$_POST['a']."/*$dosearch*.pkg.tar.*z");
            exec("ls $basedir/".$_POST['r']."/".$_POST['a']."/ | grep '$dosearch' | grep 'pkg' | grep 'z$'",$lst);
            foreach($lst as $match) {
                exec("tar xf $basedir/".$_POST['r']."/".$_POST['a']."/$match .PKGINFO -O | grep 'gitrepo'",$td);
                $retval=isset($td[0]) ? reset(explode("-",end(explode(" ",$td[0])))) : '';
                if($retval == '') {
                    $final_list[]=end(explode("/",$match));
                } else {
                    $final_list[]=end(explode("/",$match))."|".$retval;
                }
                unset($td,$retval);
            }
            unset($lst);
        }
        reset($final_list);
        echo implode(" ",array_unique($final_list));
    } else {
        echo 'error: missing info';
        exit;
    }
} else {
    echo 'error: get method not supported';
    exit;
}
?>
