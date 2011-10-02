<? if($user->isLoggedIn()): ?>
	<ul id="WallNotifications" class="WallNotifications">
		<li>
			<div class="bubbles">
				<span id="bubbles_count"></span>
			</div>
			<ul class="subnav">
				<div class="notifications-header">
					<?= wfMsg('wall-notifications') ?>
				</div>
				<div class="notifications-empty"><?= wfMsg('wall-notifications-loading') ?></div>
			</ul>
		</li>
	</ul>
<? endif; ?>