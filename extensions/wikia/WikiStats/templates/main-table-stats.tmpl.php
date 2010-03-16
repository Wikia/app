<div class="clear"></div>
<div class="clear" style="font-size:7.7pt;height:15px;">
	<a href="#definitions"><?=wfMsg("wikistats_see_definitions")?></a>
</div>
<div id="ws-main-table-stats" class="ws-main-table">
<a name="ws-mainstats"></a>
<table align="left" cellspacing="0" cellpadding="1" border="1" class="TablePager" id="ws-main-table-result">
<caption></caption>
<thead>
<tr>
	<th rowspan="4"><b><?= ucfirst(wfMsg('wikistats_date')) ?></b></th>
	<th colspan="8"><b><a href="#wikians"><?= wfMsg('wikistats_wikians') ?></a></b></th>
	<th colspan="5"><b><a href="#articles"><?= wfMsg('wikistats_articles') ?></a></b></th>
	<th colspan="4"><b><a href="#media"><?= wfMsg('wikistats_media') ?></a></b></th>
</tr>
<tr>
	<th colspan="5"><?=wfMsg('wikistats_lifetime_editors')?></th>
	<th colspan="3"><?=wfMsg('wikistats_months_edits')?></th>
	<th rowspan="3"><?=wfMsg('wikistats_total')?></th>
	<th rowspan="3"><?=wfMsg('wikistats_new_per_day')?></th>
	<th rowspan="3"><?=wfMsg('size-kilobytes', 0.5)?></th>
	<th rowspan="3"><?=wfMsg('wikistats_edits')?></th>
	<th rowspan="3"><?=wfMsg('wikistats_words')?></th>
	<th colspan="2"><?=wfMsg('wikistats_images')?></th>
	<th colspan="2"><?=wfMsg('wikistats_video')?></th>
</tr>
<tr>
	<th rowspan="2"><?=wfMsg('wikistats_total')?></th>
	<th colspan="2"><?=wfMsg('wikistats_namespaces')?></th>
	<th colspan="2"><?=wfMsg('wikistats_edits')?></th>
	<th colspan="3"><?=wfMsg('wikistats_namespaces')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_links')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_uploaded_images')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_video_embeded')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_uploaded_images')?></th>
</tr>
<tr>
	<th><?=wfMsg('wikistats_content')?></th>
	<th><?=wfMsg('wikistats_userns')?></th>
	<th>&gt;5</th>
	<th>&gt;100</th>
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_content')?></th>
	<th><?=wfMsg('wikistats_userns')?></th>
</tr>
</thead>
<tbody>
<?php $cols = array(); if (!empty($data)) { foreach ($data as $date => $columns) { ?>
<tr id="ws-table-row-<?=$date?>">
<?php 
	$out = ""; $cols = array();
	foreach ( $columns as $column => $out ) {
		$__number = $out;
		$row = "td";
		if (empty($out) || ($out === 0)) {
			$out = "&nbsp;";
		} else {
			switch ($column) {
				case 'date': 
					$stamp = mktime(23, 59, 59, substr($out, 4, 2), 1, substr($out, 0, 4));
					if ( $out == $today ) {
						$stamp = ( !empty($today_day) ) ? $today_day : $stamp;
						$out = $wgLang->sprintfDate( $mStats->dateFormat(0), wfTimestamp(TS_MW, $stamp));
					} else {
						$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
					}
					$row = "th";
					$column = "&nbsp;";
					break;
				case 'K' : # percent of articles > 0.5 kB
					$out = $mStats->numberFormat( $columns['I'] ? (100*$out)/$columns['I'] : 0, "%0d%%" ); 
					break;
				default: 
					$out = $mStats->numberFormat( $out, "%0.1f" ); 
					break;
			}
		}
		$cols[] = $column;
?>
	<<?=$row?> style="white-space:nowrap;" title="<?=$__number?>"><?= $__number ?></<?=$row?>>
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
	#-- not visible
	if ( empty($columns['visible']) ) continue;

	$stamp = mktime(23, 59, 59, substr($date, 4, 2), 1, substr($date, 0, 4));
	$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
?>
<tr>
	<th><?=$out?></th>
<?php
	foreach ($columns as $column => $out) {
		if ( $column == 'visible' ) continue;
		if ( empty($out) || ($out == 0) || ( $out > 100 ) ) {
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
	<th rowspan="4"><b><?= ucfirst(wfMsg('wikistats_date')) ?></b></th>
	<th rowspan="2"><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_content')?></th>
	<th><?=wfMsg('wikistats_userns')?></th>
	<th>&gt;5</th>
	<th>&gt;100</th>
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_content')?></th>
	<th><?=wfMsg('wikistats_userns')?></th>
	<th rowspan="3"><?=wfMsg('wikistats_total')?></th>
	<th rowspan="3"><?=wfMsg('wikistats_new_per_day')?></th>
	<th rowspan="3"><?=wfMsg('size-kilobytes', 0.5)?></th>
	<th rowspan="3"><?=wfMsg('wikistats_edits')?></th>
	<th rowspan="3"><?=wfMsg('wikistats_words')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_links')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_uploaded_images')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_video_embeded')?></th>
	<th rowspan="2"><?=wfMsg('wikistats_uploaded_images')?></th>
</tr>
<tr>
	<th colspan="2"><?=wfMsg('wikistats_namespaces')?></th>
	<th colspan="2"><?=wfMsg('wikistats_edits')?></th>
	<th colspan="3"><?=wfMsg('wikistats_namespaces')?></th>
</tr>
<tr>
	<th colspan="5"><?=wfMsg('wikistats_lifetime_editors')?></th>
	<th colspan="3"><?=wfMsg('wikistats_months_edits')?></th>
	<th colspan="2"><?=wfMsg('wikistats_images')?></th>
	<th colspan="2"><?=wfMsg('wikistats_video')?></th>
</tr>
<tr>
	<th colspan="8"><b><a href="#wikians"><?= wfMsg('wikistats_wikians') ?></a></b></th>
	<th colspan="5"><b><a href="#articles"><?= wfMsg('wikistats_articles') ?></a></b></th>
	<th colspan="4"><b><a href="#media"><?= wfMsg('wikistats_media') ?></a></b></th>
</tr>
</tfoot>
</table>
</div>
<div id="ws_visualize"></div>
<script>
$(function() {
	var thead = $('#ws-main-table-result').children('thead').children('td');
	var rows = $('#ws-main-table-result').children('tr');
	var cols = $('#ws-main-table-result').children('tfoot').children('td');

	$().log(rows);

	rows.each(function(i) {
		var row = $(this).clone();
		var table = $('<table>');
		table.append('<caption>').html('i chuj');
		table.append('<thead>').append(thead);
		
		oThead = table.insertRow();
		oThead thead
		
		table.append(row).appendTo('body');
		table.attr('id', 'fuck');
		$().log(table);
		return false;
	});

	$('table#fuck').visualize();
});
</script>
<!-- END OF MAIN STATISTICS TABLE -->
