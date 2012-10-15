<!-- s:<?= __FILE__ ?> -->
<div id="PaneNav">
	<a href="<?= $title->getLocalUrl() ?>"><?= wfMsg('swm-page-title-editor') ?></a><br/>
	<a href="<?= $title->getLocalUrl('action=list') ?>"><?= wfMsg('swm-page-title-list') ?></a>
</div>

<div id="PaneSent">
	<fieldset>
		<legend><?= wfMsg('swm-label-sent') ?></legend>
		<form method="POST" id="msgForm" action="<?= $title->getLocalUrl() ?>">
			<?= $formData['sendResult'] ?>
			<?php if (!empty($formData['messageContent'])) { ?>
			<fieldset>
				<legend><?= wfMsg('swm-label-content') ?></legend>
				<?= $formData['messageContent'] ?>
			</fieldset>
			<?php } ?>
			<div id="PaneButtons">
				<input name="mAction" type="submit" value="<?= wfMsg('swm-button-new') ?>" id="fNew"/>
			</div>
		</form>
	</fieldset>
</div>
<!-- e:<?= __FILE__ ?> -->