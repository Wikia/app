<!-- start:<?= __FILE__ ?> -->
<?php global $wgTitle;?>
<form method='post' action='<?= $submitUrl; ?>' id='renameuser'>
	<input type="hidden" name="token" value="<?=$token;?>"/>
	<fieldset>
		<legend><?=wfMsgForContent( 'renameuser' )?></legend>
		<p><strong><?=wfMsgExt('renameuser-warning', array('parse'));?></strong></p>
		<table id='mw-renameuser-table'>
			<tr>
				<td class='mw-label'>
					<label for='oldusername'><?=wfMsgForContent('renameuserold')?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="oldusername" size="20" tabindex="1" value="<?=$oldusername;?>"<?=($warnings) ? ' disabled' : null;?>/>
					<?if($warnings):?><input type="hidden" name="oldusername" value="<?=$oldusername;?>"/><?endif?>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='newusername'><?=wfMsgForContent( 'renameusernew' )?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="newusername" size="20" tabindex="2" value="<?=$newusername;?>"<?=($warnings) ? ' disabled' : null;?>/>
					<?if($warnings):?><input type="hidden" name="newusername" value="<?=$newusername;?>"/><?endif?>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>
					<label for='reason'><?=wfMsgForContent( 'renameuserreason' )?></label>
				</td>
				<td class='mw-input'>
					<input type="text" name="reason" size="60" tabindex="3" value="<?=$reason;?>"<?=($warnings) ? ' disabled' : null;?>/>
					<?if($warnings):?><input type="hidden" name="reason" value="<?=$reason;?>"/><?endif?>
				</td>
			</tr>
			<?if($warnings):?>
				<tr>
					<td class='mw-label'><?= wfMsgWikiHtml( 'renameuserwarnings' ); ?></td>
					<td class='mw-input'>
						<ul style="color: red; font-weight: bold">
							<li>
								<?= implode( '</li><li>', $warnings ); ?>
							</li>
						</ul>
						<p><strong><?=wfMsgForContent('renameuser-confirm-intro');?></strong></p>
					</td>
				</tr>
				<tr>
					<td><input type="hidden" name="confirmaction" value="1"/>&nbsp;</td>
					<td class='mw-submit'>
						<input id="submit" type="submit" name="submit" tabindex="4" value="<?=wfMsgForContent( 'renameuser-confirm-yes' );?>"/>
						<input id="cancel" type="button" name="cancel" tabindex="5" value="<?=wfMsgForContent( 'renameuser-confirm-no' );?>" onclick="window.location.href='<?=$wgTitle->getFullURL();?>';"/>
					</td>
				</tr>
			<?else:?>
				<tr>
					<td>&nbsp;
					</td>
					<td class='mw-submit'>
						<input id="submit" type="submit" name="submit" tabindex="4" value="<?=wfMsgForContent( 'renameusersubmit' );?>"/>
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
