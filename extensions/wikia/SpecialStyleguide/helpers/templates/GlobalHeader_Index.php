<?php
// TODO: remove this and aggregate into modularized GlobalHeader
?>
<header id="WikiaHeader" class="WikiaHeader">
	<div class="wikia-header-mask">
		<div class="pagetitle">
			<?= wfMessage( 'styleguide-pagetitle' )->plain() ?>
		</div>
		<div class="page-width-container">
			<nav>
				<ul>
					<li class="WikiaLogo">
						<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wg->BlankImgUrl ?>" class="sprite logo" height="23" width="91" alt="Wikia"></a>
					</li>
					<li>
						<ul id="GlobalNavigation" class="GlobalNavigation<?= $wg->GlobalHeaderVerticalColors ? ' vertical-colors' : '' ?>" data-hash="<?= $menuNodesHash ?>">
							<? if ( is_array($topNavMenuItems) ) : ?>
								<? foreach ( $topNavMenuItems as $topNavIndex ) : ?>
									<? $topNavItem = $menuNodes[$topNavIndex] ?>
									<li class="topNav <?= str_replace(' ', '_', $topNavItem['text']) ?> <?php if (
									isset($topNavItem['specialAttr']) ) { echo str_replace(' ', '_', $topNavItem['specialAttr']); } ?>" data-index="<?= $topNavIndex?>">
										<a href="<?= $topNavItem['href'] ?>"><?= $topNavItem['text'] ?>
											<? if ( !empty($topNavItem['children']) ) : ?>
												<img src="<?= $wg->BlankImgUrl; ?>" class="chevron" height="0" width="0">
											<? endif; ?>
										</a>
										<? if ( !empty($topNavItem['children']) ) : ?>
											<ul class="subnav"></ul>
										<? endif; ?>
									</li>
								<? endforeach ?>
							<? endif ?>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>
