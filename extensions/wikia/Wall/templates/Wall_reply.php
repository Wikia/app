<? if( $userBlocked === false ): ?>
	<li class="SpeechBubble new-reply" <?php echo ($showReplyForm ? '':'style="display:none"') ?>>
		<div class="speech-bubble-avatar">
			<?= AvatarService::renderAvatar($username, 30) ?>
		</div>
		<blockquote class="speech-bubble-message">
			<textarea placeholder="<?= wfMsg('wall-placeholder-reply') ?>"></textarea>
		</blockquote>
		<div class="abs-container">
			<?php if( $loginToEditProtectedPage ) { ?>
				<button class="replyButton wall-require-login" disabled="disabled" data="<?= $ajaxLoginUrl; ?>"><?= wfMsg('wall-button-to-submit-reply') ?></button>
			<?php } else { ?>
				<button class="replyButton" disabled="disabled"><?= wfMsg('wall-button-to-submit-reply') ?></button>
			<?php } ?>
			<? if (0): ?>
			<button class="replyPreview secondary" disabled="disabled" style="display: none"><?= wfMsg('wall-button-to-preview-comment') ?></button>
			<button class="replyPreviewCancel secondary" style="display: none"><?= wfMsg('wall-button-to-cancel-preview') ?></button>
			<? endif; ?>
			<div class="loadingAjax"></div>
		</div>
	</li>
<? endif; ?>