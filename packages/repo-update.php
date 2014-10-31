<?php

//
//   The Chakra Packages Viewer - repo-update module
//

error_reporting(E_ALL);
include 'include/config.php';
include 'func.php';

// Available repos
$repos = listDirs($basedir);
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( (isset($_POST['r'])) && (isset($_POST['a'])) && (isset($_POST['u'])) ) {
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
        // Perform a repo-add and repo-clean
        exec("repo-add -q $basedir/".$_POST['r']."/".$_POST['a']."/".$_POST['r'].".db.tar.gz $basedir/".$_POST['r']."/".$_POST['a']."/*.pkg.tar.*z");
        exec("sudo repo-clean -q -m c -s $basedir/".$_POST['r']."/".$_POST['a']."/");
        // Check for outdated signatures and remove
        unset($check_signatures);
        $outdated_signatures=array();
        $check_signatures = searchInRepo($_POST['r'],$_POST['a'],"^.*pkg.tar..*z.sig$");
        foreach($check_signatures as $signature) {
            if(!is_file($basedir."/".$_POST['r']."/".$_POST['a']."/".str_replace(".sig","",$signature))) {
                    $outdated_signatures[]=$signature;
            }
        }
        reset($outdated_signatures);
        foreach($outdated_signatures as $remove_signature) {
            unlink($remove_signature);
        }
        // All done
        echo 'ok';
;
    } else {
        echo 'error: missing info';
        exit;
    }
} else {
    echo 'error: get method not supported';
    exit;
}
?>
