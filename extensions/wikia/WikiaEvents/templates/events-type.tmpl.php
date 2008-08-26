<!-- s:<?= __FILE__ ?> -->
<h2><?= $events_type ?></h2>
<form action="/index.php?title=Special:WikiEvents&amp;action=type" method="post" name="eventEdit" id="eventEdit">
<input type="hidden" name="add" value="1">
<input type="hidden" name="eventActive" id="eventctive" value="1">
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
	<table cellpadding="6" cellspacing="2" border="0">
	<tr>
		<td class="hd" style="font-weight: bold;">#</td>
		<td class="hd" style="font-weight: bold;"><?= $tableHdr[0] ?></td>
		<td class="hd" style="font-weight: bold;"><?= $tableHdr[1] ?></td>
		<!--<td class="hd" style="font-weight: bold;"><?= $tableHdr[2] ?></td>-->
		<td class="hd" style="font-weight: bold;">&nbsp;</td>
	</tr>	

<?php 
if (!empty($event_select_form))
{
	$loop = 1;
	foreach ($event_select_form as $et_id => $event)
	{
?>
	<tr>
		<td class="left_links"><?= $loop ?></td>
		<td class="right_links" id="edtEvent_<?= $et_id ?>">
			<a href="javascript:void(0)" style="margin-left: 3px;" onClick="wikiaSelectEventType( '<?= $baseurl ?>', '<?= $et_id ?>', '<?= $savebtn ?>'); return false;"><?= $event['name'] ?></a>
		</td>
		<td class="right_links" id="edtEventDesc_<?= $et_id ?>">
			<?= $event['desc'] ?></a>
		</td>
<!--		<td class="right_links" id="edtEventActive_<?= $et_id ?>">
			<a href="javascript:void(0)" style="margin-left: 3px;" onClick="wikiaSetActiveEventType( '<?= $et_id ?>' ); return false;"><img src="/extensions/wikia/WikiaEvents/images/<?= $event['active'] ?>.gif" border="0" /></a>
		</td>-->
		<td class="left_links" id="actionEvent_<?= $et_id ?>"></td>
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
