<? if ($userBlocked !== true): ?>
	<div id="ForumNewMessage" class="ForumNewMessage DiscussionBox">
		<?= AvatarService::renderAvatar($username, 50) ?>
		<blockquote class="message">
			<div class="message-container">
				<h4 class="heading">Start a Discussion</h4>
				<? if ($wg->EnableMiniEditorExtForForum): ?>
					<?= $app->getView('MiniEditorController', 'Header', array(
						'attributes' => array(
							'data-min-height' => 200,
							'data-max-height' => 400
						)
					))->render() ?>
				<? endif ?>
				<div class="title-container">
					<textarea class="title" data-space-type="title" placeholder="<?= wfMsg('forum-discussion-placeholder-title') ?>"></textarea>
					<span class="no-title-warning"><?= wfMsg('wall-no-title-warning') ?></span>
				</div>
				<div class="body-container">
					<? if ($wg->EnableMiniEditorExtForForum): ?>
						<?= $app->getView('MiniEditorController', 'Editor_Header')->render() ?>
					<? endif ?>
					<textarea class="body" data-space-type="editarea" placeholder="<?= $wall_message ?>"></textarea>
					<? if ($wg->EnableMiniEditorExtForForum): ?>
						<?= $app->getView('MiniEditorController', 'Editor_Footer')->render() ?>
					<? endif ?>
					<div class="buttons" data-space-type="buttons">
						<button disabled="disabled" class="submit<?=
							$loginToEditProtectedPage ? ' require-login" data="' . $ajaxLoginUrl .'"' : '"'
						?>><?= wfMsg('forum-discussion-post') ?></button>
						<?php if($notify_everyone): ?>
							<label class="highlight">
								<input type="checkbox" class="notify-everyone" name="notifyEveryone" value="1" /><?= wfMsg('forum-discussion-highlight') ?>
							</label>
						<?php endif; ?>
					</div>
				</div>
				<? if ($wg->EnableMiniEditorExtForForum): ?>
					<?= $app->getView('MiniEditorController', 'Footer')->render() ?>
				<? endif ?>
			</div>
			<div class="throbber"></div>
		</blockquote>
	</div>
<? endif ?>