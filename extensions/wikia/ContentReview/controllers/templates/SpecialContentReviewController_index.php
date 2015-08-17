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
		<th class="content-review-special-list-header-wiki-id"><?= wfMessage( 'content-review-special-list-header-wiki-id' )->escaped() ?></th>
		<th class="content-review-special-list-header-page-name"><?= wfMessage( 'content-review-special-list-header-page-name' )->escaped() ?></th>
		<th class="content-review-special-list-header-revison-id"><?= wfMessage( 'content-review-special-list-header-revision-id' )->escaped() ?></th>
		<th class="content-review-special-list-header-status"><?= wfMessage( 'content-review-special-list-header-status' )->escaped() ?></th>
		<th class="content-review-special-list-header-submit-user"><?= wfMessage( 'content-review-special-list-header-submit-user' )->escaped() ?></th>
		<th class="content-review-special-list-header-status"><?= wfMessage( 'content-review-special-list-header-submit-time' )->escaped() ?></th>
		<th class="content-review-special-list-header-status"><?= wfMessage( 'content-review-special-list-header-reviewer' )->escaped() ?></th>
		<th class="content-review-special-list-header-status"><?= wfMessage( 'content-review-special-list-header-review-start' )->escaped() ?></th>
		<th class="content-review-special-list-header-actions"><?= wfMessage( 'content-review-special-list-header-actions' )->escaped() ?></th>
	</tr>
	</thead>
	<tbody>
	<?php if ( !empty( $reviewStatus ) ): ?>
	<?php foreach ( $reviewStatus as $contentReviewId => $content ): ?>

	<tr class="content-review-special-list-item" id="content-review-special-list-item-<?= $contentReviewId ?>">
		<?php $title = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] );
		$user = User::newFromId( $content['submit_user_id'] );?>
		<td class="content-review-special-list-item-wiki-id data-wiki-id="<?= Sanitizer::encodeAttribute( $title ) ?>">
		<?= Linker::link( $title, htmlspecialchars( $content['wiki_id'] ), [
			'class' => 'content-review-special-list-item-mediawiki-link',
			'target' => '_blank',
		] ); ?>
		</td>
		<td class="content-review-special-list-item-page-name data-page-name="<?= Sanitizer::encodeAttribute( $content['page_id'] ) ?>"><?= htmlspecialchars( $title ) ?></td>
		<td class="content-review-special-list-item-revision-id data-revision-id="<?= Sanitizer::encodeAttribute( $content['revision_id'] ) ?>"><?= htmlspecialchars( $content['revision_id'] ) ?></td>
		<td class="content-review-special-list-item-status data-review-status="<?= Sanitizer::encodeAttribute( $status[$content['status']] ) ?>"><?= htmlspecialchars( $status[$content['status']] ) ?></td>
		<td class="content-review-special-list-item-submit-user data-user-name="<?= Sanitizer::encodeAttribute( $user ) ?>"><?= htmlspecialchars( $user ) ?></td>
		<td class="content-review-special-list-item-submit-time data-review-submit-time="<?= Sanitizer::encodeAttribute( $content['submit_time'] ) ?>"><?= htmlspecialchars( $content['submit_time'] ) ?></td>
		<td class="content-review-special-list-item-reviewer data-review-reviewer="<?= Sanitizer::encodeAttribute( $content['review_user_id'] ) ?>"><?= htmlspecialchars( $content['review_user_id'] ) ?></td>
		<td class="content-review-special-list-item-review-start data-review-start="<?= Sanitizer::encodeAttribute( $content['review_start'] ) ?>"><?= htmlspecialchars( $content['review_start'] ) ?></td>
		<td class="content-review-special-list-item-actions clearfix">
		<a class="content-review-special-list-item-actions-diff  wikia-button primary" href="#" title="<?= wfMessage( 'content-review-icons-actions-diff' )->escaped() ?>" data-content-review-id="<?= Sanitizer::encodeAttribute( $contentReviewId ) ?>">
				<span class="flags-icons-special flags-icons-edit">
						<?= wfMessage( 'content-review-icons-actions-diff' )->escaped() ?>
				</span>
		</a>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
	</tbody>
</table>
