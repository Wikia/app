<? if ( ${ForumConst::userBlocked} !== true ): ?>
	<div id="ForumNewMessage" class="ForumNewMessage DiscussionBox">
		<?= AvatarService::renderAvatar( ${ForumConst::username}, 50 ) ?>
		<div class="message">
			<div class="message-container">
				<h4 class="heading"><?= wfMessage( 'forum-board-new-message-heading' )->escaped() ?></h4>
				<? if ( ${ForumConst::isTopicPage} ): ?>
					<div class="board-container">
						<select class="board-list" id="BoardList">
							<? foreach ( ${ForumConst::destinationBoards} as $board ): ?>
								<option name="boardList" value="<?= $board['value'] ?>"><?= $board['content'] ?></option>
							<? endforeach; ?>
						</select>
						<span class="board-list-error"><?= wfMessage( 'forum-no-board-selection-error' )->escaped() ?></span>
					</div>
				<? endif; ?>
				<? if ( $wg->EnableMiniEditorExtForWall ): ?>
					<?= $app->getView( 'MiniEditorController', 'Header', [
						'attributes' => [
							'data-min-height' => 200,
							'data-max-height' => 400
						]
					] )->render() ?>
				<? endif ?>
				<div class="title-container">
					<textarea class="title" data-space-type="title" placeholder="<?= wfMessage( 'forum-discussion-placeholder-title' )->escaped() ?>"></textarea>
					<span class="no-title-warning"><?= wfMessage( 'wall-no-title-warning' )->escaped() ?></span>
				</div>
				<div class="body-container">
					<? if ( $wg->EnableMiniEditorExtForWall ): ?>
						<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render() ?>
					<? endif ?>
					<textarea class="body" data-space-type="editarea" placeholder="<?= ${ForumConst::wall_message} ?>"></textarea>
					<? if ( $wg->EnableMiniEditorExtForWall ): ?>
						<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render() ?>
					<? endif ?>
					<div class="buttons" data-space-type="buttons">
						<?php if ( ${ForumConst::notify_everyone} ): ?>
							<label class="highlight">
								<input type="checkbox" class="notify-everyone" name="notifyEveryone" value="1" /><?= wfMessage( 'forum-discussion-highlight' )->escaped() ?>
							</label>
						<?php endif; ?>

						<button disabled="disabled" class="submit"><?= wfMessage( 'forum-discussion-post' )->escaped() ?></button>
						<button disabled="disabled" class="preview secondary"><?= wfMessage( 'wall-button-to-preview-comment' )->escaped() ?></button>
					</div>
				</div>
				<? if ( $wg->EnableMiniEditorExtForWall ): ?>
					<?= $app->getView( 'MiniEditorController', 'Footer' )->render() ?>
				<? endif ?>
				<?= F::app()->renderPartialCached( 'Wall', 'messageTopic', [ ] ) ?>
			</div>
			<div class="throbber"></div>
		</div>
	</div>
<? endif ?>
