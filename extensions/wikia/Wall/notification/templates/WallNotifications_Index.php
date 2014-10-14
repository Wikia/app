<? if( $loggedIn && empty( $suppressWallNotifications ) ): ?>
	<ul id="WallNotifications" class="WallNotifications <?php if( $prehide ): ?>prehide<?php endif; ?>">
		<li>
			<div class="bubbles">
				<span id="bubbles_count"></span>
			</div>
			<ul class="subnav">
				<li class="notifications-header">
					<span><?= wfMsg('wall-notifications-all') ?></span>
				</li>
				<li class="notifications-empty"><?= wfMsg('wall-notifications-loading') ?></li>
			</ul>
		</li>
	</ul>
	<div id="WallNotificationsReminder">
		<a><?= wfMsg('wall-notifications-reminder', '?') ?></a>
	</div>
<? endif; ?>