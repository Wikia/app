<? if( $userBlocked === false && $showReplyForm): ?>
	<li class="SpeechBubble new-reply" >
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render();
		endif; ?>
		<div class="speech-bubble-avatar">
			<?= AvatarService::renderAvatar($username, 30) ?>
		</div>
		<div class="speech-bubble-message">
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render();
			endif; ?>
			<textarea class="replyBody" placeholder="<?= wfMsg('wall-placeholder-reply') ?>"></textarea>
			<? if ( $wg->EnableMiniEditorExtForWall ):
				echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render();
			endif; ?>
		</div>
		<div class="speech-bubble-buttons" data-space-type="buttons">
			<button disabled="disabled" class="replyButton"><?= wfMsg('wall-button-to-submit-reply') ?></button>
			
			<button class="previewButton secondary" disabled="disabled" >
				<?= wfMsg('wall-button-to-preview-comment') ?>
			</button>
		
			<? /* ?>
			<button class="replyPreview secondary" disabled="disabled" style="display: none"><?= wfMsg('wall-button-to-preview-comment') ?></button>
			<button class="replyPreviewCancel secondary" style="display: none"><?= wfMsg('wall-button-to-cancel-preview') ?></button>
			<? */ ?>
			<div class="loadingAjax"></div>
		</div>
		<? if ( $wg->EnableMiniEditorExtForWall ):
			echo $app->getView( 'MiniEditorController', 'Footer' )->render();
		endif; ?>
	</li>
<? endif; ?>
