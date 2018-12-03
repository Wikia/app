<?php if ( $canEdit || $canRemove || $canDelete || $showViewSource || ( $isRemoved && !$isAnon ) ): ?>
		<div class="buttons">
			<div data-delay='50' class="wikia-menu-button contribute secondary">
				<?= wfMsg( 'wall-message-more' ); ?>
				<span class="drop">
					<img class="chevron"  src="<?= $wgBlankImgUrl; ?>" >
				</span>

				<ul style="min-width: 95px;">
						<?php // TODO: loop ?>
						<?php if ( $canEdit ): ?>
							<li>
								<a href="#" class="edit-message"><?= wfMessage( 'wall-message-edit' )->escaped(); ?></a>
							</li>
						<?php endif; ?>
						<li>
							<a href="<?= $threadHistoryLink; ?>" class="thread-history"><?= wfMessage( 'history_short' )->escaped(); ?></a>
						</li>
						<?php if ( $canAdminDelete ): ?>
						<li>
							<a href="#" class="admin-delete-message" data-mode="admin"> <?= wfMessage( 'wall-message-delete' )->escaped(); ?> </a>
						</li>
						<?php endif; ?>
						<?php if ( $showViewSource ): ?>
							<li>
								<a href="#" class="source-message"> <?= wfMessage( 'user-action-menu-view-source' )->escaped(); ?> </a>
							</li>
						<?php endif; ?>
						<?php if ( $canRemove ): ?>
						<li>
							<a href="#" class="remove-message" data-mode="remove"> <?= wfMessage( 'wall-message-remove' )->escaped(); ?> </a>
						</li>
						<?php endif; ?>
						<?php if ( $canDelete ): ?>
							<li>
								<a href="#" class="delete-message" data-mode="rev"> <?= wfMessage( 'wall-message-rev-delete' )->escaped(); ?> </a>
							</li>
						<?php endif; ?>
				</ul>
			</div>
		</div>
<?php endif; ?>
