<?php
	global $wgTitle;
?>

<form method='post' action='<?= $submitUrl; ?>' id='renameuser'>
	<input type="hidden" name="token" value="<?= $token; ?>"/>
	<input type="hidden" name="isConfirmed" value="<?= $isConfirmed; ?>"/>
	<fieldset>
		<legend><?= wfMessage( 'renameuser' )->inContentLanguage()->escaped(); ?></legend>
		<p><?= wfMessage( 'userrenametool-warning' )->inContentLanguage()->parse(); ?></p>
		<? if ( $showForm ): ?> 
		<table id='mw-renameuser-table'>
			<tr>
				<td class='mw-label'>
					<label for='old-username'><?= wfMessage( 'userrenametool-old' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input id="old-username" name="oldUsername" size="30" tabindex="2" readonly maxlength="<?= $maxUsernameLength; ?>" value="<?= $oldUsername; ?>"/>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='new-username'><?= wfMessage( 'userrenametool-new' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="text" id="new-username" name="newUsername" size="30" tabindex="2" maxlength="<?= $maxUsernameLength; ?>" value="<?= $newUsername; ?>"/>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='new-username-repeat'><?= wfMessage( 'userrenametool-new-repeat' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="text" id="new-username-repeat" name="newUsernameRepeat" size="30" tabindex="2" maxlength="<?= $maxUsernameLength; ?>" value="<?= $newUsernameRepeat; ?>"/>
				</td>
			</tr>
			<? if ( $selfRename ): ?>
				<tr>
					<td class='mw-label'>
						<label for="password"><?= wfMessage( 'userrenametool-current-password' )->inContentLanguage()->escaped(); ?></label>
					</td>
					<td class='mw-input'>
						<input type="password" id="password" name="password" size="30" tabindex="2" value="<?= $password; ?>"/>
					</td>
				</tr>
			<? endif; ?>
			<tr>
				<td class='mw-label'>&nbsp;</td>
				<td class='mw-input'>
					<input type="checkbox" id="understand-consequences" name="understandConsequences" size="30" tabindex="2" value="true"<?= $understandConsequences === 'true' ? ' checked' : ''; ?>/>
					<label for="understand-consequences"><?= wfMessage( 'userrenametool-understand-consequences' )->inContentLanguage()->escaped(); ?></label>
				</td>
			</tr>
			<? if ( $errors ): ?>
				<tr>
					<td class='mw-label'><?= wfMessage( 'userrenametool-errors' )->inContentLanguage()->escaped(); ?></td>
					<td class='mw-input'>
						<? foreach ( $errors as $message ): ?>
						<div class="errorbox">
							<?= $message; ?>
						</div>
						<? endforeach; ?>
					</td>
				</tr>
			<? endif; ?>
			<tr>
				<td>&nbsp;
				</td>
				<td class='mw-submit'>
					<input type="submit" name="submitbutton" tabindex="4" value="<?= wfMessage( 'userrenametool-submit' )->inContentLanguage()->escaped(); ?>"/>
				</td>
			</tr>
		</table>
		<? endif; ?> 
		<? if ( $infos ): ?>
			<tr>
				<td class='mw-label'>&nbsp;</td>
				<td class='mw-input'>
					<? foreach ( $infos as $message ): ?>
						<div class="successbox">
							<?= $message; ?>
						</div>
					<? endforeach; ?>
				</td>
			</tr>
		<? endif; ?>
	</fieldset>
</form>
