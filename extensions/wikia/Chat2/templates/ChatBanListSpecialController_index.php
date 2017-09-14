<div class="lu_filter">
	<label for="lu_search" class="lu_filter lu_first"><?= wfMessage( 'username' )->escaped() ?></label>
	<span class="lu_filter">
		<input type="text" name="lu_search" id="lu_search" size="30" autofocus>
	</span>
	<span class="lu_filter">
		<input type="button" value="<?= wfMessage( 'ipblocklist-submit' )->escaped() ?>" id="lu-showusers">
	</span>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="TablePager" id="lu-table">
	<thead>
		<tr>
			<th width="19%"><?= wfMessage( 'chat-blocklist-timestamp' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'chat-blocklist-target' )->escaped() ?></th>
			<th width="19%"><?= wfMessage( 'chat-blocklist-expiry' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'chat-blocklist-by' )->escaped() ?></th>
			<th width="22%"><?= wfMessage( 'chat-blocklist-reason' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty"><?= wfMessage( 'livepreview-loading')->escaped() ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="19%"><?= wfMessage( 'chat-blocklist-timestamp' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'chat-blocklist-target' )->escaped() ?></th>
			<th width="19%"><?= wfMessage( 'chat-blocklist-expiry' )->escaped() ?></th>
			<th width="20%"><?= wfMessage( 'chat-blocklist-by' )->escaped() ?></th>
			<th width="22%"><?= wfMessage( 'chat-blocklist-reason' )->escaped() ?></th>
		</tr>
	</tfoot>
</table>
