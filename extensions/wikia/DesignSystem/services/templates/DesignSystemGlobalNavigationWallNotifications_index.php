<div id="notificationsEntryPoint" class="wds-global-navigation__notifications-menu wds-global-navigation__notifications-menu wds-dropdown notifications-container">
	<div class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle" title="<?=wfMessage( 'global-navigation-notifications-title' )->escaped()?>">
		<div class="bubbles">
			<div class="wds-global-navigation__notifications-menu-counter notifications-count"></div>
		</div>
		<?= DesignSystemHelper::getSvg(
			'wds-icons-bell',
			'wds-icon wds-icon-small',
			wfMessage( 'global-navigation-notifications-title' )->escaped()
		) ?>
		<?= DesignSystemHelper::getSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
		) ?>
	</div>
	<div id="notifications" class="wds-dropdown__content wds-is-right-aligned wds-global-navigation__dropdown-content">
		<ul id="GlobalNavigationWallNotifications" class="WallNotifications global-nav-dropdown"></ul>
	</div>
</div>
