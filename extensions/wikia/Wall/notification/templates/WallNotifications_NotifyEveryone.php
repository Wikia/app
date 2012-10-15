<?
	$helper = new WallHelper();
?>
<? if($unread): ?>
<li class="unread_notification admin_notification">
<? else: ?>
<li class="read_notification admin_notification">
<? endif; ?>
	<a href="<?= $url ?>">
		<div class="notification">
			<div class="msg-title"><?= $helper->shortenText($title, WallNotificationsController::NOTIFICATION_TITLE_LIMIT) ?></div>
			<?php echo wfMsg('wall-notifications-notifyeveryone', $authors[0]); ?>
			<div class="timeago" title="<?= $iso_timestamp ?>"></div>
		</div>
	</a>
</li>