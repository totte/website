<?php

$pkgid = intval($_REQUEST['ID']);
if ($uid == $row["MaintainerUID"] or
	($atype == "Developer" or $atype == "Trusted User")) {

	$catarr = pkgCategories();
	$edit_cat = "<form method='post' action='packages.php?ID=".$pkgid."'>\n";
	$edit_cat.= "<input type='hidden' name='action' value='do_ChangeCategory' />";
	$edit_cat.= "<span class='f9'>".__("Category").":</span> ";
	$edit_cat.= "<select name='category_id'>\n";
	foreach ($catarr as $cid => $catname) {
		$edit_cat.= "<option value='$cid'";
		if ($cid == $row["CategoryID"]) {
		    $edit_cat.=" selected='selected'";
		}
		$edit_cat.=">".$catname."</option>";
	}
	$edit_cat.= "</select>&nbsp;<input class='button' type='submit' value='".__("change category")."' />";
	$edit_cat.= "</form><br />";

}
else {
	$edit_cat = "<br /><br /><span class='f9'>".__("Category").": " . $row['Category'] . "</span><br /><br />";
}

$submitter = "None";
if ($row["SubmitterUID"]) {
	$submitter = username_from_id($row['SubmitterUID']);
	if ($SID) {
		$submitter = '<a href="account.php?Action=AccountInfo&ID=' . urlencode($row['SubmitterUID']) . '">' . htmlentities($submitter) . '</a>';
	}
}

$maintainer = "None";
if ($row["MaintainerUID"]) {
	$maintainer = username_from_id($row['MaintainerUID']);
	if ($SID) {
		$maintainer = '<a href="account.php?Action=AccountInfo&ID=' . urlencode($row['MaintainerUID']) . '">' . htmlentities($maintainer) . '</a>';
	}
}


$votes = __("Votes") . ': ' . $row['NumVotes'];
if ($atype == "Developer" or $atype == "Trusted User") {
	$votes = "<a href=\"voters.php?ID=$pkgid\">$votes</a>";
}

# In case of wanting to put a custom message
$license = empty($row['License']) ? __("unknown") : $row['License'];

# Print the timestamps for last updates
$updated_time = ($row["ModifiedTS"] == 0) ? __("unknown") : gmdate("Y/m/d - H:i:s O", intval($row["ModifiedTS"]));
$submitted_time = ($row["SubmittedTS"] == 0) ? __("unknown") : gmdate("Y/m/d - H:i:s O", intval($row["SubmittedTS"]));

?>
<div class="pgbox">
	<div class="pgboxtitle"><span class="f3"><?php echo __("Package Details") ?></span></div>
	<div class="pgboxbody">

	<p>
	<span class='f2'><?php echo htmlentities($row['Name']) . ' ' . htmlentities(parse_pkgver_output($row['Version'])); ?></span><br />
<?php
	$escaped_url = htmlentities($row['URL']);
	if (url_good($row['URL'])) {
		echo "<span class=\"f9\"><a href=\"{$row['URL']}\">{$escaped_url}</a></span><br />";
	} else {
		echo "<span class=\"f9\">{$escaped_url}</span><br />";
	}

	if (url_good($row['Screenshot'])) {
		echo "<a href=\"{$row['Screenshot']}\"><img class=\"screenshot\" src=\"{$row['Screenshot']}\"></a>";
	}
?>
	<span class='f9'><?php echo stripslashes(htmlentities($row['Description'])); ?></span>
	<span class='f9'><?php echo $edit_cat ?></span>
	<span class='f9'><?php echo __("Submitter") .': ' . $submitter ?></span><br />
	<span class='f9'><?php echo __("Maintainer") .': ' . $maintainer ?></span><br />
	<span class='f9'><?php echo $votes ?></span>
	</p>
	<p><span class='f9'><?php echo __("License") . ': ' . htmlentities($license); ?></span></p>

	<p>
	<span class='f9'>
	<?php echo __("Last Updated") . ': ' . $updated_time ?><br />
	<?php echo __("First Submitted") . ': '. $submitted_time ?>
	</span>
	</p>
	<p><span class='f9'>
