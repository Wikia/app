<section class="content-review-module module">
	<h2><?= wfMessage( 'content-review-module-title' )->escaped() ?></h2>

	<h4 class="content-review-module-header"><?= wfMessage( 'content-review-module-header-latest' )->escaped() ?></h4>
		<?= $latestStatus ?>
	<h4 class="content-review-module-header"><?= wfMessage( 'content-review-module-header-last' )->escaped() ?></h4>
		<?= $lastStatus ?>
	<h4 class="content-review-module-header"><?= wfMessage( 'content-review-module-header-live' )->escaped() ?></h4>
		<?= $liveStatus ?>

	<? if ( $displaySubmit ) : ?>
		<div class="content-review-module-submit-container">
			<a href="#" id="content-review-module-submit" title="<?= wfMessage( "content-review-module-submit" )->escaped() ?>">
				<button class="content-review-module-button primary" type="button">
					<?= wfMessage( "content-review-module-submit" )->escaped() ?>
				</button>
			</a>
		</div>
	<? endif; ?>

	<div class="content-review-module-test-mode">
		<? if ( $isTestModeEnabled ) : ?>
			<button class="content-review-module-test-mode-disable secondary">
				<?= wfMessage('content-review-module-test-mode-disable')->escaped() ?>
			</button>
		<? else: ?>
			<button class="content-review-module-test-mode-enable secondary">
				<?= wfMessage('content-review-module-test-mode-enable')->escaped() ?>
			</button>
		<? endif ?>
	</div>

	<div class="content-review-module-help">
		<?= wfMessage( 'content-review-module-help' )->parse() ?>
	</div>
</section>
