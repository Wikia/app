<nav class="global-navigation">
	<div class="page-width">
		<div class="global-navigation-item wikia-logo-container">
			<a href="<?= htmlspecialchars($centralUrl) ?>" class="global-navigation-link wikia-logo" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" height="24" width="91" alt="Wikia"></a>
		</div>
		<div class="global-navigation-item search-container">
			<?= $app->renderView('GlobalNavigation', 'searchIndex'); ?>
		</div>
		<div class="global-navigation-item start-wikia-container">
			<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="global-navigation-link start-wikia"><span><?= wfMessage('global-navigation-create-wiki')->text(); ?></span></a>
		</div>
		<div class="global-navigation-item account-navigation-container">
			<?= $app->renderView('AccountNavigation', 'Index', [ 'template' => 'venus' ] ) ?>
			<?//= $app->renderView('WallNotifications', 'Index') ?>
		</div>
	</div>
</nav>
