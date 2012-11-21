<? if ($userBlocked !== true): ?>
	<div id="ForumNewMessage" class="ForumNewMessage DiscussionBox">
		<?= AvatarService::renderAvatar($username, 50) ?>
		<blockquote class="message">
			<div class="message-container">
				<h4 class="heading"><?= wfMsg('forum-board-new-message-heading') ?></h4>
				<? if($isTopicPage): ?>
					<div class="board-container">
						<select class="board-list" id="BoardList">
							<? foreach($destinationBoards as $board): ?>
								<option name="boardList" value="<?= $board['value'] ?>"><?= $board['content'] ?></option>
							<? endforeach; ?>
						</select>
						<span class="board-list-error"><?= wfMsg('forum-no-board-selection-error') ?></span>
					</div>
				<? endif; ?>
				<? if ($wg->EnableMiniEditorExtForWall): ?>
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
					<? if ($wg->EnableMiniEditorExtForWall): ?>
						<?= $app->getView('MiniEditorController', 'Editor_Header')->render() ?>
					<? endif ?>
					<textarea class="body" data-space-type="editarea" placeholder="<?= $wall_message ?>"></textarea>
					<? if ($wg->EnableMiniEditorExtForWall): ?>
						<?= $app->getView('MiniEditorController', 'Editor_Footer')->render() ?>
					<? endif ?>
					<div class="buttons" data-space-type="buttons">							
						<?php if($notify_everyone): ?>
							<label class="highlight">
								<input type="checkbox" class="notify-everyone" name="notifyEveryone" value="1" /><?= wfMsg('forum-discussion-highlight') ?>
							</label>
						<?php endif; ?>
						
						<button disabled="disabled" class="submit"><?= wfMsg('forum-discussion-post') ?></button>
						<button disabled="disabled" class="preview secondary"><?= wfMsg('wall-button-to-preview-comment') ?></button>
					</div>
				</div>
				<? if ($wg->EnableMiniEditorExtForWall): ?>
					<?= $app->getView('MiniEditorController', 'Footer')->render() ?>
				<? endif ?>
				<?= F::app()->renderPartialCached( 'Wall', 'messageTopic', array() ) ?>
			</div>
			<div class="throbber"></div>
		</blockquote>
	</div>
<? endif ?>