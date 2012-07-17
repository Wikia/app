<? if ( $userBlocked !== true ): ?>
	<li class="new-reply">
		<? if ($wg->EnableMiniEditorExtForForum): ?>
			<?= $app->getView('MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render() ?>
		<? endif ?>
		<div class="avatar"><?= AvatarService::renderAvatar($username, 30) ?></div>
		<blockquote class="message">
			<? if ($wg->EnableMiniEditorExtForForum): ?>
				<?= $app->getView('MiniEditorController', 'Editor_Header')->render() ?>
			<? endif ?>
			<textarea class="body" data-space-type="editarea" placeholder="<?= $wf->Msg('forum-thread-reply-placeholder') ?>"></textarea>
			<? if ($wg->EnableMiniEditorExtForForum): ?>
				<?= $app->getView('MiniEditorController', 'Editor_Footer')->render() ?>
			<? endif ?>
			<div class="buttons" data-space-type="buttons">
				<button class="submit replyButton<?=
					$loginToEditProtectedPage ? ' require-login" data="' . $ajaxLoginUrl .'"' : '"'
				?>><?= wfMsg('forum-thread-reply-post') ?></button>
			</div>
			<? if ($wg->EnableMiniEditorExtForForum): ?>
				<?= $app->getView('MiniEditorController', 'Footer')->render() ?>
			<? endif ?>
			<div class="throbber"></div>
		</blockquote>
	</li>
<? endif ?>