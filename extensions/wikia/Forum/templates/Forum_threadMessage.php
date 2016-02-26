<div id="ForumThreadMessage" class="ForumThreadMessage DiscussionBox" data-id="<?= ${ForumConst::id} ?>">
	<div class="avatar">
		<a href="<?= ${ForumConst::user_author_url} ?>"><?= AvatarService::renderAvatar( ${ForumConst::username}, 50 ) ?></a>
	</div>
	<div class="message">
		<div class="social-toolbar">
			<? if ( ${ForumConst::isWatched} ): ?>
				<button class="follow following" data-iswatched="1"><?= wfMessage( 'forum-board-thread-following' )->escaped() ?></button>
			<? else : ?>
				<button class="follow" data-iswatched="0"><?= wfMessage( 'forum-board-thread-follow' )->escaped() ?></button>
			<? endif ?>
		</div>
		<div class="author">
			<a href="<?= ${ForumConst::user_author_url} ?>"><?= ${ForumConst::displayname} ?></a>
			<? if ( !empty( ${ForumConst::isStaff} ) ): ?>
				<span class="stafflogo"></span>
			<? endif ?>
		</div>
		<h4 class="msg-title">
			<?= ${ForumConst::feedtitle} ?>
		</h4>
		<? if ( $wg->EnableMiniEditorExtForWall ): ?>
			<?= $app->getView( 'MiniEditorController', 'Header', [
				'attributes' => [
					'data-min-height' => 100,
					'data-max-height' => 400
				]
			] )->render() ?>
			<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
		<? endif ?>
			<div class="msg-body"><?= ${ForumConst::body} ?></div>
			<? if ( $wg->EnableMiniEditorExtForWall ): ?>
				<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
			<? endif ?>
			<!--
			<div class="edit-buttons sourceview">
				<button class="wikia-button cancel-edit cancel-source"><?= wfMsg( 'wall-button-done-source' ) ?></button>
			</div>
			<div class="edit-buttons edit" data-space-type="buttons">
				<button class="wikia-button save-edit"><?= wfMsg( 'wall-button-save-changes' ) ?></button>
				<button class="wikia-button cancel-edit secondary"><?= wfMsg( 'wall-button-cancel-changes' ) ?></button>
			</div>
			-->
			<div class="msg-toolbar">
				<div class="buttonswrapper">
					<?= $app->renderView( 'ForumController', 'threadMessageButtons', [ 'comment' => $comment ] ) ?>
				</div>
			</div>
			<div class="timestamp">
				<? if ( ${ForumConst::isEdited} ): ?>
					<?= wfMsg( 'wall-message-edited', [ ${ForumConst::editorUrl}, ${ForumConst::editorName}, ${ForumConst::historyUrl} ] ) ?>
				<? endif ?>
				<a class="permalink" href="<?= ${ForumConst::fullpageurl} ?>" tabindex="-1">
					<? if ( !is_null( ${ForumConst::iso_timestamp} ) ): ?>
						<span class="timeago abstimeago" title="<?= ${ForumConst::iso_timestamp} ?>" alt="<?= ${ForumConst::fmt_timestamp} ?>">&nbsp;</span>
						<span class="timeago-fmt"><?= ${ForumConst::fmt_timestamp} ?></span>
					<? else : ?>
						<span><?= ${ForumConst::fmt_timestamp} ?></span>
					<? endif ?>
				</a>
			</div>
		<? if ( $wg->EnableMiniEditorExtForWall ): ?>
			<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
		<? endif ?>
		<div class="throbber"></div>
	</div>
</div>
<? // TODO: refactor threadMessage so this can live in its own template ?>
<ul class="replies">
	<? if ( !empty( ${ForumConst::replies} ) ): ?>
		<? $i = 0 ?>
		<? foreach ( ${ForumConst::replies} as $reply ): ?>
			<? // TODO: move this logic to controler !!! ?>
			<? if ( !$reply->isRemove() || ${ForumConst::showDeleteOrRemoveInfo} ): ?>
				<?= $app->renderView( 'ForumController', 'threadReply', [
					'showDeleteOrRemoveInfo' => ${ForumConst::showDeleteOrRemoveInfo},
					'comment' => $reply,
					'isreply' => true,
					'repliesNumber' => ${ForumConst::repliesNumber},
					'showRepliesNumber' => ${ForumConst::showRepliesNumber},
					'current' => $i
				] ) ?>
			<? else : ?>
				<?= $app->renderView( 'ForumController', 'threadRemovedReply', [
					'comment' => $reply,
					'repliesNumber' => ${ForumConst::repliesNumber},
					'showRepliesNumber' => ${ForumConst::showRepliesNumber},
					'current' => $i
				] ) ?>
			<? endif ?>
			<? $i++ ?>
		<? endforeach ?>
	<? endif ?>
	<?= $app->renderView( 'ForumController', 'threadNewReply' ) ?>
</ul>
