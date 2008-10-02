<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.util.Event.onDOMReady(function () {
	visible_column(18,22,0,'<?= wfMsg('wikiastats_links') ?>');
	visible_column(23,24,0,'<?= wfMsg('wikiastats_images') ?>');
});
/*]]>*/
</script>

<div class="clear"></div>
<div id="ws-hide-table" class="panel"></div>
<!-- MAIN STATISTICS TABLE -->
<input type="hidden" id="wk-stats-city-id" value="<?=$cityId?>" />
<br />
<div class="clear" style="font-size:7.7pt;height:15px;"><a href="#definitions"><?=wfMsg("wikiastats_see_definitions")?></a></div>
<div id="ws-main-table-stats" style="width:100%;overflow:auto;margin:0px -225px 0px 0px;">
<a name="mainstats"></a>
<table align="left" cellspacing="0" cellpadding="0" border="1" id="table_stats" style="font-family: Trebuchet MS,arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb"><b><?= ucfirst(wfMsg('wikiastats_date')) ?></b></td>
	<td colspan="7" class="cb">
		<div class="hide"><a href="javascript:void(0);" title="<?= wfMsg('wikiastats_hide') ?>" onclick="javascript:visible_column(1,7,0,'<?= wfMsg('wikiastats_wikians') ?>');">X</a></div>
		<b><a href="#wikians"><?= wfMsg('wikiastats_wikians') ?></a></b>
	</td>
	<td colspan="7" class="cb">
		<div class="hide"><a href="javascript:void(0);" title="<?= wfMsg('wikiastats_hide') ?>" onclick="javascript:visible_column(8,14,0,'<?= wfMsg('wikiastats_articles') ?>');">X</a></div>
		<b><a href="#articles"><?= wfMsg('wikiastats_articles') ?></a></b>
	</td>
	<td colspan="3" class="cb">
		<div class="hide"><a href="javascript:void(0);" title="<?= wfMsg('wikiastats_hide') ?>" onclick="javascript:visible_column(15,17,0,'<?= wfMsg('wikiastats_database') ?>');">X</a></div>
		<b><a href="#database"><?= wfMsg('wikiastats_database') ?></a></b>
	</td>
	<td colspan="5" class="cb">
		<div class="hide"><a href="javascript:void(0);" title="<?= wfMsg('wikiastats_hide') ?>" onclick="javascript:visible_column(18,22,0,'<?= wfMsg('wikiastats_links') ?>');">X</a></div>
		<b><a href="#links"><?= wfMsg('wikiastats_links') ?></a></b>
	</td>
	<td colspan="2" class="cb">
		<div class="hide"><a href="javascript:void(0);" title="<?= wfMsg('wikiastats_hide') ?>" onclick="javascript:visible_column(23,24,0,'<?= wfMsg('wikiastats_images') ?>');">X</a></div>
		<b><a href="#images"><?= wfMsg('wikiastats_images') ?></a></b>
	</td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb" rowspan="3">&nbsp;</td>
	<td colspan="5" class="cb"><?=wfMsg('wikiastats_months_edits')?></td>
	<td valign="middle" colspan="2" class="cb"><?=wfMsg('wikiastats_lifetime_editors')?></td>
	<td colspan="2" rowspan="2" class="cb"><?=wfMsg('wikiastats_count')?></td>
	<td valign="middle" rowspan="3" class="cb"><?=wfMsg('wikiastats_new_per_day')?></td>
	<td colspan="2" class="cb" rowspan="2" ><?=wfMsg('wikiastats_mean')?></td>
	<td colspan="2" class="cb" rowspan="2" ><?=wfMsg('wikiastats_largerthan')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_size')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_words')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_internal')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_interwiki')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_image')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_external')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_redirects')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_uploaded_images')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_with_links')?></td>
