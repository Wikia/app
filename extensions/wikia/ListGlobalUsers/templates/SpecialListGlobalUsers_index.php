<form>
	<fieldset>
		<legend><?= wfMessage( 'listglobalusers' )->escaped(); ?></legend>
		<p><?= wfMessage( 'listglobalusers-legend' )->escaped(); ?></p>
		<div class="list-global-users-input">
		<?php foreach ( $groupNameCheckBoxSet as $checkBox ): ?>
			<div>
				<input id="<?= Sanitizer::encodeAttribute( $checkBox['groupId'] ); ?>" type="checkbox" name="groups[]" value="<?= Sanitizer::encodeAttribute( $checkBox['groupName'] ); ?>" <?= $checkBox['checked'] ?> />
				<label for="<?= Sanitizer::encodeAttribute( $checkBox['groupId'] ); ?>"><?= htmlspecialchars( $checkBox['groupLabel'] ); ?></label>
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
