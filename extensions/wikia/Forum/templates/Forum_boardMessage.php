<li class="SpeechBubble message <?= ( $removedOrDeletedMessage ? 'hide ':'' ) . ( $showRemovedBox ? ' message-removed':'' ); ?> <?= 'message-' . $linkid ?>" id="<?= $linkid ?>" data-id="<?= $id ?>" data-is-reply="<?= $isreply == true ?>" <? if ( $hide ):?> style="display:none" <? endif; ?> >
	THIS IS FORUM BOARD TEMAPLTE (Forum_boardMessage.php)
	<?php if ( ( $showDeleteOrRemoveInfo ) && ( !empty( $deleteOrRemoveInfo ) ) ): ?>
		<div class="deleteorremove-infobox" >
			<table class="deleteorremove-container"><tr><td width="100%">
			<div class="deleteorremove-bubble">
				<div class="avatar"><?= AvatarService::renderAvatar( $deleteOrRemoveInfo['user']->getName(), 20 ) ?></div>
				<div class="message">
					<? if ( $isreply ): ?>
					<?= wfMessage( 'wall-message-' . $deleteOrRemoveInfo['status'] . '-reply-because', $deleteOrRemoveInfo['user_displayname_linked'] )->escaped(); ?><br />
					<? else : ?>
					<?= wfMessage( 'wall-message-' . $deleteOrRemoveInfo['status'] . '-thread-because', $deleteOrRemoveInfo['user_displayname_linked'] )->escaped(); ?><br />
					<? endif; ?>
					<div class="reason"><?= $deleteOrRemoveInfo['reason']; ?></div>
					<div class="timestamp"><span><?= $deleteOrRemoveInfo['fmttime']; ?></span></div>
				</div>
			</div>
			</td><td>
			<? if ( $isreply ): ?>
				<button <?= ( $canRestore ? '':'disabled=disbaled' ) ?>  data-mode='restore<?= ( $fastrestore ? '-fast':'' ) ?>' data-id="<?= $id; ?>"  class="message-restore wikia-button" ><?= wfMessage( 'wall-message-restore-reply' )->escaped(); ?></button>
			<? else : ?>
				<button <?= ( $canRestore ? '':'disabled=disbaled' ) ?> data-mode='restore<?= ( $fastrestore ? '-fast':'' ) ?>' data-id="<?= $id; ?>"  class="message-restore wikia-button" ><?= wfMessage( 'wall-message-restore-thread' )->escaped(); ?></button>
			<? endif; ?>
			</td></tr></table>
		</div>
	<?php endif; ?>

	<? if ( $showRemovedBox ): ?>
		<div class='removed-info speech-bubble-message-removed' >
			<?= wfMessage( 'wall-removed-reply' )->escaped(); ?>
		</div>
	<? endif; ?>

	<div class="speech-bubble-avatar">
		<a href="<?= $user_author_url ?>">
			<? if ( !$isreply ): ?>
				<?= AvatarService::renderAvatar( $username, 50 ) ?>
			<? else : ?>
				<?= AvatarService::renderAvatar( $username, 30 ) ?>
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
		<? if ( !$isreply ): ?>
			<?php if ( $isWatched ): ?>
				<a <?php if ( !$showFollowButton ): ?>style="display:none"<?php endif; ?> data-iswatched="1" class="follow wikia-button"><?= wfMessage( 'wikiafollowedpages-following' )->escaped(); ?></a>
			<?php else : ?>
				<a <?php if ( !$showFollowButton ): ?>style="display:none"<?php endif; ?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMessage( 'oasis-follow' )->escaped(); ?></a>
			<?php endif; ?>
			<div class="msg-title"><a href="<?= $fullpageurl; ?>"><?= $feedtitle ?></a></div>
		<? endif; ?>
		<div class="edited-by">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a>
			<a href="<?= $user_author_url ?>" class="subtle"><?= $displayname2 ?></a>
			<?php if ( !empty( $isStaff ) ): ?>
				<span class="stafflogo"></span>
			<?php endif; ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render();
		endif; ?>
		<div class="msg-body" id="WallMessage_<?= $id ?>">
			<?= $body ?>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render();
		endif; ?>
		<div class="msg-toolbar">
			<div class="timestamp">
				<?php if ( $isEdited ):?>
					<?= wfMsg( 'wall-message-edited', [ $editorUrl, $editorName, $historyUrl ] ); ?>
				<?php endif; ?>
				<a href="<?= $fullpageurl; ?>" class="permalink" tabindex="-1">
					<?php if ( !is_null( $iso_timestamp ) ): ?>
					<span class="timeago abstimeago" title="<?= $iso_timestamp ?>" alt="<?= $fmt_timestamp ?>">&nbsp;</span>
					<span class="timeago-fmt"><?= $fmt_timestamp ?></span>
					<?php else : ?>
						<span><?= $fmt_timestamp ?></span>
					<?php endif; ?>
				</a>
				<div class="buttonswrapper">
					<?= $app->renderView( 'WallController', 'messageButtons', [ 'comment' => $comment ] ); ?>
				</div>
			</div>
			<div class="edit-buttons sourceview">
				<button class="wikia-button cancel-edit cancel-source"><?= wfMessage( 'wall-button-done-source' )->escaped(); ?></button>
			</div>
			<div class="edit-buttons edit" id="WallMessage_<?= $id ?>Buttons" data-space-type="buttons">
				<button class="wikia-button save-edit"><?= wfMessage( 'wall-button-save-changes' )->escaped(); ?></button>
				<button class="wikia-button cancel-edit secondary"><?= wfMessage( 'wall-button-cancel-changes' )->escaped(); ?></button>
			</div>
		</div>
	</div>
</li>
