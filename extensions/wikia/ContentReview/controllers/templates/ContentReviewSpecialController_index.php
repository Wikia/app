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
		<?php foreach ( $reviews as $contentReviewId => $review ): ?>
			<tr class="content-review-special-list-item" id="content-review-special-list-item-<?= $contentReviewId ?>">
				<td><?= htmlspecialchars( $review['wiki'] ) ?></td>
				<td><a href="<?= $review['url'] ?>" target="_blank"><?= $review['title'] ?></a></td>
				<td><?= $review['revision_id'] ?></td>
				<td><?= wfMessage( ContentReviewSpecialController::$status[$review['status']] )->escaped() ?></td>
				<td><?= htmlspecialchars( $review['user'] ) ?></td>
				<td><?= $review['submit_time'] ?></td>
				<td><?= $review['review_user_id'] ?></td>
				<td><?= $review['review_start'] ?></td>
				<td class="content-review-special-list-item-actions clearfix">
					<? if ( !empty( $review['hide'] ) ): ?>
						<?= wfMessage( 'content-review-special-review-open' )->escaped() ?>
					<? else: ?>
						<a href="<?= $review['diff'] ?>" target="_blank"
						   class="<?= ContentReviewSpecialController::$status[$review['status']] ?><?= $review['class'] ?> wikia-button primary"
						   data-wiki-id="<?= $review['wiki_id'] ?>"
						   data-page-id="<?= $review['page_id'] ?>"
						   data-old-status="<?= $review['status'] ?>"
						   data-status="<?= Wikia\ContentReview\Models\ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW ?>">
							<?= $review['diffText'] ?>
						</a>
					<? endif ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
