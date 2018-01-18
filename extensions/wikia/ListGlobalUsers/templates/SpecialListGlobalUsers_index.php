<form action="<?= Sanitizer::encodeAttribute( $formAction ); ?>" method="get">
	<fieldset>
		<legend><?= wfMessage( 'listglobalusers' )->escaped(); ?></legend>
		<input id="list-global-users-selector" class="wds-toggle__input" type="checkbox">
		<label id="list-global-users-selector-toggle" for="list-global-users-selector" class="wds-toggle__label">
			<?= wfMessage( 'listglobalusers-select-all' )->escaped(); ?>
		</label>
		<p><?= wfMessage( 'listglobalusers-legend' )->escaped(); ?></p>
		<div class="list-global-users-input">
		<?php foreach ( $groupNameCheckBoxSet as $checkBox ): ?>
			<div>
				<input id="<?= Sanitizer::encodeAttribute( $checkBox['groupId'] ); ?>" class="list-global-users-group-checkbox" type="checkbox" name="groups[]" value="<?= Sanitizer::encodeAttribute( $checkBox['groupName'] ); ?>" <?= $checkBox['checked'] ?> />
				<label for="<?= Sanitizer::encodeAttribute( $checkBox['groupId'] ); ?>"><?= htmlspecialchars( $checkBox['groupLabel'] ); ?></label>
			</div>
		<?php endforeach; ?>
		</div>
		<input type="submit" class="list-global-users-submit wds-button wds-is-squished" value="<?= wfMessage( 'htmlform-submit' )->escaped(); ?>" />
	</fieldset>
</form>
<ul class="list-global-users-members">
	<?php foreach ( $userSet as $userId => $userName ): ?>
		<li><?= Linker::userLink( $userId, $userName ) . Linker::userToolLinks( $userId, $userName, false, Linker::TOOL_LINKS_NOBLOCK ); ?></li>
	<?php endforeach; ?>
</ul>
