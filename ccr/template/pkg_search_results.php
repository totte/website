<?php if (!$result) { ?>
<div class="pgbox">
      <div class='pgboxbody'><?php print __("Error retrieving package list.") ?></div>
<?php } elseif ($total == 0) { ?>
<div class="pgbox">
<div class='pgboxbody'><?php print __("No packages matched your search criteria."); ?>
<br><br><a href="chakraos.org/packages/index.php?act=search&subdir=&sortby=date&order=descending&searchpattern=<?php print urlencode($_GET['K']); ?>"><?php print __("Search for results in the main repository"); ?></a>
</div>
</div>
<?php } elseif ($total == 1) {
		$pkgdetails = mysql_fetch_assoc($result);
		$_REQUEST['ID'] = $pkgdetails['ID'];
		package_details($pkgdetails['ID'],$_COOKIE["AURSID"]); ?>

<?php } else { ?>
	<form action='packages.php?<?php echo htmlentities($_SERVER['QUERY_STRING']) ?>' method='post'>
	<div class="pgbox">
	<div class="pgboxtitle">
		<span class='f3'><?php print __("Package Listing") ?></span>
	</div>

	<table width='100%' cellspacing='0' cellpadding='2'>
	<tr>
	<?php if ($SID): ?>
	<th>&nbsp;</th>
	<?php endif; ?>
	<th style='width: 25%; border-bottom: #666 1px solid; text-align: center;'>
		<span class="f5"><a href='?<?php print mkurl('SB=n&SO=' . $SO_next) ?>'>
		<img src="images/package.png" alt="<?php print __(" Name ")?>" title="<?php print __(" Name ")?>" align="top">
		<? print __("Name") ?></a></span>
	</th>
	<th style='border-bottom: #666 1px solid; text-align: center;'>
		<a href='?<?php print mkurl('SB=c&SO=' . $SO_next) ?>'>
		<img src="images/category.png" alt="<?php print __("Category")?>" title="<?php print __("Category")?>" align="top"></a>
	</th>
	<th style='border-bottom: #666 1px solid; text-align: center; padding-left: 10px; padding-right: 10px;'>
		<a href='?<?php print mkurl('SB=v&SO=' . $SO_next) ?>'>
		<img src="images/votes.png" alt="<?php print __(" Votes ")?>" title="<?php print __(" Votes ")?>" align="top"></a>
	</th>

	<?php if ($SID): ?>
	<th style='border-bottom: #666 1px solid; text-align: center; padding-left: 10px; padding-right: 10px;'>
		<a href='?<?php print mkurl('SB=w&SO=' . $SO_next) ?>'>
		<img src="images/voted.png" alt="<?php print __("Voted")?>" title="<?php print __("Voted")?>" align="top"></a>
	</th>
	<th style='border-bottom: #666 1px solid; text-align: center; padding-left: 10px; padding-right: 10px;'>
		<a href='?<?php print mkurl('SB=o&SO=' . $SO_next) ?>'>
		<img src="images/notify.png" alt="<?php print __("Notify")?>" title="<?php print __("Notify")?>" align="top"></a>
	<?php endif; ?>
	<th style='border-bottom: #666 1px solid; text-align: center;'>
		<span class="f5" class="blue">
		<img src="images/description.png" alt="<?php print __("Description")?>" title="<?php print __("Description")?>" align="top">
		<? print __("Description") ?></span>
	</th>
	<th style='border-bottom: #666 1px solid; text-align: center;'>
		<a href='?<?php print mkurl('SB=m&SO=' . $SO_next) ?>'>
		<img src="images/maintainer.png" alt="<?php print __("Maintainer")?>" title="<?php print __("Maintainer")?>" align="top"></a>
	</th>
	</tr>

<?php	if (isset($_COOKIE['AURSID'])) {
		$atype = account_from_sid($_COOKIE['AURSID']);
	} else {
		$atype = "";
	}
	for ($i = 0; $row = mysql_fetch_assoc($result); $i++) {
		(($i % 2) == 0) ? $c = "data1" : $c = "data2";
		if ($row["OutOfDate"]): $c = "outofdate"; endif;
?>		<tr>
		<?php if ($SID): ?>
		<td class='<?php print $c ?>'><input type='checkbox' name='IDs[<?php print $row["ID"] ?>]' value='1'></td>
		<?php endif; ?>
		<td class='<?php print $c ?>'><span class='f4'><a href='packages.php?ID=<?php print $row["ID"] ?>'><span class='black'><?php print htmlspecialchars($row["Name"]) ?> <?php print parse_pkgver_output(htmlspecialchars($row["Version"])) ?></span></a></span></td>
		<td class='<?php print $c ?>'><span class='f5'><span class='blue'><?php print $row["Category"] ?></span></span></td>
		<td class='<?php print $c ?>' style="text-align: center;"><span class='f5'><span class='blue'><?php print $row["NumVotes"] ?></span></span></td>
		<?php if ($SID): ?>
		<td class='<?php print $c ?>' style="text-align: center;"><span class='f5'><span class='blue'>
		<?php if (isset($row["Voted"])): ?>
		<?php print __("Yes") ?></span></td>
		<?php else: ?>
		</span></td>
		<?php endif; ?>
		<td class='<?php print $c ?>' style="text-align: center;"><span class='f5'><span class='blue'>
		<?php if (isset($row["Notify"])): ?>
		<?php print __("Yes") ?></span></td>
		<?php else: ?>
		</span></td>
		<?php endif; ?>
		<?php endif; ?>
		<td class='<?php print $c ?>'><span class='f4'><span dir="ltr" class='blue'>
		<?php print stripslashes(htmlspecialchars($row['Description'], ENT_QUOTES)); ?></span></span></td>
		<td class='<?php print $c ?>'><span class='f5'><span class='blue'>
		<?php if (isset($row["Maintainer"])): ?>
		<a href='packages.php?K=<?php print $row['Maintainer'] ?>&amp;SeB=m'><?php print $row['Maintainer'] ?></a>
		<?php else: ?>
		<span style='color: #dddd; font-style: italic;'><?php print __("orphan") ?></span>
		<?php endif; ?>
		</span></span></td>
		</tr>
<?php 	} ?>
	</table>
	</div>


	<div class="pgbox">
		<table width='100%'>
		<tr>
		<td>
		<div>
		<span class='f8'><img src="images/info.png" align="top">
		<span class="outdatedlegend"><?php print __("Out of Date") ?></span>
		</span>
		<br /><br />
	</div>
<?php 	if ($SID) {
?>	<div>
		<select name='action'>
			<option><?php print __("Actions") ?></option>
			<option value='do_Flag'><?php print __("Flag Out-of-date") ?></option>
			<option value='do_UnFlag'><?php print __("Unflag Out-of-date") ?></option>
			<option value='do_Adopt'><?php print __("Adopt Packages") ?></option>
			<option value='do_Disown'><?php print __("Disown Packages") ?></option>
			<?php if ($atype == "Trusted User" || $atype == "Developer"): ?>
			<option value='do_Delete'><?php print __("Delete Packages") ?></option>
			<?php endif; ?>
			<option value='do_Notify'><?php print __("Notify") ?></option>
			<option value='do_UnNotify'><?php print __("UnNotify") ?></option>
		</select>
<?php 		if ($atype == "Trusted User" || $atype == "Developer") {
?>			<input type='checkbox' name='confirm_Delete' value='1' /> <?php print __("Confirm") ?>
<?php 		}
?>		<input type='submit' class='button' style='width: 40px' value='<?php print __("Go") ?>' />
	</div>
<?php   }
?>	</td>
	<td class='show_results_footer'>
  		<span class='blue'><?php print __("Showing results %s - %s of %s", $first, $last, $total) ?></span>
		<br />
			<div id="pages">
<?php			if ($_GET['O'] > 0) {
				$O = $_GET['O'] - $_GET['PP'];
				if ($_GET['O'] < $_GET['PP']) {
					$O = 0;
				}
?>				<a href="packages.php?<?php print mkurl("O=0") ?>"><img src="images/arrow-left-double.png" alt="<<" align="top"></a>
				<a href="packages.php?<?php print mkurl("O=$O") ?>"><img src="images/arrow-left.png" alt="<" align="top"></a>
<?php   		}

			if ($_GET['PP'] > 0) {
				$pages = ceil($total / $_GET['PP']);
			}

			if ($pages > 1) {

				if ($_GET['O'] > 0) {
					$currentpage = ceil(($_GET['O'] + 1) / $_GET['PP']);
				}
				else {
					$currentpage = 1;
				}

				$morepages = $currentpage + 5;
				print (($currentpage-5) > 1) ? '...' : '';

				# Display links for more search results.
				for ($i = ($currentpage - 5); $i <= $morepages && $i <= $pages; $i++) {
					if ($i < 1) {
						$i = 1;
					}

					$pagestart = ($i - 1) * $_GET['PP'];
					if ($i <> $currentpage) {
?>						<a class="page_num" href="packages.php?<?php print mkurl('O=' . ($pagestart)) ?>"><?php echo $i ?></a>
<?php				 	}
					else {
						echo "<span id=\"page_sel\">$i</span>";
					}
				}

				print ($pages > $morepages) ? '...' : '';

				if ($total - $_GET['PP'] - $_GET['O'] > 0) {
?>					<a href='packages.php?<?php print mkurl('O=' . ($_GET['O'] + $_GET['PP'])) ?>'>
					<img src="images/arrow-right.png" alt=">" align="top"></a>
					<a href='packages.php?<?php print mkurl('O=' . ($total - $_GET['PP'])) ?>'>
					<img src="images/arrow-right-double.png" alt=">>" align="top"></a>
<?php 				}
			}
?>			</div>
	</td>
	</tr>
	</table>
	</form>
	</div>
<?php	}
?>


