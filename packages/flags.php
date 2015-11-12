<?php
//
//   The Chakra Packages Viewer - Flags module
//

include 'include/config.php';
include 'func.php';
include 'messages.php';
include 'common.php';
require_once('include/recaptchalib.php');
include 'Mail.php';

$isflagged = false;
$error = null;
$parsing_errors = array(
    "recaptcha"=>"There was an error parsing the recaptcha. go back and try again.",
    "email"=>"The provided email don't appears to be correct, plese go back and fix it.",
    "broken"=>"If you want to flag a package as broken, you must provide additional intormation."
);

// Open the flags database
$database = "repo-lck/packages.sqlite";

// Get the recaptcha values
$resp = recaptcha_check_answer ($recaptcha_private_key,
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]);

// Prevent to use this script standalone
if(!isset($_POST['p'])) {
    Header ('Location: chakraos.org/packages/index.php');
}

// Parse variables
$package_name = ( isset($_POST['p']) ) ? $_POST['p'] : "";
$package_vers = ( isset($_POST['v']) ) ? $_POST['v'] : "";
$package_subd = ( isset($_POST['s']) ) ? $_POST['s'] : "";
$package_file = ( isset($_POST['f']) ) ? $_POST['f'] : "";
$package_mail = ( isset($_POST['e']) ) ? $_POST['e'] : "";
$package_comm = ( isset($_POST['c']) ) ? $_POST['c'] : "";
$package_type = ( isset($_POST['t']) ) ? $_POST['t'] : "";

// Form is empty or there was an error parsing the parameters
if($_POST['do_flag'] !== "yes") {
    // Collect missing info
    cpHeader();
    echo "<form action=flags.php method=post>";
    echo "<table class=cctable border=0;>";
    echo "<tr><td class=cctable>";
    echo "<input name=p type=hidden value=".$package_name.">";
    echo "<input name=v type=hidden value=".$package_vers.">";
    echo "<input name=s type=hidden value=".$package_subd.">";
    echo "<input name=f type=hidden value=".$package_file.">";
    echo "<input name=t type=hidden value=".$package_type.">";
    echo "<input name=do_flag type=hidden value=\"yes\"1>";
    echo "Your email: ";
    echo "<input name=e type=text size=100 value=\"".$package_mail."\"> ";
    echo "<br /><br /><br />";
    echo "</td></tr><tr>";
    echo "<td class=cctable>";
    echo "You are about to flag <b>".$package_name."-".$package_vers."</b> as ".$package_type.", write any additional information here:";
    echo "<br /><br />";
    echo "<textarea name=c cols=100 rows=8>".$package_comm."</textarea>";
    echo "<br /><br />";
    echo "</td></tr>";
    echo "<tr><td align=center>";
    echo "<br /><br />";
    echo recaptcha_get_html($recaptcha_public_key, $error);
    echo "<br />";
    echo "<input type=submit value=\"  Flag the package as $package_type  \"></td></tr>";
    echo "</table>";
    echo "</form>";
    echo "<table class=cctable border=0;>";
    echo "<br /><br />";
    echo "<tr><td><a href='chakraos.org/packages/index.php?act=show&subdir=".$package_subd."&file=".$package_file."' onMouseOver='return statusMsg(\"".quoteJS($messages["edt12"])."\");' onMouseOut='return statusMsg(\"\");'>".$messages["edt12"]."</a></td></tr>";
    echo "</table>";
    cpFooter();
} else {
    // Wrong recaptcha
    if (!$resp->is_valid) {
        $redirect_error = "recaptcha";
    }
    if(!isEmail($package_mail)) {
        $redirect_error = "email";
    }
    if(($package_type == "broken") && ($package_comm == "")) {
        $redirect_error = "broken";
    }
    // There was an error
    if (isset($redirect_error)) {
        cpHeader();
        echo "<table class=cctable border=0;>";
        echo "<tr><td align=center class=error>";
        echo $parsing_errors[$redirect_error];
        echo "<form method=post action=flags.php>";
        echo "<input name=p type=hidden value=".$package_name.">";
        echo "<input name=v type=hidden value=".$package_vers.">";
        echo "<input name=s type=hidden value=".$package_subd.">";
        echo "<input name=f type=hidden value=".$package_file.">";
        echo "<input name=e type=hidden value=".$package_mail.">";
        echo "<input name=t type=hidden value=".$package_type.">";
        echo "</td></tr>";
        echo "<td class=hiddenbox>";
        echo "<textarea name=c>".$_POST['c']."</textarea>";
        echo "</td>";
        echo "<tr><td align=center>";
        echo "<input type=submit value=\"  Go back  \">";
        echo "</form></td></tr>";
        echo "<br /><br /><br /><br /><br /><br />";
        echo "</table>";
        echo "<br /><br /><br /><br /><br /><br />";
        cpFooter();
    // All went fine, let's flag the package
    } else {
        // It's already flagged?
        $isflagged = search_flags($database,$package_name,$package_vers);
        if(($package_name != "") && ($isflagged != true)) {
            // Insert the flag into the flags db  # TODO: make the handler open only once?
            try {
                $dbh = new PDO("sqlite:$database");
            }
            catch(PDOException $e) {
                echo $e->getMessage();
                if (isset($error)) echo $error;
                include 'templates/footer.php';
                die;
            }
            $q = "INSERT INTO Flags (Id, Name, Version, Email, Comment, Flag) ";
            $q.= "VALUES (null, '$package_name', '$package_vers','$package_mail','$package_comm','$package_type')";
            db_query($q,$dbh);

            // This should not be translated !!
            $body = 'Package details: http://chakraos.org/packages/index.php?act=show&subdir='.$package_subd.'&sortby=date&file='.$package_file."\n"
            . "\n\n---\nThe package ".$package_name."-".$package_vers." has been flagged as ".$package_type."\n"
            . "by: ".$package_mail;
            if($package_comm != "") {
                $body = $body."\n\nAdditional information: \n".stripslashes($package_comm);
            }
            $body = wordwrap($body, 70);
            $bcc = '';
            $headers = "Bcc: $bcc\nReply-to: noreply@chakraos.org\nFrom: packages@chakraos.org\nX-Mailer: Packages\n";
            @mail("chakra-packagers@googlegroups.com", "The package " . $package_name . "-" . $package_vers ." has been flagged as ". $package_type, $body, $headers);
        }
        // Package is flagged, let's redirect
        Header ('Location: http://chakraos.org/packages/index.php?act=show&subdir='.$package_subd.'&file='.rawurlencode($package_file).'');
    }
}
?>
