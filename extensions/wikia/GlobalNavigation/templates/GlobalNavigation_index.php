<nav class="global-navigation" id="globalNavigation">
	<div class="page-width">
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
