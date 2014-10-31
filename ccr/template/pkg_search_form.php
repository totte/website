<?php include_once('pkgfuncs.inc');

// Sanitize variables
if (!isset($_GET['C'])) $_GET['C'] = "";
if (!isset($_REQUEST['K'])) $_REQUEST['K'] = "";
if (!isset($_REQUEST['SeB'])) $_REQUEST['SeB'] = "";
if (!isset($_REQUEST['SB'])) $_REQUEST['SB'] = "";
if (!isset($_REQUEST['SO'])) $_REQUEST['SO'] = "";
if (!isset($_REQUEST['PP'])) $_REQUEST['PP'] = "";

?>

<div class='pgbox'>
<form action='packages.php' method='get'>
<div class='pgboxtitle'>
	<span class='f3'><?php print __("Search"); ?></span>
	<input type='hidden' name='O' value='0' />
	<input type='text' name='K' size='30' value="<?php print stripslashes(trim(htmlspecialchars($_REQUEST["K"], ENT_QUOTES))); ?>" maxlength='35' />
	<input type='submit' class='button' name='do_Search' value=' <?php print __("Go"); ?> ' />
	<?php if (!empty($_GET['detail'])): ?>
	<input type='submit'  class='button' name='do_Orphans' value='<?php print __("Orphans"); ?>' />
	<?php endif; ?>
	
	<a href="?<?php print mkurl('detail=' . ((!empty($_GET['detail'])) ? 0 : 1) ) ?>"><?php (!empty($_GET['detail']) ? printf('<img src="images/less.png" alt="-" align="center" width="14" height="14">') : printf('<img src="images/more.png" alt="+" align="center" padding="2px" width="14" height="14">')); print ('  '); print __("Advanced"); ?></a>
</div>

			<?php if (!empty($_GET['detail'])): ?>
			<div id="advanced-search">
				<input type="hidden" name="detail" value="1" />
				<br />
					<li>
						<label><?php print __("Category"); ?></label>
						<select name='C'>
							<option value='0'><?php print __("Any"); ?></option>
							<?php
							foreach (pkgCategories() as $id => $cat):
								if (intval($_GET["C"]) == $id):
							?>
							<option value="<?php print $id ?>" selected="selected"><?php print $cat; ?></option>
							<?php else: ?>
							<option value="<?php print $id ?>"><?php print $cat; ?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</li>
					<li>
					<label><?php print __("Search by"); ?></label>
						<select name='SeB'>
							<?php
							$searchby = array('nd' => __("Name, Description"), 'n' => __("Name Only"), 'm'  => __("Maintainer"), 's'  => __("Submitter"));
							foreach ($searchby as $k => $v):
								if ($_REQUEST['SeB'] == $k):
							?>
							<option value="<?php print $k; ?>" selected="selected"><?php print $v; ?></option>
							<?php else: ?>
							<option value="<?php print $k; ?>"><?php print $v; ?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</li>
					<li>
						<label><?php print __("Sort by"); ?></label>
						<select name='SB'>
							<?php
							$sortby = array('n' => __("Name"), 'c' => __("Category"), 'v' => __("Votes"), 'w' => __("Voted"), 'o' => __("Notify"), 'm' => __("Maintainer"), 'a' => __("Age"));
							foreach ($sortby as $k => $v):
								if ($_REQUEST['SB'] == $k):
							?>
							<option value='<?php print $k; ?>' selected="selected"><?php print $v; ?></option>
							<?php else: ?>
							<option value='<?php print $k; ?>'><?php print $v; ?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</li>
					<li>
						<label><?php print __("Sort order"); ?></label>
						<select name='SO'>
							<?php
							$orderby = array('a' => __("Ascending"), 'd' => __("Descending"));
							foreach ($orderby as $k => $v):
								if ($_REQUEST['SO'] == $k):
							?>
							<option value='<?php print $k; ?>' selected="selected"><?php print $v; ?></option>
							<?php else: ?>
							<option value='<?php print $k; ?>'><?php print $v; ?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</li>
					<br /><br />
					<li>
						<label><?php print __("Per page"); ?></label>
						<select name='PP'>
							<?php
							$pages = array(25, 50, 75, 100);
							foreach ($pages as $i):
								if ($_REQUEST['PP'] == $i):
							?>
							<option value="<?php print $i; ?>" selected="selected"><?php print $i; ?></option>
							<?php else: ?>
							<option value="<?php print $i; ?>"><?php print $i; ?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</li>
					<li>
						<label><?php echo __("Out of Date"); ?></label>
						<?php if (isset($_GET['outdated'])): ?>
							<input type="checkbox" name="outdated" checked />
						<?php else: ?>
							<input type="checkbox" name="outdated" />
						<?php endif; ?>
					<br />
					</li>
				</ul>
				<br/>
			</div>
			<?php endif; ?>
</form>
</div>
