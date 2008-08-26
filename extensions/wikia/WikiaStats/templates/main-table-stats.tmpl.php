<!-- s:<?= __FILE__ ?> -->
<?php
$outDate = "";
$created = (is_object($cityInfo)) ? $cityInfo->city_created : null;
if (!empty($created) && ($created != "0000-00-00 00:00:00")) {
	$dateTime = explode(" ", $created);
	#---
	$dateArr = explode("-", $dateTime[0]);
	#---
	$stamp = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]);
	$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[2] .", ". $dateArr[0]. " ".$dateTime[1];
}
$langName = (is_object($cityInfo)) ? $wgContLang->getLanguageName( $cityInfo->city_lang ) : " - ";
$catName = (is_object($cityInfo) && !empty($cats) && array_key_exists($cityId, $cats)) ? $cats[$cityId]['name'] : " - ";
$cityTitle = (is_object($cityInfo) && $cityId > 0) ? ucfirst($cityInfo->city_title) : (($cityId == 0) ? wfMsg("wikiastats_trend_all_wikia_text") : " - ");
$cityUrl = (is_object($cityInfo) && $cityId > 0) ? "<a target=\"new\" href=\"".$cityInfo->city_url."\">".$cityInfo->city_url."</a>" : " - ";
?>
<!-- s:<?= __FILE__ ?> -->
<!-- WIKI's INFORMATION -->	
<table cellspacing="0" cellpadding="1" border="0" style="font-size:8.5pt;font-family: Trebuchet MS,arial,sans-serif,helvetica;">
<tr>
	<td align="left"><strong><?= wfMsg('wikiastats_wikiid')?></strong> <?= (!empty($cityId)) ? $cityId : " - " ?></td>
	<td align="left"><strong><?= wfMsg('wikiastats_wikiname') ?></strong> <?= $cityTitle ?></td>
</tr>
<tr>
	<td align="left"><strong><?= wfMsg('wikiastats_wikilang') ?></strong> <?= (!empty($langName)) ? $langName : $cityInfo->city_lang ?></td>
	<td align="left"><strong><?= wfMsg('wikiastats_wikiurl') ?></strong> <?= $cityUrl ?></td></tr>
</tr>
<tr>
	<td align="left"><strong><?= wfMsg('wikiastats_wikicategory') ?></strong> <?= $catName ?></td>
	<td align="left"><strong><?= wfMsg('wikiastats_wikicreated') ?></strong> <?= (!empty($outDate)) ? $outDate : " - " ?></td>
</tr>
<tr>
	<td align="left" colspan="2"><strong><?= wfMsg('wikiastats_see_MW_stats') ?></strong> <a href="http://wikistats.wikia.com/EN/TablesWikia<?=(is_object($cityInfo)) ? strtoupper($cityInfo->city_dbname) : "ZZ"?>.htm" target="new">http://wikistats.wikia.com/EN/TablesWikia<?=(is_object($cityInfo)) ? strtoupper($cityInfo->city_dbname) : "ZZ"?>.htm</a> </td>
</tr>
</table>

