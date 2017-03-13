<?= DesignSystemHelper::renderSvg( 'wds-icons-reply-small', 'wds-hidden-svg' ) ?>
<?= DesignSystemHelper::renderSvg( 'wds-icons-upvote-small', 'wds-hidden-svg' ) ?>

<div class="wds-global-navigation__notifications-menu wds-dropdown notifications-container">
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
		class="wds-dropdown__content wds-is-right-aligned wds-global-navigation__dropdown-content wds-notifications__dropdown-content">
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

<!--			<svg class='wds-spinner' width='79' viewBox='0 0 79 79' xmlns='http://www.w3.org/2000/svg'>-->
<!--				<g transform='translate(39.5, 39.5)'>-->
<!--					<circle class='path stroke-theme-color' fill='none' stroke-width='3' stroke-linecap='round' r='38'></circle>-->
<!--				</g>-->
<!--			</svg>-->

		</ul>
	</div>
</div>
