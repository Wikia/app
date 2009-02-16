<!-- s:<?= __FILE__ ?> -->
<div class="dt-task-params">
<h2><?=wfMsg('daemonloader_3step')?></h2>
<h4><?=wfMsg('daemonloader_configtaskparams')?></h4>
<table class="TablePager">
<tr>
	<th valign="middle"><?=wfMsg('daemonloader_startdate')?></th>
	<td valign="middle"><input type="text" name="dt_start" id="dt_start" value="" /> (YYYYMMDD)</td>
</tr>
<tr>
	<th valign="middle"><?=wfMsg('daemonloader_enddate')?></th>
	<td valign="middle"><input type="text" name="dt_end" id="dt_end" value="" /> (YYYYMMDD)</td>
</tr>
<tr>
	<th valign="middle"><?=wfMsg('daemonloader_frequency')?></th>
	<td valign="middle">
		<select name="dt_frequency" id="dt_frequency">
			<option value="day"><?=wfMsg('daemonloader_day')?></option>
			<option value="week"><?=wfMsg('daemonloader_week')?></option>
			<option value="month"><?=wfMsg('daemonloader_month')?></option>
		</select>
	</td>
</tr>
<tr>
	<th valign="middle"><?=wfMsg('daemonloader_emails')?></th>
	<td valign="middle" style="padding:1px 10px;">
		<div><?=wfMsg('daemonloader_emails_info')?></div>
		<div><textarea name="dt_emails" cols="25" rows="5"></textarea></div>
	</td>
</tr>
</table>
</div>
<hr />
<div style="text-align:right">
	<input type="submit" name="dt_submit" id="dt_submit" value="<?=wfMsg('save')?>" />
	<input type="reset" name="dt_cancel" id="dt_cancel" value="<?=wfMsg('cancel')?>" />
</div>
<!-- e:<?= __FILE__ ?> -->