<table cellspacing="1" cellpadding="0" border="0" width="500">
<tr><td id="ws-hide-table" class="panel" width="100%">&nbsp;</td></tr>
</table>
<!-- MAIN STATISTICS TABLE -->
<input type="hidden" id="wk-stats-city-id" value="<?=$cityId?>">
<div id="ws-main-table-stats" style="width:100%";>
<table cellspacing="0" cellpadding="0" border="1" id="table_stats" style="font-family: Trebuchet MS,arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb"><b><?= ucfirst(wfMsg('wikiastats_date')) ?></b></td>
	<td colspan="4" class="cb">
		<div class="hide"><a href="javascript:void(0);" alt="<?= wfMsg('wikiastats_hide') ?>" title="<?= wfMsg('wikiastats_hide') ?>" onClick="javascript:visible_column(1,4,0,'<?= wfMsg('wikiastats_wikians') ?>');">X</a></div>
		<b><?= wfMsg('wikiastats_wikians') ?></b>
	</td>
	<td colspan="7" class="cb">
		<div class="hide"><a href="javascript:void(0);" alt="<?= wfMsg('wikiastats_hide') ?>" title="<?= wfMsg('wikiastats_hide') ?>" onClick="javascript:visible_column(5,11,0,'<?= wfMsg('wikiastats_articles') ?>');">X</a></div>
		<b><?= wfMsg('wikiastats_articles') ?></b>
	</td>
	<td colspan="3" class="cb">
		<div class="hide"><a href="javascript:void(0);" alt="<?= wfMsg('wikiastats_hide') ?>" title="<?= wfMsg('wikiastats_hide') ?>" onClick="javascript:visible_column(12,14,0,'<?= wfMsg('wikiastats_database') ?>');">X</a></div>
		<b><?= wfMsg('wikiastats_database') ?></b>
	</td>
	<td colspan="5" class="cb">
		<div class="hide"><a href="javascript:void(0);" alt="<?= wfMsg('wikiastats_hide') ?>" title="<?= wfMsg('wikiastats_hide') ?>" onClick="javascript:visible_column(15,19,0,'<?= wfMsg('wikiastats_links') ?>');">X</a></div>
		<b><?= wfMsg('wikiastats_links') ?></b>
	</td>
	<td colspan="2" class="cb">
		<div class="hide"><a href="javascript:void(0);" alt="<?= wfMsg('wikiastats_hide') ?>" title="<?= wfMsg('wikiastats_hide') ?>" onClick="javascript:visible_column(20,21,0,'<?= wfMsg('wikiastats_images') ?>');">X</a></div>
		<b><?= wfMsg('wikiastats_images') ?></b>
	</td>
<? if (!empty($userIsSpecial)) { ?>
	<td colspan="4" class="cb">
		<div class="hide"><a href="javascript:void(0);" alt="<?= wfMsg('wikiastats_hide') ?>" title="<?= wfMsg('wikiastats_hide') ?>" onClick="javascript:visible_column(22,25,0,'<?= wfMsg('wikiastats_reg_users') ?>');">X</a></div>
		<b><?= wfMsg('wikiastats_reg_users') ?></b>
	</td>
<? } ?>	
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb" rowspan="2">&nbsp;</td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_total')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_new')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_count')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_new_per_day')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_mean')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_largerthan')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_size')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_words')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_internal')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_interwiki')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_image')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_external')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_redirects')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_uploaded_images')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_with_links')?></td>
<? if (!empty($userIsSpecial)) { ?>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_total')?></td>
	<td valign="top" class="cb" colspan="3"><?=wfMsg('wikistats_edited_in_namespace')?></td>
<? } ?>	
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb">&gt;5</td>
	<td class="cb">&gt;100</td>
	<td class="cb"><?=wfMsg('wikiastats_official')?></td>
	<td class="cb">&gt;200 ch</td>
	<td class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td class="cb"><?=wfMsg('wikiastats_bytes')?></td>
	<td class="cb" nowrap>0.5 Kb</td>
	<td class="cb" nowrap>2 Kb</td>
