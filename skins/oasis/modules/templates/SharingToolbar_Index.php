<div id="SharingToolbar" class="SharingToolbar">
	<? foreach( $shareButtons as $shareButton ): ?>
		<div class="shareButton"><?= $shareButton->getShareBox() ?></div>
	<? endforeach ?>
</div>
