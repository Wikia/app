<?php
	if ($confirmation != '') {
?>
<div class="WikiaConfirmation<?= $confirmationClass ?>">
	<p class="plainlinks"><img src="<?= $wgBlankImgUrl ?>" class="sprite ok"> <?= $confirmation ?></p>
</div>
<?php
	}
?>
