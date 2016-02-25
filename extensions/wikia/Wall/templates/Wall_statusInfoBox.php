<?php if ( !empty( ${WallConst::statusInfo} ) ): ?>
	<?php if ( ${WallConst::showRemoveOrDeleteInfo} ): ?>
			<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble tail">
				<div class="avatar"><?= AvatarService::renderAvatar( ${WallConst::statusInfo}['user']->getName(), 20 ) ?></div>
				<div class="message">
					<? if( ${WallConst::isreply} ): ?>
						<?= wfMessage( 'wall-message-' . ${WallConst::statusInfo}['status'] . '-reply-because', [ ${WallConst::statusInfo}['user_displayname_linked'] ] )->text(); ?><br />
					<? else: ?>
						<?= wfMessage( 'wall-message-' . ${WallConst::statusInfo}['status'] . '-thread-because', [ ${WallConst::statusInfo}['user_displayname_linked'] ] )->text(); ?><br />
					<? endif; ?>
					<div class="reason"><?= Linker::formatComment( ${WallConst::statusInfo}['reason'] ); ?></div>
					<div class="timestamp"><span><?= ${WallConst::statusInfo}['fmttime']; ?></span></div>
				</div>
			</div>
			</td><td>
			<? if(${WallConst::isreply}): ?>
				<button <?= ( ${WallConst::canRestore} ? '' : 'disabled=disabled' ); ?>  data-mode='restore<?= ( ${WallConst::fastrestore} ? '-fast' : '' ); ?>' data-id="<?= ${WallConst::id}; ?>"  class="message-restore wikia-button" ><?= wfMessage( 'wall-message-restore-reply' )->escaped(); ?></button>
			<? else: ?>
				<button <?= ( ${WallConst::canRestore} ? '' : 'disabled=disabled' ); ?> data-mode='restore<?= ( ${WallConst::fastrestore} ? '-fast' : '' ); ?>' data-id="<?= ${WallConst::id}; ?>"  class="message-restore wikia-button" ><?= wfMessage( 'wall-message-restore-thread' )->escaped(); ?></button>
			<? endif; ?>
			</td></tr></table>
		</div>
	<?php endif; ?>

	<? if ( ${WallConst::showArchiveInfo} ): ?>
		<div class="deleteorremove-infobox">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar( ${WallConst::statusInfo}['user']->getName(), 20 ) ?></div>
				<div class="message">
					<? if ( isset( ${WallConst::statusInfo}['reason'] ) && mb_strlen( ${WallConst::statusInfo}['reason'] ) ): ?>
						<?= wfMessage( 'wall-message-closed-by-because', [ ${WallConst::statusInfo}['user_displayname_linked'] ] )->text(); ?><br>
						<div class="reason"><?= Linker::formatComment( ${WallConst::statusInfo}['reason'] ); ?></div>
					<? else: ?>
						<?= wfMessage( 'wall-message-closed-by', [ ${WallConst::statusInfo}['user']->getName(), ${WallConst::statusInfo}['user']->getUserPage() ] )->parse(); ?><br>
					<? endif; ?>
					<div class="timestamp"><span><?= ${WallConst::statusInfo}['fmttime']; ?></span></div>
				</div>
			</div>
		</div>
	<? endif; ?>
<?php endif; ?>
