<!-- s:<?= __FILE__ ?> -->
<div class="dt-task-params">
<style>
.dt-task-params th { 
	padding:2px 0px 2px 10px;
	font-family: Arial;
	font-size: 1.1em;
	font-weight: normal;
	text-align: left;
	font-style: italic;
}
.dt-task-params td { 
	padding:2px 0px 2px 35px;
	font-size: '0.9em';
	font-weight: 'normal';
	text-align: left;
}
</style>
<h2><?=wfMsg('daemonloader_3step')?></h2>
<h4><?=wfMsg('daemonloader_configtaskparams')?></h4>
<table class="dt-task-params">
<tr><th valign="middle"><?=wfMsg('daemonloader_period')?> (<?=wfMsg('daemonloader_dateformat')?>)</th></tr>	
<tr><td valign="middle"><input type="text" name="dt_start" id="dt_start" value="<?=date("Ymd", mktime(0,0,0,date("m"),date("d")+1,date("Y")))?>" size="8"/> : <input type="text" name="dt_end" id="dt_end" value="<?=date("Ymd", mktime(0,0,0,date("m")+6,date("d"),date("Y")))?>" size="8" /></td></tr>
<tr><th valign="middle"><?=wfMsg('daemonloader_frequency')?></th></tr>
<tr><td valign="middle">
	<select name="dt_frequency" id="dt_frequency">
	<option value="day"><?=wfMsg('daemonloader_day')?></option>
	<option value="week"><?=wfMsg('daemonloader_week')?></option>
	<option value="month"><?=wfMsg('daemonloader_month')?></option>
</select></td>
</tr>
<tr><th valign="middle"><?=wfMsg('daemonloader_emails')?></th></tr>
<tr><td valign="middle"><div><?=wfMsg('daemonloader_emails_info')?></div><div><textarea name="dt_emails" cols="25" rows="5" id="dt_emails"></textarea></div></td></tr>
</table>
</div>
<hr />
<div style="text-align:right">
	<input type="submit" name="dt_submit" id="dt_submit" value="<?=wfMsg('save')?>" />
	<input type="reset" name="dt_cancel" id="dt_cancel" value="<?=wfMsg('cancel')?>" />
</div>
<!-- e:<?= __FILE__ ?> -->
