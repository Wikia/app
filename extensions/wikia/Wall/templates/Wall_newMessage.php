<div class="SpeechBubble new-message post">
	<div class="speech-bubble-avatar">
		<?= AvatarService::renderAvatar($username, 50) ?>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="no-title-container">
			<div class="no-title-warning" style="display:none"><?= wfMsg('wall-no-title-warning') ?></div>
		</div>
		<textarea id="WallMessageTitle" class="title" type="text" placeholder="<?= wfMsg('wall-placeholder-topic') ?>"></textarea>
		<textarea id="WallMessageBody" class="body" placeholder="<?= wfMsg('wall-placeholder-message', $wall_username . '\'s') ?>"></textarea>
		<?php if( $loginToEditProtectedPage ) { ?>
			<button id="WallMessageSubmit" class="wall-require-login" disabled="disabled" style="display: none" data="<?= $ajaxLoginUrl; ?>"><?= wfMsg('wall-button-to-submit-comment') ?></button>
		<?php } else { ?>
			<button id="WallMessageSubmit" disabled="disabled" style="display: none"><?= wfMsg('wall-button-to-submit-comment') ?></button>
		<?php } ?>
	</blockquote>
</div>
