<input id="ImageUploadExtraId" type="hidden" value="<?= urlencode($extraId) ?>" />
<?php
$file_mwname = new FakeLocalFile(Title::newFromText($mwname, 6), RepoGroup::singleton()->getLocalRepo());
$file_name = new LocalFile(Title::newFromText($name, 6), RepoGroup::singleton()->getLocalRepo());
echo wfMsg('wmu-conflict-inf', $file_name->getName());
?>
<table cellspacing="0" id="ImageUploadConflictTable">
	<tr>
		<td style="border-right: 1px solid #CCC;">
			<h2><?= wfMsg('wmu-rename') ?></h2>
			<div style="margin: 5px 0;">
				<input type="text" id="ImageUploadRenameName" value="<?= $file_name->getName() ?>" />
				<input type="button" value="<?= wfMsg('wmu-insert') ?>" onclick="WMU_insertImage(event, 'rename');" />
			</div>
		</td>
		<td>
			<h2><?= wfMsg('wmu-existing') ?></h2>
			<div style="margin: 5px 0;">
				<input type="button" value="<?= wfMsg('wmu-insert') ?>" onclick="WMU_insertImage(event, 'existing');" />
			</div>
		</td>
	</tr>
	<tr id="ImageUploadCompare">
		<td style="border-right: 1px solid #CCC;">
			<?= $file_mwname->getThumbnail(265, 205)->toHtml() ?>
		</td>
		<td>
			<input type="hidden" id="ImageUploadExistingName" value="<?= $file_name->getName() ?>" />
			<?= $file_name->getThumbnail(265, 205)->toHtml() ?>
		</td>
	</tr>
</table>
<div style="text-align: center;"><a onclick="WMU_insertImage(event, 'overwrite');" href="#"><?= wfMsg('wmu-overwrite') ?></a></div>
