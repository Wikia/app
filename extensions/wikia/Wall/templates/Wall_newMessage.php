<? if ( $userBlocked === false ): ?>
	<div class="SpeechBubble new-message post">
		<div class="speech-bubble-avatar">
			<?= AvatarService::renderAvatar($username, 50) ?>
		</div>
		<div class="speech-bubble-message">
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Header', array(
					'attributes' => array(
						'id' => 'wall-new-message',
						'data-min-height' => 200,
						'data-max-height' => 400
					)
				))->render();
			endif; ?>
			<div class="no-title-container">
				<div class="no-title-warning" style="display:none"><?= wfMsg('wall-no-title-warning') ?></div>
			</div>
			<textarea id="WallMessageTitle" class="title" type="text" placeholder="<?= wfMsg('wall-placeholder-topic') ?>"></textarea>
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render(); 
			endif; ?>
			<textarea id="WallMessageBody" class="body" placeholder="<?= $wall_message ?>" data-space-type="editarea"></textarea>
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); 
			endif; ?>
			<?php if($notify_everyone): ?>
				<?php //never use in wall just for example?>
				<input type="checkbox" name="NotifyEveryone" id="NotifyEveryone" value="1" />
			<?php endif; ?>
			<div id="WallMessageBodyButtons" class="speech-bubble-buttons" data-space-type="buttons">
				<label class="highlight">
					<input type="checkbox" class="notify-everyone" name="notifyEveryone" value="1" />
				</label>
				<button id="WallMessageSubmit" disabled="disabled"><?= wfMsg('wall-button-to-submit-comment') ?></button>
				
				<button class="secondary" id="WallMessagePreview" disabled="disabled"><?= wfMsg('wall-button-to-preview-comment') ?></button>
				
				<div class="loadingAjax"></div>
			</div>
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Footer' )->render(); 
			endif; ?>
		</div>
	</div>
<? else: ?>
	<br />
<? endif; ?>
