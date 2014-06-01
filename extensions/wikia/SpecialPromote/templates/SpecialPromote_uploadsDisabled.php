<? if ($checkAccess): ?>
	<p class="error"><?= wfMessage( 'promote-upload-image-uploads-disabled' )->text() ?></p>
<? else: ?>
	<?= wfMsg('promote-wrong-rights'); ?>
<? endif; ?>
