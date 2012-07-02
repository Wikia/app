<table class="<?= $classes; ?>" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
		<span class='mw-collapsible-toggle'>
			<span class='mw-rc-openarrow'><?= $sideArrowLink; ?></span>
			<span class='mw-rc-closearrow'><?= $downArrowLink; ?></span>
		</span>
	</td>
	<td class="mw-enhanced-rc"></td>
	<td>
		<?= $hdrtitle ?>&nbsp;(<?= $cntChanges ?>) . . [<?= implode("; ", $users) ?>]
	</td>
</tr>
<tr>