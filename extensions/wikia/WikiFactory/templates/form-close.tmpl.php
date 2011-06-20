<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
function close_allowToSave() {
	var result = true;
	var redirect = document.getElementById('flag_<?=WikiFactory::FLAG_REDIRECT?>');
	var redirect_txt = document.getElementById('redirect_url');
	if (redirect.checked) {
		if (redirect_txt.value == "") {
			alert("<?=wfMsg('closed-redirect-alert')?>");
			result = false;
		}
		$('#flag_<?=WikiFactory::FLAG_FREE_WIKI_URL?>').attr('checked', true);
	}
	return result;
}
function checkFlag(id) {
	var field = document.getElementById(id);
	var flags = new Array('<?=WikiFactory::FLAG_DELETE_DB_IMAGES?>', '<?=WikiFactory::FLAG_FREE_WIKI_URL?>');
	for (i = 0; i < flags.length; i++) {
		if ( id != 'flag_' + flags[i]) document.getElementById('flag_' + flags[i]).checked = field.checked;
	}
}
</script>
<h2>
    <?=wfMsg('closewiki')?>
</h2>
<div id="wiki-factory-close">
<?php
	if( !is_null( $info ) ):
		echo $info;
	endif;
?>
<form id="wk-wf-variables-select" action="<?php echo Title::makeTitle( NS_SPECIAL, "CloseWiki" )->getFullURL(); ?>" method="POST">
<input type="hidden" name="wikis[ ]" value="<?php echo $wiki->city_id ?>" />
<input type="hidden" name="step" value="1" />
	<div style="padding:0px 10px;">
		<ul style="list-style:none;padding:1px 10px">
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_CREATE_DB_DUMP?>" value="<?=WikiFactory::FLAG_CREATE_DB_DUMP?>" checked="checked" /><label for="flag_<?=WikiFactory::FLAG_CREATE_DB_DUMP?>"> <?=wfMsg('closed-create-dump')?> </label></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE?>" value="<?=WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE?>" checked="checked" /><label for="flag_<?=WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE?>"> <?=wfMsg('closed-create-image-archive')?> </label></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_DELETE_DB_IMAGES?>" onchange="checkFlag(this.id)" value="<?=WikiFactory::FLAG_DELETE_DB_IMAGES?>" checked="checked" /><label for="flag_<?=WikiFactory::FLAG_DELETE_DB_IMAGES?>"> <?=wfMsg('closed-delete-database-images')?> </label></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_FREE_WIKI_URL?>" onchange="checkFlag(this.id)" value="<?=WikiFactory::FLAG_FREE_WIKI_URL?>" checked="checked" /><label for="flag_<?=WikiFactory::FLAG_FREE_WIKI_URL?>"> <?=wfMsg('closed-free-url')?> </label></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_HIDE_DB_IMAGES?>" value="<?=WikiFactory::FLAG_HIDE_DB_IMAGES?>" /><label for="flag_<?=WikiFactory::FLAG_HIDE_DB_IMAGES?>"> <?=wfMsg('closed-hide-dumps')?> </label></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_REDIRECT?>" value="<?=WikiFactory::FLAG_REDIRECT?>" /><label for="flag_<?=WikiFactory::FLAG_REDIRECT?>"> <?=wfMsg('closed-redirect-url')?> </label>
				<input type="text" name="redirect_url" id="redirect_url" value="" /> <i>ex: foo.wikia.com</i>
			</li>
		</ul>
		<ul style="list-style:none;padding:1px 10px;">
			<li>
				<?=wfMsg('closed-reason')?>
				<textarea name="close_reason"></textarea>
			</li>
		</ul>
		<ul style="list-style:none;padding:1px 10px;">
			<li style="text-align:left;padding-left:200px;">
				<input type="submit" name="close_saveBtn" value="<?=wfMsg('closed-confirm-btn')?>" onclick="return close_allowToSave();" /> 
			</li>
		</ul>
	</div>	
</form>	
</div>
<!-- e:<?= __FILE__ ?> -->
