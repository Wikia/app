<nav class="global-navigation" id="globalNavigation">
	<div class="page-width">
		<div class="global-navigation-item wikia-logo-container" id="hubsEntryPoint">
			<a href="<?= htmlspecialchars( $centralUrl ) ?>" class="global-navigation-link wikia-logo" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" height="24" width="91" alt="<?= wfMessage('global-navigation-wikia')->escaped() ?>" title="<?= wfMessage('global-navigation-wikia')->escaped() ?>"></a>
			<?= $app->renderView('GlobalNavigation', 'hubsMenu') ?>
		</div>
		<div class="global-navigation-item search-container">
			<?= $app->renderView( 'GlobalNavigation', 'searchIndex' ); ?>
		</div>
		<div class="global-navigation-item start-wikia-container">
			<a href="<?= htmlspecialchars( $createWikiUrl ) ?>" class="global-navigation-link start-wikia" title="<?= wfMessage( 'global-navigation-create-wiki' )->escaped(); ?>"><span><?= nl2br(wfMessage( 'global-navigation-create-wiki' )->escaped()); ?></span></a>
		</div>
		<div class="global-navigation-item account-navigation-container">
			<?= $app->renderView( 'GlobalNavigationAccountNavigation', 'index' ) ?>
		</div>
		<? if ($isGameStarLogoEnabled): ?>
			<a class="gamestar-logo" href="http://gamestar.de/"></a>
		<? endif; ?>
	</div>
</nav>
