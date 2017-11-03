<?php
	global $wgTitle;
?>

<form method='post' action='<?= $submitUrl; ?>' id='renameuser' data-show-confirm="<?= $showConfirm; ?>">
	<input type="hidden" name="token" value="<?= $token; ?>"/>
	<input type="hidden" name="isConfirmed" value="<?= $isConfirmed; ?>"/>
	<fieldset>
		<legend><?= wfMessage( 'renameuser' )->inContentLanguage()->escaped(); ?></legend>
		<p><?= wfMessage( 'userrenametool-warning' )->inContentLanguage()->parse(); ?></p>
		<? if ( $showForm ): ?> 
		<table id='mw-renameuser-table'>
			<tr>
				<td class='mw-label'>
					<label for='new-username'><?= wfMessage( 'userrenametool-new' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="text" id="new-username" name="newUsername" size="20" tabindex="2" value="<?= $newUsername; ?>"/>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='new-username-repeat'><?= wfMessage( 'userrenametool-new-repeat' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="text" id="new-username-repeat" name="newUsernameRepeat" size="20" tabindex="2" value="<?= $newUsernameRepeat; ?>"/>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for="password"><?= wfMessage( 'userrenametool-current-password' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="password" id="password" name="password" size="20" tabindex="2" value="<?= $password; ?>"/>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>&nbsp;</td>
				<td class='mw-input'>
					<input type="checkbox" id="understand-consequences" name="understandConsequences" size="20" tabindex="2" value="true"<?= $understandConsequences === 'true' ? ' checked' : ''; ?>/>
					<label for="understand-consequences"><?= wfMessage( 'userrenametool-understand-consequences' )->inContentLanguage()->escaped(); ?></label>
				</td>
			</tr>
			<? if ( $warnings ): ?>
				<tr>
					<td class='mw-label'><?= wfMessage( 'userrenametool-warnings' )->inContentLanguage()->escaped(); ?></td>
					<td class='mw-input'>
						<ul style="color: orange; font-weight: bold">
							<li>
								<?= implode( '</li><li>', $warnings ); ?>
							</li>
						</ul>
					</td>
				</tr>
			<? else: ?>
				<tr>
					<td>&nbsp;
					</td>
					<td class='mw-submit'>
						<input type="submit" name="submitbutton" tabindex="4" value="<?= wfMessage( 'userrenametool-submit' )->inContentLanguage()->escaped(); ?>"/>
					</td>
				</tr>
			<? endif; ?>
			<tr id="mw-warnings-row" style="display: none;">
				<td class="mw-label"><?= wfMessage( 'userrenametool-warnings' )->inContentLanguage()->escaped(); ?></td>
				<td class="mw-input">
					<ul id="mw-warnings-list">
						<li style="display: none;" id="mw-warnings-list-characters"><?= wfMessage( 'userrenametool-warnings-characters' )->inContentLanguage()->escaped(); ?></li>
						<li style="display: none;" id="mw-warnings-list-maxlength"><?= wfMessage( 'userrenametool-warnings-maxlength' )->inContentLanguage()->escaped(); ?></li>
					</ul>
				</td>
			</tr>
		</table>
		<? endif; ?> 
	</fieldset>
</form>

<? foreach ( $errors as $message ): ?>
	<div class="errorbox">
		<?= $message; ?>
	</div>
<? endforeach; ?>

<? foreach ( $infos as $message ): ?>
	<div class="successbox">
		<?= $message; ?>
	</div>
<? endforeach; ?>
