<?php if(!empty($statusInfo)): ?>
	<?php if($showRemoveOrDeleteInfo): ?>
			<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble tail">
				<div class="avatar"><?= AvatarService::renderAvatar($statusInfo['user']->getName(), 20) ?></div>
				<div class="message">
					<? if($isreply): ?>
						<?= wfMsgExt('wall-message-'.$statusInfo['status'].'-reply-because',array( 'parsemag'), array($statusInfo['user_displayname_linked'])); ?><br />
					<? else: ?>
						<?= wfMsgExt('wall-message-'.$statusInfo['status'].'-thread-because',array( 'parsemag'), array($statusInfo['user_displayname_linked'])); ?><br />
					<? endif; ?>
					<div class="reason"><?php echo $statusInfo['reason']; ?></div>
					<div class="timestamp"><span><?php echo $statusInfo['fmttime']; ?></span></div>
				</div>
			</div>
			</td><td>
			<? if($isreply): ?>
				<button <? echo ($canRestore ? '':'disabled=disbaled') ?>  data-mode='restore<?php echo ($fastrestore ? '-fast':'') ?>' data-id="<?php echo $id; ?>"  class="message-restore wikia-button" ><?php echo wfMsg('wall-message-restore-reply'); ?></button>
			<? else: ?>
				<button <? echo ($canRestore ? '':'disabled=disbaled') ?> data-mode='restore<?php echo ($fastrestore ? '-fast':'') ?>' data-id="<?php echo $id; ?>"  class="message-restore wikia-button" ><?php echo wfMsg('wall-message-restore-thread'); ?></button>
			<? endif; ?>
			</td></tr></table>
		</div>
	<?php endif; ?>
	
	<? if($showArchiveInfo): ?>
		<div class="deleteorremove-infobox">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar($statusInfo['user']->getName(), 20) ?></div>
				<div class="message">
					<?= wfMsgExt('wall-message-closed-by', array('parseinline'), array($statusInfo['user']->getName(), $statusInfo['user']->getUserPage()) ) ?><br>
					<div class="timestamp"><span><?php echo $statusInfo['fmttime']; ?></span></div>
				</div>
			</div>
		</div>
	<? endif; ?>	
	
<?php endif; ?>