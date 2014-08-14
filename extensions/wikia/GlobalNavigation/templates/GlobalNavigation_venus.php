<nav class="global-navigation">
	<div class="page-width">
		<div class="global-navigation-item">
			<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" class="logo" height="23" width="91" alt="Wikia">Test</a>
		</div>
		<div class="global-navigation-item">
			Search goes here
		</div>
		<div class="global-navigation-item">
			<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="start-wikia"><?= wfMessage('global-navigation-create-wiki')->text(); ?></a>
		</div>
		<div class="global-navigation-item">
			user login
		</div>
	</div>
</nav>