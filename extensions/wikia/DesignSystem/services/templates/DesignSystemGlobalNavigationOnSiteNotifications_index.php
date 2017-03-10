<?= DesignSystemHelper::renderSvg( 'wds-icons-reply-small' , 'wds-hidden-svg' ) ?>
<?//= DesignSystemHelper::renderSvg( 'wds-icons-megaphone' , 'wds-hidden-svg' ) ?>
<?= DesignSystemHelper::renderSvg( 'wds-icons-upvote-small' , 'wds-hidden-svg' ) ?>

<div class="wds-global-navigation__notifications-menu wds-dropdown notifications-container">
	<div id="on-site-notifications-dropdown"
	     class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle"
	     title="<?= wfMessage( 'global-navigation-notifications-title' )->escaped() ?>">
		<div class="bubbles">
			<div id="on-site-notifications-count"
			     class="wds-global-navigation__notifications-menu-counter">
			</div>
		</div>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-bell', 'wds-icon wds-icon-small',
			wfMessage( 'global-navigation-notifications-title' )->escaped() ) ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ) ?>
	</div>
	<div
		class="wds-dropdown__content wds-is-right-aligned wds-global-navigation__dropdown-content wds-notifications__dropdown-content">
		<div id="mark-all-as-read-button" class="wds-notifications__mark-all-as-read-button">
			<a class="wds-notifications__mark-all-as-read">
				<?= wfMessage( 'notifications-mark-all-as-read' )->escaped() ?>
			</a>
		</div>
		<div class="wds-notification-list">
			<ul class="wds-list wds-has-lines-between" id="notification-container">

			</ul>
		</div>
	</div>
</div>
