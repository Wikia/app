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
								<a href="#" class="edit-message"><?= wfMsg( 'wall-message-edit' ); ?></a>
							</li>
						<? endif; ?>
						<li>
							<a href="<?= $threadHistoryLink; ?>" class="thread-history"><?= wfMsg( 'history_short' ); ?></a>
						</li>
						<? if ( $canAdminDelete ): ?>
						<li>
							<a href="#" class="admin-delete-message" data-mode="admin"> <?= wfMsg( 'wall-message-delete' ); ?> </a>
						</li>
						<? endif; ?>
						<? if ( $showViewSource ): ?>
							<li>
								<a href="#" class="source-message"> <?= wfMsg( 'user-action-menu-view-source' ); ?> </a>
							</li>
						<? endif; ?>
						<? if ( $canRemove ): ?>
						<li>
							<a href="#" class="remove-message" data-mode="remove"> <?= wfMsg( 'wall-message-remove' ); ?> </a>
						</li>
						<? endif; ?>
						<? if ( $canDelete ): ?>
							<li>
								<a href="#" class="delete-message" data-mode="rev"> <?= wfMsg( 'wall-message-rev-delete' ); ?> </a>
							</li>
						<? endif; ?>

						<? if ( $notifyeveryone ): ?>
							<li>
								<a href="#" class="edit-notifyeveryone" data-dir="1"> <?= wfMsg( 'wall-message-notifyeveryone' ); ?> </a>
							</li>
						<? endif; ?>
						<? if ( $unnotifyeveryone ): ?>
							<li>
								<a href="#" class="edit-notifyeveryone" data-mode="0"> <?= wfMsg( 'wall-message-unnotifyeveryone' ); ?> </a>
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
					<a href="#" class="source-message"> <?= wfMsg( 'user-action-menu-view-source' ); ?> </a>
				<? endif; ?>

				<?php if ( $canEdit ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMsg( 'wall-message-edit' ); ?></a>
				<?php endif; ?>

				<? if ( $canRemove ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="remove"><?= wfMsg( 'wall-message-remove' ); ?> </a>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="remove-message" data-mode="removenotify"><?= wfMsg( 'wall-message-notify' ); ?> </a>
				<? endif; ?>

				<? if ( $canAdminDelete ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="admin"><?= wfMsg( 'wall-message-delete' ); ?> </a>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="admin-delete-message" data-mode="adminnotify"><?= wfMsg( 'wall-message-notify' ); ?> </a>
				<?php endif; ?>

				<?php if ( $canDelete ): ?>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMsg( 'wall-message-delete' ); ?></a>
				<?php endif; ?>

			</span>
		</div>
<?php endif; ?>