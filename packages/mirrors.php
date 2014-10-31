<?php
//
// The Chakra Project - Remote mirrors
//

include 'func.php';
include 'common.php';

// Mirror list and countries
$mirrors = array(
    array("United States",
        "http://mirror.rit.edu,/kdemod/",
        "http://mirror.eylusion.net,/",
        "ftp://mirror.dacentec.com,/chakra/",
        "http://mirror.dacentec.com,/chakra/"),
    array("Czech Republic",
        "http://ftp.sh.cvut.cz,/MIRRORS/chakra/",
        "ftp://ftp.sh.cvut.cz,/MIRRORS/chakra/"),
    array("France",
        "http://www-ftp.lip6.fr,/pub/linux/distributions/chakra/",
        "ftp://ftp.lip6.fr,/pub/linux/distributions/chakra/",
        "http://ftp.ciril.fr,/pub/linux/chakra/",
        "ftp://ftp.ciril.fr,/pub/linux/chakra/"),
    array("Germany",
        "http://rsync.chakraos.org,/packages/",
        "http://mirror.selfnet.de,/kdemod/",
        "ftp://mirror.selfnet.de,/kdemod/",
        "http://mirror.wh-stuttgart.net,/mirrors/kdemod/"),
    array("Greece",
        "http://ftp.cc.uoc.gr,/mirrors/linux/chakra/",
        "ftp://ftp.cc.uoc.gr,/mirrors/linux/chakra/"),
    array("Italy",
        "http://chakra.mirror.garr.it,/mirrors/chakra/"),
    array("Switzerland",
        "http://archlinux.puzzle.ch,/kdemod/"),
    array("Spain",
        "http://ftp.caliu.cat,/pub/distribucions/chakra/repo/"),
    array("Russia",
        "http://mirror.tspu.ru,/chakra-project/"),
    array("China",
        "http://oss.ustc.edu.cn,/kdemod/",
        "http://debian.cn99.com,/kdemod/",
        "http://mirrors.163.com,/kdemod/"),
    array("Japan",
        "http://ftp.yz.yamagata-u.ac.jp,/pub/linux/chakra/",
        "ftp://ftp.yz.yamagata-u.ac.jp,/pub/linux/chakra/"),
    array("Taiwan",
         "http://free.nchc.org.tw,/chakra/",
         "ftp://free.nchc.org.tw,/chakra/")
);

$title = " Mirrors Status";
$imagesdir = "../static/img/icon";
$titleimg = "download_32.png";
cpHeader();

?>
            <div id="about" class="box">
<?php
            foreach($mirrors as $country) {
                echo "<p><b>" . $country[0] . "</b><br>";
                for($m = 1; $m < sizeof($country); $m++) {
                    $status = rfilemtime(str_replace(",","",$country[$m]) . "testing/x86_64/testing.db.tar.gz");
                    echo "<a href='" . str_replace(",","",$country[$m]) ."'>" . reset(explode(",",$country[$m])) . "</a> | " . 
                    ($status ? "<font color='green'>online</font>" : "<font color='red'>offline</font>") . " | Last database update: $status";
                    echo "<br>";
                    unset($status);
                }
                echo "</p><br>";
            }
?>          </div>
        </div>
    </div>
<?php
cpFooter();
?>
