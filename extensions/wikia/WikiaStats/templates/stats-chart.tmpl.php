<!-- s:<?= __FILE__ ?> -->
<!-- CHART TABLE -->
<!-- MAIN STATISTICS TABLE -->
<div class="ws_chart_table" style="clear:both;padding:5px;">
<? $G = 1000 * 1000 * 1000; $M = 1000 * 1000; $K = 1000; $S = 100; $T = 10; $GB = 1024 * 1024 * 1024; $MB = 1024 * 1024; $KB = 1024; ?>	
<? if (!empty($city_id)) { ?>
<input type="hidden" id="wk-stats-city-id" value="<?=$city_id?>">
<? } 

// calculation
$chartData = array();
$iMax = 1; $sum = 0;
$useByte = 0;

/* get max value */
foreach ($data as $date => $out) {
	//percent
	if ( in_array($column, array('J', 'K')) ) {
		$_tmp = $out * 100;
	} else {
		$_tmp = $out;
	}
	#---			
	if ($_tmp > $iMax) $iMax = $_tmp;
	$sum += $_tmp;
}

$suffix = "";
$divide = 0;
$maxValue = $iMax;
foreach ($data as $date => $out) {
	#---
	$dateArr = explode("-",$date);
	$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
	$new_date = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
	#---
/*	if ($column == 'H') $value = sprintf("%0.1f", $out);
	elseif ($column == 'I') $value = sprintf("%0.0f", $out);
	elseif (($column == 'J') || ($column == 'K')) {
		$value = sprintf("%0d", $out * 100);
		$suffix = "%";
	}
	elseif ($column == 'M') {
		$useByte = 1;
		if (intval($out) > $GB) $value = sprintf("%0.1f GB", intval($out)/$GB);
		elseif (intval($out) > $MB) $value = sprintf("%0.1f MB", intval($out)/$MB);
		elseif (intval($out) > $KB) $value = sprintf("%0.1f KB", intval($out)/$KB);
		else $value = sprintf("%0.0f", intval($out));
	} else {
		if (intval($out) > $G) $value = sprintf("%0.1f G", intval($out)/$G);
		elseif (intval($out) > $M) $value = sprintf("%0.1f M", intval($out)/$M);
		elseif (intval($out) > $K) $value = sprintf("%0.1f k", intval($out)/$K);
		else $value = sprintf("%0d", intval($out));
	} */
	if (in_array($column, array('J', 'K'))) {
		$value = sprintf("%0d", $out * 100);
		$out = $out * 100;
		$suffix = "%";
	} elseif (in_array($column, array('M'))) {
		$value = sprintf("%0.0f", intval($out));
		if (intval($iMax) > $GB) {
			$value = sprintf("%0.1f", intval($out)/$GB);
			if (strlen($value) > 4) { 
				$value = sprintf("%0.0f", intval($out)/$GB);
			}
			$suffix = "GB";
			$maxValue = sprintf("%0.1f", intval($iMax)/$GB);
		} elseif (intval($iMax) > $MB) {
			$value = sprintf("%0.1f", intval($out)/$MB);
			if (strlen($value) > 4) { 
				$value = sprintf("%0.0f", intval($out)/$MB);
			}
			$suffix = "MB";
			$maxValue = sprintf("%0.1f", intval($iMax)/$MB);
		} elseif (intval($iMax) > $KB) {
			$value = sprintf("%0.1f", intval($out)/$KB);
			if (strlen($value) > 4) { 
				$value = sprintf("%0.0f", intval($out)/$KB);
			}
			$suffix = "KB";
			$maxValue = sprintf("%0.1f", intval($iMax)/$KB);
		}
	} else {
		$value = sprintf("%0.0f", intval($out));
		if (intval($iMax) > $G) {
			$value = sprintf("%0.1f", intval($out)/$G);
			if (strlen($value) > 3) { 
				$value = sprintf("%0.0f", intval($out)/$G);
			}
			$suffix = "G";
			$maxValue = sprintf("%0.1f", intval($iMax)/$G);
		} elseif (intval($iMax) > $M) {
			$value = sprintf("%0.1f", intval($out)/$M);
			if (strlen($value) > 3) { 
				$value = sprintf("%0.0f", intval($out)/$M);
			}
			$suffix = "M";
			$maxValue = sprintf("%0.1f", intval($iMax)/$M);
		} elseif (intval($iMax) > $K) {
			$value = sprintf("%0.1f", intval($out)/$K);
			if (strlen($value) > 3) { 
				$value = sprintf("%0.0f", intval($out)/$K);
			}
			$suffix = "K";
			$maxValue = sprintf("%0.1f", intval($iMax)/$K);
		}
	}
		
	#---
	$chartData[$date] = array("date" => $new_date, "value" => (!empty($out))?$value:"&nbsp;", "alt" => $out);
}

$height = $chartSettings['maxsize'];
$ratio = $height/10; if ($iMax > 10) $ratio = $height/$iMax;

$td_height = $height . $chartSettings['barunit'];
$td_width = $chartSettings['barwidth'] . $chartSettings['barunit'];
#---

$tableStyle = "ws_charts"; 

