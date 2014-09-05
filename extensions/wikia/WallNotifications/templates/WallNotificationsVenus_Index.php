<? if( $loggedIn && empty( $suppressWallNotifications ) ): ?>
	<ul id="WallNotificationsVenus" class="WallNotifications <?php if( $prehide ): ?>prehide<?php endif; ?>">
		<li>
			<header class="notifications-header"><?= wfMessage('wall-notifications-all')->text() ?></header>
		</li>
		<li class="notification empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
	</ul>
	<div id="WallNotificationsReminder">
		<a><?= wfMessage('wall-notifications-reminder', '?')->text() ?></a>
	</div>
<? endif; ?>