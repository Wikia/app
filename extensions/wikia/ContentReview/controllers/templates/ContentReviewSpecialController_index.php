<div class="content-review-special-header">
	<div class="content-review-special-header-content">
		<h1 class="content-review-special-header-content-title">
			<?= wfMessage( 'contentreview' )->escaped() ?>
		</h1>
	</div>
</div>
<table class="article-table sortable content-review-special-list">
	<thead>
	<tr class="content-review-special-list-headers">
		<th><?= wfMessage( 'content-review-special-list-header-wiki-name' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-page-name' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-revision-id' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-status' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-submit-user' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-submit-time' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-reviewer' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-review-start' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-actions' )->escaped() ?></th>
	</tr>
	</thead>
	<tbody>
	<?php if ( !empty( $reviews ) ): ?>
		<?php foreach ( $reviews as $contentReviewId => $content ): ?>
			<tr class="content-review-special-list-item" id="content-review-special-list-item-<?= $contentReviewId ?>">
				<td>
					<a href="<?= $content['url'] ?>" target="_blank"><?= $content['wiki'] ?></a>
				</td>
				<td><?= htmlspecialchars( $content['title'] ) ?></td>
				<td><?= $content['revision_id'] ?></td>
				<td><?= wfMessage( ContentReviewSpecialController::$status[$content['status']] )->escaped() ?></td>
				<td><?= htmlspecialchars( $content['user'] ) ?></td>
				<td><?= $content['submit_time'] ?></td>
				<td><?= $content['review_user_id'] ?></td>
				<td><?= $content['review_start'] ?></td>
				<td class="content-review-special-list-item-actions clearfix">
					<a href="<?= $content['diff'] ?>" target="_blank"
					   class="content-review-diff  wikia-button primary"
					   data-wiki-id="<?= $content['wiki_id'] ?>"
					   data-page-id="<?= $content['page_id'] ?>"
					   data-status="<?= $inReview ?>">
						<?= wfMessage( 'content-review-icons-actions-diff' )->escaped() ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
