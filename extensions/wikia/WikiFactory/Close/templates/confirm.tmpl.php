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
	}
	return result;
}
</script>
<?=wfMsg('closewiki-check-and-confirm')?>
<div>
	<form action="<?php echo $title->getFullUrl( "step=2") ?>" method="post">
	<table class="filehistory" style="width: 100%">
	<tr>
		<th><?=wfMsg('allmessagesname')?></th>
		<th><?=wfMsg('wf_city_id')?></th>
		<th><?=wfMsg('wf_city_lang')?></th>
		<th><?=wfMsg('wf_city_created')?></th>
		<th><?=wfMsg('wf_city_founding_user')?></th>
	</tr>
<?php foreach( $wikis as $wiki ): ?>
	<tr>
		<td>
			<ul>
				<li style="list-style:none;">
					<strong><?php echo $wiki->city_title ?></strong>
				</li>
				<li style="list-style:none;">
					<a href="<?php echo $wiki->city_url ?>"><em><?php echo $wiki->city_url ?></em></a>
				</li>
			</ul>
			<input type="hidden" name="wikis[ ]" value="<?php echo $wiki->city_id ?>" />
		</td>
		<td>
			<?php echo $wiki->city_id ?>
		</td>
		<td>
			<?php echo $wiki->city_lang ?>
		</td>
		<td>
			<?php echo $wiki->city_created ?>
		</td>
		<td>
			<ul>
				<li style="list-style:none;">
					<?php echo ( isset($wiki->city_founding_user) ) 
						? User::newFromId($wiki->city_founding_user)->getName() 
						: wfMsg('closewiki-unknown') 
					?>
				</li>	
				<li style="list-style:none;">
					<?php echo $wiki->city_founding_email ?>
				</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td colspan='5'>
			<?php echo $wiki->city_description ?>
		</td>
	</tr>
<?php endforeach ?>
	</table>
	<br />
	<div style="padding:0px 10px;">
		<ul style="list-style:none;padding:1px 10px">
		<li>
			<?php $value = WikiFactory::FLAG_CREATE_DB_DUMP; $id = sprintf("%s_%s", "flag", $value); $checked = isset($flags[$value]) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="close_flags[]" id="<?=$id?>" value="<?=$value?>" <?=$checked?>> <?=wfMsg('closed-create-dump')?>
		</li>
		<li>
			<?php $value = WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE; $id = sprintf("%s_%s", "flag", $value); $checked = isset($flags[$value]) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="close_flags[]" id="<?=$id?>" value="<?=$value?>" <?=$checked?>> <?=wfMsg('closed-create-image-archive')?>
		</li>
		<li>
			<?php $value = WikiFactory::FLAG_DELETE_DB_IMAGES; $id = sprintf("%s_%s", "flag", $value); $checked = isset($flags[$value]) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="close_flags[]" id="<?=$id?>" value="<?=$value?>" <?=$checked?>> <?=wfMsg('closed-delete-database-images')?>
		</li>
		<li>
			<?php $value = WikiFactory::FLAG_FREE_WIKI_URL; $id = sprintf("%s_%s", "flag", $value); $checked = isset($flags[$value]) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="close_flags[]" id="<?=$id?>" value="<?=$value?>" <?=$checked?>> <?=wfMsg('closed-free-url')?>
		</li>
		<li>
			<?php $value = WikiFactory::FLAG_HIDE_DB_IMAGES; $id = sprintf("%s_%s", "flag", $value); $checked = isset($flags[$value]) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="close_flags[]" id="<?=$id?>" value="<?=$value?>" <?=$checked?>> <?=wfMsg('closed-hide-dumps')?>
		</li>
		<li>
			<?php $value = WikiFactory::FLAG_REDIRECT; $id = sprintf("%s_%s", "flag", $value); $checked = isset($flags[$value]) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="close_flags[]" id="<?=$id?>" value="<?=$value?>" <?=$checked?>> <?=wfMsg('closed-redirect-url')?>
			<input type="text" name="redirect_url" id="redirect_url" value="<?=$redirect?>"> <i>ex: foo.wikia.com</i>
		</li>
		</ul>
		<ul style="list-style:none;padding:1px 10px">
			<li>
				<?=wfMsg('closed-reason')?>
				<textarea name="close_reason"><?=$reason?></textarea>
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
