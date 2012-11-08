<div id="SharingToolbar" class="SharingToolbar">
	<? foreach( $shareButtons as $shareButton ): ?>
		<div><?= $shareButton->getShareBox() ?></div>
	<? endforeach ?>
</div>
