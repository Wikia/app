<!-- s:<?= __FILE__ ?> -->
<!-- CHART TABLE -->
<!-- MAIN STATISTICS TABLE -->
<div class="ws_chart_table" style="clear:both;padding:10px 5px;">
<h2><?= ($statsKind == "daily") ? wfMsg('wikiastats_pageviews_daily') : wfMsg('wikiastats_pageviews_month') ?></h2>
<? 
$KB = 1000; $MB = $KB * $KB; $GB = $KB * $KB * $KB;
/* get max value */
if (!empty($chartValues)) {
	$chartData = array();
	foreach ($chartValues as $nspace => $dataValues) {
		//percent
		$iMax = $sum = 0;
		$nSpaceName = ($nspace == 0) ? $wgLang->ucfirst(wfMsg('wikiastats_content')) : ((isset($canonicalNamespace[$nspace])) ? str_replace("_","<br />",$canonicalNamespace[$nspace]) : $nspace);
		$suffix = "";
		$divide = 0;
		foreach ($dataValues as $date => $out) {
			$_tmp = $out;
			#---			
			if ($_tmp > $iMax) $iMax = $_tmp;
			$sum += $_tmp;
		}

		$maxValue = $iMax;
		foreach ($days as $date => $exists) {		
			# make date
			$dateArr = explode("-",$date);
			$stamp = mktime(23,59,59,$dateArr[1],(!empty($dateArr[2]))?$dateArr[2]:1,$dateArr[0]);
			$new_date = (isset($dateArr[2])) 
						? $wgLang->sprintfDate("d M Y", wfTimestamp(TS_MW, $stamp))
						: $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));

			$out = $value = (isset($dataValues[$date])) ? intval($dataValues[$date]) : 0;
			if (intval($iMax) > $GB) {
				$value = $wgLang->formatNum(sprintf("%0.1f", intval($out)/$GB));
				if (strlen($value) > 4) { 
					$value = sprintf("%0.0f", intval($out)/$GB);
				}
				$suffix = wfMsg('size-gigabytes', "");
				$maxValue = $wgLang->formatNum(sprintf("%0.1f", intval($iMax)/$GB));
			} elseif (intval($iMax) > $MB) {
				$value = $wgLang->formatNum(sprintf("%0.1f", intval($out)/$MB));
				if (strlen($value) > 4) { 
					$value = sprintf("%0.0f", intval($out)/$MB);
				}
				$suffix = wfMsg('size-megabytes', "");
				$maxValue = $wgLang->formatNum(sprintf("%0.1f", intval($iMax)/$MB));
			} elseif (intval($iMax) > $KB) {
				$value = $wgLang->formatNum(sprintf("%0.1f", intval($out)/$KB));
				if (strlen($value) > 4) { 
					$value = sprintf("%0.0f", intval($out)/$KB);
				}
				$suffix = wfMsg('size-kilobytes', "");
				$maxValue = $wgLang->formatNum(sprintf("%0.1f", intval($iMax)/$KB));
			}
			$chartData[$date] = array("date" => $new_date, "value" => (!empty($out))?$value:0, "alt" => $out);
		}

		$height = intval(2*$chartSettings['maxsize']/3);
		$ratio = $height/10; if ($iMax > 10) $ratio = $height/$iMax;
		$td_height = $height . $chartSettings['barunit'];
		$td_width = $chartSettings['barwidth'] . $chartSettings['barunit'];
		$tableStyle = "ws_charts"; 
		
		$barColor = ($statsKind == 'daily') ? "yellow" : "green";
		
		$columnsBar = "";
		if (empty($sum)) $sum = 1;
		$i = 0;
		$max_div_height = 0;

		foreach ($days as $date => $exists) {
			$_tmp = (isset($dataValues[$date])) ? intval($dataValues[$date]) : 0;
			$div_height = intval($ratio * $_tmp);
			if ($div_height > $max_div_height) {
				$max_div_height = $div_height;
			}
			$columnsBar .= "<td valign=\"bottom\" align=\"center\" class=\"ws_chart_column\">";
			$columnsBar .= "<div alt=\"".$_tmp."\" style=\"height:".$div_height."px;width:".$td_width.";background:url('/extensions/wikia/WikiaStats/images/bar_".$barColor.".gif');\">&nbsp;</div>";
			$columnsBar .= "</td>";
			$i++;
		}
