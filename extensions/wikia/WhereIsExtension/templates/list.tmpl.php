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
	$gVal = empty($formData['selectedVal']) ? '' : $formData['selectedVal'];
	foreach($formData['vars'] as $varId => $varName) {
		$selected = $gVar == $varId ? ' selected="selected"' : '';
		echo "\t\t<option value=\"$varId\"$selected>$varName</option>\n";
	}
	?>
	</select>
	<?= wfMsg('whereisextension-isset') ?>
	<select name="val">
		<option value="true"<?= $gVal == 'true' ? ' selected="selected"' : '' ?>>true</option>
		<option value="false"<?= $gVal == 'false' ? ' selected="selected"' : '' ?>>false</option>
	</select>
	<input type="submit" value="<?= wfMsg('whereisextension-submit') ?>"/>
	</form>
	<?php
	if (!empty($formData['wikis']) && count($formData['wikis'])) {
		?>
		<h3 id="headerWikis"><?= wfMsg('whereisextension-list') ?> (<?= count($formData['wikis']) ?>)</h3>
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
