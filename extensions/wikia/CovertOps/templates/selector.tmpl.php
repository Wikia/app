<!-- s:<?= __FILE__ ?> -->
<div id="PaneCompose">
		<form method="post" id="msgForm" action="<?= $title->getLocalUrl() ?>">
			<fieldset>
				<legend><?= wfMsg('cops-label-select') ?></legend>
				<input type="text" name="mTitle" value="" />
				<input name="coEdit" type="submit" value="<?= wfMsg('edit') ?>" id="fSave"/>
			</fieldset>
			<fieldset>
				<legend><?= wfMsg('cops-label-caveat') ?></legend>
				<?= wfMsg('cops-caveat') ?>
			</fieldset>
		</form>
</div>
<!-- e:<?= __FILE__ ?> -->
