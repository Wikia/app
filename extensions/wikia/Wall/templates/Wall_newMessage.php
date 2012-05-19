<? if ( $userBlocked === false ): ?>
	<div class="SpeechBubble new-message post">
		<div class="speech-bubble-avatar">
			<?= AvatarService::renderAvatar($username, 50) ?>
		</div>
		<blockquote class="speech-bubble-message">
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
			<div id="WallMessageBodyButtons" class="speech-bubble-buttons" data-space-type="buttons">
				<button id="WallMessageSubmit" disabled="disabled" style="display: none"<?
					if ( $loginToEditProtectedPage ): ?> class="wall-require-login" data="<?= $ajaxLoginUrl; ?>"<? endif;
				?>><?= wfMsg('wall-button-to-submit-comment') ?></button>
				<? /* ?>
				<button id="WallMessagePreview" disabled="disabled" style="display: none" class="secondary"><?= wfMsg('wall-button-to-preview-comment') ?></button>
				<button id="WallMessagePreviewCancel" style="display: none" class="secondary"><?= wfMsg('wall-button-to-cancel-preview') ?></button>
				<? */ ?>
				<div class="loadingAjax"></div>
			</div>
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Footer' )->render(); 
			endif; ?>
		</blockquote>
	</div>
<? else: ?>
	<br />
<? endif; ?>