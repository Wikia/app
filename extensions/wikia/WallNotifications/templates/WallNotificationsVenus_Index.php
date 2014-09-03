<? if( $loggedIn && empty( $suppressWallNotifications ) ): ?>
	<ul id="WallNotificationsVenus" class="WallNotifications <?php if( $prehide ): ?>prehide<?php endif; ?>">
		<li class="notifications-header">
			<span><strong><?= wfMessage('wall-notifications-all')->text() ?></strong></span>
		</li>
		<li class="notifications-empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
	</ul>
	<div id="WallNotificationsReminder">
		<a><?= wfMessage('wall-notifications-reminder', '?')->text() ?></a>
	</div>
<? endif; ?>