<?php
		$urlpath = URL_DIR . substr($row['Name'], 0, 2) . "/" . $row['Name'] . "/" . $row['Name'];
		print "<a href=\"{$urlpath}.tar.gz\">" . __("Tarball") . "</a> :: " . ((USE_GESHI) ? ("<a href='pkgbuild_view.php?p=" . urlencode($row['Name'])) : "<a href=\"{$urlpath}/PKGBUILD\"") . "'>" . "PKGBUILD" . "</a></span>";

		if ($row["OutOfDate"] == 1) {
			echo "<br /><span class='f6'><img src='images/flag-red.png' align='center'/> ".__("This package has been flagged out of date.")."</span>";
		}
?>
	</p>
<?php

	$deps = package_dependencies($row["ID"]);
	$requiredby = package_required($row["Name"]);

	if (count($deps) > 0 || count($requiredby) > 0) {
		echo '<p><pre><span class="f7">';
	}

	if (count($deps) > 0) {

		echo "<span class='f2'>". __("Dependencies")."</span>";

		while (list($k, $darr) = each($deps)) {
                        IF ($darr[0]=="[@]") {
				break;
			}
			# darr: (DepName, DepCondition, PackageID), where ID is NULL if it didn't exist
			if (!is_null($darr[2])) {
				echo "<a href=\"packages.php?ID=" . urlencode($darr[2]) . "\">" . $darr[0] . htmlentities($darr[1]) . "</a>";
			}
			else {
			      $noversion = explode ("<",$darr[0],2);
			      echo "<a href='chakraos.org/packages/index.php?act=search&subdir=&sortby=date&order=descending&searchpattern=^" . urlencode($noversion[0]) . "-[0-9]'>" . $darr[0] . htmlentities($darr[1]) . "</a>";
			}
		}

		if (count($requiredby) > 0) {
			echo '<br />';
		}
	}

	if (count($requiredby) > 0) {

		echo "<br /><span class='f2'>". __("Required by")."</span>";

		while (list($k, $darr) = each($requiredby)) {
			# darr: (PackageName, PackageID)
			echo " <a href='packages.php?ID=".$darr[1]."'>".$darr[0]."</a>";
		}

	}

	if (count($deps) > 0 || count($requiredby) > 0) {
		echo '</span></pre></p>';
	}

	# $sources[0] = 'src';
	$sources = package_sources($row["ID"]);

	if (count($sources) > 0) {

?>
	<div class='boxSoftTitle'><span class='f3'><?php echo __("Sources") ?></span></div>
	<br />
	<div>
<?php
		$wrongsource = false;
		while (list($k, $src) = each($sources)) {
			$src = explode('::', $src);
			$src = parse_pkgver_output($src);
			$parsed_url = parse_url($src[0]);
			if (isset($parsed_url['scheme']) || isset($src[1])) {
				## It is an external source
				#if(RemoteFileExists($src[0])) {
					printf("<a href=\"%s\">%s</a><br />\n",
						(isset($src[1]) ? $src[1] : $src[0]),
						htmlentities($src[0]));
				#}
				#else {
				#	$wrongsource = true;
				#}
			}
			else {
				$src = $src[0];
				# It is presumably an internal source, check if the file exist
				 if (file_exists($urlpath."/$src")) {
					$source_ext = end(explode(".",$src));
					if (($source_ext == "diff" || $source_ext == "patch") && USE_GESHI) {
						printf("<a href=\"diff_view.php?p=%s&d=%s\">%s</a><br />\n",
							urlencode($row['Name']),
							urlencode($src),
							htmlentities($src));
					}
					else {
						printf("<a href=\"%s/%s\">%s</a><br />\n",
							htmlspecialchars($urlpath),
							htmlspecialchars($src),
							htmlentities($src));
					}
				}
				else {
					$wrongsource = true;
				}
			}
		}
		if ($wrongsource) {
?>			<br />
			<span class='f9'>
			<?php echo __("Please look the") . " " . ((USE_GESHI) ? ("<a href='pkgbuild_view.php?p=" . urlencode($row['Name'])) : ("<a href='" . urlencode($urlpath) . "/PKGBUILD")) . "'>" . __("PKGBUILD") . "</a> " . __("for more details about the source code");
?>			</span>
<?php		}
?>
	</div>

<?php
	}
?>
	</div>

</div>
