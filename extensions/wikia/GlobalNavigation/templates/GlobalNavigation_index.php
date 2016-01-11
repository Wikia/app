<?php if (!$wg->EnableGlobalNav2016): ?>
	<nav class="global-navigation" id="globalNavigation">
		<div class="global-navigation-container">
			<div class="wikia-logo-container table-cell">
				<a href="<?= htmlspecialchars( $centralUrl ) ?>"
					class="wikia-logo"
					rel="nofollow"
					data-id="wikia-logo">
					<img src="<?= $wg->BlankImgUrl ?>"
						height="24"
						width="91"
						alt="<?= wfMessage( 'oasis-global-page-header' )->escaped() ?>"
						title="<?= wfMessage( 'oasis-global-page-header' )->escaped() ?>">
				</a>
			</div>
			<div class="hubs-container table-cell" id="hubsEntryPoint">
				<?= $app->renderView( 'GlobalNavigation', 'hubsMenu' ) ?>
	</div>
	<div class="search-container table-cell">
		<?= $app->renderView( 'GlobalNavigation', 'searchIndex' ); ?>
	</div>
	<div class="account-navigation-container table-cell">
		<?= $app->renderView( 'GlobalNavigationAccountNavigation', 'index' ) ?>
	</div>
	<?php if ( !$isAnon && $notificationsEnabled ): ?>
		<div class="notifications-container table-cell" id="notificationsEntryPoint">
			<?= $app->renderView( 'GlobalNavigationWallNotifications', 'Index' ); ?>
		</div>
	<?php endif; ?>
	<div class="start-wikia-container table-cell">
		<a href="<?= htmlspecialchars( $createWikiUrl ) ?>"
		   class="start-wikia"
		   title="<?= wfMessage( 'global-navigation-create-wiki' )->escaped(); ?>"
		   data-id="start-wikia">
			<span><?= ( wfMessage( 'global-navigation-create-wiki' )->escaped() ); ?></span>
		</a>
	</div>
	<? if ( $isGameStarLogoEnabled ): ?>
		<a class="gamestar-logo" href="http://gamestar.de/"></a>
	<? endif; ?>
	</div>
	</nav>
<?php else: //wgEnableGlobalNav2016 ?>
	<nav class="global-navigation global-navigation-2016" id="globalNavigation">
		<div class="global-navigation-container">
			<div class="wikia-logo-container table-cell">
				<a href="<?= htmlspecialchars( $centralUrl ) ?>"
					class="wikia-logo"
					rel="nofollow"
					data-id="wikia-logo">
					<img src="<?= $wg->BlankImgUrl ?>"
						height="24"
						width="91"
						alt="<?= wfMessage( 'oasis-global-page-header' )->escaped() ?>"
						title="<?= wfMessage( 'oasis-global-page-header' )->escaped() ?>">
					<span class="wikia-logo__subtitle"><?= wfMessage( 'global-navigation-home-of-fandom' )->escaped() ?></span>
				</a >
			</div >
			<div class="table-cell">
				<a class="cell-link" href="http://gameshub.wikia.com/wiki/Games_Hub">Games</a>
				<a class="cell-link" href="http://movieshub.wikia.com/wiki/Movies_Hub">Movies</a>
				<a class="cell-link" href="http://tvhub.wikia.com/wiki/TV_Hub">TV</a>
			</div>
			<div class="table-cell">
				<div id="exploreWikiaEntryPoint">
					<a class="cell-link" href="#">Explore Wikia</a>
					<ul class="explore-wikia-dropdown" id="exploreWikiaDropdown">
						<li><a href="http://gameshub.wikia.com/wiki/Games_Hub">Games</a></li>
						<li><a href="http://movieshub.wikia.com/wiki/Movies_Hub">Movies</a></li>
						<li><a href="http://tvhub.wikia.com/wiki/TV_Hub">TV</a></li>
						<li><a href="#">Top Communities</a></li>
						<li><a href="#">Community Central</a></li>
					</ul>
				</div>
			</div>
			<div class="search-container table-cell">
				<?= $app->renderView('GlobalNavigation', 'searchIndex'); ?>
			</div>
			<div class="account-navigation-container table-cell">
				<?= $app->renderView('GlobalNavigationAccountNavigation', 'index') ?>
			</div>
			<?php if (!$isAnon && $notificationsEnabled): ?>
				<div class="notifications-container table-cell" id="notificationsEntryPoint">
					<?= $app->renderView('GlobalNavigationWallNotifications', 'Index'); ?>
				</div>
			<?php endif; ?>
			<? if ($isGameStarLogoEnabled): ?>
				<a class="gamestar-logo" href="http://gamestar.de/"></a>
			<? endif; ?>
		</div>
	</nav>
<? endif; ?>
