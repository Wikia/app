<div class="wds-hidden-svg">
	<?= DesignSystemHelper::renderSvg( 'wds-icons-flag-small' ) ?>
	<?= DesignSystemHelper::renderSvg( 'wds-icons-comment-small' ) ?>
	<?= DesignSystemHelper::renderSvg( 'wds-icons-heart-small' ) ?>
</div>

<?
	// wds-global-navigation__notifications-menu wds-dropdown notifications-container bubbles
	// wds-global-navigation__dropdown-content wds-is-right-aligned
	// are borrowed from Global Navigation and they're responsible for displaying the icon,
	// dropdown and bubble with unread notifications count
?>
<div class="wds-global-navigation__notifications-dropdown wds-dropdown wds-has-dark-shadow">
	<div id="onSiteNotificationsDropdown"
	     class="wds-global-navigation__dropdown-toggle wds-dropdown__toggle"
	     title="<?= wfMessage( 'global-navigation-notifications-title' )->escaped() ?>">
		<div id="onSiteNotificationsCount" class="wds-global-navigation__notifications-counter wds-is-hidden">
			<? //= will be populated by jQuery ?>
		</div>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-bell', 'wds-icon',
			wfMessage( 'global-navigation-notifications-title' )->escaped() ) ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ) ?>
	</div>
	<div
		class="wds-dropdown__content wds-is-right-aligned wds-notifications__dropdown-content">
		<div id="markAllAsReadButton" class="wds-notifications__mark-all-as-read-button">
			<a class="wds-notifications__mark-all-as-read">
				<?= wfMessage( 'notifications-mark-all-as-read' )->escaped() ?>
			</a>
		</div>
		<p class="wds-notifications__zero-state wds-is-hidden">
			<?= wfMessage( 'notifications-no-notifications-message' )->escaped() ?>
		</p>
		<ul class="wds-notifications__notification-list wds-list wds-has-lines-between"
		    id="notificationContainer">
			<? //= will be populated by jQuery ?>
		</ul>
	</div>
</div>
