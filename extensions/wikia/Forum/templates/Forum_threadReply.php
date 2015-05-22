<li>
	<div class="avatar"><?= AvatarService::renderAvatar($username, 30) ?></div>
	<div class="message">
		<div class="author">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a>
			<? if (!empty($isStaff)): ?>
				<span class="stafflogo"></span>
			<? endif ?>
		</div>
		<? if ($wg->EnableMiniEditorExtForWall): ?>
			<?= $app->getView('MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render() ?>
		<? endif ?>
		<? if ($wg->EnableMiniEditorExtForWall): ?>
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
</li>
