<li class="SpeechBubble message <?php echo ($removedOrDeletedMessage ? 'hide ':'') . ($showRemovedBox?' message-removed':''); ?> <? echo 'message-'.$linkid ?>" id="<? echo $linkid ?>" data-id="<? echo $id ?>" data-is-reply="<?= $isreply == true ?>" <? if($hide):?> style="display:none" <? endif;?> >
	<?php if(($showDeleteOrRemoveInfo) && (!empty($deleteOrRemoveInfo) )): ?>
		<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar($deleteOrRemoveInfo['user']->getName(), 20) ?></div>
				<div class="message">
					<? if($isreply): ?>
					<?= wfMsgExt('wall-message-'.$deleteOrRemoveInfo['status'].'-reply-because',array( 'parsemag'), array($deleteOrRemoveInfo['user_displayname_linked'])); ?><br />
					<? else: ?>
					<?= wfMsgExt('wall-message-'.$deleteOrRemoveInfo['status'].'-thread-because',array( 'parsemag'), array($deleteOrRemoveInfo['user_displayname_linked'])); ?><br />
					<? endif; ?>
					<div class="reason"><?php echo $deleteOrRemoveInfo['reason']; ?></div>
					<div class="timestamp"><span><?php echo $deleteOrRemoveInfo['fmttime']; ?></span></div>
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
	
	<? if($showRemovedBox): ?>
		<div class='removed-info speech-bubble-message-removed' >
			<?php echo wfMsg('wall-removed-reply'); ?>
		</div>
	<? endif; ?>
	
	<div class="speech-bubble-avatar">
		<a href="<?= $user_author_url ?>">
			<? if(!$isreply): ?>
				<?= AvatarService::renderAvatar($username, 50) ?>
			<? else: ?>
				<?= AvatarService::renderAvatar($username, 30) ?>
			<? endif ?>
		</a>
	</div>
	<blockquote class="speech-bubble-message">
		<? if(!$isreply): ?>
			<?php if($isWatched): ?>
				<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="1" class="follow wikia-button"><?= wfMsg('wall-message-following'); ?></a>
			<?php else: ?>	
				<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg('wall-message-follow'); ?></a>
			<?php endif;?>
			<div class="msg-title"><a href="<?= $fullpageurl; ?>"><? echo $feedtitle ?></a></div>
		<? endif; ?>
		<div class="edited-by">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a> 
			<a href="<?= $user_author_url ?>" class="subtle"><?= $displayname2 ?></a>
			<?php if( !empty($isStaff) ): ?> 
				<span class="stafflogo"></span>
			<?php endif; ?>
		</div>
		<div class="msg-body">
			<? echo $body ?>
		</div>
		
		<div class="timestamp" style="clear:both">
			<?php if($isEdited):?>
				<? echo wfMsg('wall-message-edited', array('$1' => $editorUrl, '$2' => $editorName, '$3' => $historyUrl )); ?>
			<?php endif; ?>
			<a  href="<?= $fullpageurl; ?>" class="permalink" tabindex="-1">
				<?php if (!is_null($iso_timestamp)): ?>
				<span class="timeago abstimeago" title="<?= $iso_timestamp ?>" alt="<?= $fmt_timestamp ?>">&nbsp;</span>
				<span class="timeago-fmt"><?= $fmt_timestamp ?></span>
				<?php else: ?>
					<span><?= $fmt_timestamp ?></span>
				<?php endif; ?>
			</a>
			<div class="buttonswrapper">
				<?= $app->renderView( 'WallController', 'messageButtons', array('comment' => $comment)) ; ?>
			</div>
			
		</div>
	</blockquote>
	<? if(!$isreply): ?>
		<ul class="replies">
			<? if(!empty($replies)): ?>
				<? $i =0;?>
				<? if($showLoadMore): ?>
					<?= $app->renderView( 'WallController', 'loadMore', array('repliesNumber' => $repliesNumber) ); ?>
				<? endif; ?>	
				<? foreach( $replies as $key  => $val): ?>
					<?php //TODO: move this logic to controler !!! ?>
					<?php if(!$val->isRemove() || $showDeleteOrRemoveInfo): ?>
						<?= $app->renderView( 'WallController', 'message', array('showDeleteOrRemoveInfo' => $showDeleteOrRemoveInfo, 'comment' => $val, 'isreply' => true, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i)  ) ; ?>
					<?php else: ?>
						<?= $app->renderView( 'WallController', 'messageRemoved', array('comment' => $val, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i)) ; ?>	
					<?php endif; ?>	
					<? $i++; ?>
				<? endforeach; ?>
			<? endif; ?>
			<?= $app->renderView( 'WallController', 'reply', array('showReplyForm' => $showReplyForm )); ?>
		</ul>
	<? endif; ?>
</li>
