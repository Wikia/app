<?php
	if ($confirmation != '') {
?>
<div class="WikiaConfirmation<?= $confirmationClass ?>">
	<p class="plainlinks"><img src="<?= $wg->BlankImgUrl ?>" class="sprite ok"> <?= $confirmation ?></p>
</div>
<?php
	}
?>
