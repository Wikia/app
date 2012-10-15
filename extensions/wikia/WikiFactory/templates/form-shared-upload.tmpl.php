<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
.ezsuVariableValueRow {
	width: 250px;
}

.ezsuVariableNameRow {
	width: 150px;
}

tr.ezsuBottomRow td {
	border-width: 1px 0 0 0;
	border-style: solid;
	border-color: #000000;
	text-align: center;
}

table.ezsuTable {
	border-width: 1px;
	border-spacing: 0px;
	border-style: solid;
	border-color: #000000;
	border-collapse: separate;
	width: 100%
}

table.ezsuTable th {
	border-width: 1px;
	border-style: solid;
	border-color: #000000;
	padding: 2px;
}

table.ezsuTable td {
	padding: 2px;
}
/*]]>*/
</style>

<h2>EZ Shared Upload Setup</h2>
<?php //var_dump($wiki); ?>
<div id="ezsuContainer">
<form name="ezsuForm" method="POST">
	Using SharedUpload? <?php echo ( $EZSharedUpload['active'] ? "<span style=\"color: green; font-weight: bold;\">yes</span>" : "<span style=\"color: red; font-weight: bold;\">no</span>" ); ?>
	&nbsp;<a href="<?php echo $EZSharedUpload['varTitle'] . "wgUseSharedUploads"; ?>">[change]</a><br />
	<table class="ezsuTable">
	<thead class="color1">
		<tr>
			<td colspan="4" align="left">
				<strong>Source Wiki ID:</strong>&nbsp;
				<input type="text" name="ezsuWikiId" value="<?php echo $EZSharedUpload['remote']['wikiId'];?>" style="width: 50px;"/>
				<input type="submit" name="ezsuLoad" value="load" />
			</td>
		</tr>
		<tr>
			<th colspan="2" align="center">Local</th>
			<th colspan="2" align="center">Remote<?php echo empty($EZSharedUpload['remote']['wikiId']) ? "&nbsp;(not loaded yet)" : ""; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="right" class="ezsuVariableNameRow"><strong>wgCityId:</strong></td>
			<td class="ezsuVariableValueRow"><?php echo $wiki->city_id; ?></td>
			<td align="right" class="ezsuVariableNameRow"><strong>wgCityId:</strong></td>
			<td class="ezsuVariableValueRow"><?php echo $EZSharedUpload['remote']['wikiId']; ?></td>
		</tr>
		<tr>
			<td align="right"><strong>wgServer:</strong></td>
			<td>&nbsp;<?php echo $EZSharedUpload['local']['wgServer']; ?></td>
			<td align="right"><strong>wgServer:</strong></td>
			<td>&nbsp;<?php echo $EZSharedUpload['remote']['wgServer']; ?></td>
		</tr>
		<tr>
			<td align="right"><a href="<?php echo $EZSharedUpload['varTitle'] . "wgSharedUploadDBname"; ?>"><strong>wgSharedUploadDBname:</strong></a></td>
			<td>&nbsp;<?php echo $EZSharedUpload['local']['wgSharedUploadDBname']; ?></td>
			<td align="right"><strong>wgDBname:</strong></td>
			<td>&nbsp;<?php echo $EZSharedUpload['remote']['wgDBname']; ?></td>
		</tr>
		<tr>
			<td align="right"><a href="<?php echo $EZSharedUpload['varTitle'] . "wgSharedUploadDirectory"; ?>"><strong>wgSharedUploadDirectory:</strong></a></td>
			<td>&nbsp;<?php echo $EZSharedUpload['local']['wgSharedUploadDirectory']; ?></td>
			<td align="right"><strong>wgUploadDirectory:</strong></td>
			<td>&nbsp;<?php echo $EZSharedUpload['remote']['wgUploadDirectory']; ?></td>
		</tr>
		<tr>
			<td align="right"><a href="<?php echo $EZSharedUpload['varTitle'] . "wgSharedUploadPath"; ?>"><strong>wgSharedUploadPath:</strong></a></td>
			<td>&nbsp;<?php echo $EZSharedUpload['local']['wgSharedUploadPath']; ?></td>
			<td align="right"><strong>wgUploadPath:</strong></td>
			<td>&nbsp;<?php echo $EZSharedUpload['remote']['wgUploadPath']; ?></td>
		</tr>
		<tr>
			<td align="right"><a href="<?php echo $EZSharedUpload['varTitle'] . "wgRepositoryBaseUrl"; ?>"><strong>wgRepositoryBaseUrl:</strong></a></td>
			<td>&nbsp;<?php echo $EZSharedUpload['local']['wgRepositoryBaseUrl']; ?></td>
			<td align="right"><strong>Base URL:</strong></td>
			<td>&nbsp;<?php echo $EZSharedUpload['remote']['baseUrl']; ?></td>
		</tr>
		<tr>
			<td align="right"><a href="<?php echo $EZSharedUpload['varTitle'] . "wgFetchCommonsDescriptions"; ?>"><strong>wgFetchCommonsDescriptions:</strong></a></td>
			<td>&nbsp;<?php echo ($EZSharedUpload['local']['wgFetchCommonsDescriptions']) ? "<span style=\"color: green; font-weight: bold;\">yes</span>" : "<span style=\"color: red; font-weight: bold;\">no</span>"; ?></td>
			<td align="right"></td>
			<td></td>
		</tr>
		<?php if(!empty($EZSharedUpload['remote']['wikiId'])): ?>
			<tr class="ezsuBottomRow">
				<td colspan="4">
					<input type="submit" name="ezsuSave" value="Save" />
					&nbsp;<?php echo $EZSharedUpload['info']; ?>
				</td>
			</tr>
		<?php endif;?>
	</tbody>
	</table>
</form>
</div>
<!-- e:<?= __FILE__ ?> -->
