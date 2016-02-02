<div class="pgbox">
<?php

$uid = uid_from_sid($SID);
while (list($indx, $carr) = each($comments)) { ?>
	<div class="comment-header"><?php
		if ($SID) {
			$carr['UserName'] = "<a href=\"account.php?Action=AccountInfo&amp;ID={$carr['UsersID']}\">{$carr['UserName']}</a>";
		}

		$commentHeader = '<p style="display:inline;">' . __('Comment by: %s on %s', $carr['UserName'], gmdate('r', $carr['CommentTS'])) . '</p>';

		if (canDeleteCommentArray($carr, $atype, $uid)) {
			$durl = '<form method="post" action="packages.php?ID='.$row['ID'].'">';
			$durl.= '<fieldset style="display:inline; border:none;">';
			$durl.= '<input type="hidden" name="action" value="do_DeleteComment" />';
			$durl.= '<input type="hidden" name="comment_id" value="'.$carr['ID'].'" />';
			$durl.= '<input type="image" src="images/x.png" ';
			$durl.= ' alt="'.__("Delete comment").'" name="submit" value="1" ';
			$durl.= ' />&nbsp;';
			$durl.= '</fieldset>';
			$commentHeader = $durl.$commentHeader."</form>";
		}
		echo $commentHeader; ?>
	</div>
	<blockquote class="comment-body">
	<br />
	<?php
		$parsecode=ccr_htmlspecialchars($carr['Comments']);
		// make links clickable
		$parsecode=do_clickable($parsecode);
		// add smilies
		$parsecode=do_smilies($parsecode);
		?>
		<pre><?php echo stripslashes($parsecode) ?></pre>
	</blockquote>
<?php } ?>
</div>

<?php
$count = package_comments_count($_GET['ID']);
if ($count > 10 && !isset($_GET['comments'])) {
?> 	<div class="pgbox">
		<div class="show_results">
			<?php echo '<a href="'. $_SERVER['REQUEST_URI'] . '&comments=all">'. __("Show all %s comments", $count) . '</a>'; ?>
		</div>
	</div>
<?php } ?>
