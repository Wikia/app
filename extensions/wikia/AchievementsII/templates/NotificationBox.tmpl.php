<?php
global $wgExtensionsPath;
?>
<link href="<?= $wgExtensionsPath ?>/wikia/AchievementsII/css/notification.css" type="text/css" rel="stylesheet">
<?php
$badgeName = htmlspecialchars($badge->getName());
?>
<div class="AchievementsNotification accent reset" style="display: none;">
	<img src="<?=$badge->getPictureUrl(90);?>" alt="<?=$badgeName;?>" />
	<div class="text">
		<h1><?=wfMsg('achievements-notification-title', $user->getName());?></h1>
		<p><?=wfMsg('achievements-notification-subtitle', $badge->getName(), $badge->getPersonalGivenFor());?></p>
		<p><?=wfMsgExt('achievements-notification-link', array('parse'), $user->getName());?></p>
	</div>
	<div class="points <?=AchConfig::getInstance()->getLevelMsgKeyPart($badge->getLevel());?>">
		<span><?=wfMsg( 'achievements-points-with-break', AchConfig::getInstance()->getLevelScore( $badge->getLevel() ) );?></span>
	</div>
</div>

<script>
	// FIXME: move this somewhere else?
	wgAfterContentAndJS.push(function() {
		$(function() {
			$('.AchievementsNotification').slideDown('slow');
			setTimeout(function() {$('.AchievementsNotification').slideUp('slow');}, 10000);
		});
	});
</script>

