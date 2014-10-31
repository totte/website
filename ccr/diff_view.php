<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/' . PATH_SEPARATOR . 'template/' . PATH_SEPARATOR . $GESHI_PATH);

include('aur.inc');
include('config.inc');
include_once('geshi.php'); 

if(end(explode(".",$_GET['d'])) == 'diff' || end(explode(".",$_GET['d'])) == 'patch') {
        $file = URL_DIR . "/". substr(urlencode(basename($_GET['p'])), 0, 2) . "/" . urlencode(basename($_GET['p']))."/".urlencode(basename($_GET['p']))."/".urlencode(basename($_GET['d']));  
} else {
	$file = '';
}

if (is_file($file)) {
	$text = file_get_contents($file);
} else {
	$text = "";
}

$language = 'diff';

html_header();  
?>

<div class='pgbox'>
	<div class='pgbuildbody'>
		<?php if ($text != "") { 
			$geshi = new GeSHi($text, $language); ?>
			<pre><?php echo $geshi->parse_code() ?></pre>
		<?php } else { ?> 
			<span class='f4'> <?php print __("Sorry, this file it's not a valid Diff patch") ?> </span> 
		<?php } ?>
	</div>
</div>

<?php 
html_footer(AUR_VERSION); 
?>
