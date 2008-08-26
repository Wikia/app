<!-- s:<?= __FILE__ ?> -->
<div>
<h2><?= $ev_title_setup ?></h2>
<fieldset>
	<legend style="margin-left: 2px width:100%;"> <?= $ev_param_list ?></legend>
	<div style="display: block;" id="selectDiv">
	<table cellpadding="6" cellspacing="2" style="border: 1px inset #000000;">
	<tr>
		<td style="font-weight: bold; text-align: center;" colspan="<?= (count($tableHdr)+1) ?>"><?=$tableRowHdr?></td>
	</tr>
	<tr>
<?
	foreach ($tableHdr as $hdr)
	{
?>	
		<td style="font-weight: bold; text-align: center;"><?=$hdr?></td>
<?
	}
?>		
		<td style="font-weight: bold;">&nbsp;</td>
	</tr>	

<?php 
if (!empty($setupVars))
{
	$loop = 1;
	foreach ($setupVars as $p_id => $var)
	{
?>
	<tr>
		<td style="text-align: right"><?= $loop ?></td>
		<td style="text-align: left"><?= $var['name'] ?></a></td>
		<td style="text-align: center" id="epEventValue_<?= $p_id ?>"><?= $var['value'] ?></a>
		</td>
		<td style="text-align: left" id="epEventDesc_<?= $p_id ?>"><?= $var['desc'] ?></a>
		</td>
		<td style="text-align: center" id="epEventActive_<?= $p_id ?>">
			<a href="javascript:void(0)" style="margin-left: 3px;" onClick="wikiaSetActiveEventParamSetup( '<?= addslashes($baseurl) ?>', '<?= addslashes($p_id) ?>', '<?= addslashes($savebtn) ?>', '<?= addslashes($btnedit) ?>' ); return false;"><img src="/extensions/wikia/WikiaEvents/images/<?= $var['active'] ?>.gif" border="0" /></a>
		</td>
		<td style="text-align: center" id="actionEvent_<?= $p_id ?>">
			<a href="javascript:void(0)" style="margin-left: 3px;" onClick="wikiaSelectEventSetup( '<?= addslashes($baseurl) ?>', '<?= $p_id ?>', '<?= addslashes($savebtn) ?>', '<?= addslashes($btnedit) ?>'); return false;"><?= $btnedit ?></a>
		</td>
		<td style="text-align: center" id="actionEventImg_<?= $p_id ?>">&nbsp;</td>
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
