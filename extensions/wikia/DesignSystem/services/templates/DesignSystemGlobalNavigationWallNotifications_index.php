<div class="wds-global-navigation__content-item wds-global-navigation__notifications wds-dropdown wds-is-active notifications-entry-point">
	<div class="wds-global-navigation__notifications-counter wds-dropdown-toggle wds-global-navigation__dropdown-toggle notifications-count"></div>
	<?= DesignSystemHelper::getSvg(
		'wds-icons-bell',
		'wds-icon wds-icon-small'
	) ?>
	<?= DesignSystemHelper::getSvg(
		'wds-icons-dropdown-tiny',
		'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
	) ?>
	<div id="notifications" class="wds-dropdown-content wds-global-navigation__dropdown notifications-container">
		<ul id="GlobalNavigationWallNotifications" class="WallNotifications global-nav-dropdown">
		</ul>
	</div>
</div>
