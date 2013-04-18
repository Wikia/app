<div id="phalanx-mainframe">
	<div id="phalanx-nav-area">
<?= $app->renderView('PhalanxSpecial', 'tabs', array('currentTab' => 'test')); ?>
	</div>

	<div id="phalanx-content-area">
		<form id="phalanx-block-test" action="<?= $action ?>">
			<label>
				<?= wfMsg( 'phalanx-test-description' ) ?>
				<input type="text" id="phalanx-block-text" name="wpBlockText" value="<?= htmlspecialchars($blockText) ?>" autofocus>
			</label>
			<input type="submit" value="<?= wfMsg( 'phalanx-test-submit' ) ?>">
		</form>
<?php if (isset($listing)): ?>
		<fieldset>
			<legend><?= wfMsg( 'phalanx-test-results-legend' ); ?></legend>
			<div id="phalanx-check-results"><?= $listing ?></div>
		</fieldset>
	</div>
<?php endif; ?>
</div>
