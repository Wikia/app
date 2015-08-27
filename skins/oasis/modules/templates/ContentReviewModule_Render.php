<section class="content-review-module module">
	<h2><?=
		/**
		 * Possible keys:
		 * content-review-module-unreviewed-title
		 * content-review-module-inreview-title
		 * content-review-module-current-title
		 */
		wfMessage( "content-review-module-{$moduleType}-title" )->escaped() ?></h2>
	<p><?=
		/**
		 * Possible keys:
		 * content-review-module-unreviewed-description
		 * content-review-module-inreview-description
		 * content-review-module-current-description
		 */
		wfMessage( "content-review-module-{$moduleType}-description" )->escaped() ?></p>
	<? if ( $moduleType !== ContentReviewModuleController::MODULE_TYPE_CURRENT ) : ?>
		<a href="#" id="content-review-module-submit" title="<?= wfMessage( "content-review-module-{$moduleType}-submit" )->escaped() ?>" data-type="<?= $moduleType ?>">
			<button class="content-review-module-button" type="button">
				<?= wfMessage( "content-review-module-{$moduleType}-submit" )->escaped() ?>
			</button>
		</a>
	<? endif; ?>
	<? if ( $isTestModeEnabled ) : ?>
		<button class="content-review-test-mode-disable"><?= wfMessage('content-review-test-mode-disable')->escaped() ?></button>
	<? else: ?>
		<button id="content-review-module-enable-test-mode"><?= wfMessage('content-review-module-enable-test-mode')->escaped() ?></button>
	<? endif ?>



</section>
