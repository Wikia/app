<!-- s:<?= __FILE__ ?> -->
<!-- ANON WIKIANS TABLE -->
<div id="ws-wikians-absent-table-stats">
<div id="ws-wikians-title">
	<?= wfMsg('wikiastats_anon_wikians_count', count($anonData)); ?>
</div>
<?php
if (!empty($anonData))
{
?>	
<table cellspacing="0" cellpadding="0" border="1" id="table_anon_wikians_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb" rowspan="2"><b><?= wfMsg('wikiastats_username') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_edits') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_first_edit') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_last_edit') ?></b></td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb"><?= wfMsg('wikiastats_rank') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_total') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_date') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_days_ago') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_date') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_days_ago') ?></td>
</tr>
<?php
$rank = 0;
foreach ($anonData as $id => $data)
{
	$rank++;
	#---
	$outFirstEdit = substr(wfMsg(strtolower(date("F",$data['min']))), 0, 3) . " " . date("d",$data['min']) .", ".date("Y",$data['min']);
	#---
	$outLastEdit = substr(wfMsg(strtolower(date("F",$data['max']))), 0, 3) . " " . date("d",$data['max']) .", ".date("Y",$data['max']);
?>
<tr>
	<td class="eb" nowrap><a href="<?= $city_url ?><?= Title::makeTitle(NS_SPECIAL, "Contributions")->getLocalURL() ?>/<?=$data['user_name']?>" target="new"><?= $data['user_name'] ?></a></td>
	<td class="eb" nowrap><?= $rank ?></td>
	<td class="eb" nowrap><?= $data['cnt'] ?></td>
	<td class="eb" nowrap><?= $outFirstEdit ?></td>
	<td class="eb" nowrap><?= sprintf("%0.0f", (time() - $data["min"])/(60*60*24)) ?></td>
	<td class="eb" nowrap><?= $outLastEdit ?></td>
	<td class="eb" nowrap><?= sprintf("%0.0f", (time() - $data["max"])/(60*60*24)) ?></td>
</tr>	
<?php
}
?>
</table>
<?
}
?>
</div>
<!-- END OF ANON WIKIANS TABLE -->
<!-- e:<?= __FILE__ ?> -->
