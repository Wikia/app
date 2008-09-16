<!-- MAIN STATISTICS NOTES -->
<div id="wk-stats-legend">
<a href="#wslegend" class="big"></a>
<fieldset>
<legend class="legend-subtitle"><?=wfMsg('wikiastats_statistics_legend')?></legend>
<?= wfMsg('wikiastats_note_mainstats') ?><br />
<span id="wk-stats-legend-values"><font color="#800000"><?= wfMsg('wikiastats_history_mainstats_value1'); ?></font></span>
<span id="wk-stats-legend-values"><font color="#555555"><?= wfMsg('wikiastats_history_mainstats_value2'); ?></font></span>
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
<span id="wk-column-group"><?= wfMsg("wikiastats_wikians") ?><a name="wikians"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 7) {
?>
<span id="wk-column-group"><?= wfMsg("wikiastats_articles") ?><a name="articles"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 14) {
?>
<span id="wk-column-group"><?= wfMsg("wikiastats_database") ?><a name="database"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 17) {
?>
<span id="wk-column-group"><?= wfMsg("wikiastats_links") ?><a name="links"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 22) {
?>
<span id="wk-column-group"><?= wfMsg("wikiastats_images") ?><a name="images"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	}
	$i++;
?>
<span id="wk-column-<?=$column?>"><?=$column?>: <?= wfMsg("wikiastats_mainstats_column_".$column) ?></span><br />
<?
}
?>
</div>
</div>
</fieldset>
<!-- END OF MAIN STATISTICS NOTES -->
