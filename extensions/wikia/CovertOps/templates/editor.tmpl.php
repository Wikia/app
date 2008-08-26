<!-- s:<?= __FILE__ ?> -->
<div id="PanePreview"<?= empty($formData['messagePreview']) ? ' style="display:none"' : '' ?>>
	<fieldset>
	<legend><?= wfMsg('cops-label-preview') ?></legend>
		<div id="WikiTextPreview">
			<?= empty($formData['messagePreview']) ? '' : $formData['messagePreview'] ?>
		</div>
	</fieldset>
</div>

<div id="PaneCompose">
		<div id="PaneError"><?= isset($formData['errMsg']) ? Wikia::errormsg($formData['errMsg']) : '' ?></div>
		<form method="post" id="msgForm" action="<?= $title->getLocalUrl() ?>">
			<fieldset>
				<legend><?= wfMsg('cops-label-content') ?></legend>
				<input type="hidden" name="mTitle" value="<?= $formData['mTitle'] ?>" />
				<textarea name="mContent" id="mContent" cols="30" rows="10"><?= empty($formData['messageContent']) ? '' : $formData['messageContent'] ?></textarea>
			</fieldset>
			<div id="PaneButtons">
				<input name="coPreview" type="submit" value="<?= wfMsg('cops-button-preview') ?>" id="fPreview"/>
				<input name="coSave" type="submit" value="<?= wfMsg('cops-button-save') ?>" id="fSave"/>
			</div>
		</form>
</div>
<!-- e:<?= __FILE__ ?> -->