<? if (!empty($userIsSpecial)) { ?>
	<td class="cb" nowrap><?=wfMsg('wikistats_main_namespace')?></td>
	<td class="cb" nowrap><?=wfMsg('wikistats_user_namespace')?></td>
	<td class="cb" nowrap><?=wfMsg('wikistats_image_namespace')?></td>
<? } ?>	
</tr>
<?php
foreach ($monthlyStats as $date => $columnsData) {
	#---
	if ($columnsData['visible'] === 1) {
		$dateArr = explode("-", $date);
		$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
		$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];

?>
<tr>
	<td class="db" nowrap><?= $outDate ?></td>
<?
		$loop = 0;
		foreach ($columns as $column) {
			if ( in_array($column, array('date')) ) continue;
			$loop++;
			if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;
			#---
			$out = $columnsData[$column];
			$class = "rb";
			if ( in_array($column, array('B','H','I','J','K')) ) {
				$out = "&nbsp;";
			} elseif (empty($columnsData[$column]) || ($columnsData[$column] == 0)) {
				$out = "&nbsp;";
			} else {
				if ($columnsData[$column] < 0) {
					$out = "<font color=\"#800000\">".sprintf("%0.0f%%", $columnsData[$column])."</font>";
				} elseif (($columnsData[$column] > 0) && ($columnsData[$column] < 25)) {
					$out = "<font color=\"#000000\">".sprintf("+%0.0f%%", $columnsData[$column])."</font>";
				} elseif (($columnsData[$column] > 25) && ($columnsData[$column] < 75)) {
					$out = "<font color=\"#008000\">".sprintf("+%0.0f%%", $columnsData[$column])."</font>";
				} elseif (($columnsData[$column] > 75) && ($columnsData[$column] < 100)) {
					$out = "<font color=\"#008000\"><u>".sprintf("+%0.0f%%", $columnsData[$column])."</u></font>";
				} elseif ($columnsData[$column] >= 100) {
					$out = "&nbsp;";
				}
			}
?>
	<td class="rb"><?= $out ?></td>
<?php			
		}
?>
</tr>
<?php
	}
}
?>
</tr>
<tr bgcolor="#ffeecc">
<?php 
$loop = 0;
foreach ($columns as $column) {
	if ($column == "date") $column = "&nbsp;";
	$loop++;
	if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;
?>
	<td class="cb" title="<?= wfMsg("wikiastats_mainstats_column_".$column) ?>"><?= $column ?></td>
<?	
}
?>
<?php
foreach ($statsData as $date => $columnsData) {
?>
<tr>
<?php 
	$G = 1000 * 1000 * 1000;
	$M = 1000 * 1000;
	$K = 1000;	
	$GB = 1024 * 1024 * 1024;
	$MB = 1024 * 1024;
	$KB = 1024;	
	$loop = 0;
	foreach ($columns as $column) {
		$out = $columnsData[$column];
		$class = "rb";
		$loop++;
		if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;
		
		if (empty($columnsData[$column]) || ($columnsData[$column] == 0)) {
			$out = "&nbsp;";
		} else {
			if ($column == 'date') {
				$class = "db";
				$dateArr = explode("-",$columnsData[$column]);
				$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
				$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
				if ($columnsData[$column] == $today) {
				    $stamp = (!empty($today_day)) ? $today_day : $stamp;
					$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . date("d", $stamp) . ", " . date("Y", $stamp);
				}
			}
			elseif ($column == 'A')
				$out = sprintf("%0d", $columnsData[$column]);
			elseif ($column == 'H')
				$out = sprintf("%0.1f", $columnsData[$column]);
			elseif ($column == 'I')
				$out = sprintf("%0.0f", $columnsData[$column]);
			elseif (($column == 'J') || ($column == 'K'))
				$out = sprintf("%0d%%", $columnsData[$column] * 100);
			elseif ($column == 'M') {
				if (intval($columnsData[$column]) > $GB)
					$out = sprintf("%0.1f GB", intval($columnsData[$column])/$GB);
				elseif (intval($columnsData[$column]) > $MB)
					$out = sprintf("%0.1f MB", intval($columnsData[$column])/$MB);
				elseif ($columnsData[$column] > $KB)
					$out = sprintf("%0.1f KB", intval($columnsData[$column])/$KB);
				else
					$out = sprintf("%0d", intval($columnsData[$column]));
			} else {
				if (intval($columnsData[$column]) > $G)
					$out = sprintf("%0.1f G", intval($columnsData[$column])/$G);
				elseif (intval($columnsData[$column]) > $M)
					$out = sprintf("%0.1f M", intval($columnsData[$column])/$M);
				elseif ($columnsData[$column] > $K)
					$out = sprintf("%0.1f k", intval($columnsData[$column])/$K);
				else
					$out = sprintf("%0d", intval($columnsData[$column]));
			}
		}
		
?>
	<td class="<?= $class ?>" nowrap><?= $out ?></td>
<?	
	}
	
	if ($date == $today) {
?>
</tr><tr>
<? 
		$loop = 0;
		foreach ($columns as $column) { 
			$loop++;
			if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;
?>
	<td bgcolor="#ffeecc" class="cb_small">&nbsp;</td>
<? 
		} 
	} 
?>	
</tr>
<?
}
?>
</tr>
<tr bgcolor="#ffdead">
	<td class="cb"><b><?= wfMsg('wikiastats_date') ?></b></td>
	<td colspan="4" class="cb"><b><?= wfMsg('wikiastats_wikians') ?></b></td>
	<td colspan="7" class="cb"><b><?= wfMsg('wikiastats_articles') ?></b></td>
	<td colspan="3" class="cb"><b><?= wfMsg('wikiastats_database') ?></b></td>
	<td colspan="5" class="cb"><b><?= wfMsg('wikiastats_links') ?></b></td>
