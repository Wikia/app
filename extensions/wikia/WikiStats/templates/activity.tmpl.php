<div id="ws-breakdown">
	<div id="ws-wikians-title" style="clear:left;width:auto;float:left">
		<div valign="middle">
			<span><?= (isset($anons)) ? wfMsg('wikistats_anon_wikians') :  wfMsg('wikistats_active_absent_wikians') ?></span>
		</div>	
		<span class="small" style="padding:0"><?= wfMsg('wikistats_active_wikians_subtitle') ?></span>
	</div>
	<div id="ws-progress-wikians-bar"></div>
	<div class="clear">&nbsp;</div>
	<div style="text-align:left;" id="wk-select-month-wikians-div"><?= wfMsg("wikistats_active_wikians_date") ?>
		<span class="wk-select-class"><select id="ws-breakdown-<?= (isset($anons)) ? "anons-" : "" ?>month" style="text-align:left; font-size:11px;">
<?php for ($i = 1; $i <= 6; $i++) {
	$month_name = ($i == 1) ? wfMsg('wikistats_active_month') : wfMsg('wikistats_active_months');
	#$month_name = ($i == 0) ? wfMsg('wikistats_now') : $month_name;
	$selected = "";
?>
		<option <?= $selected ?> value="<?= $i ?>"><?= ( $i > 0 ) ? $i . " " .$month_name : $month_name ?></option>
<?php } ?>	
		</select>, 
		<?= (isset($anons)) ? wfMsg("wikistats_number_anons") : wfMsg("wikistats_number_editors") ?>
		<select id="ws-breakdown-<?= (isset($anons)) ? "anons-" : "" ?>limit" style="text-align:left; font-size:11px;">
<?php foreach ( array(10, 25, 50, 100) as $value ) { ?>
		<option value="<?= $value ?>"><?= $value ?></option>
<?php } ?>		
		</select>
		</span>
		<span class="wk-select-class">
			<input type="button" id="ws-breakdown-<?= (isset($anons)) ? "anons-" : "" ?>btn" value="<?= wfMsg('wikistats_showstats_btn') ?>" />
			<!--<input type="button" id="ws-breakdown-<?= (isset($anons)) ? "anons-" : "" ?>xls-btn" value="<?= wfMsg('wikistats_export_xls') ?>" /> -->
		</span>
	</div>
	<div id="ws-breakdown-data<?=(isset($anons)) ? $anons : 0?>"></div>
</div>
