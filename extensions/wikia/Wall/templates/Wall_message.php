<li class="SpeechBubble message <?php echo ($isreply ? '':'message-main'); ?> <?php echo ($removedOrDeletedMessage ? 'hide ':'') . ($removedOrDeletedMessage ?' message-removed':''); ?> <? echo 'message-'.$linkid ?>" id="<? echo $linkid ?>" data-id="<? echo $id ?>" data-is-reply="<?= $isreply == true ?>" <? if($collapsed):?> style="display:none" <? endif;?> >
	<?php echo $head ?>
	<?php echo $app->renderView( 'WallController', 'statusInfoBox', [ 'showDeleteOrRemoveInfo' => $showDeleteOrRemoveInfo, 'comment' => $comment ] ); ?>

	<? if( $removedOrDeletedMessage ): ?>
		<div class='removed-info speech-bubble-message-removed' >
			<?php echo wfMsg('wall-removed-reply'); ?>
		</div>
	<? endif; ?>

	<?php if ( !$removedOrDeletedMessage ): ?>
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
					<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="1" class="follow wikia-button"><?= wfMessage('wikiafollowedpages-following')->text(); ?></a>
				<?php else: ?>
					<a <?php if(!$showFollowButton): ?>style="display:none"<?php endif;?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMessage('oasis-follow')->text(); ?></a>
				<?php endif;?>
			<? endif; ?>

			<?php if($showVotes): ?>
				<div class="voting-controls">
					<a class="votes<?= $votes > 0 ? "" : " notlink" ?>" data-votes="<?= $votes ?>">
						<?= wfMessage('wall-votes-number', '<span class="number" >'.$votes.'</span>')->text() ?>
					</a>
					<?php if($canVotes):?>
						<a class="vote <?php if($isVoted): ?>voted<?php endif;?>">
							<img src="<?= $wg->BlankImgUrl ?>" height="19" width="19" >
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->renderPartialCached( 'MiniEditorController', 'Header', 'Wall_message', [
					'attributes' => [ 'data-min-height' => 100, 'data-max-height' => 400 ]
				] );
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
					<?= wfMessage('wall-quote-reply-to', $quote_of_postfix)->text() ?>
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
						<?= wfMessage('wall-message-edited', [ '$1' => $editorUrl, '$2' => $editorName, '$3' => $historyUrl ] )->text(); ?>
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
					<?= $app->renderView( 'WallController', 'messageButtons', [ 'comment' => $comment ] ); ?>
				</div>
				<?= $app->renderPartialCached( 'WallController', 'messageEditButtons', 'Wall_message' ); ?>
			</div>
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->renderPartialCached( 'MiniEditorController', 'Footer', 'Wall_message' );
			endif; ?>
		</div>
	<? endif; ?>

	<?php echo $app->renderView( 'WallController', 'statusInfoBox', [ 'showDeleteOrRemoveInfo' => $showClosedBox, 'comment' => $comment ] ); ?>

	<? if(!$isreply): ?>
		<ul class="replies">
			<? if(!empty($replies)): ?>
				<? $i =0;?>
				<? if($showLoadMore): ?>
					<li class="load-more">
						<a href="#"><?= wfMessage( 'wall-message-loadmore' )->numParams( $repliesNumber )->parse(); ?></a>
					</li>
				<? endif; ?>
				<? foreach( $replies as $key  => $val): ?>
					<?php //TODO: move this logic to controler !!! ?>
					<?php if(!$val->isRemove() || $showDeleteOrRemoveInfo): ?>
						<?= $app->renderView( 'WallController', 'message', [ 'isThreadPage' => $isThreadPage, 'comment' => $val, 'isreply' => true, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i ] ) ; ?>
					<?php else: ?>
						<?= $app->renderView( 'WallController', 'messageRemoved', [ 'comment' => $val, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i ] ) ; ?>
					<?php endif; ?>
					<? $i++; ?>
				<? endforeach; ?>
			<? endif; ?>
			<? if( $repliesNumber < $repliesLimit ) {
				echo $app->renderViewCached( 'WallController', 'reply', 'Wall_message'.$showReplyForm, [ 'showReplyForm' => $showReplyForm ] );
			} else {
				echo "<div class=message-topic-error >" . wfMessage('wall-message-limit-reached')->numParams( $repliesLimit )->parse() . "</div>";
			} ?>
			<?php if($showTopics): ?>
				<?= F::app()->renderPartial( 'Wall', 'relatedTopics', [ 'relatedTopics' => $relatedTopics, 'showEditTopics' => $showEditTopics ] ) ?>
			<?php endif; ?>
		</ul>
	<? endif; ?>
</li>
