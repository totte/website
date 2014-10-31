<?php

$folder = "unsupported-temp/41361143001";

function find_pkgbuild($keyword, $folder) {
	global $found;
	if($handle = opendir($folder)) {
		while(($file = readdir($handle)) !== false) {
			if($file == $keyword) {
				$found[] = $folder ."/".$file;
			} elseif(is_dir($folder.'/'.$file) && $file != '.' && $file != '..') {
				find_pkgbuild($keyword,$folder.'/'.$file);
			} 
		}
		closedir($handle);
	}
}

$found = array();
find_pkgbuild("PKGBUILD", $folder);
echo "found: " . $found[0];
unset($found);
?>