</tr>
<tr bgcolor="#ffeecc">
	<td colspan="3" class="cb"><?=wfMsg('wikiastats_main_namespace')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_other_namespace')?></td>
	<td class="cb" rowspan="2"><?=wfMsg('wikiastats_total')?></td>
	<td class="cb"><?=wfMsg('wikiastats_main_namespace')?></td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb"><?=wfMsg('wikiastats_total')?></td>
	<td class="cb">&gt;5</td>
	<td class="cb">&gt;100</td>
	<td class="cb" style="white-space:nowrap;"><?=lcfirst(wfMsg('wikiastats_username'))?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('wikistats_image_namespace')?></td>
	<td class="cb">&gt;10</td>
	<td class="cb"><?=wfMsg('wikiastats_official')?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('wikiastats_more_200_ch')?></td>
	<td class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td class="cb"><?=wfMsg('wikiastats_bytes')?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('size-kilobytes', 0.5)?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('size-kilobytes', 2)?></td>
</tr>
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
		#if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;

		if (empty($columnsData[$column]) || ($columnsData[$column] == 0)) {
			$out = "&nbsp;";
		} else {
			if ($column == 'date') {
				$class = "db";
				$dateArr = explode("-",$columnsData[$column]);
				$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
				$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
				if ($columnsData[$column] == $today) {
				    $stamp = (!empty($today_day)) ? $today_day : $stamp;
					$out = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(0), wfTimestamp(TS_MW, $stamp));
				}
			}
			elseif ($column == 'G')
				$out = sprintf("%0d", $columnsData[$column]);
			elseif ($column == 'K')
				$out = $wgLang->formatNum(sprintf("%0.1f", $columnsData[$column]));
			elseif ($column == 'L')
				$out = sprintf("%0.0f", $columnsData[$column]);
			elseif (($column == 'M') || ($column == 'N'))
				$out = sprintf("%0d%%", $columnsData[$column] * 100);
			elseif ($column == 'P') {
				if (intval($columnsData[$column]) > $GB)
					$out = wfMsg('size-gigabytes', $wgLang->formatNum(sprintf("%0.1f", intval($columnsData[$column])/$GB)));
				elseif (intval($columnsData[$column]) > $MB)
					$out = wfMsg('size-megabytes', $wgLang->formatNum(sprintf("%0.1f", intval($columnsData[$column])/$MB)));
				elseif ($columnsData[$column] > $KB)
					$out = wfMsg('size-kilobytes', $wgLang->formatNum(sprintf("%0.1f", intval($columnsData[$column])/$KB)));
				else
					$out = sprintf("%0d", intval($columnsData[$column]));
			} else {
				if (intval($columnsData[$column]) > $G)
					$out = sprintf("%s G", $wgLang->formatNum(sprintf("%0.1f", intval($columnsData[$column])/$G)));
				elseif (intval($columnsData[$column]) > $M)
					$out = sprintf("%s M", $wgLang->formatNum(sprintf("%0.1f", intval($columnsData[$column])/$M)));
				elseif ($columnsData[$column] > $K)
					$out = sprintf("%s K", $wgLang->formatNum(sprintf("%0.1f", intval($columnsData[$column])/$K)));
				else
					$out = sprintf("%0d", intval($columnsData[$column]));
			}
		}

?>
	<td class="<?= $class ?>" style="white-space:nowrap;"><?= $out ?></td>
