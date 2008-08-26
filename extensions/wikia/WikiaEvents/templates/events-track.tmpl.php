<!-- s:<?= __FILE__ ?> -->
<h2><?= $events_text ?></h2>
<form action="/index.php?title=Special:WikiEvents&amp;action=track" method="post" name="eventTrack" id="eventTrack">
<div style="display: block;">
<fieldset>
	<legend style="margin-left: 2px width:100%;"> <?= $eventtpltext ?></legend>
	<div style="display: block;">
	<table cellpadding="4" cellspacing="4" border="0" id="wk-select-table" name="wk-select-table">
	<tr>
		<td><?= $event_name ?></td>
		<td style="width:70%;" align="left">
		<select name="wk_select_event_name" id="wk_select_event_name" style="font-size:10px; width:30em;">
			<option value="0"><?= $selectevent ?></option>
<?php 
if (!empty($event_select_form))
{
	foreach ($event_select_form as $ev_id => $event)
	{
		$selected = ($ev_id == $select_event) ? "selected" : "";
?>
			<option value="<?= $ev_id ?>" <?= $selected ?>><?= $event['name'] ?></option>
<?
	}	
}
?>
		</select>
		</td>
		<td id="eventMsg_select"><input type="submit" value="Go" style="font-size:10px; width:5em;"></td>
	</tr>
	<tr>
	<td colspan=3 id="showTextValues"></td>
	</tr>
	</table>
	</div>
</fieldset>
</div>
</form>
<!-- e:<?= __FILE__ ?> -->
