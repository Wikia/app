<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#PaneList #headerWikis {
	margin-top: 20px;
}
</style>

<div id="PaneList">
	<form method="get" action="">
	<select name="var">
	<?php
	$gVar = empty($formData['selectedVar']) ? '' : $formData['selectedVar'];
	foreach($formData['vars'] as $varId => $varName) {
		$selected = $gVar == $varId ? ' selected="selected"' : '';
		echo "\t\t<option value=\"$varId\"$selected>$varName</option>\n";
	}
	?>
	</select>
	<input type="submit" value="<?= wfMsg('whereisextension-submit') ?>"/>
	</form>
	<?php
	$cnt = count($formData['wikis']);
	if (!empty($formData['wikis']) && $cnt) {
		?>
		<h3 id="headerWikis"><?= wfMsg('whereisextension-list') ?> (<?= $cnt ?>)</h3>
		<ul>
		<?php
		foreach($formData['wikis'] as $wikiName => $wikiUrl) {
			?>
			<li><a href="<?= htmlspecialchars($wikiUrl) ?>"><?= $wikiName ?></a></li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	?>
</div>
<!-- e:<?= __FILE__ ?> -->