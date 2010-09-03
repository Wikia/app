<header id="WikiaHeader" class="WikiaHeader">
	<h1>Wikia</h1>
	<nav>
		<ul>
			<li class="WikiaLogo">
				<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wgBlankImgUrl ?>" height="26" width="91" alt="Wikia"></a>
			</li>
			<li>
				<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="wikia-button"><?= wfMsg('oasis-global-nav-create-wiki') ?></a>
			</li>
			<li>
				<ul id="GlobalNavigation" class="GlobalNavigation">
<?php
if(is_array($menuNodes) && isset($menuNodes[0])) {
	foreach($menuNodes[0]['children'] as $level0) {
?>
					<li>
						<a href="<?= $menuNodes[$level0]['href'] ?>"><?= $menuNodes[$level0]['text'] ?> <img src="<?= $wgBlankImgUrl; ?>" class="chevron"></a>
						<ul class="subnav">
							<li>
								<img src="<?= $wgStylePath ?>/oasis/images/temp_globalnav_spotlight.jpg" width="270" height="143">
							</li>
<?php
		foreach($menuNodes[$level0]['children'] as $level1) {
?>
							<li>
								<a href="<?= $menuNodes[$level1]['href'] ?>"><?= $menuNodes[$level1]['text'] ?></a>
								<ul>
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
	<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-left">
	<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-right">
</header>
