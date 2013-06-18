<? if ( $userBlocked !== true ): ?>
	<li class="new-reply">
		<? if ($wg->EnableMiniEditorExtForWall): ?>
			<?= $app->getView('MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render() ?>
		<? endif ?>
		<div class="avatar"><?= AvatarService::renderAvatar($username, 30) ?></div>
		<blockquote class="message">
			<? if ($wg->EnableMiniEditorExtForWall): ?>
				<?= $app->getView('MiniEditorController', 'Editor_Header')->render() ?>
			<? endif ?>
			<textarea class="replyBody" data-space-type="editarea" placeholder="<?= wfMsg('forum-thread-reply-placeholder') ?>"></textarea>
			<? if ($wg->EnableMiniEditorExtForWall): ?>
				<?= $app->getView('MiniEditorController', 'Editor_Footer')->render() ?>
			<? endif ?>
			<div class="buttons" data-space-type="buttons">
				<button class="submit replyButton"><?= wfMsg('forum-thread-reply-post') ?></button>
			</div>
			<? if ($wg->EnableMiniEditorExtForWall): ?>
				<?= $app->getView('MiniEditorController', 'Footer')->render() ?>
			<? endif ?>
			<div class="throbber"></div>
		</blockquote>
	</li>
<? endif ?>