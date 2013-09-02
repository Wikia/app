
<header id="WikiaHeader" class="WikiaHeader<?= (empty($wg->WikiaSeasonsGlobalHeader) ? '' : ' WikiaSeasonsGlobalHeader') ?>">
	<div class="wikia-header-mask">
		<a href="#" id="BrowseEntry" class="browse-entry">
			<span class="chevron-container"></span>
			<span class="hubname-container"><?= wfMsg('hub-'. $category->cat_name)?></span>
			<span class="text-container"><?= wfMessage('oasis-global-nav-browse-entry-point')->text() ?></span>
		</a>
		<nav>
			<? if ( $displayHeader ): ?>
				<h1><?= wfMsgHtml('oasis-global-nav-header'); ?></h1>
			<? endif; ?>
			<ul class="WikiaLogoContainer">
				<li class="WikiaLogo">
					<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" class="sprite logo" height="23" width="91" alt="Wikia"></a>
				</li>
				<?= (empty($wg->WikiaSeasonsGlobalHeader) ? '' : $app->renderView('WikiaSeasons', 'globalHeaderLights', array())); ?>
			</ul>
		</nav>
		<?= $app->renderView('WallNotifications', 'Index') ?>
		<?= $app->renderView('AccountNavigation', 'Index') ?>
		<? if ( !empty($isGameStarLogoEnabled )) echo $app->renderView('GameStarLogo', 'Index'); ?>
	</div>
</header>
