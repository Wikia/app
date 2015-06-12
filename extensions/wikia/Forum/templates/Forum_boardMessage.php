<li class="SpeechBubble message <?php echo ($removedOrDeletedMessage ? 'hide ':'') . ($showRemovedBox?' message-removed':''); ?> <? echo 'message-'.$linkid ?>" id="<? echo $linkid ?>" data-id="<? echo $id ?>" data-is-reply="<?= $isreply == true ?>" <? if($hide):?> style="display:none" <? endif;?> >
	THIS IS FORUM BOARD TEMAPLTE (Forum_boardMessage.php)
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
	<div class="speech-bubble-message">
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render();
		endif; ?>
		<? if(!$isreply): ?>
			<?php if($isWatched): ?>
				<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="1" class="follow wikia-button"><?= wfMsg('wikiafollowedpages-following'); ?></a>
			<?php else: ?>
				<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg('oasis-follow'); ?></a>
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
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render();
		endif; ?>
		<div class="msg-body" id="WallMessage_<?= $id ?>">
			<? echo $body ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render();
		endif; ?>
		<div class="msg-toolbar">
			<div class="timestamp">
				<?php if($isEdited):?>
					<? echo wfMsg('wall-message-edited', array( $editorUrl, $editorName, $historyUrl )); ?>
				<?php endif; ?>
				<a href="<?= $fullpageurl; ?>" class="permalink" tabindex="-1">
					<?php if (!is_null($iso_timestamp)): ?>
					<span class="timeago abstimeago" title="<?= $iso_timestamp ?>" alt="<?= $fmt_timestamp ?>">&nbsp;</span>
					<span class="timeago-fmt"><?= $fmt_timestamp ?></span>
					<?php else: ?>
						<span><?= $fmt_timestamp ?></span>
					<?php endif; ?>
				</a>
				<div class="buttonswrapper">
					<?= $app->renderView( 'WallController', 'messageButtons', array('comment' => $comment)); ?>
				</div>
			</div>
			<div class="edit-buttons sourceview">
				<button class="wikia-button cancel-edit cancel-source"><?php echo wfMsg('wall-button-done-source'); ?></button>
			</div>
			<div class="edit-buttons edit" id="WallMessage_<?= $id ?>Buttons" data-space-type="buttons">
				<button class="wikia-button save-edit"><?php echo wfMsg('wall-button-save-changes'); ?></button>
				<button class="wikia-button cancel-edit secondary"><?php echo wfMsg('wall-button-cancel-changes'); ?></button>
			</div>
		</div>
	</div>
</li>
