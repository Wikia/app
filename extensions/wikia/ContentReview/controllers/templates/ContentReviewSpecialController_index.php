<h1 class="content-review-special-header-content-title">
	<?= wfMessage( 'content-review-special-title' )->escaped() ?>
</h1>
<p>
	<?= wfMessage( 'content-review-special-guidelines' )->parse() ?>
</p>
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
		<?php foreach ( $reviews as $wikiReview ): ?>
			<?php foreach( $wikiReview as $review ): ?>
				<tr class="content-review-special-list-item <?= $review['escalated'] ? 'content-review-escalated' : '' ?>">
					<td>
						<a href="<?= Sanitizer::cleanUrl( $review['wikiArchiveUrl'] ) ?>">
							<?= htmlspecialchars( $review['wiki'] ) ?>
						</a>
					</td>
					<td><a href="<?= Sanitizer::encodeAttribute( $review['url'] ) ?>" target="_blank"><?= htmlspecialchars( $review['title'] ) ?></a></td>
					<td><?= $review['revision_id'] ?></td>
					<td><?= wfMessage( ContentReviewSpecialController::$statusMessageKeys[$review['status']] )->escaped() ?></td>
					<td><?= htmlspecialchars( $review['user'] ) ?></td>
					<td><?= $review['submit_time'] ?></td>
					<td><?= htmlspecialchars( $review['review_user_name'] ) ?></td>
					<td><?= $review['review_start'] ?></td>
					<td class="content-review-special-list-item-actions clearfix">
						<? if ( !empty( $review['hide'] ) ): ?>
							<?= wfMessage( 'content-review-special-review-open' )->escaped() ?>
						<? else: ?>
							<a href="<?= Sanitizer::encodeAttribute( $review['diff'] ) ?>" target="_blank"
							   class="<?= ContentReviewSpecialController::$statusMessageKeys[$review['status']] ?><?= $review['class'] ?> wikia-button primary"
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
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
