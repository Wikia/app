<header id="WikiaHeader" class="WikiaHeader">
	<nav>
		<h1>Wikia Navigation</h1>
		<ul>
			<li class="WikiaLogo">
				<a href="<?= htmlspecialchars($centralUrl) ?>" rel="nofollow"><img src="<?= $wgBlankImgUrl ?>" class="sprite logo" height="23" width="91" alt="Wikia"></a>
			</li>
			<li class="start-a-wiki">
				<a href="<?= htmlspecialchars($createWikiUrl) ?>" class="wikia-button"><?= wfMsgHtml('oasis-global-nav-create-wiki'); ?></a>
			</li>
			<li>
				<ul id="GlobalNavigation" class="GlobalNavigation<?php if($isCorporatePage): ?> WikiaComNav<?php endif; ?>">
<?php
if(is_array($menuNodes) && isset($menuNodes[0])) {
	$i = 0;
	
	foreach($menuNodes[0]['children'] as $level0) {
?>
					<li <?php if($isCorporatePage): ?>class="<?= str_replace(' ', '_', $menuNodes[$level0]['text']); ?>"<?php endif; ?>>
						<a href="<?= $menuNodes[$level0]['href'] ?>"><?= $menuNodes[$level0]['text'] ?> <img src="<?= $wgBlankImgUrl; ?>" class="chevron" height="0" width="0"></a>
						<ul class="subnav">
							<? /*
							<li id="SPOTLIGHT_GLOBALNAV_<?= ++$i?>"<?= $wgEnableSpotlightsV2_GlobalNav ? ' class="SPOTLIGHT_GLOBALNAV"' : '' ?>>
								<?= AdEngine::getInstance()->getAd('SPOTLIGHT_GLOBALNAV_'.$i) ?>
							</li>
							*/ ?>
<?php
		foreach($menuNodes[$level0]['children'] as $level1) {
?>
							<li>
								<a href="<?= $menuNodes[$level1]['href'] ?>"><?= $menuNodes[$level1]['text'] ?></a>
								<ul class="catnav">
<?php
			if( is_array( $menuNodes[$level1]['children'] ) ):
				foreach( $menuNodes[$level1]['children'] as $level2):
?>
									<li><a href="<?php echo $menuNodes[$level2]['href'] ?>"><?php echo $menuNodes[$level2]['text'] ?></a></li>
<?php
				endforeach;
			endif;

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
	<? if( $wgEnableWallExt ) echo wfRenderModule('WallNotifications'); ?>
	<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-left" width="0" height="0">
	<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-right" width="0" height="0">
</header>
