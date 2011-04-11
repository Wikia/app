<?php echo $cat_select; ?>
<form method="post" id="PLBCopyLayout" >
	<ul>
		<?php foreach($selected_cats as $key => $value): ?>
			<li >
				<input type="hidden" name="cat_ids[]" value="<?php echo $key; ?>"/> <span><?php echo $value; ?></span> <a href="#" ><?php echo wfMsg("plb-copy-delete-link"); ?></a>
			</li>		
		<?php endforeach; ?>
	</ul>
	<div id="confirm" style="display:none" ><?php echo wfMsg('plb-copy-confirm'); ?></div>
	<button name="addCategory" id="addCategory" ><?php echo wfMsg("plb-copy-submit-link"); ?></button>
</form>

<ul>
	<li id="emptyElement" style="display:none" >
		<input type="hidden" name="cat_ids[]" value=""/> <span></span> <a  href="#" ><?php echo wfMsg("plb-copy-delete-link"); ?></a>
	</li>
</ul>