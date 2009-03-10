<!-- s:<?= __FILE__ ?> -->
<table class="TablePager" style="width:100%">
<tr>
	<th>#</th>
	<th><?=wfMsg('daemonloader_daemonname')?></th>
	<th><?=wfMsg('daemonloader_period')?></th>
	<th><?=wfMsg('daemonloader_frequency')?></th>
	<th><?=wfMsg('daemonloader_daemonparams')?></th>
	<th style="width:60px"><?=wfMsg('daemonloader_files')?></th>
	<th><?=wfMsg('daemonloader_createdby')?></th>
	<th><?=wfMsg('daemonloader_created')?></th>
	<th><?=wfMsg('daemonloader_options')?></th>
</tr>
<?php 
	if (!empty($allJobs)) : 
		foreach ($allJobs as $i => $aRow) {
?>
<tr>
	<td><?=$i+1?></th>
	<td><?=$allDaemons[$aRow['dt_id']]['dt_name']?></td>
	<td style="white-space:nowrap;"><?=$aRow['start']?> : <?=$aRow['end']?></td>
	<td><?=wfMsg('daemonloader_' . $aRow['frequency'])?></td>
	<td><?=wordwrap($aRow['param_values'],50,"<br />", true)?></td>
	<td><?=$aRow['result_xls_files']?></td>
	<td><?=($aRow['createdby']) ? $aRow['createdby']->getName() : "" ?></td>
	<td><?=$wgLang->date( wfTimestamp( TS_MW, $aRow['added'] ), true )?></td>
	<td><a id="dt-remove-<?=$aRow['id']?>" style="cursor:pointer" onclick="removeJobTask('<?=$aRow['id']?>');"><?=wfMsg('delete')?></a><br />
		<a id="dt-change-<?=$aRow['id']?>" style="cursor:pointer" onclick="changeJobTask('<?=$aRow['id']?>');"><?=wfMsg('daemonloader_newtask')?></a>
	</td>
</tr>	
<?php 
		}
	endif 
?>
</table>
<!-- e:<?= __FILE__ ?> -->
