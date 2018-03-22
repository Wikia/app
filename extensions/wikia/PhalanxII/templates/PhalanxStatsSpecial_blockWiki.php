<table border="1" class="wikitable" style="font-family:monospace;">
	<tr>
		<th><?= wfMessage( 'phalanx-stats-table-wiki-id' )->text() ?></th>
		<th><?= wfMessage( 'phalanx-stats-table-wiki-name' )->text() ?></th>
		<th><?= wfMessage( 'phalanx-stats-table-wiki-url' )->text() ?></th>
		<th><?= wfMessage( 'phalanx-stats-table-wiki-last-edited' )->text() ?></th>
	</tr>
	<tr>
		<td><?= $wikiData['wiki_id'] ?></td>
		<td><?= $wikiData['sitename'] ?></td>
		<td><a href="<?= $wikiData['url'] ?>"><?= $wikiData['url'] ?></a></td>
		<td><?= $wikiData['last_timestamp'] ?></td>
	</tr>
</table>

<fieldset>
	<legend><?= wfMessage( 'phalanx-stats-results' )->escaped(); ?></legend>
	<?= $statsPager ?>
</fieldset>
