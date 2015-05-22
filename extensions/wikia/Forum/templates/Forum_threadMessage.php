<div id="ForumThreadMessage" class="ForumThreadMessage DiscussionBox" data-id="<?= $id ?>">
	<div class="avatar">
		<a href="<?= $user_author_url ?>"><?= AvatarService::renderAvatar($username, 50) ?></a>
	</div>
	<div class="message">
		<div class="social-toolbar">
			<? if ($isWatched): ?>
				<button class="follow following" data-iswatched="1"><?= wfMessage( 'forum-board-thread-following' )->escaped() ?></button>
			<? else: ?>
				<button class="follow" data-iswatched="0"><?= wfMessage( 'forum-board-thread-follow' )->escaped() ?></button>
			<? endif ?>
		</div>
		<div class="author">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a>
			<? if (!empty($isStaff)): ?>
				<span class="stafflogo"></span>
			<? endif ?>
		</div>
		<h4 class="msg-title">
			<?= $feedtitle ?>
		</h4>
		<? if ($wg->EnableMiniEditorExtForWall): ?>
			<?= $app->getView('MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render() ?>
			<?= $app->getView('MiniEditorController', 'Editor_Header')->render() ?>
		<? endif ?>
			<div class="msg-body"><?= $body ?></div>
			<? if ($wg->EnableMiniEditorExtForWall): ?>
				<?= $app->getView('MiniEditorController', 'Editor_Footer')->render() ?>
			<? endif ?>
			<!--
			<div class="edit-buttons sourceview">
				<button class="wikia-button cancel-edit cancel-source"><?= wfMsg('wall-button-done-source') ?></button>
			</div>
			<div class="edit-buttons edit" data-space-type="buttons">
				<button class="wikia-button save-edit"><?= wfMsg('wall-button-save-changes') ?></button>
				<button class="wikia-button cancel-edit secondary"><?= wfMsg('wall-button-cancel-changes') ?></button>
			</div>
			-->
			<div class="msg-toolbar">
				<div class="buttonswrapper">
					<?= $app->renderView('ForumController', 'threadMessageButtons', array('comment' => $comment)) ?>
				</div>
			</div>
			<div class="timestamp">
				<? if ($isEdited): ?>
					<?= wfMsg('wall-message-edited', array( $editorUrl, $editorName, $historyUrl )) ?>
				<? endif ?>
				<a class="permalink" href="<?= $fullpageurl ?>" tabindex="-1">
					<? if (!is_null($iso_timestamp)): ?>
						<span class="timeago abstimeago" title="<?= $iso_timestamp ?>" alt="<?= $fmt_timestamp ?>">&nbsp;</span>
						<span class="timeago-fmt"><?= $fmt_timestamp ?></span>
					<? else: ?>
						<span><?= $fmt_timestamp ?></span>
					<? endif ?>
				</a>
			</div>
		<? if ($wg->EnableMiniEditorExtForWall): ?>
			<?= $app->getView('MiniEditorController', 'Footer')->render() ?>
		<? endif ?>
		<div class="throbber"></div>
	</div>
</div>
<? // TODO: refactor threadMessage so this can live in its own template ?>
<ul class="replies">
	<? if (!empty($replies)): ?>
		<? $i = 0 ?>
		<? foreach($replies as $reply): ?>
			<? //TODO: move this logic to controler !!! ?>
			<? if (!$reply->isRemove() || $showDeleteOrRemoveInfo): ?>
				<?= $app->renderView('ForumController', 'threadReply', array(
					'showDeleteOrRemoveInfo' => $showDeleteOrRemoveInfo,
					'comment' => $reply,
					'isreply' => true,
					'repliesNumber' => $repliesNumber,
					'showRepliesNumber' => $showRepliesNumber,
					'current' => $i
				)) ?>
			<? else: ?>
				<?= $app->renderView('ForumController', 'threadRemovedReply', array(
					'comment' => $reply,
					'repliesNumber' => $repliesNumber,
					'showRepliesNumber' => $showRepliesNumber,
					'current' => $i
				)) ?>
			<? endif ?>
			<? $i++ ?>
		<? endforeach ?>
	<? endif ?>
	<?= $app->renderView('ForumController', 'threadNewReply') ?>
</ul>
