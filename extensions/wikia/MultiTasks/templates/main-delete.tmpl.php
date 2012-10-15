<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#mainForm table {width: 100%}
#mainForm table tr {vertical-align: top}
#wpPage {width: 100%}
.right {text-align: right}
</style>
<div id="PaneCompose">
	<div id="PaneError">
		<?= !empty($err) ? Wikia::errormsg($err) : '' ?>
	</div>
	<div id="PaneInfo">
		<?= wfMsg('multidelete_help') ?>
	</div>
	<form method="post" id="mainForm" action="<?= htmlspecialchars($obj->mTitle->getLocalURL( "action=submit" )) ?>">
		<table>
			<tr>
				<td class="right"><?= wfMsg('multiwikiedit_as') ?></td>
				<td>
					<select tabindex="1" name="wpMode" id="wpMode" style="width:350px">
						<option value="you" <?= ( $obj->mMode == 'you' ) ? 'selected="selected"' : '' ?> > <?= wfMsg('multiwikiedit_select_yourself') ?> </option>
						<option value="script" <?= ( $obj->mMode == 'script' ) ? 'selected="selected"' : '' ?> > <?= wfMsg('multidelete_select_script') ?> </option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="right">
					<?= wfMsg('multiwikiedit_on') ?>
				</td>
				<td>
					<select tabindex="2" name="wpRange" id="wpRange" style="width:350px">
					<? foreach ( $aLangOptions as $value => $txt ) { ?>
						<option value="<?=$value?>" <?= ( $obj->mRange == $value ) ? 'selected="selected"' : '' ?> > <?= $txt ?> </option>
					<? } ?>	
					</select>
				</td>
			</tr>
			<tr id="wikiinbox" style="vertical-align:top; <?= ($obj->mRange == 'selected') ? '' : 'display: none;'; ?>" >
				<td align="right">
					<?=wfMsg('multidelete_inbox_caption')?> :
				</td>
				<td align="left">
					<textarea tabindex="3" name="wpWikiInbox" id="wpWikiInbox" cols="40" rows="2" ><?= $obj->mWikiInbox ?></textarea>
				</td>
			</tr>

			<tr>
				<td class="right">
					<?= wfMsg('multidelete_page') ?>
				</td>
				<td>
					<textarea tabindex="4" name="wpPage" id="wpPage" rows="10"><?= htmlspecialchars($obj->mPage) ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="right">
					<?= wfMsg('multidelete_reason') ?>
				</td>
				<td>
					<input name="wpReason" type="text" size="40" tabindex="5" />
				</td>
			</tr>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input name="wpAction" type="submit" value="<?= wfMsg('multidelete_button') ?>" tabindex="6"/>
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
	var selectedInbox = document.getElementById ('wikiinbox') ;
	if ((rangeControl.options[rangeControl.selectedIndex].value) == 'selected') {
		selectedInbox.style.display = '' ;
	}
	var PreferencesSave = document.getElementById ('wpSaveprefs') ;
	rangeControl.onchange = function () {
		selectedInbox.style.display = ((this.options[this.selectedIndex].value) == 'selected') ? '' : 'none';
	}
}
$(MultiWikiEditEnhanceControls) ;
-->
</script>
<!-- e:<?= __FILE__ ?> -->
