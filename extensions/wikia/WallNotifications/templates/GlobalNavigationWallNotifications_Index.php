<div class="bubbles">
	<div class="bubbles-count notifications-count"></div>
</div>
<a class="notifications-entry-point"></a>
<li id="notifications" class="notifications-container <?php if( $prehide ): ?> prehide<?php endif; ?>">
	<ul id="GlobalNavigationWallNotifications" class="WallNotifications global-nav-dropdown">
		<li id="notificationsContainer">
			<ul>
				<li class="notification empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
			</ul>
		</li>
	</ul>
</li>

