<?php

//
//   The Chakra Packages Viewer - remove-pkg module
//

error_reporting(E_ALL);
include 'include/config.php';
include 'func.php';
// Available repos
$repos = listDirs($basedir);
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( (isset($_POST['r'])) && (isset($_POST['a'])) && (isset($_POST['u'])) && (isset($_POST['n'])) ) {
        // Safe method same as basedir but accepts any encodding
        $package = end(explode("/",$_POST['n']));
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
        // Remove package
        exec("repo-remove -q $basedir/".$_POST['r']."/".$_POST['a']."/".$_POST['r'].".db.tar.gz $(pacman -Qp  $basedir/".$_POST['r']."/".$_POST['a']."/$package | cut -d ' ' -f1)");
        unlink($basedir."/".$_POST['r']."/".$_POST['a']."/".$package);
        if(file_exists($basedir."/".$_POST['r']."/".$_POST['a']."/".$package.".sig")) {
            unlink($basedir."/".$_POST['r']."/".$_POST['a']."/".$package.".sig");
        }
        echo 'ok';
    } else {
        echo 'error: missing info';
        exit;
    }
} else {
    echo 'error: get method not supported';
    exit;
}
?>
