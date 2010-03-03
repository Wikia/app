<div id="MagCloudSavedMagazines" title="<?= wfMsg('magcloud-load-magazine-title') ?>" class="MagCloudDialog">

	<div id="MagCloudSavedMagazinesList">
<?php if (empty($magazines)) { ?>
		<p id="MagCloudSavedMagazinesListEmpty"><?= wfMsg('magcloud-load-magazine-empty') ?></p>
<?php } else foreach($magazines as $id => $magazine): ?>
		<input type="radio" name="MagCloudMagazine" id="MagCloudMagazine-<?= $id ?>" rel="<?= $magazine['hash'] ?>" />
		<h3><label for="MagCloudMagazine-<?= $id ?>"><?= htmlspecialchars($magazine['title']) ?></label></h3>
		<p><?= htmlspecialchars($magazine['subtitle']) ?></p>
		<br />
<?php endforeach; ?>
	</div>

	<div id="MagCloudSavedMagazinesButtons" class="MagCloudPopupButtons">
<?php if (!empty($magazines)): ?>
		<a class="wikia-button" id="MagCloudLoadMagazine"><?= wfMsg('magcloud-load-magazine-load') ?></a>
<?php endif; ?>

		<a class="wikia-button secondary" id="MagCloudCancel"><?= wfMsg('cancel') ?></a>
	</div>
</div>
