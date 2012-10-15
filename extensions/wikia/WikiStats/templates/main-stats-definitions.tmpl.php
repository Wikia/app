<!-- MAIN STATISTICS NOTES -->
<div class="clear"></div>
<div id="wk-stats-legend" style="display: block">
<a name="definitions"></a>
<fieldset>
<legend class="legend-subtitle"><?=wfMsg('wikistats_statistics_legend')?></legend>
<?= wfMsg('wikistats_note_mainstats') ?><br />
<span class="wk-stats-legend-values" style="color:#800000;"><?= wfMsg('wikistats_history_mainstats_value1'); ?></span>
<span class="wk-stats-legend-values" style="color:#555555;"><?= wfMsg('wikistats_history_mainstats_value2'); ?></span>
<span class="wk-stats-legend-values" style="color:#008000"><?= wfMsg('wikistats_history_mainstats_value3'); ?></span>
<span class="wk-stats-legend-values" style="color:#0000FF"><?= wfMsg('wikistats_history_mainstats_value4'); ?></span>
<br />
<?= wfMsg('wikistats_nbr_format') ?><br />
<span class="wk-stats-legend-values"><font color="#555555"><?= wfMsg('wikistats_nbr_kilo'); ?></font></span>
<span class="wk-stats-legend-values"><font color="#555555"><?= wfMsg('wikistats_nbr_mega'); ?></font></span>
<span class="wk-stats-legend-values"><font color="#555555"><?= wfMsg('wikistats_nbr_giga'); ?></font></span>
<br />
<div id="wk-stats-legend-columns">
<?php
$i = 0; $loop = 0;
foreach ($columns as $column) {
	if ($column == "date") continue;
	$loop++;
	if ($i == 0) {
?>
<span class="wk-column-group"><?= wfMsg("wikistats_wikians") ?><a name="wikians"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 4) {
?>
<span class="wk-column-group"><?= wfMsg("wikistats_articles") ?><a name="articles"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} elseif ($i == 7) {
?>
<span class="wk-column-group"><?= wfMsg("wikistats_media") ?><a name="media"></a>&nbsp;<b><a href="#mainstats" class="big">&uarr;</a></b></span><br />
<?
	} 
	$i++;
?>
<span id="wk-column-<?=$column?>"><?=$column?>: <?= wfMsg("wikistats_column_".$column) ?></span><br />
<?
}
?>
</div>
</fieldset>
</div>
<!-- END OF MAIN STATISTICS NOTES -->
