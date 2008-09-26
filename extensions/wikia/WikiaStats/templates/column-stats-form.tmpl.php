<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
ChangeColumnStats = function(e) {
	var column = YD.get( "ws_column_stats" ).value;
	var cities = "<?=$cities?>";
    var baseurl = "/index.php?title=Special:WikiaStats&action=compare&table=" + column; 
    if (cities) {
    	baseurl += "&cities=" + cities;
	}
    document.location = baseurl;
};

YE.addListener("ws_column_stats", "change", ChangeColumnStats);
/*]]>*/
</script>
<?
$G = 1000 * 1000 * 1000;
$M = 1000 * 1000;
$K = 1000;	
$GB = 1024 * 1024 * 1024;
$MB = 1024 * 1024;
$KB = 1024;	
$empty_row = "<td>&nbsp;</td>";
$cityUrl = "<a href=\"/index.php?title=Special:WikiaStats&action=citystats&city=%s\">";
$i = 0;
?>
<div style="text-align:right; float:left;padding:5px;">
<select name="ws_column_stats" id="ws_column_stats" style="text-align:left; font-size:11px;">
<? foreach ($rangeColumns as $id => $letter) { ?>
<option value="<?=($id+3)?>" <?=(($column == ($id+3)) ? " selected=\"selected\" " : "")?>><?=wfMsg("wikiastats_mainstats_short_column_" . $letter)?></option>
<? } ?>
</select>
</div>
<div style="float:left; margin-left:auto;margin-right:auto;width:100%">
<!--<?=$pager?>-->
</div>
<!-- table -->
<div class="medium" style="float:left; width:auto;overflow-x:auto;">
<table style="width:auto" class="ws-trend-table">
<?
$rows = array();
$loop = 0;
foreach ($cityOrderList as $id => $city_id)
{
	$k = ($loop % 3);
	if (!array_key_exists($k, $rows)) {
	    $rows[$k] = "";
    }
	$colspan = 3; $align="center";
	if (($loop == 0) && ($k == 0)) {
		$colspan = 2; $align="left";
	}
	#---
	$empty_row .= "<td>&nbsp;</td>";
	#---	
	$dbname = (array_key_exists($city_id, $cityList)) ? $cityList[$city_id]['dbname'] : "";
	$wikiaName = ($city_id == 0) ? wfMsg('wikiastats_trend_all_wikia_text') : $dbname;
	$rows[$k] .= "<td colspan=\"$colspan\" align=\"$align\"><strong>".sprintf($cityUrl, $city_id).$wikiaName."</a></strong></td>";
	$loop++;
}
foreach ($rows as $r => $data)
{
	$colspan = ($r < 2) ? 1 : 2;
?>
<tr><td colspan="<?=$colspan?>">&nbsp;</td><?=$data?></tr>
<?	
}
$prev_date = "";
foreach ($columnHistory as $date => $dateValues) 
{
	$show_percent = false;
	$cur_date = $date;
	#---
	$addEmptyLine = (!empty($prev_date)) ? WikiaGenericStats::checkColumnStatDate($date, $prev_date) : false;
	#---
	if ($addEmptyLine !== false)
	{
?>		
<tr style="background-color:#ffdead;font-size:<?=$addEmptyLine?>px;"><?=$empty_row?></tr>
<?		
	}
	
	if (strpos($date, STATS_COLUMN_PREFIX) !== false) //
	{
		$date = str_replace(STATS_COLUMN_PREFIX, "", $date);
		$show_percent = true;
	}
	#---
	$outDate = WikiaGenericStats::makeCorrectDate($date, ($date==date('Y-m')));
?>	
<tr>
<td class="eb-trend" style="width:80px;white-space:nowrap;"><strong><?=$outDate?></strong></td>
<?
	#---
	foreach ($cityOrderList as $id => $city_id)
	{
		$output = "&nbsp;";
		if (array_key_exists($city_id, $dateValues))
		{
			if ($dateValues[$city_id] != "null")
			{
				if ($show_percent === false)
				{
					if ($column == 9)
						$output = sprintf("%0d", $dateValues[$city_id]);
					elseif ($column == 13)
						$output = sprintf("%0.1f", $dateValues[$city_id]);
					elseif ($column == 14)
						$output = sprintf("%0.0f", $dateValues[$city_id]);
					elseif (($column == 15) || ($column == 16))
					{
						$output = sprintf("%0d%%", $dateValues[$city_id] * 100);
					}
					elseif ($column == 18)
					{
						if ($dateValues[$city_id] > $GB)
							$output = sprintf("%0.1f GB", $dateValues[$city_id]/$GB);
						elseif ($dateValues[$city_id] > $MB)
							$output = sprintf("%0.1f MB", $dateValues[$city_id]/$MB);
						elseif ($dateValues[$city_id] > $KB)
							$output = sprintf("%0.1f KB", $dateValues[$city_id]/$KB);
						else
							$output = sprintf("%0d", intval($dateValues[$city_id]));
					}
					else
					{
						if ($dateValues[$city_id] > $G)
							$output = sprintf("%0.1f G", intval($dateValues[$city_id]/$G));
						elseif ($dateValues[$city_id] > $M)
							$output = sprintf("%0.1f M", $dateValues[$city_id]/$M);
						elseif ($dateValues[$city_id] > $K)
							$output = sprintf("%0.1f k", intval($dateValues[$city_id])/$K);
						else
							$output = sprintf("%0d", $dateValues[$city_id]);
					}
				}
				else
				{
					if ($dateValues[$city_id] < 0)
					{
						$output = "<font color=\"#800000\">".sprintf("%0.0f%%", $dateValues[$city_id])."</font>";
					}
					elseif (($dateValues[$city_id] > 0) && ($dateValues[$city_id] < 25))
					{
						$output = "<font color=\"#555555\">".sprintf("+%0.0f%%", $dateValues[$city_id])."</font>";
					}
					elseif (($dateValues[$city_id] > 25) && ($dateValues[$city_id] < 75))
					{
						$output = "<font color=\"#008000\">".sprintf("+%0.0f%%", $dateValues[$city_id])."</font>";
					}
					elseif (($dateValues[$city_id] > 75) && ($dateValues[$city_id] < 100))
					{
						$output = "<font color=\"#008000\"><u>".sprintf("+%0.0f%%", $dateValues[$city_id])."</u></font>";
					}
					elseif ($dateValues[$city_id] >= 100)
					{
						$output = "&nbsp;";
					}
				}
			}
		}
?>
<td class="eb-trend" style="width:30px;white-space:nowrap;"><?=((!empty($output)) ? $output : "&nbsp;")?></td>
<?
	}
?>
</tr>
<?	
	$prev_date = $cur_date;
}
?>	
</table>
</div>
<div class="clear"></div>
<div style="float:left; margin-left:auto;margin-right:auto;width:100%">
<!--<?=$pager?>-->
</div>
<!-- e:<?= __FILE__ ?> -->
