<?php if(!empty($statusInfo)): ?>
	<?php if($showRemoveOrDeleteInfo): ?>
			<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble tail">
				<div class="avatar"><?= AvatarService::renderAvatar($statusInfo['user']->getName(), 20) ?></div>
				<div class="message">
					<? if($isreply): ?>
						<?= wfMessage('wall-message-'.$statusInfo['status'].'-reply-because', array($statusInfo['user_displayname_linked']))->text(); ?><br />
					<? else: ?>
						<?= wfMessage('wall-message-'.$statusInfo['status'].'-thread-because', array($statusInfo['user_displayname_linked']))->text(); ?><br />
					<? endif; ?>
					<div class="reason"><?php echo $statusInfo['reason']; ?></div>
					<div class="timestamp"><span><?php echo $statusInfo['fmttime']; ?></span></div>
				</div>
			</div>
			</td><td>
			<? if($isreply): ?>
				<button <? echo ($canRestore ? '':'disabled=disbaled') ?>  data-mode='restore<?php echo ($fastrestore ? '-fast':'') ?>' data-id="<?php echo $id; ?>"  class="message-restore wikia-button" ><?php echo wfMessage('wall-message-restore-reply')->text(); ?></button>
			<? else: ?>
				<button <? echo ($canRestore ? '':'disabled=disbaled') ?> data-mode='restore<?php echo ($fastrestore ? '-fast':'') ?>' data-id="<?php echo $id; ?>"  class="message-restore wikia-button" ><?php echo wfMessage('wall-message-restore-thread')->text(); ?></button>
			<? endif; ?>
			</td></tr></table>
		</div>
	<?php endif; ?>
	
	<? if($showArchiveInfo): ?>
		<div class="deleteorremove-infobox">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar($statusInfo['user']->getName(), 20) ?></div>
				<div class="message">
					<? if ( isset($statusInfo['reason']) && mb_strlen($statusInfo['reason']) ): ?>
						<?= wfMessage('wall-message-closed-by-because', array($statusInfo['user_displayname_linked']))->text(); ?><br>
						<div class="reason"><?php echo $statusInfo['reason']; ?></div>
					<? else: ?>
						<?= wfMessage('wall-message-closed-by', array($statusInfo['user']->getName(), $statusInfo['user']->getUserPage()))->parse(); ?><br>
					<? endif; ?>
					<div class="timestamp"><span><?php echo $statusInfo['fmttime']; ?></span></div>
				</div>
			</div>
		</div>
	<? endif; ?>
<?php endif; ?>

