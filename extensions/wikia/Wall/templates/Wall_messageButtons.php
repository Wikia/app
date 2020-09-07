<div class="buttons">

	<? if ( $canFastAdminDelete ): ?>
		<button  class="secondary fast-admin-delete-message" data-mode="fastadmin"><?= wfMessage( 'wall-message-fast-admin-delete-message' )->escaped() ?></button>
	<? endif; ?>

	<? if ( !$isClosed && $canQuote ): ?>
		<button class="quote-button secondary"><?= wfMessage( 'wall-message-quote-button' )->escaped() ?></button>
	<? endif; ?>

	<?php
		$dropdown = [ ];

		if ( $canEdit ) {
			$dropdown[] = [
				'class' => 'edit-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-edit' )->escaped(),
			];
		}

		$dropdown[] = [
			'class' => 'thread-history',
			'href' => $threadHistoryLink,
			'text' => wfMessage( 'history_short' )->escaped(),
		];

		if ( $canAdminDelete ) {
			$dropdown[] = [
				'attr' => 'data-mode="admin"',
				'class' => 'admin-delete-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-delete' )->escaped(),
			];
		}

		if ( $showViewSource ) {
			$dropdown[] = [
				'class' => 'source-message',
				'href' => '#',
				'text' => wfMessage( 'user-action-menu-view-source' )->escaped(),
			];
		}

		if ( $canRemove ) {
			$dropdown[] = [
				'attr' => 'data-mode="remove"',
				'class' => 'remove-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-remove' )->escaped(),
			];
		}

		if ( $canDelete ) {
			$dropdown[] = [
				'attr' => 'data-mode="rev"',
				'class' => 'delete-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-rev-delete' )->escaped(),
			];
		}

		if ( $canClose ) {
			$dropdown[] = [
				'attr' => 'data-mode="close"',
				'class' => 'close-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-close-thread' )->escaped(),
			];
		}

		if ( $canReopen ) {
			$dropdown[] = [
				'class' => 'reopen-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-reopen-thread' )->escaped(),
			];
		}

		if ( $canMove ) {
			$dropdown[] = [
				'class' => 'move-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-move-thread' )->escaped(),
			];
		}
	?>
	<?php if ( !empty( $dropdown ) ): ?>
		<?= F::app()->renderView( 'MenuButton',
			'Index',
			[
				'action' => [ 'text' => wfMessage( 'wall-message-more' )->escaped(), 'id' => '' ],
				'class' => 'secondary',
				'dropdown' => $dropdown
			]
		) ?>
	<?php endif; ?>
</div>
