<? if($user->isLoggedIn()): ?>
	<ul id="WallNotifications" class="WallNotifications">
		<li>
			<div class="bubbles">
				<span id="bubbles_count"></span>
			</div>
			<ul class="subnav">
				<li class="notifications-header">
					<?= wfMsg('wall-notifications') ?>
				</li>
				<li class="notifications-empty"><?= wfMsg('wall-notifications-loading') ?></li>
			</ul>
		</li>
	</ul>
<? endif; ?>