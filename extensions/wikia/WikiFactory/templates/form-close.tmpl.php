<!-- s:<?= __FILE__ ?> -->
<script>
function close_allowToSave() {
	var result = true;
	var redirect = document.getElementById('flag_<?=WikiFactory::FLAG_REDIRECT?>');
	var redirect_txt = document.getElementById('redirect_url');
	if (redirect.checked) {
		if (redirect_txt.value == "") {
			alert("<?=wfMsg('closed-redirect-alert')?>");
			result = false;
		}
	}
	return result;
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
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_CREATE_DB_DUMP?>" value="<?=WikiFactory::FLAG_CREATE_DB_DUMP?>" checked="checked"> <?=wfMsg('closed-create-dump')?></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE?>" value="<?=WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE?>" checked="checked"> <?=wfMsg('closed-create-image-archive')?></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_DELETE_DB_IMAGES?>" value="<?=WikiFactory::FLAG_DELETE_DB_IMAGES?>" checked="checked"> <?=wfMsg('closed-delete-database-images')?></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_FREE_WIKI_URL?>" value="<?=WikiFactory::FLAG_FREE_WIKI_URL?>" checked="checked"> <?=wfMsg('closed-free-url')?></li>
			<li><input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_HIDE_DB_IMAGES?>" value="<?=WikiFactory::FLAG_HIDE_DB_IMAGES?>"> <?=wfMsg('closed-hide-dumps')?></li>
			<li>
				<input type="checkbox" name="close_flags[]" id="flag_<?=WikiFactory::FLAG_REDIRECT?>" value="<?=WikiFactory::FLAG_REDIRECT?>"> <?=wfMsg('closed-redirect-url')?>
				<input type="text" name="redirect_url" id="redirect_url" value="">
			</li>
		</ul>
		<ul style="list-style:none;padding:1px 10px;">
			<li style="text-align:left;padding-left:200px;">
				<input type="submit" name="close_saveBtn" value="<?=wfMsg('closed-confirm-btn')?>" onclick="return close_allowToSave();"> 
			</li>
		</ul>
	</div>	
</form>	
</div>
<!-- e:<?= __FILE__ ?> -->
