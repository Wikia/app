<div id="notificationsEntryPoint" class="wds-global-navigation__content-item wds-global-navigation__content-item-notifications-menu wds-dropdown wds-is-active">
	<div class="bubbles">
		<div class="wds-global-navigation__content-item-notifications-menu-counter notifications-count"></div>
	</div>
	<?= DesignSystemHelper::getSvg(
		'wds-icons-bell',
		'wds-icon wds-icon-small'
	) ?>
	<?= DesignSystemHelper::getSvg(
		'wds-icons-dropdown-tiny',
		'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
	) ?>
	<div id="notifications" class="wds-dropdown-content wds-is-right-aligned wds-global-navigation__dropdown notifications-container">
		<ul id="GlobalNavigationWallNotifications" class="WallNotifications global-nav-dropdown">
		</ul>
	</div>
</div>
