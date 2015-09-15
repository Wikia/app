<div class="content-review-special-header">
	<div class="content-review-special-header-content">
		<h1 class="content-review-special-header-content-title">
			<?= wfMessage( 'content-review-special-title' )->escaped() ?>
		</h1>
	</div>
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
					<td><a href="<?= Sanitizer::cleanUrl( $review['url'] ) ?>" target="_blank"><?= htmlspecialchars( $review['title'] ) ?></a></td>
					<td><?= $review['revision_id'] ?></td>
					<td><?= wfMessage( ContentReviewSpecialController::$statusMessageKeys[$review['status']] )->escaped() ?></td>
					<td><?= htmlspecialchars( $review['review_user_name'] ) ?></td>
					<td><?= $review['review_start'] ?></td>
					<td><?php if ( !empty($review['review_end'] ) ) echo $review['review_end']; ?></td>
					<td class="content-review-special-list-item-actions clearfix">
						<a href="<?= Sanitizer::encodeAttribute( $review['diff'] ) ?>" class="wikia-button secondary">
							<?= wfMessage( 'content-review-special-show-revision' )->escaped() ?>
						</a>
						<?php if ( !empty( $review['restore'] ) ): ?>
							<a href="<?= $review['restoreUrl'] ?>" class="content-review-restore-revision wikia-button primary">
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