?>		
<table cellspacing="0" cellpadding="0" border="0" class="<?=$tableStyle?>">
<tr>
	<td valign="bottom" align="right" rowspan="2" class="ws_chart_yaxis"><div style="padding:0px 3px 0px 0px;"><?=$maxValue?></div><div style="height:<?=$max_div_height?>px;">&nbsp;</div></td>
	<td align='right' style="padding:0px 10px 22px 5px;white-space:nowrap;" colspan="<?= (count($days)+1) ?>"><strong><?= str_replace("<br />", " ", $nSpaceName) ?></strong></td>
</tr>
<tr>
<?= $columnsBar ?>
</tr>
<tr style="background-color:#FFFFFF">
<td valign="middle" align="right" class="ws_chart_yaxis" style="border-top:1px solid #000000;"><div style="padding:0px 3px 0px 0px;"><strong><?=($suffix)?"[".$suffix."]":""?></strong></div></td>
<!-- VALUES -->
<?
		$dateYear = array();
		$prev_year = 0;
		$loop = 0;
		foreach ($chartData as $date => $values) {
			$value = (!empty($chartData[$date]['value'])) ? $chartData[$date]['value'] : 0;
			$color = ($loop%2) ? "color:#191970;" : "color:#A52A2A;";
			$loop++;
			/* */
			$dateArr = explode(" ",$values['date']);
			if (!array_key_exists($dateArr[1], $dateYear)) {
				$dateYear[$dateArr[1]] = 0;
			}
			$dateYear[$dateArr[1]]++;
			$addStyle = "";
			if ( $prev_year != $dateArr[1] ) {
				if ($prev_year != 0) {
					$addStyle = "border-left:1px dotted #000000;";
				}
				$prev_year = $dateArr[1];
			}
			$tableStyle = $addStyle;
?>	
	<td valign='middle' align='center' class="ws_chart_xaxis" style="<?=$addStyle?><?=$color?>"><?= $value ?></td>
<?
		}
?>	
</tr>
<tr style="background-color:#FFFFFF">
<td valign="middle" align="right" class="ws_chart_yaxis"><div style="padding:0px 3px 0px 0px;"><?= ($statsKind == "daily") ? wfMsg('wikiastats_active_day') : wfMsg('wikiastats_active_month')?></div></td>
<!-- DAYS/MONTHS -->
<?
		$dateYear = array();
		$prev_year = 0;
		foreach ($chartData as $date => $values) {
			$dateArr = explode(" ",$values['date']);
			$val = (isset($dateArr[2])) ? $dateArr[1] . " " . $dateArr[2] : $dateArr[1];
			if (!array_key_exists($val, $dateYear)) {
				$dateYear[$val] = 0;
			}
			$dateYear[$val]++;
			$addStyle = "";
			if ( $prev_year != $val ) {
				if ($prev_year != 0) {
					$addStyle = "border-left:1px dotted #000000;";
				}
				$prev_year = $val;
			}
			$selMonth = $dateArr[0];
?>	
	<td valign='middle' align='center' class="ws_chart_xaxis_months" style="<?=$addStyle?>"><?= $selMonth ?></td>
<?
		}
?>	
</tr>
<!-- YEARS -->
<tr style="background-color:#FFFFFF">
<td valign="middle" align="right" class="ws_chart_yaxis"><div style="padding:0px 3px 0px 0px;"><?=wfMsg('wikiastats_active_year')?></div></td>
<?
		$loop_y = 0;
		foreach ($dateYear as $year => $cnt) { 
			$style = ($loop_y == 0) ? "border-left:0px;width:12px;white-space:normal;" : "white-space:normal;width:10px"; $loop_y++;
?>
	<td align='center' colspan="<?=$cnt?>" class="ws_chart_xaxis_year" style="<?=$style?>"><?= $year ?></td>
<?
		}
?>
</tr>
</table>
<br />
<?
	}
}
?>
</div>
<!-- END OF PAGE EDITED DETAILS TABLE -->
<!-- e:<?= __FILE__ ?> -->
