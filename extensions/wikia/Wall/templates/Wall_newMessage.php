<? if( $userBlocked === false ): ?>
<div class="SpeechBubble new-message post">
	<div class="speech-bubble-avatar">
		<?= AvatarService::renderAvatar($username, 50) ?>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="no-title-container">
			<div class="no-title-warning" style="display:none"><?= wfMsg('wall-no-title-warning') ?></div>
		</div>
		<textarea id="WallMessageTitle" class="title" type="text" placeholder="<?= wfMsg('wall-placeholder-topic') ?>"></textarea>
		<? if (User::isIP($wall_username) ): ?>
			<textarea id="WallMessageBody" class="body" placeholder="<?= wfMsg('wall-placeholder-message-anon') ?>"></textarea>
		<? else: ?>
			<textarea id="WallMessageBody" class="body" placeholder="<?= wfMsgExt('wall-placeholder-message', array('parsemag'), array($wall_username)) ?>"></textarea>
		<? endif; ?>
		<?php if( $loginToEditProtectedPage ) { ?>
			<button id="WallMessageSubmit" class="wall-require-login" disabled="disabled" style="display: none" data="<?= $ajaxLoginUrl; ?>"><?= wfMsg('wall-button-to-submit-comment') ?></button>
		<?php } else { ?>
			<button id="WallMessageSubmit" disabled="disabled" style="display: none"><?= wfMsg('wall-button-to-submit-comment') ?></button>
		<?php } ?>
		<? if (0): ?>
		<button id="WallMessagePreview" disabled="disabled" style="display: none" class="secondary"><?= wfMsg('wall-button-to-preview-comment') ?></button>
		<button id="WallMessagePreviewCancel" style="display: none" class="secondary"><?= wfMsg('wall-button-to-cancel-preview') ?></button>
		<? endif; ?>
		<div class="loadingAjax"></div>
	</blockquote>
</div>
<? else: ?>
<br />
<? endif; ?>