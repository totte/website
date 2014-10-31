<?php
include_once('lib/aur.inc');
include_once('lib/config.inc');

set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/' . PATH_SEPARATOR . 'template/' . PATH_SEPARATOR . $GESHI_PATH);

include_once('geshi.php');

$prefix = urlencode(substr(basename($_GET['p']), 0, 2));
$package = urlencode(basename($_GET['p']));
$file = URL_DIR . "/{$prefix}/{$package}/{$package}/PKGBUILD";

$text = "";
if (is_file($file)) {
	$text = file_get_contents($file);
}

$language = 'bash';

html_header(); 
?>

<div class='pgbox'>
	<div class='pgbuildbody'>
		<?php if ($text != "") {
			$geshi = new GeSHi($text, $language);
			# $geshi->set_header_type(GESHI_HEADER_PRE); ?>
			<pre><?php echo $geshi->parse_code() ?></pre>
		<?php } else { ?> 
			<span class='f4'> <?php print __("Sorry, this file it's not a valid PKGBUILD") ?> </span> 
		<?php } ?>
	</div>
</div>

<?php 
html_footer(AUR_VERSION);
?>
