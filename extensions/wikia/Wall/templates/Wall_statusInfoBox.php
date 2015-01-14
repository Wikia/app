<?php if ( !empty( $statusInfo ) ): ?>
	<?php if ( $showRemoveOrDeleteInfo ): ?>
			<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble tail">
				<div class="avatar"><?= AvatarService::renderAvatar( $statusInfo['user']->getName(), 20 ) ?></div>
				<div class="message">
					<? if( $isreply ): ?>
						<?= wfMessage( 'wall-message-' . $statusInfo['status'] . '-reply-because', [ $statusInfo['user_displayname_linked'] ] )->text(); ?><br />
					<? else: ?>
						<?= wfMessage( 'wall-message-' . $statusInfo['status'] . '-thread-because', [ $statusInfo['user_displayname_linked'] ] )->text(); ?><br />
					<? endif; ?>
					<div class="reason"><?= Linker::formatComment( $statusInfo['reason'] ); ?></div>
					<div class="timestamp"><span><?= $statusInfo['fmttime']; ?></span></div>
				</div>
			</div>
			</td><td>
			<? if($isreply): ?>
				<button <?= ( $canRestore ? '' : 'disabled=disabled' ); ?>  data-mode='restore<?= ( $fastrestore ? '-fast' : '' ); ?>' data-id="<?= $id; ?>"  class="message-restore wikia-button" ><?= wfMessage( 'wall-message-restore-reply' )->escaped(); ?></button>
			<? else: ?>
				<button <?= ( $canRestore ? '' : 'disabled=disabled' ); ?> data-mode='restore<?= ( $fastrestore ? '-fast' : '' ); ?>' data-id="<?= $id; ?>"  class="message-restore wikia-button" ><?= wfMessage( 'wall-message-restore-thread' )->escaped(); ?></button>
			<? endif; ?>
			</td></tr></table>
		</div>
	<?php endif; ?>

	<? if ( $showArchiveInfo ): ?>
		<div class="deleteorremove-infobox">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar( $statusInfo['user']->getName(), 20 ) ?></div>
				<div class="message">
					<? if ( isset( $statusInfo['reason'] ) && mb_strlen( $statusInfo['reason'] ) ): ?>
						<?= wfMessage( 'wall-message-closed-by-because', [ $statusInfo['user_displayname_linked'] ] )->text(); ?><br>
						<div class="reason"><?= Linker::formatComment( $statusInfo['reason'] ); ?></div>
					<? else: ?>
						<?= wfMessage( 'wall-message-closed-by', [ $statusInfo['user']->getName(), $statusInfo['user']->getUserPage() ] )->parse(); ?><br>
					<? endif; ?>
					<div class="timestamp"><span><?= $statusInfo['fmttime']; ?></span></div>
				</div>
			</div>
		</div>
	<? endif; ?>
<?php endif; ?>
