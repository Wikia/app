<?
	$helper = new WallHelper();
?>
<li class="unread_notification admin_notification">
	<a href="<?= $url ?>">
		<div class="notification">
			<div class="msg-title"><?= $helper->shortenText($title, WallNotificationsController::NOTIFICATION_TITLE_LIMIT) ?></div>
			<?= $msg ?>
			<div class="timeago" title="<?= $iso_timestamp ?>"></div>
		</div>
	</a>
</li>