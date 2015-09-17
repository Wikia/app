<h1 class="content-review-special-header-content-title">
	<?= wfMessage( 'content-review-special-title' )->escaped() ?>
</h1>
<div class="content-review-special-back-link">
	<a href="<?= Sanitizer::cleanUrl( $baseSpecialPageUrl ) ?>">
		<?= wfMessage( 'content-review-special-archive-back-link' )->escaped() ?>
	</a>
</div>
<table class="article-table sortable content-review-special-list">
	<thead>
	<tr class="content-review-special-list-headers">
		<th><?= wfMessage( 'content-review-special-list-header-page-name' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-revision-id' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-status' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-reviewer' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-review-start' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-review-end' )->escaped() ?></th>
		<th><?= wfMessage( 'content-review-special-list-header-actions' )->escaped() ?></th>
	</tr>
	</thead>
	<tbody>
	<?php if ( !empty( $reviews ) ): ?>
		<?php foreach ( $reviews as $wikiReview ): ?>
			<?php foreach( $wikiReview as $review ): ?>
				<tr class="content-review-special-list-item">
					<td><a href="<?= Sanitizer::cleanUrl( $review['diff'] ) ?>" target="_blank"><?= htmlspecialchars( $review['title'] ) ?></a></td>
					<td><?= $review['revision_id'] ?></td>
					<td><?=
						/**
						 * Possible message keys:
						 * content-review-status-unreviewed
						 * content-review-status-in
						 * content-review-status-approved
						 * content-review-status-rejected
						 * content-review-status-live
						 * content-review-status-autoapproved
						 */
						wfMessage( ContentReviewSpecialController::$statusMessageKeys[$review['status']] )->escaped()
						?></td>
					<td><?= htmlspecialchars( $review['review_user_name'] ) ?></td>
					<td><?= $review['review_start'] ?></td>
					<td><?php if ( !empty($review['review_end'] ) ) echo $review['review_end']; ?></td>
					<td class="content-review-special-list-item-actions clearfix">
						<a href="<?= Sanitizer::cleanUrl( $review['diff'] ) ?>" class="wikia-button primary">
							<?= wfMessage( 'content-review-special-show-revision' )->escaped() ?>
						</a>
						<?php if ( !empty( $review['restore'] ) ): ?>
							<a href="<?= Sanitizer::cleanUrl( $review['restoreUrl'] ) ?>" class="content-review-restore-revision wikia-button secondary">
								<?= wfMessage( 'content-review-special-restore' )->escaped() ?>
							</a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
