<div class="wds-global-navigation">
	<div class="wds-global-navigation__content-bar">
		<a href="#" class="wds-global-navigation__content-item wds-global-navigation__content-item-logo">
			<?= DesignSystemHelper::getSvg(
				'wds-company-logo-fandom',
				'wds-global-navigation__content-item-logo-fandom'
			) ?>
			<span class="wds-global-navigation__content-item-logo-powered-by">powered by</span>
			<?= DesignSystemHelper::getSvg(
				'wds-company-logo-wikia',
				'wds-global-navigation__content-item-logo-wikia'
			) ?>
		</a>
		<a href="#" class="wds-global-navigation__content-item wds-global-navigation__content-item-link wds-is-games">Games</a>
		<a href="#" class="wds-global-navigation__content-item wds-global-navigation__content-item-link wds-is-movies">Movies</a>
		<a href="#" class="wds-global-navigation__content-item wds-global-navigation__content-item-link wds-is-tv">TV</a>
		<div class="wds-global-navigation__content-item wds-global-navigation__content-item-link wds-dropdown">
			<div class="wds-dropdown-toggle wds-global-navigation__dropdown-toggle">
				<span>Wikis</span>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
				) ?>
			</div>
			<div class="wds-dropdown-content wds-global-navigation__dropdown">
				<ul class="wds-list">
					<li><a href="#" class="wds-global-navigation__dropdown-link">Explore Wikis</a></li>
					<li><a href="#" class="wds-global-navigation__dropdown-link">Community Central</a></li>
				</ul>
			</div>
		</div>
		<form class="wds-global-navigation__content-item wds-global-navigation__content-item-search">
			<div class="wds-global-navigation__content-item-search-input-wrapper">
				<label class="wds-global-navigation__content-item-search-label">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-magnifying-glass',
						'wds-icon wds-icon-small'
					) ?>
					<input class="wds-global-navigation__content-item-search-input" name="search" placeholder="Search"/>
				</label>
				<button class="wds-button wds-is-text wds-global-navigation__content-item-search-close">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-cross',
						'wds-icon wds-icon-small wds-global-navigation__content-item-search-close-icon'
					) ?>
				</button>
			</div>
			<button class="wds-button wds-global-navigation__content-item-search-submit">
				<?= DesignSystemHelper::getSvg(
					'wds-icons-arrow',
					'wds-icon wds-icon-small wds-global-navigation__content-item-search-icon'
				) ?>
			</button>
		</form>
		<div class="wds-global-navigation__content-item wds-dropdown wds-global-navigation__user-menu">
			<div class="wds-dropdown-toggle wds-global-navigation__dropdown-toggle">
				<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="wds-avatar wds-is-circle" alt="user name"/>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
				) ?>
			</div>
			<div class="wds-dropdown-content wds-global-navigation__dropdown">
				<ul class="wds-list">
					<li><a href="#" class="wds-global-navigation__dropdown-link">View Profile</a></li>
					<li><a href="#" class="wds-global-navigation__dropdown-link">My Talk</a></li>
					<li><a href="#" class="wds-global-navigation__dropdown-link">My Preferences</a></li>
					<li><a href="#" class="wds-global-navigation__dropdown-link">Help</a></li>
					<li><a href="#" class="wds-global-navigation__dropdown-link">Sign Out</a></li>
				</ul>
			</div>
		</div>
		<?= $app->renderView( 'DesignSystemGlobalNavigationWallNotificationsService', 'index' ); ?>
		<div class="wds-global-navigation__content-item wds-global-navigation__content-item-start-a-wiki">
			<a href="#" class="wds-button wds-is-squished wds-is-secondary">
				<span class="wds-global-navigation__content-item-start-a-wiki-caption">Start a wiki</span>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-plus',
					'wds-global-navigation__content-item-start-a-wiki-icon wds-icon'
				) ?>
			</a>
		</div>
	</div>
</div>
