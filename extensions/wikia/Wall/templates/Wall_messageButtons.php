<div class="buttons">

	<? if ( $canFastAdminDelete ): ?>
		<button  class="secondary fast-admin-delete-message" data-mode="fastadmin"><?= wfMessage( 'wall-message-fast-admin-delete-message' )->escaped() ?></button>
	<? endif; ?>

	<? if ( !$isClosed ): ?>
		<button class="quote-button secondary"><?= wfMessage( 'wall-message-quote-button' )->escaped() ?></button>
	<? endif; ?>

	<?php
		$dropdown = array();

		if ( $canEdit ) {
			$dropdown[] = array(
				'class' => 'edit-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-edit' )->escaped(),
			);
		}

		$dropdown[] = array(
			'class' => 'thread-history',
			'href' => $threadHistoryLink,
			'text' => wfMessage( 'history_short' )->escaped(),
		);

		if ( $canAdminDelete ) {
			$dropdown[] = array(
				'attr' => 'data-mode="admin"',
				'class' => 'admin-delete-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-delete' )->escaped(),
			);
		}

		if ( $showViewSource ) {
			$dropdown[] = array(
				'class' => 'source-message',
				'href' => '#',
				'text' => wfMessage( 'user-action-menu-view-source' )->escaped(),
			);
		}

		if ( $canRemove ) {
			$dropdown[] = array(
				'attr' => 'data-mode="remove"',
				'class' => 'remove-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-remove' )->escaped(),
			);
		}

		if ( $canDelete ) {
			$dropdown[] = array(
				'attr' => 'data-mode="rev"',
				'class' => 'delete-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-rev-delete' )->escaped(),
			);
		}

		if ( $canNotifyeveryone ) {
			$dropdown[] = array(
				'attr' => 'data-dir="1"',
				'class' => 'edit-notifyeveryone',
				'href' => '#',
				'text' => wfMessage( 'wall-message-notifyeveryone' )->escaped(),
			);
		}

		if ( $canUnnotifyeveryone ) {
			$dropdown[] = array(
				'attr' => 'data-mode="0"',
				'class' => 'edit-notifyeveryone',
				'href' => '#',
				'text' => wfMessage( 'wall-message-unnotifyeveryone' )->escaped(),
			);
		}

		if ( $canClose ) {
			$dropdown[] = array(
				'attr' => 'data-mode="close"',
				'class' => 'close-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-close-thread' )->escaped(),
			);
		}

		if ( $canReopen ) {
			$dropdown[] = array(
				'class' => 'reopen-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-reopen-thread' )->escaped(),
			);
		}

		if ( $canMove ) {
			$dropdown[] = array(
				'class' => 'move-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-move-thread' )->escaped(),
			);
		}
	?>
	<?php if ( !empty( $dropdown ) ): ?>
		<?= F::app()->renderView( 'MenuButton',
			'Index',
			array(
				'action' => array( 'text' => wfMessage( 'wall-message-more' )->escaped(), 'id' => '' ),
				'class' => 'secondary',
				'dropdown' => $dropdown
			)
		) ?>
	<?php endif; ?>
</div>
<?php //TODO: This is hack for now unification buttons for all skins ASAP!!! ?>
<div class="buttons-monobook">
	<!-- only show this if it's user's own message -->
	<span class="tools">
		<? if( $canFastAdminDelete ): ?>
			<a href="#"  class="fast-admin-delete-message" data-mode="fastadmin"><?= wfMessage( 'wall-message-fast-admin-delete-message' )->escaped() ?></a>
		<? endif; ?>

		<? if ( !$isClosed ): ?>
			<a href="#" class="quote-button"><?= wfMessage( 'wall-message-quote-button' )->escaped() ?></a>
		<? endif; ?>

		<? if ( $canClose ): ?>
			<a href="#" class="close-thread" data-mode="close"> <?= wfMessage( 'wall-message-close-thread' )->escaped(); ?> </a>
		<? endif; ?>

		<? if ( $canReopen): ?>
			<a href="#" class="reopen-thread"> <?= wfMessage( 'wall-message-reopen-thread' )->escaped(); ?> </a>
		<? endif; ?>

		<? if ( $showViewSource ): ?>
			<a href="#" class="source-message"> <?= wfMessage( 'user-action-menu-view-source' )->escaped(); ?> </a>
		<? endif; ?>

		<a href="<?= $threadHistoryLink ?>" class="thread-history"> <?= wfMessage( 'history_short' )->escaped(); ?> </a>

		<?php if ( $canEdit ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMessage( 'wall-message-edit' )->escaped(); ?></a>
		<?php endif; ?>

		<? if ( $canRemove ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="remove"><?= wfMessage( 'wall-message-remove' )->escaped(); ?> </a>
		<? endif; ?>

		<? if ( $canAdminDelete ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="admin"><?= wfMessage( 'wall-message-delete' )->escaped(); ?> </a>
		<?php endif;?>

		<?php if ( $canDelete ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMessage( 'wall-message-rev-delete' )->escaped(); ?></a>
		<?php endif; ?>

		<? if ( $canNotifyeveryone ): ?>
			<a href="#" class="edit-notifyeveryone" data-dir="1"> <?= wfMessage( 'wall-message-notifyeveryone' )->escaped(); ?> </a>
		<? endif; ?>
		<? if ( $canUnnotifyeveryone ): ?>
			<a href="#" class="edit-notifyeveryone" data-mode="0"> <?= wfMessage( 'wall-message-unnotifyeveryone' )->escaped(); ?> </a>
		<? endif; ?>
		<? if ( $canMove ): ?>
			<a href="#" class="move-thread"> <?= wfMessage( 'wall-message-move-thread' )->escaped(); ?> </a>
		<? endif; ?>

	</span>
</div>
