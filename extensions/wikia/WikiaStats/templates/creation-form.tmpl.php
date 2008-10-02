<!-- s:<?= __FILE__ ?> -->
<div class="stats-subtitle"><?= wfMsg('wikiastats_creation_wikia_text') ?></div>
<div class="wk-select-class-clear">
<?=wfMsg('wikiastats_creation_legend')?>
0 ≤ <font color="#AF5615">Xxx</font> < 5 ≤ <font color="#8F8735">Xxx</font> < 50 ≤ <font color="#187F17">Xxx</font> < 500 ≤ <font color=\"#267BCF\">Xxx</font>
</div>
<br />
<div id="ws-main-table">
<!-- CREATION's STATISTICS -->
<div class="medium" style="float:left; width:auto;">
<div class="wk-info-clear"><?= wfMsg('wikiastats_mainstats_short_column_A'); ?></div>
<div class="wk-select-class-clear"><?= wfMsg('wikiastats_mainstats_column_A'); ?></div>
<div class="div-eb-trend-clear"></div>
<!-- CREATION WIKIANS -->
<?
if (!empty($dWikians) && is_array($dWikians))
{
?>
<!--<div class="ws-div-history" style="background-color:#ffffdd;width:<?= $max_wikians * 100 ?>px;">-->
<table cellspacing="0" cellpadding="0" border="0" class="ws-div-history">
<?
$loop = 0;
foreach ($dWikians as $id => $date)
{
	$dateArr = explode("-", $date);
	#---
	$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
	$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
#	$style1 = "border:1px solid #808080; border-bottom: 0px; border-right:0px;";
#	$style1 = ($loop == (count($dWikians) - 1)) ? "border:1px solid #808080; border-right:0px;" : $style1;

#	$style = "border:1px solid #808080; border-bottom:0px;";
#	$style = ($loop == (count($dWikians) - 1)) ? "border:1px solid #808080;" : $style;
?>
<tr>
	<td class="ws-td-rb"><?=$outDate?></td>
	
<?
	$url = "<td class=\"ws-td-lb\" style=\"white-space:nowrap;\">";
	//$width = 100 * count($wikians[$date]);
	if ( !empty($wikians) && !empty($wikians[$date]) )
	{
		foreach ($wikians[$date] as $id => $wikiaInfo)
		{
			$out = $wikiaInfo['cnt'];
			$dbname = (!empty($wikiaInfo['city_id']) && array_key_exists($wikiaInfo['city_id'], $cityList)) ? $cityList[$wikiaInfo['city_id']]['dbname'] : "";
			
			#---
			$color = "#267BCF";
			if (($out >= 0) && ($out < 5)) $color = "#AF5615";
			elseif (($out >= 5) && ($out < 50)) $color = "#8F8735";
			elseif (($out >= 50) && ($out < 500)) $color = "#187F17";
			
			$url .= "<a href=\"/index.php?title=Special:WikiaStats&action=citystats&city=".$wikiaInfo['city_id']."\" style=\"color:$color;\">{<strong>".$dbname."</strong>}</a> " . $wikiaInfo['cnt'] . " | ";
		}
	}
	$url .= "&nbsp;</td>";
	$loop++;
?>
<?=$url?>
</tr>
<?				
}
?>
</table>	
<?
}
?>
<div class="wk-clear-hr">&nbsp;</div>
<div class="wk-info-clear"><?= wfMsg('wikiastats_mainstats_short_column_E'); ?></div>
<div class="wk-select-class-clear"><?= wfMsg('wikiastats_mainstats_column_E'); ?></div>
<div class="div-eb-trend-clear"></div>
<!-- CREATION WIKIANS -->
<?
if (!empty($dArticles) && is_array($dArticles))
{
?>
<table cellspacing="0" cellpadding="0" border="0" class="ws-div-history">
<?
foreach ($dArticles as $id => $date)
{
	$dateArr = explode("-", $date);
	#---
	$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
	$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
?>
<tr>
	<td class="ws-td-rb"><?=$outDate?></div>
	<td class="ws-td-lb" style="white-space:nowrap;">
<?
	if ( !empty($article) && !empty($article[$date]) ) {
		foreach ($article[$date] as $id => $wikiaInfo) {
			$out = $wikiaInfo['cnt'];
			$dbname = (!empty($wikiaInfo['city_id']) && array_key_exists($wikiaInfo['city_id'], $cityList)) ? $cityList[$wikiaInfo['city_id']]['dbname'] : "";

			$color = "#267BCF";
			if (($out >= 0) && ($out < 5)) $color = "#AF5615";
			elseif (($out >= 5) && ($out < 50)) $color = "#8F8735";
			elseif (($out >= 50) && ($out < 500)) $color = "#187F17";

			#---				
			$url = "<a href=\"/index.php?title=Special:WikiaStats&action=citystats&city=".$wikiaInfo['city_id']."\" style=\"color:$color;\">{<strong>".$dbname."</strong>}</a> " . $wikiaInfo['cnt'] . "| ";
?>
		<?=$url?>
<?				
		}
	}
?>		
	&nbsp;</td>
</tr>	
<?		
}
?>
</table>	
<?
}
?>
<br />
</div>
</div>
<!-- e:<?= __FILE__ ?> -->
