<table class="boxSoft">
<tr>
<th colspan="2" class="boxSoftTitle">
<a href="rss.php"><img src="images/feed-icon-14x14.png" alt="RSS Feed" /></a>
<span class="f3"><?php print __("Recent Updates") ?></span>
</th>
</tr>

<?php foreach ($newest_packages->getIterator() as $row): ?>
<tr>
<td class="boxSoft">
<span class="f4"><span class="blue">
<a href="packages.php?ID=<?php print intval($row["ID"]); ?>">
<?php print htmlentities($row["Name"]) . ' ' . htmlentities(parse_pkgver_output($row["Version"])); ?>
</a></span></span>
</td>
<td class="boxSoft">

<?php
$mod_int = intval($row["ModifiedTS"]);
$sub_int = intval($row["SubmittedTS"]);

if ($mod_int != 0):
  $modstring = gmdate("Y/m/d - H:i:s O", $mod_int);
elseif ($sub_int != 0):
  $modstring = '<img src="images/new.png" align="center" alt="'. __("New!").'" /> ' . gmdate("Y/m/d - H:i:s O", $sub_int);
else:
  $modstring = '(unknown)';
endif;
?>

<span class="f4"><?php print $modstring; ?></span>
</td>
</tr>

<?php endforeach; ?>

</table>

