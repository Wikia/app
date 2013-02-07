<div id="phalanx-mainframe">
	<div id="phalanx-nav-area">
		<?= $app->renderView('PhalanxSpecial', 'tabs', array('currentTab' => 'test')); ?>
	</div>

	<div id="phalanx-content-area">
		<fieldset>
			<form id="phalanx-block-test" action="<?= $action ?>">
				<label>
					<?= wfMsg( 'phalanx-test-description' ) ?>
					<input type="text" id="phalanx-block-text" name="wpBlockText" value="<?= htmlspecialchars($blockText) ?>">
				</label>
				<input type="submit" value="<?= wfMsg( 'phalanx-test-submit' ) ?>">
			</form>
		</fieldset>
		<fieldset>
			<legend><?= wfMsg( 'phalanx-test-results-legend' ); ?></legend>
			<div id="phalanx-block-test-result"></div>
		</fieldset>
	</div>
</div>
