<!-- MAIN STATISTICS NOTES -->
<div id="wk-stats-legend" style="display:<?=(!empty($show_charts))?"none":"block"?>;">
<a name="definitions"></a>
<fieldset>
<legend class="legend-subtitle"><?=wfMsg('wikiastats_statistics_legend')?></legend>
<?= wfMsg('wikiastats_note_mainstats') ?><br />
<span class="wk-stats-legend-values"><font color="#800000"><?= wfMsg('wikiastats_history_mainstats_value1'); ?></font></span>
<span class="wk-stats-legend-values"><font color="#555555"><?= wfMsg('wikiastats_history_mainstats_value2'); ?></font></span>
<span class="wk-stats-legend-values"><font color="#008000"><?= wfMsg('wikiastats_history_mainstats_value3'); ?></font></span>
<span class="wk-stats-legend-values"><font color="#008000"><u><?= wfMsg('wikiastats_history_mainstats_value4'); ?></u></font></span>
<br />
<div id="wk-stats-legend-columns">
<?php
$i = 0; $loop = 0;
foreach ($columns as $column) {
	if ($column == "date") continue;
	$loop++;
	if ($i == 0) {
?>
<span class="wk-column-group"><?= wfMsg("wikiastats_wikians") ?><a name="wikians"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 7) {
?>
<span class="wk-column-group"><?= wfMsg("wikiastats_articles") ?><a name="articles"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 14) {
?>
<span class="wk-column-group"><?= wfMsg("wikiastats_database") ?><a name="database"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 17) {
?>
<span class="wk-column-group"><?= wfMsg("wikiastats_links") ?><a name="links"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 22) {
?>
<span class="wk-column-group"><?= wfMsg("wikiastats_images") ?><a name="images"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	}
	$i++;
?>
<span id="wk-column-<?=$column?>"><?=$column?>: <?= wfMsg("wikiastats_mainstats_column_".$column) ?></span><br />
<?
}
?>
</div>
</fieldset>
</div>
<!-- END OF MAIN STATISTICS NOTES -->
