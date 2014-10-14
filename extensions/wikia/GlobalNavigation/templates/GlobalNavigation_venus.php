<nav class="global-navigation">
	<div class="page-width">
		<div class="global-navigation-item">
			<a href="<?= htmlspecialchars($centralUrl) ?>" class="global-navigation-link wikia-logo" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" height="24" width="91" alt="Wikia"></a>
			<?= $app->renderView('GlobalNavigation', 'hubsMenu') ?>
		</div>
		<div class="global-navigation-item">
			Search goes here
		</div>
		<div class="global-navigation-item">
			<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="global-navigation-link start-wikia"><span><?= wfMessage('global-navigation-create-wiki')->text(); ?></span></a>
		</div>
		<div class="global-navigation-item">
			user login
		</div>
	</div>
</nav>