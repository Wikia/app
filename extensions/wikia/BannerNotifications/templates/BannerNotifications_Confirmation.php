<?php if (!empty( $notifications )): ?>
<div class="banner-notifications-wrapper">
	<? foreach( $notifications as $notification ): ?>
		<div class="banner-notification <?= $notification['class'] ?>">
			<button class="close wikia-chiclet-button"><img src=" <?= $wg->StylePath ?>/oasis/images/icon_close.png"></button>
			<div class="msg"><?= $notification['message'] ?></div>
		</div>
	<? endforeach ?>
</div>
<?php endif ?>
