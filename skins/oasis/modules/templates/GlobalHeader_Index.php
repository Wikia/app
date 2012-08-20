<header id="WikiaHeader" class="WikiaHeader">
	<? if ( !empty($isGameStarLogoEnabled )) echo wfRenderModule('GameStarLogo'); ?>
	<nav>
		<h1>Wikia Navigation</h1>
		<ul>
			<li class="WikiaLogo">
				<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" class="sprite logo" height="23" width="91" alt="Wikia"></a>
			</li>
			<li class="start-a-wiki">
				<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="wikia-button"><?= wfMsgHtml('oasis-global-nav-create-wiki'); ?></a>
			</li>
			<li>
				<ul id="GlobalNavigation" class="GlobalNavigation<?= $wg->GlobalHeaderVerticalColors ? ' vertical-colors' : '' ?>" data-hash="<?= $menuNodesHash ?>">
					<? if(is_array($topNavMenuItems)): ?>
						<? foreach($topNavMenuItems as $topNavIndex): ?>
								<? $topNavItem = $menuNodes[$topNavIndex] ?>
								<li class="topNav <?= str_replace(' ', '_', $topNavItem['text']) ?> <?php if( isset($topNavItem['class']) ) { echo str_replace(' ', '_', $topNavItem['class']); } ?>" data-index="<?= $topNavIndex?>">
									<a href="<?= $topNavItem['href'] ?>"><?= $topNavItem['text'] ?><img src="<?= $wg->BlankImgUrl; ?>" class="chevron" height="0" width="0"></a>
									<ul class="subnav"></ul>
								</li>
						<? endforeach ?>
					<? endif ?>
				</ul>
			</li>
		</ul>
	</nav>
	<?= wfRenderModule('AccountNavigation') ?>
	<? echo wfRenderModule('WallNotifications'); ?>
	<img src="<?= $wg->BlankImgUrl ?>" class="banner-corner-left" width="0" height="0">
	<img src="<?= $wg->BlankImgUrl ?>" class="banner-corner-right" width="0" height="0">
</header>
