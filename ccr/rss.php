<?php

set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/' . PATH_SEPARATOR . 'lang/');
include_once("aur.inc");
include_once("feedcreator.class.php");

#detect prefix
$protocol = $_SERVER["HTTPS"]=='on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

#If there's a cached version <1hr old, won't regenerate now
$rss = new UniversalFeedCreator();
$rss->useCached("RSS2.0", "/tmp/ccr-newestpkg.xml", 1800);

#All the general RSS setup
$rss->title = "CCR Newest Packages";
$rss->description = "The latest and greatest packages in the CCR";
$rss->link = "${protocol}://{$host}/ccr/";
$rss->syndicationURL = "{$protocol}://{$host}/ccr/rss.php";
$image = new FeedImage();
$image->title = "CCR";
$image->url = "{$protocol}://{$host}/ccr/images/ccr-logo.png";
$image->link = $rss->link;
$image->description = "CRR Newest Packages Feed";
$rss->image = $image;

#Get the latest packages and add items for them
$dbh = db_connect();
$q = "SELECT * FROM Packages ";
$q.= "ORDER BY SubmittedTS DESC ";
$q.= "LIMIT 0 , 20";
$result = db_query($q, $dbh);

while ($row = mysql_fetch_assoc($result)) {
	$mod_int = intval($row["ModifiedTS"]);
	$sub_int = intval($row["SubmittedTS"]);
	
	$item = new FeedItem();
	if (($mod_int == 0) && ($sub_int != 0)) {
		$item->title = "[NEW] ".htmlentities($row["Name"]."-".$row["Version"]);
	} else {
		$item->title = htmlentities($row["Name"]."-".$row["Version"]);
	}
	$item->link = "{$protocol}://chakraos.org/ccr/packages.php?ID={$row["ID"]}";
	$item->description = htmlentities($row["Description"]);
	$item->date = intval($row["SubmittedTS"]);
	$item->source = "{$protocol}://{$host}/ccr/";
	$item->author = htmlentities(username_from_id($row["MaintainerUID"]));
	$rss->addItem($item);
}

#save it so that useCached() can find it
$rss->saveFeed("RSS2.0","/tmp/ccr-newestpkg.xml",true);

