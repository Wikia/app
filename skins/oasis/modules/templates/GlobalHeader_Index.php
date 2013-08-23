<? if ( !empty($isGameStarLogoEnabled )): ?>
	<div class="gamestar-wrapper">
		<div class="gamestar-container">
			<div class="gamestar"></div>
		</div>
	</div>
<? endif; ?>
<header id="WikiaHeader" class="WikiaHeader<?= (empty($wg->WikiaSeasonsGlobalHeader) ? '' : ' WikiaSeasonsGlobalHeader') ?>">
	<div class="wikia-header-mask">
		<div class="page-width-container">
			<? if ( !empty($isGameStarLogoEnabled )) echo $app->renderView('GameStarLogo', 'Index'); ?>
			<a href="#" id="BrowseEntry" class="browse-entry">
				<span class="chevron-container"></span>
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
			<?= $app->renderView('AccountNavigation', 'Index') ?>
			<?= $app->renderView('WallNotifications', 'Index') ?>
		</div>
	</div>
</header>
