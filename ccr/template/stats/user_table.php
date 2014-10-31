<?php
 $username = username_from_sid($_COOKIE["AURSID"]); 
?>
<table class='boxSoft'>
<tr>
<th colspan='2' class='boxSoftTitle'>
<span class='f3'><?php print __("My Statistics"); ?></span>
</th>
</tr>
<tr>
<td class='boxSoft'>
<?php if ($maintainer_unsupported_count > 0) { ?>
	<span class='f4'><a href="packages.php?SeB=m&amp;L=2&amp;K=<?php echo $username; ?>">
	<?php print __("Packages in CCR"); ?></a></span>
<?php } else {
	?><span class='f4'><?php print __("Packages in CCR"); ?></span>
<?php } ?>

</td>
<td class='boxSoft'>
<span class='f4'><?php print $maintainer_unsupported_count; ?></span>
</td>
</tr>
<tr>
<td class='boxSoft'>
<?php if ($flagged_outdated > 0) { ?>
	<span class='f4'><a href="packages.php?SeB=m&amp;outdated&amp;K=<?php echo $username; ?>">
	<?php print __("Out of Date"); ?></a></span>
<?php } else {
	?><span class='f4'><?php print __("Out of Date"); ?></span>
<?php } ?>

</td>
<td class='boxSoft'>
<span class='f4'>
<?php echo $flagged_outdated ?></span>
</td>
</tr>
</table>

