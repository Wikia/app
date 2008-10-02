<!-- s:<?= __FILE__ ?> -->
<!-- WIKIANS ABSENT TABLE -->
<div id="ws-wikians-absent-table-stats">
<?php
if (!empty($wkAbsent))
{
?>	
<div id="ws-wikians-title">
	<?= wfMsg('wikiastats_recently_absent_wikians', count($wkAbsent)); ?>
</div>
<table cellspacing="0" cellpadding="0" border="1" id="table_absent_wikians_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb"><b><?= wfMsg('wikiastats_username') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_edits') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_first_edit') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_last_edit') ?></b></td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb">&nbsp;</td>
	<td class="cb"><?= wfMsg('wikiastats_rank') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_total') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_date') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_days_ago') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_date') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_days_ago') ?></td>
</tr>
<?php
foreach ($wkAbsent as $rank => $data)
{
	#---
	$outFirstEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(0), wfTimestamp(TS_MW, $data['first_edit']));
	#---
	$outLastEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(0), wfTimestamp(TS_MW, $data['last_edit']));
?>
<tr>
	<td class="eb" style="white-space:nowrap;"><a href="<?= $city_url ?><?= Title::makeTitle(NS_USER, $data['user_name'])->getLocalURL() ?>" target="new"><?= $data['user_name'] ?></a></td>
	<td class="eb" style="white-space:nowrap;"><?= $rank ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $data['total'] ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $outFirstEdit ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $data['first_edit_ago'] ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $outLastEdit ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $data['last_edit_ago'] ?></td>
</tr>	
<?php
}
?>
</table>
<?
}
?>
</div>
<!-- END OF WIKIANS ABSENT TABLE -->
<!-- e:<?= __FILE__ ?> -->
