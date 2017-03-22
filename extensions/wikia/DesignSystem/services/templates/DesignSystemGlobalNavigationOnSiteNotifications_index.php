<?= DesignSystemHelper::renderSvg( 'wds-icons-reply-small', 'wds-hidden-svg' ) ?>
<?= DesignSystemHelper::renderSvg( 'wds-icons-upvote-small', 'wds-hidden-svg' ) ?>

<?
	// wds-global-navigation__notifications-menu wds-dropdown notifications-container bubbles
	// wds-global-navigation__dropdown-content wds-is-right-aligned
	// are borrowed from Global Navigation and they're responsible for displaying the icon,
	// dropdown and bubble with unread notifications count
?>
<div class="wds-global-navigation__notifications-menu wds-dropdown notifications-container wds-notifications">
	<div id="onSiteNotificationsDropdown"
	     class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle"
	     title="<?= wfMessage( 'global-navigation-notifications-title' )->escaped() ?>">
		<div class="bubbles">
			<div id="onSiteNotificationsCount"
			     class="wds-global-navigation__notifications-menu-counter">
			</div>
		</div>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-bell', 'wds-icon wds-icon-small',
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
		<p class="wds-notifications__zero-state">
			<?= wfMessage( 'notifications-no-notifications-message' )->escaped() ?>
		</p>
		<ul class="wds-notifications__notification-list wds-list wds-has-lines-between"
		    id="notificationContainer">
			<? //= will be populated by jQuery ?>
		</ul>
	</div>
</div>
