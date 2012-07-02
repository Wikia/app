<!-- s:<?= __FILE__ ?> -->
<div id="PaneCompose">
	<div id="PaneError">
		<?= !empty($err) ? Wikia::errormsg($err) : '' ?>
	</div>
	<div id="PaneInfo">
		<?=wfMsg('multiwikiedit_help')?>
	</div>
	<form name="multiwikiedit" class="highlightform" id="highlightform" enctype="multipart/form-data" method="post" action="<?=htmlspecialchars($obj->mTitle->getLocalURL( "action=submit" )) ?>">
	<table>
		<tr>
			<td align="right"><?=wfMsg('multiwikiedit_as')?> :</td>
			<td align="left">
				<select tabindex="1" name="wpMode" id="wpMode">
					<option value="script" <?= ( $obj->mMode == 'script' ) ? 'selected="selected"' : '' ?> > <?= wfMsg('multiwikiedit_select_script') ?> </option>
					<option value="you" <?= ( $obj->mMode == 'you' ) ? 'selected="selected"' : '' ?> > <?= wfMsg('multiwikiedit_select_yourself') ?> </option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"><?=wfMsg('multiwikiedit_on')?> :</td>
			<td align="left">
				<select tabindex="2" name="wpRange" id="wpRange">
				<? foreach ( $aLangOptions as $value => $txt ) { ?>
					<option value="<?=$value?>" <?= ( $obj->mRange == $value ) ? 'selected="selected"' : '' ?> > <?= $txt ?> </option>
				<? } ?>	
				<? foreach ( $aCatOptions as $value => $txt ) { ?>
					<option value="<?=$value?>" <?= ( $obj->mRange == $value ) ? 'selected="selected"' : '' ?> > <?= $txt ?> </option>
				<? } ?>	
				</select>
			</td>
		</tr>
	<? $obj->mRange == 'selected' ? $display_hidden = '' : $display_hidden = 'display: none;' ; ?>
		<tr id="wikiinbox" style="vertical-align:top; <?= $display_hidden ?>" >
			<td align="right"><?=wfMsg('multiwikiedit_inbox_caption')?> :</td>
			<td align="left">
				<textarea tabindex="3" name="wpWikiInbox" id="wpWikiInbox" cols="40" rows="2" ><?= $obj->mWikiInbox ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="right" style="vertical-align:top"><?= wfMsg('multiwikiedit_page_text') ?> :</td>
			<td align="left">
				<textarea tabindex="4" name="wpText" id="wpText" cols="40" rows="10"><?= $obj->mText ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="right" style="vertical-align:top"><?= wfMsg('multiwikiedit_summary_text') ?> :</td>
			<td align="left">
				<input type="text" tabindex="5" name="wpSummary" style="width: 100%;" id="wpSummary" value="<?= $obj->mSummary ?>">
			</td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left">
				<input type="checkbox" tabindex="6" name="wpMinorEdit" id="wpMinorEdit" value="1" <?= ($obj->mMinorEdit) ? ' checked="checked" ' : '' ?> /><?= wfMsg('multiwikiedit_minoredit_caption') ?>
			</td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left">
				<input type="checkbox" tabindex="7" name="wpBotEdit" id="wpBotEdit" value="1" <?= ($obj->mBotEdit) ? ' checked="checked" ' : '' ?> /><?= wfMsg('multiwikiedit_botedit_caption') ?> 
			</td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left">
				<input type="checkbox" tabindex="8" name="wpAutoSummary" id="wpAutoSummary" value="1" <?= ($obj->mAutoSummary) ? ' checked="checked" ' : '' ?> /><?= wfMsg('multiwikiedit_autosummary_caption') ?>
			</td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left">
				<input type="checkbox" tabindex="9" name="wpNoRecentChanges" id="wpNoRecentChanges" value="1" <?= $obj->mNoRecentChanges ? ' checked="checked" ' : '' ?> /><?= wfMsg('multiwikiedit_norecentchanges_caption') ?>
			</td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left">
				<input type="checkbox" tabindex="10" name="wpNewOnly" id="wpNewOnly" value="1" <?= ($obj->mNewOnly) ? 'checked="checked"' : '' ?> /><?= wfMsg('multiwikiedit_newonly_caption') ?> 
			</td>
		</tr>
		<tr>
			<td align="right" style="vertical-align:top"><?= wfMsg('multiwikiedit_page')?> :</td>
			<td align="left">
				<textarea tabindex="11" name="wpPage" id="wpPage" cols="40" rows="2"><?= htmlspecialchars($obj->mPage) ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="right">&#160;</td>
			<td align="left">
				<input tabindex="12" name="wpmultiwikieditSubmit" type="submit" value="<?=wfMsg('multiwikiedit_button')?>" />
			</td>
		</tr>
	</table>
	<input type='hidden' name='wpEditToken' value="<?=$obj->mToken?>" />
	</form>
</div>
<script type="text/javascript">
<!--
function MultiWikiEditEnhanceControls () {
	var rangeControl = document.getElementById ('wpRange') ;
	//var selectedInput = document.getElementById ('wikilist') ;
	var selectedInbox = document.getElementById ('wikiinbox') ;
	if ((rangeControl.options[rangeControl.selectedIndex].value) == 'selected') {
		//selectedInput.style.display = '' ;
		selectedInbox.style.display = '' ;
	}
	var PreferencesSave = document.getElementById ('wpSaveprefs') ;
	rangeControl.onchange = function () {
		if ((this.options[this.selectedIndex].value) == 'selected') {
			//selectedInput.style.display = '' ;
			selectedInbox.style.display = '' ;
		} else {
			//selectedInput.style.display = 'none' ;
			selectedInbox.style.display = 'none' ;
		}
	}
}
$(MultiWikiEditEnhanceControls);
-->
</script>
<!-- e:<?= __FILE__ ?> -->
