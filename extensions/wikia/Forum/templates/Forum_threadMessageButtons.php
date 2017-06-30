<? if ( $canEdit || $canRemove || $canDelete || $showViewSource || ( $isRemoved && !$isAnon ) ): ?>
		<div class="buttons">
			<div data-delay='50' class="wikia-menu-button contribute secondary">
				<?= wfMsg( 'wall-message-more' ); ?>
				<span class="drop">
					<img class="chevron"  src="<?= $wgBlankImgUrl; ?>" >
				</span>

				<ul style="min-width: 95px;">
						<?php // TODO: loop ?>
						<? if ( $canEdit ): ?>
							<li>
								<a href="#" class="edit-message"><?= wfMessage( 'wall-message-edit' )->escaped(); ?></a>
							</li>
						<? endif; ?>
						<li>
							<a href="<?= $threadHistoryLink; ?>" class="thread-history"><?= wfMessage( 'history_short' )->escaped(); ?></a>
						</li>
						<? if ( $canAdminDelete ): ?>
						<li>
							<a href="#" class="admin-delete-message" data-mode="admin"> <?= wfMessage( 'wall-message-delete' )->escaped(); ?> </a>
						</li>
						<? endif; ?>
						<? if ( $showViewSource ): ?>
							<li>
								<a href="#" class="source-message"> <?= wfMessage( 'user-action-menu-view-source' )->escaped(); ?> </a>
							</li>
						<? endif; ?>
						<? if ( $canRemove ): ?>
						<li>
							<a href="#" class="remove-message" data-mode="remove"> <?= wfMessage( 'wall-message-remove' )->escaped(); ?> </a>
						</li>
						<? endif; ?>
						<? if ( $canDelete ): ?>
							<li>
								<a href="#" class="delete-message" data-mode="rev"> <?= wfMessage( 'wall-message-rev-delete' )->escaped(); ?> </a>
							</li>
						<? endif; ?>

						<? if ( $notifyeveryone ): ?>
							<li>
								<a href="#" class="edit-notifyeveryone" data-dir="1"> <?= wfMessage( 'wall-message-notifyeveryone' )->escaped(); ?> </a>
							</li>
						<? endif; ?>
						<? if ( $unnotifyeveryone ): ?>
							<li>
								<a href="#" class="edit-notifyeveryone" data-mode="0"> <?= wfMessage( 'wall-message-unnotifyeveryone' )->escaped(); ?> </a>
							</li>
						<? endif; ?>
				</ul>
			</div>
		</div>
		<?php // TODO: This is hack for now unification buttons for all skins ASAP!!! ?>
		<div class="buttons-monobook">
			<!-- only show this if it's user's own message -->
			<span class="tools">
				<? if ( $showViewSource ): ?>
					<a href="#" class="source-message"> <?= wfMessage( 'user-action-menu-view-source' )->escaped(); ?> </a>
				<? endif; ?>

				<?php if ( $canEdit ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMessage( 'wall-message-edit' )->escaped(); ?></a>
				<?php endif; ?>

				<? if ( $canRemove ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="remove"><?= wfMessage( 'wall-message-remove' )->escaped(); ?> </a>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="removenotify"><?= wfMessage( 'wall-message-notify' )->escaped(); ?> </a>
				<? endif; ?>

				<? if ( $canAdminDelete ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="admin"><?= wfMessage( 'wall-message-delete' )->escaped(); ?> </a>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="adminnotify"><?= wfMessage( 'wall-message-notify' )->escaped(); ?> </a>
				<?php endif; ?>

				<?php if ( $canDelete ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMessage( 'wall-message-delete' )->escaped(); ?></a>
				<?php endif; ?>

			</span>
		</div>
<?php endif; ?>
