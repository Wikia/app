<table cellpadding="0" cellspacing="0" border="0" style="background: none">
<tr>
	<td valign="top" style="white-space: nowrap">
		<tt><span id='mw-rc-openarrow-<?=$inx?>' class='mw-changeslist-expanded changes-list-entry' style='visibility:hidden'><a href='#' onclick='toggleVisibility(<?=$inx?>); return false' title='Pokaż szczegóły (wymagana JavaScript)' class='mw-arr-r'><img src="/skins/common/images/Arr_r.png" width="12" height="12" alt="+" title="Pokaż szczegóły (wymagana JavaScript)" /></a></span><span id='mw-rc-closearrow-<?=$inx?>' class='mw-changeslist-hidden changes-list-entry' style='display:none'><a href='#' onclick='toggleVisibility(<?=$inx?>); return false' title='Ukryj szczegóły' class='mw-arr-d'><img src="/skins/common/images/Arr_d.png" width="12" height="12" alt="-" title="Ukryj szczegóły" /></a></span>&nbsp;<span class="newpage">&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;</tt>
	</td>
	<td style="padding-left:5px"><?=$hdrtitle?>&nbsp;(<?=$cntChanges?>) . . [<?= implode("; ", $users) ?>]</td>
</tr>
</table>
