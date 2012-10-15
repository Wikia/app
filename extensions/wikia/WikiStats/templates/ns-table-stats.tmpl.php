<div class="clear"></div>
<?php if (!empty($data)) : ?>
<div id="ws-main-table-stats" class="ws-main-table" style="width:100%;overflow:auto;">
<a name="ws-mainstats"></a>
<table align="left" cellspacing="0" cellpadding="1" border="1" class="TablePager" id="ws-main-table-result" style="width:200px">
<caption></caption>
<thead>
<tr>
	<th rowspan="2"><b><?= ucfirst(wfMsg('wikistats_date')) ?></b></th>
<?php  foreach ( $tableTitle as $ns => $value ) : ?>	
	<th colspan="3"><b><a href="#namespace_<?=$ns?>"><?= $value ?></a></b></th>
<?php endforeach ?>	
</tr>
<tr>
<?php foreach ( $tableTitle as $ns => $value ) : ?>	
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_new_per_day')?></th>
	<th><?=wfMsg('wikistats_edits')?></th>
<?php endforeach ?>	
</tr>
</thead>
<tbody>
<?php $cols = array(); foreach ($data as $date => $columns) { ?>
<tr id="ws-table-row-<?=$date?>">
<?
	$stamp = mktime(23, 59, 59, substr($date, 4, 2), 1, substr($date, 0, 4));
	if ( $date == $today ) {
		$stamp = ( !empty($today_day) ) ? $today_day : $stamp;
		$out = $wgLang->sprintfDate( $mStats->dateFormat(0), wfTimestamp(TS_MW, $stamp));
	} else {
		$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
	}
	$row = "th";
	$column = "&nbsp;";
?>
<<?=$row?> style="white-space:nowrap;" title="<?=$out?>"><?= $out ?></<?=$row?>>	
<?php 
	$out = ""; $cols = array();
	foreach ( $tableTitle as $ns => $value ) {
		if ( !isset( $columns[$ns] ) ) {
			foreach ( array('A','B','C') as $c ) {
				$columns[$ns][$c] = 0;
			}
		}
		foreach ( $columns[$ns] as $column => $out ) {
			if ( $column == 'date' ) continue;
			$row = "td";
			if (empty($out) || ($out === 0)) {
				$out = "&nbsp;";
			} else {
				$out = $wgContLang->formatNum($out);
			}
			$cols[] = $column;
?>			
<<?=$row?> style="white-space:nowrap;" title="<?=$column?>"><?= $out ?></<?=$row?>>
<?php
		}
?>
	
<?php		
	}
?>
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr>
	<th rowspan="2"><b><?= ucfirst(wfMsg('wikistats_date')) ?></b></th>
<?php foreach ( $tableTitle as $ns => $value ) : ?>	
	<th><?=wfMsg('wikistats_total')?></th>
	<th><?=wfMsg('wikistats_new_per_day')?></th>
	<th><?=wfMsg('wikistats_edits')?></th>
<?php endforeach ?>	
</tr>
<tr>
<?php  foreach ( $tableTitle as $ns => $value ) : ?>	
	<th colspan="3"><b><a href="#namespace_<?=$ns?>"><?= $value ?></a></b></th>
<?php endforeach ?>	
</tr>
</tfoot>
</table>
</div>
<div id="ws_visualize"></div>
<?php endif ?>
<!-- END OF NAMESPACE STATISTICS TABLE -->
