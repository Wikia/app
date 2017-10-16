<div id="phalanx-mainframe">
	<div id="phalanx-nav-area">
<?= $app->renderPartial( 'PhalanxSpecial', 'tabs', [ 'currentTab' => 'test' ] ); ?>
	</div>

	<div id="phalanx-content-area">
		<form id="phalanx-block-test" action="<?= $action ?>">
			<label>
				<?= wfMessage( 'phalanx-test-description' )->escaped(); ?>
				<input type="text" id="phalanx-block-text" name="wpBlockText" value="<?= Sanitizer::encodeAttribute( $blockText ); ?>" autofocus>
			</label>
			<input type="submit" value="<?= wfMessage( 'phalanx-test-submit' )->escaped(); ?>">
		</form>
<?php if (isset($listing)): ?>
		<fieldset>
			<legend><?= wfMessage( 'phalanx-test-results-legend' )->escaped(); ?></legend>
			<div id="phalanx-check-results"><?= $listing ?></div>
		</fieldset>
	</div>
<?php endif; ?>
</div>
