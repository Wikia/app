<!-- s:<?= __FILE__ ?> -->
<h2><?= $events ?></h2>
<form action="/index.php?title=Special:WikiEvents&amp;action=events" method="post" name="eventEdit" id="eventEdit">
<input type="hidden" name="add" value="1">
<div style="display: block;">
<fieldset>
	<legend style="margin-left: 2px width:100%;"> <?= $edit_txt ?></legend>
	<div style="display: block;">
	<table cellpadding="4" cellspacing="0" border="0">
	<tr>
		<td><?= $event_name ?></td>
		<td style="width: 150px;">
			<input type="text" style="padding: 2px; font-size:10px; text-color: blue; width: 20em;" name="eventName" id="eventName">
		</td>
	</tr>	
	<tr>
		<td><?= $event_desc ?></td>
		<td style="width: 300px;">
			<input type="text" style="padding: 2px; font-size:10px; text-color: blue; width: 40em;" name="eventDesc" id="eventDesc">
		</td>
	</tr>	
	<tr>
		<td><?= $event_active ?></td>
		<td>
			<input type="checkbox" style="padding: 2px; font-size:10px; " name="eventActive" id="eventctive">
		</td>
	</tr>	
	<tr>
		<td><?= $hookname ?></td>
		<td>
			<input type="text" style="padding: 2px; font-size:10px; text-color: blue; width: 40em;" name="wk-select-hook" id="wk-select-hook">
		</td>
	</tr>	
	<tr>
		<td><div id="wk-hook-name" style="display:none;"><?= $hookname ?></div></td>
	</tr>	
	<tr>
		<td>&nbsp;</td>
		<td align="right"><input type="submit" name="saveEventBtn" id="saveEventBtn" style="font-size:10px;" value="<?= $savebtn ?>"></td>
	</tr>		
	</table>
	</div>
</fieldset>
</div>
</form>
<div>
<fieldset>
	<legend style="margin-left: 2px width:100%;"> <?= $select_txt ?></legend>
	<div style="display: block;" id="selectDiv">
	<table cellpadding="3" cellspacing="2" border="0" style="font-size:10px;">
	<tr>
		<td class="hd" style="font-weight: bold;">#</td>
		<td class="hd" style="font-weight: bold;"><?= $tableHdr[0] ?></td>
		<td class="hd" style="font-weight: bold;"><?= $tableHdr[1] ?></td>
		<td class="hd" style="font-weight: bold;"><?= $tableHdr[2] ?></td>
		<td class="hd" style="font-weight: bold;"><?= $tableHdr[3] ?></td>
		<td class="hd" style="font-weight: bold;"></td>
		<td class="hd" style="font-weight: bold;"></td>
	</tr>	

<?php 
if (!empty($event_select_form))
{
	$loop = 1;
	foreach ($event_select_form as $ev_id => $event)
	{
?>
	<tr>
		<td class="left_links" valign="middle"><?= $loop ?></td>
		<td class="right_links" id="edtEvent_<?= $ev_id ?>">
			<a href="javascript:void(0)" style="margin-left: 3px;" onClick="wikiaSelectEvent( '<?= $baseurl ?>', '<?= $ev_id ?>', '<?= $savebtn ?>'); return false;"><?= $event['name'] ?></a>
		</td>
		<td class="right_links" id="edtEventDesc_<?= $ev_id ?>">
			<?= $event['desc'] ?>
		</td>
		<td class="right_links" id="edtEventHook_<?= $ev_id ?>">
			<?= $event['hook'] ?>
		</td>
		<td class="right_links" id="edtEventActive_<?= $ev_id ?>">
			<a href="javascript:void(0)" style="margin-left: 3px;" onClick="wikiaSetActiveEvent( '<?= $ev_id ?>' ); return false;"><img src="/extensions/wikia/WikiaEvents/images/<?= $event['active'] ?>.gif" border="0" /></a>
		</td>
		<td class="left_links" id="actionEvent_<?= $ev_id ?>" nowrap></td>
		<td class="left_links" id="actionEventImg_<?= $ev_id ?>" nowrap></td>
	</tr>	
<?
		$loop++;
	}	
}
?>
	</table>
	</div>	
</fieldset>
</div>
<!-- e:<?= __FILE__ ?> -->