$active = ($column >= 'A' && $column < 'E') ? "wikians"  : "";
$active = ($column >= 'E' && $column < 'L') ? "articles" : $active;
$active = ($column >= 'L' && $column < 'N') ? "database" : $active;
$active = ($column >= 'N' && $column < 'T') ? "links" 	 : $active;
$active = ($column >= 'T' && $column < 'X') ? "unique_wikians" : $active;
$active = ($column >= 'X') ? "images" : $active;

$barColor = ($column >= 'A' && $column < 'E') ? "orange" : "";
$barColor = ($column >= 'E' && $column < 'L') ? "blue" : $barColor;
$barColor = ($column >= 'L' && $column < 'N') ? "red" : $barColor;
$barColor = ($column >= 'N' && $column < 'T') ? "green" : $barColor;
$barColor = ($column >= 'T' && $column < 'X') ? "purple" : $barColor;
$barColor = ($column >= 'X') ? "yellow" : $barColor;

$title = "<div class=\"wk-stats-legend\"><a name=\"".strtolower($active)."\">";
$title .= "<a href=\"#wikians\" style=\"" . (($column >= 'A' && $column < 'E') ? "color:#A52A2A;font-weight:bold" : "color: #6495ED") . "\">".wfMsg("wikiastats_wikians")."</a> - ";
$title .= "<a href=\"#articles\" style=\"" . (($column >= 'E' && $column < 'L') ? "color:#A52A2A;font-weight:bold" : "color: #6495ED") . "\">".wfMsg("wikiastats_articles")."</a> - ";
$title .= "<a href=\"#database\" style=\"" . (($column >= 'L' && $column < 'N') ? "color:#A52A2A;font-weight:bold" : "color: #6495ED") . "\">".wfMsg("wikiastats_database")."</a> - ";
$title .= "<a href=\"#links\" style=\"" . (($column >= 'N' && $column < 'T') ? "color:#A52A2A;font-weight:bold" : "color: #6495ED") . "\">".wfMsg("wikiastats_links")."</a> - ";
$title .= "<a href=\"#unique_wikians\" style=\"" . (($column >= 'T' && $column < 'W') ? "color:#A52A2A;font-weight:bold" : "color: #6495ED") . "\">".wfMsg("wikiastats_reg_users")."</a> - ";
$title .= "<a href=\"#images\" style=\"" . (($column >= 'X') ? "color:#A52A2A;font-weight:bold" : "color: #6495ED") . "\">".wfMsg("wikiastats_images")."</a>";
$title .= "</div>";
$columnsBar = "";
if (empty($sum)) $sum = 1;
$i = 0;
$max_div_height = 0;
foreach ($data as $date => $out) {
	
	if ( in_array($column, array('J', 'K')) ) //percent
		$_tmp = $out * 100;
	else
		$_tmp = $out;		
	$div_height = intval($ratio * $_tmp);
	if ($div_height > $max_div_height) {
		$max_div_height = $div_height;
	}
	$columnsBar .= "<td valign=\"bottom\" align=\"center\" class=\"ws_chart_column\">
	<div alt=\"".$_tmp."\" style=\"height:".$div_height."px;width:".$td_width.";background:url('/extensions/wikia/WikiaStats/images/bar_".$barColor.".gif');\">&nbsp;</div>
	</td>";
	$i++;
}
?>
<?= $title ?>
<table cellspacing="0" cellpadding="0" border="0" class="<?=$tableStyle?>">
<tr>
	<td valign="bottom" align="right" rowspan="2" class="ws_chart_yaxis"><div style="padding:0px 3px 0px 0px;"><?=$maxValue?></div><div style="height:<?=$max_div_height?>px;">&nbsp;</div></td>
	<td align='right' style="padding:0px 10px 22px 5px;" colspan="<?= (count($data)+1) ?>"><?= wfMsg("wikiastats_mainstats_column_$column") ?> (<strong><?=$column?></strong>)</td>
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
<td valign="middle" align="right" class="ws_chart_yaxis"><div style="padding:0px 3px 0px 0px;"><?=wfMsg('wikiastats_active_month')?></div></td>
<!-- MONTHS -->
<?
	$dateYear = array();
	$prev_year = 0;
	foreach ($chartData as $date => $values) {
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
?>	
	<td valign='middle' align='center' class="ws_chart_xaxis_months" style="<?=$addStyle?>"><?= $dateArr[0] ?></td>
<?
	}
?>	
</tr>
<!-- YEARS -->
<tr style="background-color:#FFFFFF">
<td valign="middle" align="right" class="ws_chart_yaxis"><div style="padding:0px 3px 0px 0px;"><?=wfMsg('wikiastats_active_year')?></div></td>
<?
	$loop_y = 0;
	foreach ($dateYear as $year => $cnt) { $style = ($loop_y == 0) ? "border-left:0px" : ""; $loop_y++;
?>
	<td align='center' colspan="<?=$cnt?>" class="ws_chart_xaxis_year" style="<?=$style?>"><?= $year ?></td>
<?
	}
?>
</tr>
</table>
</div>
<br /><br />
<!-- END OF PAGE EDITED DETAILS TABLE -->
<!-- e:<?= __FILE__ ?> -->
