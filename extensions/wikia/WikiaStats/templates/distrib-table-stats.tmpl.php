<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<div id="ws-distrib-table-stats">
<table cellspacing="0" cellpadding="0" border="1" id="table_distrib_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb"><b><?= wfMsg('wikiastats_distrib_edits') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_distrib_wikians') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_distrib_edits_total') ?></b></td>
</tr>
<?php
foreach ($statsData as $id => $data)
{
?>
<tr>
	<td class="eb" nowrap><?= $data['edits'] ?></td>
	<td class="eb" nowrap><?= $data['wikians'] ?></td>
	<td class="eb" nowrap><?= $data['wikians_perc'] ?></td>
	<td class="eb" nowrap><?= $data['edits_total'] ?></td>
	<td class="eb" nowrap><?= $data['edits_total_perc'] ?></td>
</tr>	
<?php
}
?>
</table>
</div>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
