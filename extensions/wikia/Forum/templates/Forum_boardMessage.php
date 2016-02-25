<li class="SpeechBubble message <?php echo ( ${ForumConst::removedOrDeletedMessage} ? 'hide ':'' ) . ( ${ForumConst::showRemovedBox} ? ' message-removed':'' ); ?> <? echo 'message-' . ${ForumConst::linkid} ?>" id="<? echo ${ForumConst::linkid} ?>" data-id="<? echo ${ForumConst::id} ?>" data-is-reply="<?= ${ForumConst::isreply} == true ?>" <? if ( ${ForumConst::hide} ):?> style="display:none" <? endif; ?> >
	THIS IS FORUM BOARD TEMAPLTE (Forum_boardMessage.php)
	<?php if ( ( ${ForumConst::showDeleteOrRemoveInfo} ) && ( !empty( ${ForumConst::deleteOrRemoveInfo} ) ) ): ?>
		<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar( ${ForumConst::deleteOrRemoveInfo}['user']->getName(), 20 ) ?></div>
				<div class="message">
					<? if ( ${ForumConst::isreply} ): ?>
					<?= wfMsgExt( 'wall-message-' . ${ForumConst::deleteOrRemoveInfo}['status'] . '-reply-because', [ 'parsemag' ], [ ${ForumConst::deleteOrRemoveInfo}['user_displayname_linked'] ] ); ?><br />
					<? else : ?>
					<?= wfMsgExt( 'wall-message-' . ${ForumConst::deleteOrRemoveInfo}['status'] . '-thread-because', [ 'parsemag' ], [ ${ForumConst::deleteOrRemoveInfo}['user_displayname_linked'] ] ); ?><br />
					<? endif; ?>
					<div class="reason"><?php echo ${ForumConst::deleteOrRemoveInfo}['reason']; ?></div>
					<div class="timestamp"><span><?php echo ${ForumConst::deleteOrRemoveInfo}['fmttime']; ?></span></div>
				</div>
			</div>
			</td><td>
			<? if ( ${ForumConst::isreply} ): ?>
				<button <? echo ( ${ForumConst::canRestore} ? '':'disabled=disbaled' ) ?> data-mode='restore<?php echo ( ${ForumConst::fastrestore} ? '-fast':'' ) ?>' data-id="<?php echo ${ForumConst::id}; ?>" class="message-restore wikia-button" ><?php echo wfMsg( 'wall-message-restore-reply' ); ?></button>
			<? else : ?>
				<button <? echo ( ${ForumConst::canRestore} ? '':'disabled=disbaled' ) ?> data-mode='restore<?php echo ( ${ForumConst::fastrestore} ? '-fast':'' ) ?>' data-id="<?php echo ${ForumConst::id}; ?>" class="message-restore wikia-button" ><?php echo wfMsg( 'wall-message-restore-thread' ); ?></button>
			<? endif; ?>
			</td></tr></table>
		</div>
	<?php endif; ?>

	<? if ( ${ForumConst::showRemovedBox} ): ?>
		<div class='removed-info speech-bubble-message-removed' >
			<?php echo wfMsg( 'wall-removed-reply' ); ?>
		</div>
	<? endif; ?>

	<div class="speech-bubble-avatar">
		<a href="<?= ${ForumConst::user_author_url} ?>">
			<? if ( !${ForumConst::isreply} ): ?>
				<?= AvatarService::renderAvatar( ${ForumConst::username}, 50 ) ?>
			<? else : ?>
				<?= AvatarService::renderAvatar( ${ForumConst::username}, 30 ) ?>
			<? endif ?>
		</a>
	</div>
	<div class="speech-bubble-message">
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Header', [
				'attributes' => [
					'data-min-height' => 100,
					'data-max-height' => 400
				]
			] )->render();
		endif; ?>
		<? if ( !${ForumConst::isreply} ): ?>
			<?php if ( ${ForumConst::isWatched} ): ?>
				<a <?php if ( !${ForumConst::showFollowButton} ): ?>style="display:none"<?php endif; ?> data-iswatched="1" class="follow wikia-button"><?= wfMsg( 'wikiafollowedpages-following' ); ?></a>
			<?php else : ?>
				<a <?php if ( !${ForumConst::showFollowButton} ): ?>style="display:none"<?php endif; ?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg( 'oasis-follow' ); ?></a>
			<?php endif; ?>
			<div class="msg-title"><a href="<?= ${ForumConst::fullpageurl}; ?>"><? echo ${ForumConst::feedtitle} ?></a></div>
		<? endif; ?>
		<div class="edited-by">
			<a href="<?= ${ForumConst::user_author_url} ?>"><?= ${ForumConst::displayname} ?></a>
			<a href="<?= ${ForumConst::user_author_url} ?>" class="subtle"><?= ${ForumConst::displayname2} ?></a>
			<?php if ( !empty( ${ForumConst::isStaff} ) ): ?>
				<span class="stafflogo"></span>
			<?php endif; ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render();
		endif; ?>
		<div class="msg-body" id="WallMessage_<?= ${ForumConst::id} ?>">
			<? echo ${ForumConst::body} ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render();
		endif; ?>
		<div class="msg-toolbar">
			<div class="timestamp">
				<?php if ( ${ForumConst::isEdited} ):?>
					<? echo wfMsg( 'wall-message-edited', [ ${ForumConst::editorUrl}, ${ForumConst::editorName}, ${ForumConst::historyUrl} ] ); ?>
				<?php endif; ?>
				<a href="<?= ${ForumConst::fullpageurl}; ?>" class="permalink" tabindex="-1">
					<?php if ( !is_null( ${ForumConst::iso_timestamp} ) ): ?>
					<span class="timeago abstimeago" title="<?= ${ForumConst::iso_timestamp} ?>" alt="<?= ${ForumConst::fmt_timestamp} ?>">&nbsp;</span>
					<span class="timeago-fmt"><?= ${ForumConst::fmt_timestamp} ?></span>
					<?php else : ?>
						<span><?= ${ForumConst::fmt_timestamp} ?></span>
					<?php endif; ?>
				</a>
				<div class="buttonswrapper">
					<?= $app->renderView( 'WallController', 'messageButtons', [ 'comment' => $comment ] ); ?>
				</div>
			</div>
			<div class="edit-buttons sourceview">
				<button class="wikia-button cancel-edit cancel-source"><?php echo wfMsg( 'wall-button-done-source' ); ?></button>
			</div>
			<div class="edit-buttons edit" id="WallMessage_<?= ${ForumConst::id} ?>Buttons" data-space-type="buttons">
				<button class="wikia-button save-edit"><?php echo wfMsg( 'wall-button-save-changes' ); ?></button>
				<button class="wikia-button cancel-edit secondary"><?php echo wfMsg( 'wall-button-cancel-changes' ); ?></button>
			</div>
		</div>
	</div>
</li>
