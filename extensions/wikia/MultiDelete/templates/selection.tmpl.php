<!-- s:<?= __FILE__ ?> -->
<div id="PaneList">
	<form method="post" id="mainForm" action="<?= $title->getLocalUrl() ?>">
		<?php
		if (empty($formData['wikis'])) {
			echo wfMsg('multidelete-info-empty-list');
		} else {
			?>
			<label><input id="mSelectAllWikis" type="checkbox" /><?= wfMsg('multidelete-select-all') ?></label><br/><br/>
			<?php
			foreach ($formData['wikis'] as $wikiId => $wikiData) {
				foreach ($wikiData as $titleData) {
					echo "<label><input name=\"mSelectedWikis[]\" type=\"checkbox\" value=\"$wikiId\" />{$titleData['domain']}</label><br/>\n";
				}
			}
		?>
		<input type='hidden' name='mEditToken' value="<?= $formData['editToken'] ?>" />
		<input type='hidden' name='mRange' value="confirmed" />
		<input type='hidden' name='mTitles' value="<?= htmlspecialchars(serialize($formData['mTitles'])) ?>" />
		<input name="mAction" type="submit" value="<?= wfMsg('multidelete-button') ?>"/>
		<?php
		}
		?>
	</form>
</div>
<script type="text/javascript">
addOnloadHook(function () {
	YAHOO.util.Event.addListener('mSelectAllWikis', 'click',  selectAll);
});

function selectAll() {
	var wikis = document.getElementsByName('mSelectedWikis[]');
	for (i=wikis.length-1; i>=0; i--) {
		wikis[i].checked = this.checked;
	}
}
</script>
<!-- e:<?= __FILE__ ?> -->
