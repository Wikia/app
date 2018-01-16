<form>
	<fieldset>
		<legend><?= wfMessage( 'listglobalusers' )->escaped(); ?></legend>
		<p><?= wfMessage( 'listglobalusers-legend' )->escaped(); ?></p>
		<div class="list-global-users-input">
		<?php foreach ( $groupNameForm as $field ): ?>
			<div>
				<?php $groupId = Sanitizer::encodeAttribute( "mw-input-groups-{$field['groupName']}" ); ?>
				<?php $checked = $field['active'] ? 'checked' : ''; ?>
				<input id="<?= $groupId ?>" type="checkbox" name="groups[]" value="<?= Sanitizer::encodeAttribute( $field['groupName'] ); ?>" <?= $checked ?> />
				<label for="<?= $groupId ?>"><?= htmlspecialchars( $field['groupLabel'] ); ?></label>
			</div>
		<?php endforeach; ?>
		</div>
		<input type="submit" class="list-global-users-submit wds-button wds-is-squished" value="<?= Sanitizer::encodeAttribute( wfMessage( 'htmlform-submit' )->text() ); ?>" />
	</fieldset>
</form>
<ul class="list-global-users-members">
	<?php foreach ( $userSet as $userId => $userName ): ?>
		<li><?= Linker::userLink( $userId, $userName ) . Linker::userToolLinks( $userId, $userName, false, Linker::TOOL_LINKS_NOBLOCK ); ?></li>
	<?php endforeach; ?>
</ul>
