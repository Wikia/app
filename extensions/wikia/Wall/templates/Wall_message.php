<li class="SpeechBubble message <?php echo (${WallConst::isreply} ? '':'message-main'); ?> <?php echo (${WallConst::removedOrDeletedMessage} ? 'hide ':'') . (${WallConst::showRemovedBox}?' message-removed':''); ?> <? echo 'message-'.${WallConst::linkid} ?>" id="<? echo ${WallConst::linkid} ?>" data-id="<? echo ${WallConst::id} ?>" data-is-reply="<?= ${WallConst::isreply} == true ?>" <? if(${WallConst::collapsed}):?> style="display:none" <? endif;?> >
	<?php echo ${WallConst::head} ?>
	<?php echo $app->renderView( 'WallController', 'statusInfoBox', [ 'showDeleteOrRemoveInfo' => ${WallConst::showDeleteOrRemoveInfo}, 'comment' => ${WallConst::comment} ] ); ?>

	<? if(${WallConst::showRemovedBox}): ?>
		<div class='removed-info speech-bubble-message-removed' >
			<?php echo wfMsg('wall-removed-reply'); ?>
		</div>
	<? endif; ?>

	<div class="speech-bubble-avatar">
		<a href="<?= ${WallConst::user_author_url} ?>">
			<? if(!${WallConst::isreply}): ?>
				<?= AvatarService::renderAvatar(${WallConst::username}, 50) ?>
			<? else: ?>
				<?= AvatarService::renderAvatar(${WallConst::username}, 30) ?>
			<? endif ?>
		</a>
	</div>

	<div class="speech-bubble-message">
		<? if(!${WallConst::isreply}): ?>
			<?php if(${WallConst::isWatched}): ?>
				<a <?php if(!${WallConst::showFollowButton}): ?>style="display:none"<?php endif;?> data-iswatched="1" class="follow wikia-button"><?= wfMsg('wikiafollowedpages-following'); ?></a>
			<?php else: ?>
				<a <?php if(!${WallConst::showFollowButton}): ?>style="display:none"<?php endif;?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg('oasis-follow'); ?></a>
			<?php endif;?>
		<? endif; ?>

		<?php if(${WallConst::showVotes}): ?>
			<div class="voting-controls">
				<a class="votes<?= ${WallConst::votes} > 0 ? "" : " notlink" ?>" data-votes="<?= ${WallConst::votes} ?>">
					<?= wfMsg('wall-votes-number', '<span class="number" >'.${WallConst::votes}.'</span>') ?>
				</a>
				<?php if(${WallConst::canVotes}):?>
					<a class="vote <?php if(${WallConst::isVoted}): ?>voted<?php endif;?>">
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
		<? if(!${WallConst::isreply}): ?>
			<div class="msg-title"><a href="<?= ${WallConst::fullpageurl}; ?>"><? echo ${WallConst::feedtitle} ?></a></div>
		<? endif; ?>

		<div class="edited-by">
			<a href="<?= ${WallConst::user_author_url} ?>"><?= ${WallConst::displayname} ?></a>
			<a href="<?= ${WallConst::user_author_url} ?>" class="subtle"><?= ${WallConst::displayname2} ?></a>
			<?php if( !empty(${WallConst::isStaff}) ): ?>
				<span class="stafflogo"></span>
			<?php endif; ?>
		</div>

		<?php if(${WallConst::quote_of}): ?>
		<div class="quote-of">
			<a href="<?php echo ${WallConst::quote_of_url}; ?>" data-postfix="<?php echo ${WallConst::quote_of_postfix}; ?>" >
				<?= wfMsg('wall-quote-reply-to', ${WallConst::quote_of_postfix}) ?>
			</a>
		</div>
		<?php endif; ?>

		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Editor_Header', 'Wall_message' );
		endif; ?>
		<div class="msg-body" id="WallMessage_<?= ${WallConst::id} ?>">
			<? echo ${WallConst::body} ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Editor_Footer', 'Wall_message' );
		endif; ?>
		<div class="msg-toolbar">
			<div class="timestamp">
				<?php if(${WallConst::isEdited}):?>
					<? if(${WallConst::showSummary}): ?>
						<? echo wfMsg('wall-message-edited-summary', [ '$1' => ${WallConst::summary}, '$2' => ${WallConst::editorUrl}, '$3' => ${WallConst::editorName}, '$4' => ${WallConst::historyUrl} ] ); ?>
					<? else: ?>
						<? echo wfMsg('wall-message-edited', [ '$1' => ${WallConst::editorUrl}, '$2' => ${WallConst::editorName}, '$3' => ${WallConst::historyUrl} ] ); ?>
					<? endif; ?>
				<?php endif; ?>
				<a href="<?= ${WallConst::fullpageurl}; ?>" class="permalink" tabindex="-1">
					<?php if (!is_null(${WallConst::iso_timestamp})): ?>
					<span class="timeago abstimeago" title="<?= ${WallConst::iso_timestamp} ?>" alt="<?= ${WallConst::fmt_timestamp} ?>">&nbsp;</span>
					<span class="timeago-fmt"><?= ${WallConst::fmt_timestamp} ?></span>
					<?php else: ?>
						<span><?= ${WallConst::fmt_timestamp} ?></span>
					<?php endif; ?>
				</a>
			</div>
			<div class="buttonswrapper">
				<?= $app->renderView( 'WallController', 'messageButtons', [ 'comment' => ${WallConst::comment} ] ); ?>
			</div>
			<?= $app->renderPartialCached( 'WallController', 'messageEditButtons', 'Wall_message' ); ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->renderPartialCached( 'MiniEditorController', 'Footer', 'Wall_message' );
		endif; ?>
	</div>

	<?php echo $app->renderView( 'WallController', 'statusInfoBox', [ 'showDeleteOrRemoveInfo' => ${WallConst::showClosedBox}, 'comment' => ${WallConst::comment} ] ); ?>

	<? if(!${WallConst::isreply}): ?>
		<ul class="replies">
			<? if(!empty(${WallConst::replies})): ?>
				<? $i =0;?>
				<? if(${WallConst::showLoadMore}): ?>
					<?= $app->renderView( 'WallController', 'loadMore', [ 'repliesNumber' => ${WallConst::repliesNumber} ] ); ?>
				<? endif; ?>
				<? foreach( ${WallConst::replies} as $key  => $val): ?>
					<?php //TODO: move this logic to controler !!! ?>
					<?php if(!$val->isRemove() || ${WallConst::showDeleteOrRemoveInfo}): ?>
						<?= $app->renderView( 'WallController', 'message', [ 'isThreadPage' => ${WallConst::isThreadPage}, 'comment' => $val, 'isreply' => true, 'repliesNumber' => ${WallConst::repliesNumber}, 'showRepliesNumber' => ${WallConst::showRepliesNumber},  'current' => $i ] ) ; ?>
					<?php else: ?>
						<?= $app->renderView( 'WallController', 'messageRemoved', [ 'comment' => $val, 'repliesNumber' => ${WallConst::repliesNumber}, 'showRepliesNumber' => ${WallConst::showRepliesNumber},  'current' => $i ] ) ; ?>
					<?php endif; ?>
					<? $i++; ?>
				<? endforeach; ?>
			<? endif; ?>
			<? if( ${WallConst::repliesNumber} < ${WallConst::repliesLimit} ) {
				echo $app->renderViewCached( 'WallController', 'reply', 'Wall_message'.${WallConst::showReplyForm}, [ 'showReplyForm' => ${WallConst::showReplyForm} ] );
			} else {
				echo "<div class=message-topic-error >" . wfMsgExt('wall-message-limit-reached', [ 'parsemag' ], [ ${WallConst::repliesLimit} ] ) . "</div>";
			} ?>
			<?php if(${WallConst::showTopics}): ?>
				<?= F::app()->renderPartial( 'Wall', 'relatedTopics', [ 'relatedTopics' => ${WallConst::relatedTopics} ] ) ?>
			<?php endif; ?>
		</ul>
	<? endif; ?>
</li>
