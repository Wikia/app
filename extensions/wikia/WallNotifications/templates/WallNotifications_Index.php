<? if( $loggedIn && empty( $suppressWallNotifications ) ): ?>
	<ul id="WallNotifications" class="WallNotifications <?php if( $prehide ): ?>prehide<?php endif; ?>">
		<li>
			<div class="bubbles">
				<span id="bubbles_count"></span>
			</div>
			<ul class="subnav">
				<li class="notifications-header">
					<span><?= wfMessage('wall-notifications-all')->text() ?></span>
				</li>
				<li class="notifications-empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
			</ul>
		</li>
	</ul>
	<div id="WallNotificationsReminder">
		<a><?= wfMessage('wall-notifications-reminder', '?')->text() ?></a>
	</div>
<? endif; ?>