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
			<nav>
				<? if ( $displayHeader ): ?>
				<h1><?= wfMsgHtml('oasis-global-nav-header'); ?></h1>
				<? endif; ?>
				<ul>
					<li class="WikiaLogo">
						<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" class="sprite logo" height="23" width="91" alt="Wikia"></a>
					</li>
					<li class="start-a-wiki">
						<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="wikia-button"><?= wfMsgHtml('oasis-global-nav-create-wiki'.$altMessage); ?></a>
					</li>
					<li>
						<ul id="GlobalNavigation" class="GlobalNavigation<?= $wg->GlobalHeaderVerticalColors ? ' vertical-colors' : '' ?>" data-hash="<?= $menuNodesHash ?>">
							<? if(is_array($topNavMenuItems)): ?>
								<? foreach($topNavMenuItems as $topNavIndex): ?>
										<? $topNavItem = $menuNodes[$topNavIndex] ?>
										<li class="topNav <?= str_replace(' ', '_', $topNavItem['text']) ?> <?php if( isset($topNavItem['specialAttr']) ) { echo str_replace(' ', '_', $topNavItem['specialAttr']); } ?>" data-index="<?= $topNavIndex?>">
											<a href="<?= $topNavItem['href'] ?>"><?= $topNavItem['text'] ?><img src="<?= $wg->BlankImgUrl; ?>" class="chevron" height="0" width="0"></a>
											<ul class="subnav"></ul>
										</li>
								<? endforeach ?>
							<? endif ?>
						</ul>
					</li>
					<?= (empty($wg->WikiaSeasonsGlobalHeader) ? '' : $app->renderView('WikiaSeasons', 'globalHeaderLights', array())); ?>
				</ul>
			</nav>
			<?= $app->renderView('AccountNavigation', 'Index') ?>
			<?= $app->renderView('WallNotifications', 'Index') ?>
		</div>
	</div>
</header>
