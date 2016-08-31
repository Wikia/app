<div class="wds-global-navigation__notifications-menu wds-dropdown wds-is-active notifications-entry-point">
	<div class="wds-dropdown-toggle wds-global-navigation__dropdown-toggle">
		<div class="wds-global-navigation__notifications-menu-counter notifications-count"></div>
		<?= DesignSystemHelper::getSvg(
			'wds-icons-bell',
			'wds-icon wds-icon-small'
		) ?>
		<?= DesignSystemHelper::getSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
		) ?>
	</div>
	<div id="notifications" class="wds-dropdown-content wds-is-right-aligned wds-global-navigation__dropdown notifications-container">
		<ul id="GlobalNavigationWallNotifications" class="WallNotifications global-nav-dropdown">
		</ul>
	</div>
</div>
