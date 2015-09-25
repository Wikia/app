<section class="templatedraft-module module">
	<h2><?= wfMessage( 'templatedraft-module-title-approve' )->escaped() ?></h2>
	<p><?= wfMessage( 'templatedraft-module-content-approve' )->escaped() ?></p>
	<?php if ( $allowApprove ): ?>
		<a href="<?= Sanitizer::encodeAttribute( $draftUrl ) ?>">
			<button class="templatedraft-module-button" type="button" data-id="templatedraft-module-button-approve">
				<?= wfMessage( 'templatedraft-module-button-approve' )->escaped() ?>
			</button>
		</a>
	<?php else: ?>
		<p><?= wfMessage( 'templatedraft-module-approve-protected' )->parse() ?></p>
	<?php endif ?>
</section>
