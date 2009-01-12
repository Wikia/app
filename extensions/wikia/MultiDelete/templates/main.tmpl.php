<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#mainForm table tr {vertical-align: top}
.right {text-align: right}
</style>
<div id="PaneCompose">
	<div id="PaneError"><?= !empty($formData['errMsg']) ? Wikia::errormsg($formData['errMsg']) : '' ?></div>
	<div id="PaneInfo"><?= wfMsg('multidelete-help') ?></div>
	<form method="post" id="mainForm" action="<?= $title->getLocalUrl() ?>">
		<table>
			<tr>
				<td class="right">
					<?= wfMsg('multidelete-as') ?>
				</td>
				<td>
					<select name="mMode" id="mMode" style="width:350px">
					<?php
					foreach ($formData['modes'] as $val => $text) {
						$selected = $val == $formData['mode'] ? ' selected="selected"' : '';
						echo "<option value=\"$val\"$selected>$text</option>\n";
					}
					?>
					</select>
				</td>
			</tr>

			<tr>
				<td class="right">
					<?= wfMsg('multidelete-on') ?>
				</td>
				<td>
					<select name="mRange" id="mRange" style="width:350px">
					<?php
					foreach ($formData['ranges'] as $val => $text) {
						$selected = $val == $formData['range'] ? ' selected="selected"' : '';
						echo "<option value=\"$val\"$selected>$text</option>\n";
					}
					?>
					</select>
				</td>
			</tr>

			<tr id="wikiInboxRow" style="<?= $formData['rangeHidden'] ?>">
				<td class="right">
					<?= wfMsg('multidelete-inbox-caption') ?>
				</td>
				<td>
					<textarea name="mWikiInbox" id="mWikiInbox" cols="40" rows="2"><?= empty($formData['wikiInbox']) ? '' : $formData['wikiInbox'] ?></textarea>
				</td>
			</tr>

			<tr>
				<td class="right">
					<?= wfMsg('multidelete-page') ?>
				</td>
				<td>
					<textarea name="mTitles" id="mTitles" cols="40" rows="10"><?= empty($formData['titles']) ? '' : $formData['titles'] ?></textarea>
				</td>
			</tr>

			<tr>
				<td>
				</td>
				<td>
					<input name="mAction" type="submit" value="<?= wfMsg('multidelete-button') ?>"/>
				</td>
			</tr>
		</table>

		<input type='hidden' name='mEditToken' value="<?= $formData['editToken'] ?>" />
	</form>
</div>

<script type="text/javascript">
function $(id) {
	return document.getElementById(id);
}

function showWikiInbox () {
	var wikiInboxRow = $('wikiInboxRow');

	if ((this.options[this.selectedIndex].value) == 'selected') {
		wikiInboxRow.style.display = '';
	} else {
		wikiInboxRow.style.display = 'none' ;
	}
}
YAHOO.util.Event.addListener('mRange', 'change', showWikiInbox);
</script>
<!-- e:<?= __FILE__ ?> -->