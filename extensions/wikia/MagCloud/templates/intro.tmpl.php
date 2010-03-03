<div id="MagCloudIntroPopup" title="MagCloud" class="MagCloudDialog">
	<h3><?= wfMsg('magcloud-intro-create-magazine') ?></h3>

	<div id="MagCloudIntroPopupPreviews">
		<a href="<?= htmlspecialchars($preview['href']) ?>" target="_blank">
			<img src="<?= $preview['src'] ?>" />
		</a>

		<p><?= wfMsg('magcloud-intro-hint') ?></p>
	</div>

	<div id="MagCloudIntroArrow" class="clearfix">
		<span><?= wfMsg('magcloud-intro-check-out') ?></span>
	</div>

	<div id="MagCloudIntroPopupButtons" class="MagCloudPopupButtons">
		<a class="wikia-button" id="MagCloudIntroPopupOk">
			<?= wfMsg('magcloud-intro-get-started') ?>
		</a>
<?php if (!$isAnon): ?>
		<a class="wikia-button secondary" id="MagCloudIntroPopupLoad">
			<?= wfMsg('magcloud-intro-view-my-magazines') ?>
		</a>
<?php
	endif;
?>
		<a class="wikia-button secondary" id="MagCloudIntroPopupCancel">
			<?= wfMsg('cancel') ?>
		</a>
	</div>
</div>
