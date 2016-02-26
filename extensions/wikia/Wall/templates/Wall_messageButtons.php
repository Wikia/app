<div class="buttons">

	<? if ( ${WallConst::canFastAdminDelete} ): ?>
		<button  class="secondary fast-admin-delete-message" data-mode="fastadmin"><?= wfMessage( 'wall-message-fast-admin-delete-message' )->escaped() ?></button>
	<? endif; ?>

	<? if ( !${WallConst::isClosed} ): ?>
		<button class="quote-button secondary"><?= wfMessage( 'wall-message-quote-button' )->escaped() ?></button>
	<? endif; ?>

	<?php
		$dropdown = [ ];

		if ( ${WallConst::canEdit} ) {
			$dropdown[] = [
				'class' => 'edit-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-edit' )->escaped(),
			];
		}

		$dropdown[] = [
			'class' => 'thread-history',
			'href' => ${WallConst::threadHistoryLink},
			'text' => wfMessage( 'history_short' )->escaped(),
		];

		if ( ${WallConst::canAdminDelete} ) {
			$dropdown[] = [
				'attr' => 'data-mode="admin"',
				'class' => 'admin-delete-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-delete' )->escaped(),
			];
		}

		if ( ${WallConst::showViewSource} ) {
			$dropdown[] = [
				'class' => 'source-message',
				'href' => '#',
				'text' => wfMessage( 'user-action-menu-view-source' )->escaped(),
			];
		}

		if ( ${WallConst::canRemove} ) {
			$dropdown[] = [
				'attr' => 'data-mode="remove"',
				'class' => 'remove-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-remove' )->escaped(),
			];
		}

		if ( ${WallConst::canDelete} ) {
			$dropdown[] = [
				'attr' => 'data-mode="rev"',
				'class' => 'delete-message',
				'href' => '#',
				'text' => wfMessage( 'wall-message-rev-delete' )->escaped(),
			];
		}

		if ( ${WallConst::canNotifyeveryone} ) {
			$dropdown[] = [
				'attr' => 'data-dir="1"',
				'class' => 'edit-notifyeveryone',
				'href' => '#',
				'text' => wfMessage( 'wall-message-notifyeveryone' )->escaped(),
			];
		}

		if ( ${WallConst::canUnnotifyeveryone} ) {
			$dropdown[] = [
				'attr' => 'data-mode="0"',
				'class' => 'edit-notifyeveryone',
				'href' => '#',
				'text' => wfMessage( 'wall-message-unnotifyeveryone' )->escaped(),
			];
		}

		if ( ${WallConst::canClose} ) {
			$dropdown[] = [
				'attr' => 'data-mode="close"',
				'class' => 'close-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-close-thread' )->escaped(),
			];
		}

		if ( ${WallConst::canReopen} ) {
			$dropdown[] = [
				'class' => 'reopen-thread',
				'href' => '#',
				'text' => wfMessage( 'wall-message-reopen-thread' )->escaped(),
			];
		}

		if ( ${WallConst::canMove} ) {
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
<?php //TODO: This is hack for now unification buttons for all skins ASAP!!! ?>
<div class="buttons-monobook">
	<!-- only show this if it's user's own message -->
	<span class="tools">
		<? if( ${WallConst::canFastAdminDelete} ): ?>
			<a href="#"  class="fast-admin-delete-message" data-mode="fastadmin"><?= wfMessage( 'wall-message-fast-admin-delete-message' )->escaped() ?></a>
		<? endif; ?>

		<? if ( !${WallConst::isClosed} ): ?>
			<a href="#" class="quote-button"><?= wfMessage( 'wall-message-quote-button' )->escaped() ?></a>
		<? endif; ?>

		<? if ( ${WallConst::canClose} ): ?>
			<a href="#" class="close-thread" data-mode="close"> <?= wfMessage( 'wall-message-close-thread' )->escaped(); ?> </a>
		<? endif; ?>

		<? if ( ${WallConst::canReopen}): ?>
			<a href="#" class="reopen-thread"> <?= wfMessage( 'wall-message-reopen-thread' )->escaped(); ?> </a>
		<? endif; ?>

		<? if ( ${WallConst::showViewSource} ): ?>
			<a href="#" class="source-message"> <?= wfMessage( 'user-action-menu-view-source' )->escaped(); ?> </a>
		<? endif; ?>

		<a href="<?= ${WallConst::threadHistoryLink} ?>" class="thread-history"> <?= wfMessage( 'history_short' )->escaped(); ?> </a>

		<?php if ( ${WallConst::canEdit} ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMessage( 'wall-message-edit' )->escaped(); ?></a>
		<?php endif; ?>

		<? if ( ${WallConst::canRemove} ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="remove"><?= wfMessage( 'wall-message-remove' )->escaped(); ?> </a>
		<? endif; ?>

		<? if ( ${WallConst::canAdminDelete} ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="admin"><?= wfMessage( 'wall-message-delete' )->escaped(); ?> </a>
		<?php endif;?>

		<?php if ( ${WallConst::canDelete} ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMessage( 'wall-message-rev-delete' )->escaped(); ?></a>
		<?php endif; ?>

		<? if ( ${WallConst::canNotifyeveryone} ): ?>
			<a href="#" class="edit-notifyeveryone" data-dir="1"> <?= wfMessage( 'wall-message-notifyeveryone' )->escaped(); ?> </a>
		<? endif; ?>
		<? if ( ${WallConst::canUnnotifyeveryone} ): ?>
			<a href="#" class="edit-notifyeveryone" data-mode="0"> <?= wfMessage( 'wall-message-unnotifyeveryone' )->escaped(); ?> </a>
		<? endif; ?>
		<? if ( ${WallConst::canMove} ): ?>
			<a href="#" class="move-thread"> <?= wfMessage( 'wall-message-move-thread' )->escaped(); ?> </a>
		<? endif; ?>

	</span>
</div>
