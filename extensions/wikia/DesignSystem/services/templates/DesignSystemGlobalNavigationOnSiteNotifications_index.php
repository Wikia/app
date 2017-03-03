<div id="onSiteNotificationsEntryPoint"
     class="wds-global-navigation__notifications-menu wds-global-navigation__notifications-menu wds-dropdown on-site-notifications-container">
	<div class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle"
	     title="<?= wfMessage( 'global-navigation-notifications-title' )->escaped() ?>">
		<div class="bubbles">
			<div class="wds-global-navigation__notifications-menu-counter on-site-notifications-count">
			</div>
		</div>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-bell', 'wds-icon wds-icon-small',
			wfMessage( 'global-navigation-notifications-title' )->escaped() ) ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ) ?>
	</div>
	<div id="on_site_notifications"
	     class="wds-dropdown__content wds-is-right-aligned wds-global-navigation__dropdown-content">
		<ul id="GlobalNavigationOnSiteNotifications"
		    class="OnSiteNotifications global-nav-dropdown"></ul>
	</div>
</div>
