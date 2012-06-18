<article id="ContentWarning" class="ContentWarning WikiaArticle">
	<h2><?= $title ?></h2>

	<section class="warning"><?= $body ?></section>

	<button id="ContentWarningApprove" class="approve"><?= $btnContinue ?></button>
	<button id="ContentWarningCancel" class="secondary cancel"><?= $btnCancel ?></button>

	<?= wfMsgExt( 'content-warning-footnote', array( 'parse' ) ) ?>
</article>
