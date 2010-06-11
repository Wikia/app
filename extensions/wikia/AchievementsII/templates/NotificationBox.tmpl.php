<?php
global $wgExtensionsPath, $wgStyleVersion;
?>
<link href="<?= $wgExtensionsPath.'/wikia/AchievementsII/css/notification.css?'.$wgStyleVersion ?>" type="text/css" rel="stylesheet">
<?php
$badgeName = htmlspecialchars($badge->getName());
?>
<div id="wikia-alert" class="accent" style="display: none;">
	<img src="<?=$badge->getPictureUrl(90);?>" alt="<?=$badgeName;?>" width="90" height="90" />
	<div id="alert">
		<h1><?=wfMsg('achievements-notification-title', $user->getName());?></h1>
		<h2><?=wfMsg('achievements-notification-subtitle', $badge->getName(), $badge->getPersonalGivenFor());?></h2>
		<p><?=wfMsgExt('achievements-notification-link', array('parse'), $user->getName());?></p>
	</div>
	<h3 class="<?=AchConfig::getInstance()->getLevelMsgKeyPart($badge->getLevel());?>">
		<span id="points"><?=wfMsg( 'achievements-points-with-break', AchConfig::getInstance()->getLevelScore( $badge->getLevel() ) );?></span>
	</h3>
</div>

<script>
	wgAfterContentAndJS.push(
		function() {
			$(function() {
				var trackFunc = function(e) {
					window.jQuery.tracker.byStr('Achievements/notification/yourprofile');
				};
				
				$('#alert').find('a').click(trackFunc);

				$('#wikia-alert').click(function(e) {
					trackFunc();
					window.location.href = $('#alert').find('a').attr('href');
				});
				
				$('#wikia-alert').slideDown('slow');
				setTimeout(function() {$('#wikia-alert').slideUp('slow');}, 10000);
				window.jQuery.tracker.byStr('Achievements/notification/appears');
			});
		}
	);
</script>