<? if (!empty($userIsSpecial)) { ?>
	<td colspan="4" class="cb"><b><?= wfMsg('wikiastats_reg_users') ?></b></td>
<? } ?>	
	<td colspan="2" class="cb"><b><?= wfMsg('wikiastats_images') ?></b></td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb" rowspan="2">&nbsp;</td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_total')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_new')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_count')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_new_per_day')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_mean')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_largerthan')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_size')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_words')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_internal')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_interwiki')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_image')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_external')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_redirects')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_uploaded_images')?></td>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_with_links')?></td>
<? if (!empty($userIsSpecial)) { ?>
	<td valign="top" rowspan="2" class="cb"><?=wfMsg('wikiastats_total')?></td>
	<td valign="top" class="cb" colspan="3"><?=wfMsg('wikistats_edited_in_namespace')?></td>
<? } ?>	
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb">&gt;5</td>
	<td class="cb">&gt;100</td>
	<td class="cb"><?=wfMsg('wikiastats_official')?></td>
	<td class="cb">&gt;200 ch</td>
	<td class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td class="cb"><?=wfMsg('wikiastats_bytes')?></td>
	<td class="cb" nowrap>0.5 Kb</td>
	<td class="cb" nowrap>2 Kb</td>
<? if (!empty($userIsSpecial)) { ?>
	<td class="cb" nowrap><?=wfMsg('wikistats_main_namespace')?></td>
	<td class="cb" nowrap><?=wfMsg('wikistats_user_namespace')?></td>
	<td class="cb" nowrap><?=wfMsg('wikistats_image_namespace')?></td>
<? } ?>	
</tr>
</table>
<div style="font-size:7.5pt; font-family:Trebuchet MS,verdana, arial;float:left;padding-bottom:10px;"><?=wfMsg("wikiastats_date_of_generate", wfMsg(strtolower(date("l",$today_day))) . " " . substr(wfMsg(strtolower(date("F",$today_day))), 0, 3) . " " . date("d", $today_day) . ", " . date("Y", $today_day))?></div>
</div>
<!-- END OF MAIN STATISTICS TABLE -->
<!-- MAIN STATISTICS NOTES -->
<div id="wk-stats-legend">
<?= wfMsg('wikiastats_note_mainstats') ?><br />
<span id="wk-stats-legend-values"><font color="#800000"><?= wfMsg('wikiastats_history_mainstats_value1'); ?></font></span>
<span id="wk-stats-legend-values"><font color="#000000"><?= wfMsg('wikiastats_history_mainstats_value2'); ?></font></span>
<span id="wk-stats-legend-values"><font color="#008000"><?= wfMsg('wikiastats_history_mainstats_value3'); ?></font></span>
<span id="wk-stats-legend-values"><font color="#008000"><u><?= wfMsg('wikiastats_history_mainstats_value4'); ?></u></font></span>
<br />
<div id="wk-stats-legend-columns">
<?php 
$i = 0; $loop = 0;
foreach ($columns as $column) {
	if ($column == "date") continue;
	$loop++;
	if ($i == 0) {
?>		
<span id="wk-column-group"><?= wfMsg("wikiastats_wikians") ?></span><br />
<?		
	} elseif ($i == 4) {
?>		
<span id="wk-column-group"><?= wfMsg("wikiastats_articles") ?></span><br />
<?		
	} elseif ($i == 11) {
?>		
<span id="wk-column-group"><?= wfMsg("wikiastats_database") ?></span><br />
<?		
	} elseif ($i == 14) {
?>		
<span id="wk-column-group"><?= wfMsg("wikiastats_links") ?></span><br />
<?	
	} elseif ($i == 19) {
?>
<span id="wk-column-group"><?= wfMsg("wikiastats_images") ?></span><br />
<?
	} elseif ($i == 21) {
		if (!empty($userIsSpecial)) { 
?>		
<span id="wk-column-group"><?= wfMsg("wikiastats_reg_users") ?></span><br />
<?
		}
	}
	$i++;
	if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;
?>
<span id="wk-column-<?=$column?>"><?=$column?>: <?= wfMsg("wikiastats_mainstats_column_".$column) ?></span><br />
<?	
}
?>
</div>
</div>
<!-- END OF MAIN STATISTICS NOTES -->
<!-- e:<?= __FILE__ ?> -->
