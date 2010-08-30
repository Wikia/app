<?php
	if ($confirmation != '') {
?>
<div class="WikiaConfirmation<?= $confirmationClass ?>">
	<p class="plainlinks"><img src="<?= $wgBlankImgUrl ?>" class="accept-icon"><?= $confirmation ?></p>
</div>
<?php
	}
?>
