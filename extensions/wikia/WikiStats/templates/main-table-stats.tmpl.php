<div class="clear"></div>
<div class="clear" style="font-size:7.7pt;height:15px;margin:20px 0px 0px;">
	<a href="#definitions"><?=wfMsg("wikistats_see_definitions")?></a>
</div>
<div id="ws-main-table-stats" class="ws-main-table">
<a name="ws-mainstats"></a>
<table align="left" cellspacing="0" cellpadding="1" border="1" class="TablePager" id="ws-main-table-result">
<caption></caption>
<thead>
<tr>
	<th rowspan="2"><b><?= ucfirst(wfMsg('wikistats_date')) ?></b></th>
	<th colspan="4"><b><a href="#wikians"><?= wfMsg('wikistats_wikians') ?></a></b></th>
	<th colspan="2"><b><a href="#articles"><?= wfMsg('wikistats_articles') ?></a></b></th>
	<th colspan="2"><b><a href="#media"><?= wfMsg('wikistats_media') ?></a></b></th>
	<th colspan="8"><b><a href="#media"><?= wfMsg('wikistats_per_namespace') ?></a></b></th>

</tr>
<tr>
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_content')?></th>
	<th><?=wfMsg('wikistats_edits')?> &gt;5</th>
	<th><?=wfMsg('wikistats_edits')?> &gt;100</th>
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_edits')?></th>
	<th><?=wfMsg('wikistats_images')?></th>
	<th><?=wfMsg('wikistats_video')?></th>
	<th><?=wfMsg('wikistats_article_created')?></th>
	<th><?=wfMsg('wikistats_article_talk')?></th>
	<th><?=wfMsg('wikistats_blog_created')?></th>
	<th><?=wfMsg('wikistats_blog_comment')?></th>
	<th><?=wfMsg('wikistats_photo_new')?></th>
	<th><?=wfMsg('wikistats_video_new')?></th>
	<th><?=wfMsg('wikistats_user_page_edits')?></th>
	<th><?=wfMsg('wikistats_user_talk_edits')?></th>
</tr>
</thead>
<tbody>
<?php $cols = array(); if (!empty($data)) { foreach ($data as $date => $columns) { ?>
<tr id="ws-table-row-<?=$date?>">
<?php 
	$out = "";
	$cols = array();
	foreach ( $columns as $column => $out ) {
		if (in_array($column, array('F', 'H', 'J'))) continue;
	
		$__number = $out;
		$row = "td";
		if (empty($out) || ($out === 0)) {
			$out = "&nbsp;";
		} else {
			if ($column == 'date' ) { 
				$stamp = mktime(23, 59, 59, substr($out, 4, 2), 1, substr($out, 0, 4));
				if ( $out == $today ) {
					$stamp = ( !empty($today_day) ) ? $today_day : $stamp;
					$out = $wgLang->sprintfDate( $mStats->dateFormat(0), wfTimestamp(TS_MW, $stamp));
				} else {
					$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
				}
				$row = "th";
				$column = "&nbsp;";
			} else {
				$out = $wgContLang->formatNum($out);
			}
		}
		$cols[] = $column;
		$style = "";
?>
	<<?=$row?> style="white-space:nowrap;<?=$style?>" title="<?= $column ?> - <?=$__number?>"><?= $out ?></<?=$row?>>
<?php		
	}
?>
</tr>
<?php } } ?>
</tbody>
<!-- column numbers -->
<tfoot>
<tr><th><?= implode('</th><th>', $cols) ?></th></tr>
<!-- diffs -->
<?php 
$loop = 0;
foreach ($diffData as $date => $columns) { 
	$loop++;
	#-- don't display
	if ( empty($userIsSpecial) && (is_array($wgStatsExcludedNonSpecialGroup)) && (in_array($loop, $wgStatsExcludedNonSpecialGroup) )) continue;

	$stamp = mktime(23, 59, 59, substr($date, 4, 2), 1, substr($date, 0, 4));
	$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
?>
<tr>
	<th><?=$out?></th>
<?php
	foreach ($columns as $column => $out) {
		if (in_array($column, array('date', 'F', 'H', 'J'))) continue;

		if ( empty($out) || ($out == 0) ) {
			$out = "&nbsp;";
		} else {
			$out = $mStats->diffFormat($out);
		}
?>		
	<th style="white-space:nowrap;"><?= $out ?></th>
<?php	
	}
?>		
</tr>
<?php 
}
?>
<tr>
	<th rowspan="2"><b><?= ucfirst(wfMsg('wikistats_date')) ?></b></th>
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_content')?></th>
	<th>&gt;5</th>
	<th>&gt;100</th>
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_edits')?></th>
	<th><?=wfMsg('wikistats_images')?></th>
	<th><?=wfMsg('wikistats_video')?></th>
	<th><?=wfMsg('wikistats_article_created')?></th>
	<th><?=wfMsg('wikistats_article_talk')?></th>
	<th><?=wfMsg('wikistats_blog_created')?></th>
	<th><?=wfMsg('wikistats_blog_comment')?></th>
	<th><?=wfMsg('wikistats_photo_new')?></th>
	<th><?=wfMsg('wikistats_video_new')?></th>
	<th><?=wfMsg('wikistats_user_page_edits')?></th>
	<th><?=wfMsg('wikistats_user_talk_edits')?></th>
</tr>	
<tr>
	<th colspan="2"><b><a href="#wikians"><?= wfMsg('wikistats_wikians') ?></a></b></th>
	<th colspan="2"><b><a href="#articles"><?= wfMsg('wikistats_articles') ?></a></b></th>
	<th colspan="4"><b><a href="#media"><?= wfMsg('wikistats_media') ?></a></b></th>
	<th colspan="8"><b><a href="#media"><?= wfMsg('wikistats_per_namespace') ?></a></b></th>
</tr>
</tfoot>
</table>
</div>
<div id="ws_visualize"></div>
<!-- END OF MAIN STATISTICS TABLE -->
