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
					<?= Linker::link( $reviewData['title'][$contentReviewId], htmlspecialchars( $reviewData['title'][$contentReviewId]->getDatabaseName() ), [
						'class' => 'content-review-special-list-item-mediawiki-link',
						'target' => '_blank',
					] ); ?>
				</td>
				<td><?= htmlspecialchars( $reviewData['title'][$contentReviewId]->getBaseText() ) ?></td>
				<td><?= htmlspecialchars( $content['revision_id'] ) ?></td>
				<td><?= htmlspecialchars( wfMessage( SpecialContentReviewController::$status[$content['status']] ) ) ?></td>
				<td><?= htmlspecialchars( $reviewData['user'][$contentReviewId] ) ?></td>
				<td><?= htmlspecialchars( $content['submit_time'] ) ?></td>
				<td><?= htmlspecialchars( $content['review_user_id'] ) ?></td>
				<td><?= htmlspecialchars( $content['review_start'] ) ?></td>
				<td class="content-review-special-list-item-actions clearfix">
					<a class="content-review-special-list-item-actions-diff  wikia-button primary" href="#"
					   title="<?= wfMessage( 'content-review-icons-actions-diff' )->escaped() ?>"
					   data-content-review-id="<?= Sanitizer::encodeAttribute( $contentReviewId ) ?>">
				<span class="content-review-icons-special content-review-icons-diff">
						<?= wfMessage( 'content-review-icons-actions-diff' )->escaped() ?>
				</span>
					</a>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
