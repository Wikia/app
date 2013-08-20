<!-- start:<?= __FILE__ ?> -->
<?php global $wgTitle;?>
<form method='post' action='<?= $submitUrl; ?>' id='renameuser'>
	<input type="hidden" name="token" value="<?=$token;?>"/>
	<fieldset>
		<legend><?=wfMsgForContent( 'renameuser' )?></legend>
		<p><?=wfMsgExt('userrenametool-warning', array('parse'));?></p>
		<table id='mw-renameuser-table'>
			<tr>
				<td class='mw-label'>
					<label for='oldusername'><?=wfMsgForContent('userrenametool-old')?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="oldusername" size="20" tabindex="1" value="<?=$oldusername_hsc;?>"<?=($warnings) ? ' disabled' : null;?>/>
					<?if($warnings):?><input type="hidden" name="oldusername" value="<?=$oldusername_hsc;?>"/><?endif?>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='newusername'><?=wfMsgForContent( 'userrenametool-new' )?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="newusername" size="20" tabindex="2" value="<?=$newusername_hsc;?>"<?=($warnings) ? ' disabled' : null;?>/>
					<?if($warnings):?><input type="hidden" name="newusername" value="<?=$newusername_hsc;?>"/><?endif?>
					<span id="newUsernameEncoded"><?=wfMessage( 'userrenametool-encoded' )->escaped()?> <strong></strong></span>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='reason'><?=wfMsgForContent( 'userrenametool-reason' )?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="reason" size="60" tabindex="3" value="<?=$reason;?>"<?=($warnings) ? ' disabled' : null;?>/>
					<?if($warnings):?><input type="hidden" name="reason" value="<?=$reason;?>"/><?endif?>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='notify_renamed'><?=wfMsg( 'userrenametool-notify-renamed' )?></label>
				</td>
				<td class="mw-input">
					<input type="checkbox" name="notify_renamed" checked="<?= ($notify_renamed) ? '' : "checked"; ?>" />
				</td>
			</tr>
			<?if($warnings):?>
				<tr>
					<td class='mw-label'><?= wfMsgWikiHtml( 'userrenametool-warnings' ); ?></td>
					<td class='mw-input'>
						<ul style="color: orange; font-weight: bold">
							<li>
								<?= implode( '</li><li>', $warnings ); ?>
							</li>
						</ul>
						<?if($show_confirm):?>
							<p><strong><?=wfMsgForContent('userrenametool-confirm-intro');?></strong></p>
						<?endif;?>
					</td>
				</tr>
				<?if($show_confirm):?>
					<tr>
						<td><input type="hidden" name="confirmaction" value="1"/>&nbsp;</td>
						<td class='mw-submit'>
							<input id="submit" type="submit" name="submit" tabindex="4" value="<?=wfMsgForContent( 'userrenametool-confirm-yes' );?>"/>
							<input id="cancel" type="button" name="cancel" tabindex="5" value="<?=wfMsgForContent( 'userrenametool-confirm-no' );?>" onclick="window.location.href='<?=$wgTitle->getFullURL();?>';"/>
						</td>
					</tr>
				<?endif;?>
			<?else:?>
				<tr>
					<td>&nbsp;
					</td>
					<td class='mw-submit'>
						<input id="submit" type="submit" name="submit" tabindex="4" value="<?=wfMsgForContent( 'userrenametool-submit' );?>"/>
					</td>
				</tr>
			<?endif;?>
			
		</table>
	</fieldset>
</form>

<?foreach($errors as $message):?>
	<div class="errorbox">
		<?= $message; ?>
	</div>
<?endforeach;?>

<?foreach($infos as $message):?>
	<div class="successbox">
		<?= $message; ?>
	</div>
<?endforeach;?>
<!-- end:<?= __FILE__ ?> -->
