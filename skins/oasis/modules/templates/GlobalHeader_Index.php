<header id="WikiaHeader" class="WikiaHeader">
	<nav>
		<? if (!$wgSingleH1) { ?>
		<h1>Wikia Navigation</h1>
		<? } ?>
		<ul>
			<li class="WikiaLogo">
				<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wgBlankImgUrl ?>" class="sprite logo" height="23" width="91" alt="Wikia"></a>
			</li>
			<li>
				<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="wikia-button"><?= wfMsg('oasis-global-nav-create-wiki') ?></a>
			</li>
			<li>
				<ul id="GlobalNavigation" class="GlobalNavigation">
<?php
if(is_array($menuNodes) && isset($menuNodes[0])) {
	$i = 0;
	foreach($menuNodes[0]['children'] as $level0) {
?>
					<li>
						<a href="<?= $menuNodes[$level0]['href'] ?>"><?= $menuNodes[$level0]['text'] ?> <img src="<?= $wgBlankImgUrl; ?>" class="chevron" height="0" width="0"></a>
						<ul class="subnav">
							<li id="Wrapper_SPOTLIGHT_GLOBALNAV_<?= ++$i?>">
								<?= AdEngine::getInstance()->getAd('SPOTLIGHT_GLOBALNAV_'.$i) ?>
							</li>
<?php
		foreach($menuNodes[$level0]['children'] as $level1) {
?>
							<li>
								<a href="<?= $menuNodes[$level1]['href'] ?>"><?= $menuNodes[$level1]['text'] ?></a>
								<ul class="catnav">
<?php
			foreach($menuNodes[$level1]['children'] as $level2) {
?>
									<li><a href="<?= $menuNodes[$level2]['href'] ?>"><?= $menuNodes[$level2]['text'] ?></a></li>
<?php
			}
?>
								</ul>
							</li>
<?php
		}
?>
						</ul>
					</li>
<?php
	}
}
?>
				</ul>
			</li>
		</ul>
	</nav>
	<?= wfRenderModule('AccountNavigation') ?>
	<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-left" width="0" height="0">
	<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-right" width="0" height="0">
</header>
