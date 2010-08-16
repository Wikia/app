<div id="ws-breakdown">
	<form id="ws-form" action="<?= $mTitle->getLocalUrl() ?>/<?=$mAction?>" method="get">
	<div id="ws-wikians-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<span><?= (isset($anons)) ? wfMsg('wikistats_anon_wikians') :  wfMsg('wikistats_active_absent_wikians') ?></span>
		</div>	
		<span class="small" style="padding:0"><?= wfMsg('wikistats_active_wikians_subtitle') ?></span>
	</div>
	<div id="ws-progress-wikians-bar"></div>
	<div class="clear">&nbsp;</div>
	<div style="text-align:left;" id="wk-select-month-wikians-div"><?= wfMsg("wikistats_active_wikians_date") ?>
		<span class="wk-select-class"><select id="ws-breakdown-month" name="wsmonth" style="text-align:left; font-size:11px;">
<?php for ($i = 1; $i <= 6; $i++) {
	$month_name = ($i == 1) ? wfMsg('wikistats_active_month') : wfMsg('wikistats_active_months');
	#$month_name = ($i == 0) ? wfMsg('wikistats_now') : $month_name;
	$selected = ( $mMonth == $i ) ? "selected=\"selected\"" : "";
?>
		<option <?= $selected ?> value="<?= $i ?>"><?= ( $i > 0 ) ? $i . " " .$month_name : $month_name ?></option>
<?php } ?>	
		</select>, 
		<?= (isset($anons)) ? wfMsg("wikistats_number_anons") : wfMsg("wikistats_number_editors") ?>
		<select id="ws-breakdown-limit" name="wslimit" style="text-align:left; font-size:11px;">
<?php 
	foreach ( array(10, 25, 50, 100) as $value ) { 
		$sel = ( $value == $mLimit ) ? "selected=\"selected\"" : "";
?>
		<option <?=$sel?> value="<?= $value ?>"><?= $value ?></option>
<?php } ?>		
		</select>
		</span>
		<span class="wk-select-class">
			<input type="submit" id="ws-breakdown-btn" value="<?= wfMsg('wikistats_showstats_btn') ?>" />
			<!--<input type="button" id="ws-breakdown-<?= (isset($anons)) ? "anons-" : "" ?>xls-btn" value="<?= wfMsg('wikistats_export_xls') ?>" /> -->
		</span>
	</div>
	</form>
	<div id="ws-breakdown-data<?=(isset($anons)) ? $anons : 0?>"><?=$data?></div>
</div>
