<div id="notificationsEntryPoint" class="wds-global-navigation__notifications-menu wds-global-navigation__content-item-notifications-menu wds-dropdown notifications-container">
	<div class="wds-dropdown-toggle wds-global-navigation__dropdown-toggle">
		<div class="bubbles">
			<div class="wds-global-navigation__content-item-notifications-menu-counter notifications-count"></div>
		</div>
	</div>
	<?= DesignSystemHelper::getSvg(
		'wds-icons-bell',
		'wds-icon wds-icon-small'
	) ?>
	<?= DesignSystemHelper::getSvg(
		'wds-icons-dropdown-tiny',
		'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
	) ?>
	<div id="notifications" class="wds-dropdown-content wds-is-right-aligned wds-global-navigation__dropdown">
		<ul id="GlobalNavigationWallNotifications" class="WallNotifications global-nav-dropdown"></ul>
	</div>
</div>
