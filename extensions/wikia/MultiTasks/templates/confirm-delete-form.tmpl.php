<!-- s:<?= __FILE__ ?> -->
<p><?=wfMsg('multidelete_help')?></p>
<form name="multidelete" class="highlightform" id="highlightform" enctype="multipart/form-data" method="post" action="<?=htmlspecialchars($obj->mTitle->getLocalURL( "action=addTask" )) ?>">
<table>
	<tr>
		<td align="right"><?=wfMsg('multiwikiedit_as')?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpMode" id="wpMode" value="<?=$mTaskParams['mode']?>" />
			<?=($mTaskParams['mode'] == 'script') ? wfMsg('multidelete_select_script') : wfMsg('multiwikiedit_select_yourself');?>
		</td>
	</tr>
	<tr>
		<td align="right"><?=wfMsg('multiwikiedit_on')?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpRange" id="wpRange" value="<?=$mTaskParams['range']?>" />
<? if ( isset( $obj->mLangOptions[$mTaskParams['range']] ) ) {
	echo $obj->mLangOptions[$mTaskParams['range']];
} ?>
		</td>
	</tr>
	<tr id="wikiinbox" style="vertical-align:top; <?= ($mTaskParams['range'] == 'selected') ? '' : 'display: none;' ; ?>" >
		<td align="right"><?=wfMsg('multidelete_inbox_caption')?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpWikiInbox" id="wpWikiInbox" value="<?=$mTaskParams['wikis']?>" />
			<?= $mTaskParams['wikis'] ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="vertical-align:top"><?= wfMsg('multidelete_reason') ?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpReason" id="wpReason" value="<?=$mTaskParams['reason']?>">
			<?= $mTaskParams['reason'] ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="vertical-align:top"><?= wfMsg('multidelete_page')?> :</td>
		<td align="left" style="padding:2px 5px;">
		<input type="hidden" name="wpPage" id="wpPage" value="<?= implode( "|", array_map("wfEscapeWikiText", $mTaskParams['page']) ) ?>" />
<? if ( !empty($mTaskParams['page']) ) { foreach ($mTaskParams['page'] as $page) { ?>
			<?=$page?><br />
<?	} } ?>
		</td>
	</tr>
	<tr>
		<td align="right">&#160;</td>
		<td align="left" style="padding:2px 5px;">
			<input tabindex="12" name="wpmultideleteSubmit" type="submit" value="<?=wfMsg('multiwikiedit_confirm')?>" />
		</td>
	</tr>
</table>
<input type='hidden' name='wpEditToken' value="<?=$mTaskParams['edittoken']?>" />
</form>
<!-- e:<?= __FILE__ ?> -->
