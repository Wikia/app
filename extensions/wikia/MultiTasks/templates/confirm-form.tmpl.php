<!-- s:<?= __FILE__ ?> -->
<p><?=wfMsg('multiwikiedit_help')?></p>
<form name="multiwikiedit" class="highlightform" id="highlightform" enctype="multipart/form-data" method="post" action="<?=htmlspecialchars($obj->mTitle->getLocalURL( "action=addTask" )) ?>">
<table>
	<tr>
		<td align="right"><?=wfMsg('multiwikiedit_as')?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpMode" id="wpMode" value="<?=$mTaskParams['mode']?>" />
			<?=($mTaskParams['mode'] == 'script') ? wfMsg('multiwikiedit_select_script') : wfMsg('multiwikiedit_select_yourself');?>
		</td>
	</tr>
	<tr>
		<td align="right"><?=wfMsg('multiwikiedit_on')?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpRange" id="wpRange" value="<?=$mTaskParams['range']?>" />
<? if ( isset( $obj->mLangOptions[$mTaskParams['range']] ) ) { 
	echo $obj->mLangOptions[$mTaskParams['range']];
} elseif ( isset( $obj->mCatOptions[$mTaskParams['range']] ) ) { 
	echo $obj->mCatOptions[$mTaskParams['range']];
} ?>
		</td>
	</tr>
<? $mTaskParams['range'] == 'selected' ? $display_hidden = '' : $display_hidden = 'display: none;' ; ?>
	<tr id="wikiinbox" style="vertical-align:top; <?= $display_hidden ?>" >
		<td align="right"><?=wfMsg('multiwikiedit_inbox_caption')?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpWikiInbox" id="wpWikiInbox" value="<?=$mTaskParams['wikis']?>" />
			<?= $mTaskParams['wikis'] ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="vertical-align:top"><?= wfMsg('multiwikiedit_page_text') ?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpText" id="wpText" value="<?=$mTaskParams['text']?>">
			<?= $mTaskParams['text'] ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="vertical-align:top"><?= wfMsg('multiwikiedit_summary_text') ?> :</td>
		<td align="left" style="padding:2px 5px;">
			<input type="hidden" name="wpSummary" id="wpSummary" value="<?=$mTaskParams['summary']?>">
			<?= $mTaskParams['summary'] ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?=wfMsg('multiwikiedit_edit_options')?></td>
		<td align="left" style="padding:2px 5px;">
<? $wpMinorEdit = ( isset($mTaskParams['flags'][0]) && (intval($mTaskParams['flags'][0]) > 0) ); ?>
			<input type="hidden" name="wpMinorEdit" id="wpMinorEdit" value="<?=intval($wpMinorEdit)?>">
			<?= ( $wpMinorEdit ) ? wfMsg('multiwikiedit_minoredit_caption') : "<strike>".wfMsg('multiwikiedit_minoredit_caption')."</strike>" ?>
		</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left" style="padding:2px 5px;">
<? $wpBotEdit = ( isset($mTaskParams['flags'][1]) && (intval($mTaskParams['flags'][1]) > 0) ); ?>
			<input type="hidden" name="wpBotEdit" id="wpBotEdit" value="<?= intval($wpBotEdit) ?>">
			<?= ( $wpBotEdit ) ? wfMsg('multiwikiedit_botedit_caption') : "<strike>".wfMsg('multiwikiedit_botedit_caption')."</strike>" ?>
		</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left" style="padding:2px 5px;">
<? $wpAutoSummary = ( isset($mTaskParams['flags'][2]) && (intval($mTaskParams['flags'][2]) > 0) ); ?>
			<input type="hidden" name="wpAutoSummary" id="wpAutoSummary" value="<?= intval($wpAutoSummary) ?>">
			<?= ( $wpAutoSummary ) ? wfMsg('multiwikiedit_autosummary_caption') : "<strike>".wfMsg('multiwikiedit_autosummary_caption')."</strike>" ?>
		</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left" style="padding:2px 5px;">
<? $wpNoRecentChanges = ( isset($mTaskParams['flags'][3]) && (intval($mTaskParams['flags'][3]) > 0) ); ?>
			<input type="hidden" name="wpNoRecentChanges" id="wpNoRecentChanges" value="<?= intval($wpNoRecentChanges) ?>">
			<?= ( $wpNoRecentChanges ) ? wfMsg('multiwikiedit_norecentchanges_caption') : "<strike>".wfMsg('multiwikiedit_norecentchanges_caption')."</strike>" ?>
		</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left" style="padding:2px 5px;">
<? $wpNewOnly = ( isset($mTaskParams['flags'][4]) && (intval($mTaskParams['flags'][4]) > 0) ); ?>
			<input type="hidden" name="wpNewOnly" id="wpNewOnly" value="<?= intval($wpNewOnly) ?>">
			<?= ( $wpNewOnly ) ? wfMsg('multiwikiedit_newonly_caption') : "<strike>".wfMsg('multiwikiedit_newonly_caption')."</strike>" ?>
		</td>
	</tr>
	<tr>
		<td align="right" style="vertical-align:top"><?= wfMsg('multiwikiedit_page')?> :</td>
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
			<input tabindex="12" name="wpmultiwikieditSubmit" type="submit" value="<?=wfMsg('multiwikiedit_confirm')?>" />
		</td>
	</tr>
</table>
<input type='hidden' name='wpEditToken' value="<?=$mTaskParams['edittoken']?>" />
</form>
<!-- e:<?= __FILE__ ?> -->
