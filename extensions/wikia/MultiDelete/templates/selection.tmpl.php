<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.TablePager td, .TablePager th {padding: 5px; border: 1px solid silver}
.noactive {background-color: #FFEAEA ! important}
</style>

<div id="PaneList">
	<form method="post" id="mainForm" action="<?= $title->getLocalUrl() ?>">
		<?php
		foreach ($formData['wikis'] as $wikiId => $wikiDomain) {
			echo "<label><input name=\"mSelectedWikis[]\" type=\"checkbox\" value=\"$wikiId\" />$wikiDomain</label><br/>\n";
		}
		?>
		<input type='hidden' name='mEditToken' value="<?= $formData['editToken'] ?>" />
		<input type='hidden' name='mRange' value="all-confirmed" />
		<input type='hidden' name='mPages' value="<?= $formData['mPages'] ?>" />
		<input name="mAction" type="submit" value="<?= wfMsg('multidelete-button') ?>"/>
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->