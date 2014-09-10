<? if( $loggedIn && empty( $suppressWallNotifications ) ): ?>
	<div id="WallNotificationsReminder">
		<a><?= wfMessage('wall-notifications-reminder', '?')->text() ?></a>
	</div>
<? endif; ?>
