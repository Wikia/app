<article id="ContentWarning" class="ContentWarning WikiaArticle">
	<h2><?= wfMsg( 'content-warning-title' ) ?></h2>

	<section class="warning"><?= $body ?></section>

	<button id="ContentWarningApprove" class="approve"><?= wfMsg( 'content-warning-button-continue' ) ?></button>
	<a href="<?= $btnCancelUrl ?>" class="wikia-button secondary cancel"><?= wfMsg( 'content-warning-button-cancel' )?></a>

	<?= wfMsgExt( 'content-warning-footnote', array( 'parse' ) ) ?>
</article>
