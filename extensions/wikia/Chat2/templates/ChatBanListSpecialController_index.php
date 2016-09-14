
<div class="lu_filter">
	<span class="lu_filter lu_first"><?= wfMessage( 'username' )->escaped() ?></span>
	<span class="lu_filter">
		<input type="text" name="lu_search" id="lu_search" size="10" >
	</span>
	<span class="lu_filter">
		<input type="button" value="<?= wfMessage( 'ipblocklist-submit' )->escaped() ?>" id="lu-showusers">
	</span>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lu-table">
	<thead>
		<tr>
			<th width="19%"><?= wfMessage( 'blocklist-timestamp' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-target' )->escaped() ?></th>
			<th width="19%"><?= wfMessage( 'blocklist-expiry' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-by' )->escaped() ?></th>
			<th width="22%"><?= wfMessage( 'blocklist-reason' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty"><?= wfMessage( 'livepreview-loading')->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="19%"><?= wfMessage( 'blocklist-timestamp' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-target' )->escaped() ?></th>
			<th width="19%"><?= wfMessage( 'blocklist-expiry' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'blocklist-by' )->escaped() ?></th>
			<th width="22%"><?= wfMessage( 'blocklist-reason' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
