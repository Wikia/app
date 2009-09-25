<div id="MagCloudIntroPopup" title="MagCloud" class="MagCloudDialog">
	<h3><?= wfMsg('magcloud-intro-create-magazine') ?></h3>
	<h4><?= wfMsg('magcloud-intro-check-out') ?></h4>

	<div id="MagCloudIntroPopupPreviews">
		<a href="<?= htmlspecialchars($preview['href']) ?>" target="_blank">
			<img src="<?= $preview['src'] ?>" />
		</a>
	</div>

	<p><?= wfMsg('magcloud-intro-hint') ?></p>

	<div id="MagCloudIntroPopupButtons" class="MagCloudPopupButtons<?= $isAnon ? ' MagCloudPopupButtonsAnon' : '' ?>">
		<a class="bigButton" id="MagCloudIntroPopupOk">
			<big><?= wfMsg('magcloud-intro-get-started') ?></big>
			<small> </small>
		</a>
<?php if (!$isAnon): ?>
		<a class="bigButton greyButton" id="MagCloudIntroPopupLoad">
			<big><?= wfMsg('magcloud-intro-view-my-magazines') ?></big>
			<small> </small>
		</a>
<?php
	endif;
?>
		<a class="bigButton greyButton" id="MagCloudIntroPopupCancel">
			<big><?= wfMsg('cancel') ?></big>
			<small> </small>
		</a>
	</div>
</div>
