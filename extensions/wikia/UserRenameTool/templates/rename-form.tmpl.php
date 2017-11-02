<?php
    global $wgTitle;
?>

<form method='post' action='<?= $submitUrl; ?>' id='renameuser'>
	<input type="hidden" name="token" value="<?= $token; ?>"/>
	<fieldset>
		<legend><?= wfMessage( 'renameuser' )->inContentLanguage()->escaped(); ?></legend>
		<p><?= wfMessage( 'userrenametool-warning' )->inContentLanguage()->parse(); ?></p>
		<table id='mw-renameuser-table'>
			<tr>
				<td class='mw-label'>
					<label for='newusername'><?= wfMessage( 'userrenametool-new' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="newusername" size="20" tabindex="2" value="<?= $newusername_hsc; ?>"/>
					<span id="newUsernameEncoded"><?= wfMessage( 'userrenametool-encoded' )->escaped(); ?> <strong></strong></span>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='newusernamerepeat'><?= wfMessage( 'userrenametool-new-repeat' )->inContentLanguage()->escaped(); ?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="newusernamerepeat" size="20" tabindex="2" value="<?= $newusername_repeat_hsc; ?>"/>
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
