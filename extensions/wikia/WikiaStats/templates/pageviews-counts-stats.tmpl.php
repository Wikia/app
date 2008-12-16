<!-- s:<?= __FILE__ ?> -->
<!-- PAGEVISITS COUNTS TABLE -->
<div id="ws-page-views-table-stats">
<br />
<?php
if (!empty($statsCount)) {
	$Kb = 1000;
	$Mb = $Kb * $Kb;
	$Gb = $Kb * $Kb * $Kb;
	$aNamespaces = $statsCount['namespaces'];
	ksort($aNamespaces, SORT_NUMERIC);
	
	$rows = array();
	$rows_month = array();
	if (!empty($statsCount['months'])) {
		$prev_value = array(0,0);
		foreach ($statsCount['months'] as $date => $values) {
			$row = "";
			$dateArr = explode("-",$date);
			$is_month = 0;
			if (!isset($dateArr[2])) {
				$is_month = 1;
			}
			$stamp = mktime(23,59,59,$dateArr[1],($is_month)?1:$dateArr[2],$dateArr[0]);
			$out = $wgLang->sprintfDate(($is_month)?"M Y":WikiaGenericStats::getStatsDateFormat(1), wfTimestamp(TS_MW, $stamp));
			if ($is_month) {
				$row .= "<tr bgcolor=\"#FFFFDD\"><td colspan=\"".(count($aNamespaces)+2)."\" style=\"line-height:2px;\">&nbsp;</td></tr>";
			}
			$row .= "<tr><td class=\"rb\" style=\"white-space:nowrap;\">".$out."</td>";
			$all = 0;
			foreach ($aNamespaces as $id => $value) {
				$_tmp = (isset($values[$id])) ? $values[$id] : 0;
				$_v = (isset($statsCount['trends'][$date][$id])) ? $statsCount['trends'][$date][$id] : 0;
				$row .= "<td class=\"rb\" style=\"width:40px;font-size:7.5pt;background-color:".WikiaGenericStats::colorizeTrend($_v)."\">";
				$row .= "<div class=\"ws-tpv\">".$wgLang->formatNum(sprintf("%0.1f", $_v))."%</div>";
				$row .= "<div class=\"ws-tpvl\">".WikiaGenericStats::getNumberFormat($_tmp)."</div></td>";
				$all += $_tmp;
			}
			/*$trend_all = "";
			if (isset($prev_value[$is_month])) {
				$trend_all = WikiaGenericStats::calculateTrend($all, $prev_value[$is_month]);
			}
			$row .= "<td class=\"cb\" style=\"white-space:nowrap;background-color:#ffdead\">".WikiaGenericStats::getNumberFormat($all)."</td>";*/
			$row .= "</tr>";
			($is_month == 0) ? $rows[] = $row : $rows_month[] = $row;
		} 
		krsort($rows);
		krsort($rows_month);
	}
?>	
<table id="ws-pageviews-legend" class="b" style="margin-top: 5px;" cellspacing="0">
<tr>
<td class="ws-pv-50"><nobr>-50%</nobr></td>
<td class="ws-pv-40"><nobr>-40%</nobr></td>
<td class="ws-pv-30"><nobr>-30%</nobr></td>
<td class="ws-pv-20"><nobr>-20%</nobr></td>
<td class="ws-pv-10"><nobr>-10%</nobr></td>
<td class="ws-pv0">0%</td>
<td class="ws-pv10">10%</td>
<td class="ws-pv20">20%</td>
<td class="ws-pv30">30%</td>
<td class="ws-pv40">40%</td>
<td class="ws-pv50">50%</td>
<td style="white-space:nowrap;padding-left:10px"><?=wfMsg('wikiastats_pageviews_percent')?></td>
</tr>
</tbody>
</table>
<br />
<div style="float:left; padding-bottom: 5px; width:100%; max-width:100%; max-height:600px;overflow-y:auto;">
<!-- CHARTS -->
<?=$chartHTML?>
<!-- END OF CHARTS -->
<br />
<table cellspacing="0" cellpadding="0" border="1" id="table_page_edited_stats" style="width:auto;font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#FFFFDD">
	<td class="cb" rowspan="2"><?=wfMsg('wikiastats_date')?></td>
	<td class="cb" colspan="<?=count($aNamespaces)?>"><?=wfMsg('wikiastats_namespace')?></td>
</tr>	
<tr bgcolor="#FFFFDD">
<? foreach ($aNamespaces as $id => $value) { ?>	
	<td class="cb" style="font-size:7pt;"><?= ($id == 0) ? $wgLang->ucfirst(wfMsg('wikiastats_content')) : ((isset($canonicalNamespace[$id])) ? str_replace("_","<br />",$canonicalNamespace[$id]) : $id)?></td>
<? } ?>
	<!--<td class="cb" style="font-size:7pt;">#</td>-->
</tr>
<?= implode("", $rows)?>
<?= implode("", $rows_month)?>
<tr bgcolor="#FFFFDD">
	<td class="cb" rowspan="3"><?=wfMsg('wikiastats_date')?></td>
<? $all = 0; foreach ($aNamespaces as $id => $value) { 
	$all += intval($value); 
?>	
	<td class="cb" style="font-weight:bold"><?= WikiaGenericStats::getNumberFormat($value) ?></td>
<? } ?>
	<!--<td class="cb"><?= WikiaGenericStats::getNumberFormat($all)?></td>-->
</tr>
<tr bgcolor="#FFFFDD">
<? foreach ($aNamespaces as $id => $value) { ?>	
	<td class="cb" style="font-size:7pt;"><?= ($id == 0) ? $wgLang->ucfirst(wfMsg('wikiastats_content')) : ((isset($canonicalNamespace[$id])) ? str_replace("_","<br />",$canonicalNamespace[$id]) : $id)?></td>
<? } ?>
	<!--<td class="cb" style="font-size:7pt;">#</td>-->
</tr>
<tr bgcolor="#FFFFDD">
	<td class="cb" colspan="<?=count($aNamespaces)?>"><?=wfMsg('wikiastats_namespace')?></td>
</tr>	
</table>
</div>
<?
}
?>
</div>
<!-- END OF PAGEVISITS COUNT TABLE -->
<!-- e:<?= __FILE__ ?> -->
