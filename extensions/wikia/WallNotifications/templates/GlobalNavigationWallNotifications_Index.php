<? if( $loggedIn && empty( $suppressWallNotifications ) ): ?>
	<li id="notifications" <?php if( $prehide ): ?>class="prehide"<?php endif; ?>>
		<a href="#"><?= wfMessage('wall-notifications-all')->text() ?> <span class="notifications-count"></span></a>
		<ul id="GlobalNavigationWallNotifications" class="WallNotifications">
			<li>
				<header class="notifications-header"><?= wfMessage('wall-notifications-all')->text() ?></header>
			</li>
			<li class="notification empty"><?= wfMessage('wall-notifications-loading')->text() ?></li>
		</ul>
	</li>
<? endif; ?>