<?
	}

	if ($date == $today) {
?>
</tr><tr>
<?
		$loop = 0;
		foreach ($columns as $column) {
			$loop++;
			#if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;
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
foreach ($monthlyStats as $date => $columnsData) {
	#---
	if ($columnsData['visible'] === 1) {
		$dateArr = explode("-", $date);
		$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
		$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));

?>
<tr>
	<td class="db" style="white-space:nowrap;"><?= $outDate ?></td>
<?
		$loop = 0;
		foreach ($columns as $column) {
			if ( in_array($column, array('date')) ) continue;
			$loop++;
			#---
			$out = $columnsData[$column];
			$class = "rb";
			/*if ( in_array($column, array('B','H','I','J','K')) ) {
				$out = "&nbsp;";
			} else*/
			if (empty($columnsData[$column]) || ($columnsData[$column] == 0)) {
				$out = "&nbsp;";
			} else {
				if ($columnsData[$column] < 0) {
					$out = "<font color=\"#800000\">".sprintf("%0.0f%%", $columnsData[$column])."</font>";
				} elseif (($columnsData[$column] > 0) && ($columnsData[$column] < 25)) {
					$out = "<font color=\"#555555\">".sprintf("+%0.0f%%", $columnsData[$column])."</font>";
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
<tr bgcolor="#ffeecc">
	<td class="cb" rowspan="3">&nbsp;</td>
	<td class="cb"><?=wfMsg('wikiastats_total')?></td>
	<td class="cb">&gt;5</td>
	<td class="cb">&gt;100</td>
	<td class="cb" style="white-space:nowrap;"><?=lcfirst(wfMsg('wikiastats_username'))?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('wikistats_image_namespace')?></td>
	<td class="cb" rowspan="2"><?=wfMsg('wikiastats_total')?></td>
	<td class="cb">&gt;10</td>
	<td class="cb"><?=wfMsg('wikiastats_official')?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('wikiastats_more_200_ch')?></td>
	<td valign="middle" rowspan="3" class="cb"><?=wfMsg('wikiastats_new_per_day')?></td>
	<td class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td class="cb"><?=wfMsg('wikiastats_bytes')?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('size-kilobytes', 0.5)?></td>
	<td class="cb" style="white-space:nowrap;"><?=wfMsg('size-kilobytes', 2)?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_edits')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_size')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_words')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_internal')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_interwiki')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_image')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_external')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_redirects')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_uploaded_images')?></td>
	<td rowspan="3" class="cb"><?=wfMsg('wikiastats_with_links')?></td>
</tr>
<tr bgcolor="#ffeecc">
	<td colspan="3" class="cb"><?=wfMsg('wikiastats_main_namespace')?></td>
	<td colspan="2" class="cb"><?=wfMsg('wikiastats_other_namespace')?></td>
	<td class="cb"><?=wfMsg('wikiastats_main_namespace')?></td>
	<td colspan="2" rowspan="2" class="cb"><?=wfMsg('wikiastats_count')?></td>
	<td colspan="2" class="cb" rowspan="2" ><?=wfMsg('wikiastats_mean')?></td>
	<td colspan="2" class="cb" rowspan="2" ><?=wfMsg('wikiastats_largerthan')?></td>
</tr>
<tr bgcolor="#ffeecc">
	<td colspan="5" class="cb"><?=wfMsg('wikiastats_months_edits')?></td>
	<td valign="middle" colspan="2" class="cb"><?=wfMsg('wikiastats_lifetime_editors')?></td>
</tr>
<tr bgcolor="#ffdead">
	<td class="cb"><b><?= ucfirst(wfMsg('wikiastats_date')) ?></b></td>
	<td colspan="7" class="cb">
		<b><a href="#wikians"><?= wfMsg('wikiastats_wikians') ?></a></b>
	</td>
	<td colspan="7" class="cb">
		<b><a href="#articles"><?= wfMsg('wikiastats_articles') ?></a></b>
	</td>
	<td colspan="3" class="cb">
		<b><a href="#database"><?= wfMsg('wikiastats_database') ?></a></b>
	</td>
	<td colspan="5" class="cb">
		<b><a href="#links"><?= wfMsg('wikiastats_links') ?></a></b>
	</td>
	<td colspan="2" class="cb">
		<b><a href="#images"><?= wfMsg('wikiastats_images') ?></a></b>
	</td>
</tr>
</table>
</div>

<!-- END OF MAIN STATISTICS TABLE -->
<!-- e:<?= __FILE__ ?> -->
