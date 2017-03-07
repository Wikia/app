<div class="wds-global-navigation__notifications-menu wds-global-navigation__notifications-menu wds-dropdown notifications-container">
	<div id="on-site-notifications-dropdown"
	     class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle"
	     title="<?= wfMessage( 'global-navigation-notifications-title' )->escaped() ?>">
		<div class="bubbles">
			<div
				class="wds-global-navigation__notifications-menu-counter on-site-notifications-count">
			</div>
		</div>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-bell', 'wds-icon wds-icon-small',
			wfMessage( 'global-navigation-notifications-title' )->escaped() ) ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ) ?>
	</div>
	<div class="wds-dropdown__content wds-is-right-aligned wds-global-navigation__dropdown-content">
		<div class="mark-all-as-read-button">
			<a  class="mark-all-as-read">
				<?= wfMessage( 'notifications-mark-all-as-read' )->escaped() ?>
			</a>
		</div>
		<div class="scrollable-part" id="on-site-notifications">

		</div>
	</div>
</div>
