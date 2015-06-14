<li class="SpeechBubble message <?php echo ($isreply ? '':'message-main'); ?> <?php echo ($removedOrDeletedMessage ? 'hide ':'') . ($showRemovedBox?' message-removed':''); ?> <? echo 'message-'.$linkid ?>" id="<? echo $linkid ?>" data-id="<? echo $id ?>" data-is-reply="<?= $isreply == true ?>" <? if($collapsed):?> style="display:none" <? endif;?> >	
	<?php echo $head ?>
	<?php echo $app->renderView( 'WallController', 'statusInfoBox', array('showDeleteOrRemoveInfo' => $showDeleteOrRemoveInfo, 'comment' => $comment) ); ?>
	
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
		<? if(!$isreply): ?>
			<?php if($isWatched): ?>
				<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="1" class="follow wikia-button"><?= wfMsg('wikiafollowedpages-following'); ?></a>
			<?php else: ?>
				<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg('oasis-follow'); ?></a>
			<?php endif;?>
		<? endif; ?>

		<?php if($showVotes): ?>
			<div class="voting-controls">
				<a class="votes<?= $votes > 0 ? "" : " notlink" ?>" data-votes="<?= $votes ?>">
					<?= wfMsg('wall-votes-number', '<span class="number" >'.$votes.'</span>') ?>
				</a>			
				<?php if($canVotes):?>
					<a class="vote <?php if($isVoted): ?>voted<?php endif;?>">
						<img src="<?= $wg->BlankImgUrl ?>" height="19" width="19" >
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>	
		
		
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Header', 'Wall_message', array(
				'attributes' => array( 'data-min-height' => 100, 'data-max-height' => 400 )
			));
		endif; ?>
		<? if(!$isreply): ?>
			<div class="msg-title"><a href="<?= $fullpageurl; ?>"><? echo $feedtitle ?></a></div>
		<? endif; ?>
		
		<div class="edited-by">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a>
			<a href="<?= $user_author_url ?>" class="subtle"><?= $displayname2 ?></a>
			<?php if( !empty($isStaff) ): ?>
				<span class="stafflogo"></span>
			<?php endif; ?>
		</div>
		
		<?php if($quote_of): ?>
		<div class="quote-of">
			<a href="<?php echo $quote_of_url; ?>" data-postfix="<?php echo $quote_of_postfix; ?>" >
				<?= wfMsg('wall-quote-reply-to', $quote_of_postfix) ?>
			</a>
		</div>
		<?php endif; ?>
		
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Editor_Header', 'Wall_message' );
		endif; ?>
		<div class="msg-body" id="WallMessage_<?= $id ?>">
			<? echo $body ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Editor_Footer', 'Wall_message' );
		endif; ?>
		<div class="msg-toolbar">
			<div class="timestamp">
				<?php if($isEdited):?>
					<? if($showSummary): ?> 
						<? echo wfMsg('wall-message-edited-summary', array('$1' => $summary, '$2' => $editorUrl, '$3' => $editorName, '$4' => $historyUrl )); ?>
					<? else: ?> 	
						<? echo wfMsg('wall-message-edited', array( '$1' => $editorUrl, '$2' => $editorName, '$3' => $historyUrl )); ?>
					<? endif; ?>
				<?php endif; ?>
				<a href="<?= $fullpageurl; ?>" class="permalink" tabindex="-1">
					<?php if (!is_null($iso_timestamp)): ?>
					<span class="timeago abstimeago" title="<?= $iso_timestamp ?>" alt="<?= $fmt_timestamp ?>">&nbsp;</span>
					<span class="timeago-fmt"><?= $fmt_timestamp ?></span>
					<?php else: ?>
						<span><?= $fmt_timestamp ?></span>
					<?php endif; ?>
				</a>
			</div>
			<div class="buttonswrapper">
				<?= $app->renderView( 'WallController', 'messageButtons', array('comment' => $comment)); ?>
			</div>
			<?= $app->renderPartialCached( 'WallController', 'messageEditButtons', 'Wall_message' ); ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Footer', 'Wall_message' );
		endif; ?>
	</div>
	
	<?php echo $app->renderView( 'WallController', 'statusInfoBox', array('showDeleteOrRemoveInfo' => $showClosedBox, 'comment' => $comment) ); ?>
	
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
						<?= $app->renderView( 'WallController', 'message', array('isThreadPage' => $isThreadPage, 'comment' => $val, 'isreply' => true, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i)  ) ; ?>
					<?php else: ?>
						<?= $app->renderView( 'WallController', 'messageRemoved', array('comment' => $val, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i)) ; ?>
					<?php endif; ?>
					<? $i++; ?>
				<? endforeach; ?>
			<? endif; ?>
			<?= $app->renderViewCached( 'WallController', 'reply', 'Wall_message'.$showReplyForm, array('showReplyForm' => $showReplyForm )); ?>
			<?php if($showTopics): ?>
				<?= F::app()->renderPartial( 'Wall', 'relatedTopics', array('relatedTopics' => $relatedTopics) ) ?>
			<?php endif; ?>
		</ul>
	<? endif; ?>
</li>
