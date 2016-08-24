<? if ( $userBlocked === false ): ?>
	<div class="SpeechBubble new-message post">
		<div class="speech-bubble-avatar">
			<?= AvatarService::renderAvatar($username, 50) ?>
		</div>
		<div class="speech-bubble-message">
			<? if ( $showMiniEditor ):
				echo $app->getView( 'MiniEditorController', 'Header', [
					'attributes' => [
						'id' => 'wall-new-message',
						'data-min-height' => 200,
						'data-max-height' => 400
					]
				] )->render();
			endif; ?>
			<div class="no-title-container">
				<div class="no-title-warning" style="display:none"><?= wfMessage( 'wall-no-title-warning' )->escaped(); ?></div>
			</div>
			<textarea id="WallMessageTitle" class="title" type="text" placeholder="<?= wfMessage( 'wall-placeholder-topic' )->escaped(); ?>"></textarea>
			<? if ( $showMiniEditor ):
				echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render();
			endif; ?>
			<textarea id="WallMessageBody" class="body" placeholder="<?= $wall_message ?>" data-space-type="editarea"></textarea>
			<? if ( $showMiniEditor ):
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
				<button id="WallMessageSubmit" disabled="disabled"><?= wfMessage( 'wall-button-to-submit-comment' )->escaped(); ?></button>
				
				<button class="secondary" id="WallMessagePreview" disabled="disabled"><?= wfMessage( 'wall-button-to-preview-comment' )->escaped(); ?></button>
				
				<div class="loadingAjax"></div>
			</div>
			<? if ( $showMiniEditor ):
				echo $app->getView( 'MiniEditorController', 'Footer' )->render(); 
			endif; ?>
		</div>
	</div>
<? else: ?>
	<br />
<? endif; ?>
