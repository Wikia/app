<?php
	if ($confirmation != '') {
?>
<div class="banner-notifications-wrapper">
	<div class="banner-notification <?= $confirmationClass ?>">
		<button class="close wikia-chiclet-button"><img src=" <?= $wg->StylePath ?>/oasis/images/icon_close.png"></button>
		<div class="msg"><?= $confirmation ?></div>
	</div>
</div>
<?php
	}
?>
