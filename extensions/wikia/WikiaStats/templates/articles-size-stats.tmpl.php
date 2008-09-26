<!-- s:<?= __FILE__ ?> -->
<!-- ARTICLES SIZE TABLE -->
<div id="ws-article-size-table-stats">
<?php
if (!empty($articleCount))
{
?>	
<table cellspacing="0" cellpadding="0" border="1" id="table_article_size_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb" rowspan="2"><b><?= wfMsg('wikiastats_date') ?></b></td>
	<td class="cb" colspan="<?= count($articleSize) ?>"><b><?= wfMsg('wikiastats_articles_text') ?></b></td>
</tr>
<tr bgcolor="#ffeecc">
<?
foreach ($articleSize as $s => $values)
{
	$text = "&lt;&nbsp;".$s." B";
	if ($s >= 1024)
	{
		$text = "&lt;&nbsp;".sprintf ("%.0f", $s/1024)." kB";
	}
?>	
	<td class="cb"><?= $text ?></td>
<?
}
?>	
</tr>
<?php
foreach ($articleCount as $date => $monthStats)
{
	$cntAll = intval($monthStats['count']);
	#---
	$dateArr = explode("-",$date);
	$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
	$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
	if ($date == sprintf("%s-%s", date("Y"), date("m")))
	{
		$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . date("d") . ", " . $dateArr[0];
	}

?>
<tr>
	<td class="eb" style="white-space:nowrap;"><?= $out ?></td>
<?
	foreach ($articleSize as $s => $values)
	{
		$cntDate = (is_array($values) && array_key_exists($date, $values)) ? intval($values[$date]['count']) : 0;
		$rowValue = sprintf("%0.1f%%", ($cntDate * 100) / $cntAll);
?>	
	<td class="eb" style="white-space:nowrap;"><?= $rowValue ?></td>
<?
	}
?>
</tr>	
<?php
}
?>
</table>
<?
}
?>
</div>
<!-- END OF ARTICLES SIZE TABLE -->
<!-- e:<?= __FILE__ ?> -->
