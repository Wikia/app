<li class="SpeechBubble new-reply">
	<div class="speech-bubble-avatar">
		<?= AvatarService::renderAvatar($username, 30) ?>
	</div>
	<blockquote class="speech-bubble-message">
		<textarea placeholder="<?= wfMsg('wall-placeholder-reply') ?>"></textarea>
	</blockquote>
	<div class="abs-container">
		<?php if( $loginToEditProtectedPage ) { ?>
			<button class="replyButton wall-require-login" data="<?= $ajaxLoginUrl; ?>"><?= wfMsg('wall-button-to-submit-reply') ?></button>
		<?php } else { ?>
			<button class="replyButton"><?= wfMsg('wall-button-to-submit-reply') ?></button>
		<?php } ?>
	</div>
</li>