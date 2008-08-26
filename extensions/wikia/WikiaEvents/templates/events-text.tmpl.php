<!-- s:<?= __FILE__ ?> -->
<h2><?= $events_text ?></h2>
<form action="/index.php?title=Special:WikiEvents&amp;action=type" method="post" name="eventEdit" id="eventEdit">
<input type="hidden" name="add" value="1">
<div style="display: block;">
<fieldset>
	<legend style="margin-left: 2px width:100%;"> <?= $eventtpltext ?></legend>
	<div style="display: block;">
	<table cellpadding="4" cellspacing="0" border="0" id="wk-select-table" name="wk-select-table">
	<tr>
		<td><?= $event_name ?></td>
		<td style="width:100%;" align="left">
		<select name="wk-select-event-name" id="wk-select-event-name" style="font-size:10px; width:30em;">
			<option value="0"><?= $selectevent ?></option>
<?php 
if (!empty($event_select_form))
{
	foreach ($event_select_form as $ev_id => $event)
	{
?>
			<option value="<?= $ev_id ?>"><?= $event['name'] ?></option>
<?
	}	
}
?>
		</select>
		</td>
		<td id="eventMsg_select"></td>
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
