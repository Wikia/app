<h1 class="content-review-special-header-content-title">
	<?= wfMessage( 'content-review-special-js-pages-title' )->escaped() ?>
</h1>
<table class="article-table">
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
				<td><?= $page['latestRevision']['statusMessage'] ?></td>
				<td><?= $page['latestReviewed']['statusMessage'] ?></td>
				<td><?= $page['liveRevision']['statusMessage'] ?></td>
				<td>
					<?php if ( $page['submit'] ): ?>
						<button class="content-review-module-submit primary">
							<?= $submit ?>
						</button>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
