<h1><?= wfMsg('tasks-log-title') ?></h1>

<table id="task_log" class="wikitable">
	<? foreach ( $taskLogs as $log ) { ?>
	<tbody class="log-<?= $log['severity'] ?>">
		<? unset($log['@context']['task_id']); // don't care about the task_id ?>
		<tr>
			<td><?= $log['@timestamp'] ?></td>
			<td><?= $log['@message'] ?></td>
		</tr>
		<? if ( !empty($log['@context']) ) { ?>
		<tr class="log-context">
			<td colspan="2"><?= json_encode($log['@context'], JSON_PRETTY_PRINT); ?></td>
		</tr>
		<? } ?>
	</tbody>
	<? } ?>
</table>
