<div class="buttons">
	
	<? if($canFastAdminDelete): ?>
		<button  class="secondary fast-admin-delete-message" data-mode="fastadmin"><?= wfMsg('wall-message-fast-admin-delete-message') ?></button>
	<? endif; ?>

	<button class="quote-button secondary"><?= wfMsg('wall-message-quote-button') ?></button>
	
	<?php
		$dropdown = array();

		if($canEdit) {
			$dropdown[] = array(
				'class' => 'edit-message',
				'href' => '#',
				'text' => wfMsg('wall-message-edit'),
			);
		}

		$dropdown[] = array(
			'class' => 'thread-history',
			'href' => $threadHistoryLink,
			'text' => wfMsg('history_short')
		);

		if($canAdminDelete) {
			$dropdown[] = array(
				'attr' => 'data-mode="admin"',
				'class' => 'admin-delete-message',
				'href' => '#',
				'text' => wfMsg('wall-message-delete'),
			);
		}

		if($showViewSource) {
			$dropdown[] = array(
				'class' => 'source-message',
				'href' => '#',
				'text' => wfMsg('user-action-menu-view-source'),
			);
		}

		if($canRemove) {
			$dropdown[] = array(
				'attr' => 'data-mode="remove"',
				'class' => 'remove-message',
				'href' => '#',
				'text' => wfMsg('wall-message-remove'),
			);
		}

		if($canDelete) {
			$dropdown[] = array(
				'attr' => 'data-mode="rev"',
				'class' => 'delete-message',
				'href' => '#',
				'text' => wfMsg('wall-message-rev-delete'),
			);
		}

		if($canNotifyeveryone) {
			$dropdown[] = array(
				'attr' => 'data-dir="1"',
				'class' => 'edit-notifyeveryone',
				'href' => '#',
				'text' => wfMsg('wall-message-notifyeveryone'),
			);
		}

		if($canUnnotifyeveryone) {
			$dropdown[] = array(
				'attr' => 'data-mode="0"',
				'class' => 'edit-notifyeveryone',
				'href' => '#',
				'text' => wfMsg('wall-message-unnotifyeveryone'),
			);
		}

		if($canClose) {
			$dropdown[] = array(
				'attr' => 'data-mode="close"',
				'class' => 'close-thread',
				'href' => '#',
				'text' => wfMsg('wall-message-close-thread'),
			);
		}

		if($canReopen) {
			$dropdown[] = array(
				'class' => 'reopen-thread',
				'href' => '#',
				'text' => wfMsg('wall-message-reopen-thread'),
			);
		}
		
		if($canMove) {
			$dropdown[] = array(
				'class' => 'move-thread',
				'href' => '#',
				'text' => wfMsg('wall-message-move-thread'),
			);
		}
	?>
	<?php if(!empty($dropdown)): ?>
		<?= F::app()->renderView('MenuButton',
			'Index',
			array(
				'action' => array("text" => wfMsg('wall-message-more'), "id" => ""),
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
		<? if($canFastAdminDelete): ?>
			<a href="#"  class="fast-admin-delete-message" data-mode="fastadmin"><?= wfMsg('wall-message-fast-admin-delete-message') ?></a>
		<? endif; ?>
		
		<a href="#" class="quote-button"><?= wfMsg('wall-message-quote-button') ?></a>
		
		<? if( $canClose ): ?>
		 	<a href="#" class="close-thread" data-mode="close"> <?= wfMsg('wall-message-close-thread'); ?> </a>
		 <? endif; ?>
		 
		<? if( $canReopen): ?>
		 	<a href="#" class="reopen-thread"> <?= wfMsg('wall-message-reopen-thread'); ?> </a>
		<? endif; ?>
		
		<? if( $showViewSource ): ?>
			<a href="#" class="source-message"> <?= wfMsg('user-action-menu-view-source'); ?> </a>
		<? endif; ?>

                <a href="<?= $threadHistoryLink ?>" class="thread-history"> <?= wfMsg('history_short'); ?> </a>

		<?php if( $canEdit ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMsg('wall-message-edit'); ?></a>
		<?php endif; ?>

		<? if( $canRemove ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="remove"><?= wfMsg('wall-message-remove'); ?> </a>
		<? endif; ?>

		<? if( $canAdminDelete ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="admin"><?= wfMsg('wall-message-delete'); ?> </a>
		<?php endif;?>

		<?php if( $canDelete ): ?>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMsg('wall-message-delete'); ?></a>
		<?php endif; ?>

		 <? if( $canNotifyeveryone ): ?>
		 	<a href="#" class="edit-notifyeveryone" data-dir="1"> <?= wfMsg('wall-message-notifyeveryone'); ?> </a>
		 <? endif; ?>
		 <? if( $canUnnotifyeveryone ): ?>
		 	<a href="#" class="edit-notifyeveryone" data-mode="0"> <?= wfMsg('wall-message-unnotifyeveryone'); ?> </a>
		 <? endif; ?>
		 <? if( $canMove ): ?>
		 	<a href="#" class="move-thread"> <?= wfMsg('wall-message-move-thread'); ?> </a>
		 <? endif; ?>

	</span>
</div>
