<div id="MagCloudSavedMagazines" title="<?= wfMsg('magcloud-load-magazine-title') ?>" class="MagCloudDialog">

	<div id="MagCloudSavedMagazinesList">
<?php foreach($magazines as $id => $magazine): ?>
		<input type="radio" name="MagCloudMagazine" id="MagCloudMagazine-<?= $id ?>" rel="<?= $magazine['hash'] ?>" />
		<h3><label for="MagCloudMagazine-<?= $id ?>"><?= htmlspecialchars($magazine['title']) ?></label></h3>
		<p><?= htmlspecialchars($magazine['subtitle']) ?></p>
		<br />
<?php endforeach; ?>
	</div>

	<div id="MagCloudSavedMagazinesButtons" class="MagCloudPopupButtons">
		<a class="bigButton" id="MagCloudLoadMagazine">
			<big><?= wfMsg('magcloud-load-magazine-load') ?></big>
			<small> </small>
		</a>

		<a class="bigButton greyButton" id="MagCloudCancel">
			<big><?= wfMsg('cancel') ?></big>
			<small> </small>
		</a>
	</div>
</div>
