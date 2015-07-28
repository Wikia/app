<div id="QuickToolsModal" class="QuickToolsModal WikiaForm" data-username="<?= Sanitizer::encodeAttribute( $username ) ?>">
	<h1><?= wfMessage( 'quicktools-modal-title', $username )->escaped() ?></h1>
	<div class="input-group">
		<label for="quicktools-time">
			<?= wfMessage( 'quicktools-label-time' )->escaped() ?>
			<input id="quicktools-time" type="text" placeholder="<?= wfMessage( 'quicktools-placeholder-time' )->escaped() ?>" />
		</label>
	</div>
	<div class="input-group">
		<label for="quicktools-reason">
			<?= wfMessage( 'quicktools-label-reason' )->escaped() ?>
			<input id="quicktools-reason" type="text" value="<?= wfMessage( 'quicktools-label-default-reason' )->escaped() ?>" />
		</label>
	</div>
	<div class="input-group">
		<label for="quicktools-block-length">
			<?= wfMessage( 'quicktools-label-block-length' )->escaped() ?>
			<input id="quicktools-block-length" type="text" value="<?= Sanitizer::encodeAttribute( $blocklength ) ?>" />
		</label>
	</div>
	<div class="spacer"></div>
	<div class="button-column">
		<button class="wikia-button quicktools-action" id="quicktools-rollback-all" data-rollback="1"><?= wfMessage( 'quicktools-rollback-all' )->escaped() ?></button>
		<button class="wikia-button quicktools-action" id="quicktools-revert-all" data-rollback="1" data-delete="1"><?= wfMessage( 'quicktools-revert-all' )->escaped() ?></button>
		<button class="wikia-button quicktools-action" id="quicktools-block-and-revert" data-rollback="1" data-delete="1" data-block="1"><?= wfMessage( 'quicktools-block-and-revert' )->escaped() ?></button>
	</div>
	<div class="button-column">
		<button class="wikia-button quicktools-action" id="quicktools-delete-all" data-delete="1"><?= wfMessage( 'quicktools-delete-all' )->escaped() ?></button>
		<button class="wikia-button quicktools-action" id="quicktools-block" data-block="1"><?= wfMessage( 'quicktools-block' )->escaped() ?></button>
		<button class="wikia-button quicktools-action" id="quicktools-bot" data-bot="<?= Sanitizer::encodeAttribute( $botflag ) ?>"><?= wfMessage( 'quicktools-botflag-' . $botflag )->escaped() ?></button>
	</div>
</div>
