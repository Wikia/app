<div id="QuickToolsModal" class="QuickToolsModal WikiaForm" data-username="<?= htmlspecialchars( $username ) ?>">
	<h1><?= wfMessage( 'quicktools-modal-title', $username )->escaped() ?></h1>
	<div class="input-group">
		<label for="quicktools-time"><?= wfMessage( 'quicktools-label-time' )->escaped() ?></label>
		<input id="quicktools-time" type="text" value="<?= htmlspecialchars( $timestamp ) ?>" />
	</div>
	<div class="input-group">
		<label for="quicktools-reason"><?= wfMessage( 'quicktools-label-reason' )->escaped() ?></label>
		<input id="quicktools-reason" type="text" value="<?= wfMessage( 'quicktools-label-default-reason' )->escaped() ?>" />
	</div>
	<div class="input-group">
		<label for="quicktools-block-length"><?= wfMessage( 'quicktools-label-block-length' )->escaped() ?></label>
		<input id="quicktools-block-length" type="text" value="<?= htmlspecialchars( $blocklength ) ?>" />
	</div>
	<div class="spacer"></div>
	<div class="button-column">
		<button class="wikia-button" id="quicktools-rollback-all"><?= wfMessage( 'quicktools-rollback-all' )->escaped() ?></a>
		<button class="wikia-button" id="quicktools-revert-all"><?= wfMessage( 'quicktools-revert-all' )->escaped() ?></a>
		<button class="wikia-button" id="quicktools-block-and-revert"><?= wfMessage( 'quicktools-block-and-revert' )->escaped() ?></a>
	</div>
	<div class="button-column">
		<button class="wikia-button" id="quicktools-delete-all"><?= wfMessage( 'quicktools-delete-all' )->escaped() ?></a>
		<button class="wikia-button" id="quicktools-block"><?= wfMessage( 'quicktools-block' )->escaped() ?></a>
		<button class="wikia-button" id="quicktools-bot" data-bot="<?= htmlspecialchars( $botflag ) ?>"><?= wfMessage( 'quicktools-botflag-' . $botflag )->escaped() ?></a>
	</div>
</div>