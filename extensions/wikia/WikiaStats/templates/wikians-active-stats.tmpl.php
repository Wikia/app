<!-- s:<?= __FILE__ ?> -->
<!-- WIKIANS ACTIVE TABLE -->
<div id="ws-wikians-active-table-stats">
<?php
if (!empty($wkActive))
{
?>	
<br />
<div id="ws-wikians-title">
	<?= wfMsg('wikiastats_recently_active_wikians', count($wkActive)); ?>
	<br />
	<span class="small"><?= wfMsg('wikiastats_active_wikians_subtitle_info') ?></span>
</div>
<table cellspacing="0" cellpadding="0" border="1" id="table_active_wikians_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb" rowspan="2"><b><?= wfMsg('wikiastats_username') ?></b></td>
	<td class="cb" colspan="6"><b><?= wfMsg('wikiastats_edits') ?></b></td>
	<td class="cb" rowspan="2" colspan="2"><b><?= wfMsg('wikiastats_first_edit') ?></b></td>
	<td class="cb" rowspan="2" colspan="2"><b><?= wfMsg('wikiastats_last_edit') ?></b></td>
</tr>
<tr bgcolor="#ffdead">
	<td class="cb" colspan="4"><b><?= wfMsg('wikiastats_articles_text') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_other') ?></b></td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb" rowspan="2">&nbsp;</td>
	<td class="cb" colspan="2"><?= wfMsg('wikiastats_rank') ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikiastats_active_month') : wfMsg('wikiastats_active_months')) ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_total') ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_total') ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikiastats_active_month') : wfMsg('wikiastats_active_months')) ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_date') ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_days_ago') ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_date') ?></td>
	<td class="cb" rowspan="2"><?= wfMsg('wikiastats_days_ago') ?></td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb"><?= wfMsg('wikiastats_now') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_prev_rank') ?></td>
</tr>
<?php
foreach ($wkActive as $rank => $data)
{
	$rank_change = $data['rank_change'];
	if ($data['rank_change'] < 0)
	{
		$rank_change = "<font color=\"#800000\">".$rank_change."</font>";
	}
	elseif ($data['rank_change'] > 0)
	{
		$rank_change = "<font color=\"#008000\">+".$rank_change."</font>";
	}	
	elseif ($data['rank_change'] == 0)
	{
		$rank_change = "...";
	}	
	#---
	$outFirstEdit = substr(wfMsg(strtolower(date("F",$data['first_edit']))), 0, 3) . " " . date("d",$data['first_edit']) .", ".date("Y",$data['first_edit']);
	#---
	$outLastEdit = substr(wfMsg(strtolower(date("F",$data['last_edit']))), 0, 3) . " " . date("d",$data['last_edit']) .", ".date("Y",$data['last_edit']);
?>
<tr>
	<td class="eb" nowrap><a href="<?= trim($city_url) ?><?= Title::makeTitle(NS_USER, $data['user_name'])->getLocalURL() ?>" target="new"><?= $data['user_name'] ?></a></td>
	<td class="eb" nowrap><?= $rank ?></td>
	<td class="eb" nowrap><?= $rank_change ?></td>
	<td class="eb" nowrap><?= $data['edits_last'] ?></td>
	<td class="eb" nowrap><?= $data['total'] ?></td>
	<td class="eb" nowrap><?= $data['total_other'] ?></td>
	<td class="eb" nowrap><?= $data['edits_other_last'] ?></td>
	<td class="eb" nowrap><?= $outFirstEdit ?></td>
	<td class="eb" nowrap><?= $data['first_edit_ago'] ?></td>
	<td class="eb" nowrap><?= $outLastEdit ?></td>
	<td class="eb" nowrap><?= $data['last_edit_ago'] ?></td>
</tr>	
<?php
}
?>
</table>
<?
}
?>
</div>
<br />
<!-- END OF WIKIANS ACTIVE TABLE -->
<!-- e:<?= __FILE__ ?> -->
