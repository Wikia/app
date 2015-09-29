<h1 class="content-review-special-header-content-title">
	<?= wfMessage( 'content-review-special-js-pages-title' )->escaped() ?>
</h1>
<table>
	<thead>
	<tr class="content-review-special-list-headers">
		<th><?= wfMessage( 'content-review-special-list-header-page-name' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-module-header-latest' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-module-header-last' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-module-header-live' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-actions' )->escaped() ?></th>
	</tr>
	</thead>
	<tbody>
		<?php foreach( $jsPages as $page ): ?>
			<tr>
				<td><?= $page['pageLink'] ?></td>
				<td><?= $page['latestRevision']['diffLink'] . $page['latestRevision']['statusMsg'] . $page['latestRevision']['reasonLink'] ?></td>
				<td><?= $page['latestReviewed']['diffLink'] . $page['latestReviewed']['statusMsg'] . $page['latestReviewed']['reasonLink'] ?></td>
				<td><?= $page['liveRevision']['diffLink'] . $page['liveRevision']['statusMsg'] ?></td>
				<td><?= $page['submit'] ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
