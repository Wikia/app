<header id="WikiaHeader" class="WikiaHeader">
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
				<ul id="GlobalNavigation" class="GlobalNavigation<? if($wg->GlobalHeaderVerticalColors): ?> vertical-colors<? endif; ?>">
<?
				if(is_array($menuNodes) && isset($menuNodes[0])):
					$i = 0;
	
					foreach($menuNodes[0]['children'] as $level0):
?>
					<li class="<?= str_replace(' ', '_', $menuNodes[$level0]['text']); ?> <? if( !empty($menuNodes[$level0]) && !empty($menuNodes[$level0]['class']) ) { echo $menuNodes[$level0]['class']; }  ?>">
						<a href="<?= $menuNodes[$level0]['href'] ?>"><?= $menuNodes[$level0]['text'] ?> <img src="<?= $wg->BlankImgUrl; ?>" class="chevron" height="0" width="0"></a>
						<ul class="subnav">
<? 
							foreach($menuNodes[$level0]['children'] as $level1): 
?>
							<li>
								<a href="<?= $menuNodes[$level1]['href'] ?>"><?= $menuNodes[$level1]['text'] ?></a>
								<ul class="catnav">
<?
								if( is_array( $menuNodes[$level1]['children'] ) ):
									foreach( $menuNodes[$level1]['children'] as $level2):
?>
									<li><a href="<?php echo $menuNodes[$level2]['href'] ?>"><?php echo $menuNodes[$level2]['text'] ?></a></li>
<?
									endforeach;
								endif;
?>
								</ul>
							</li>
<?
							endforeach;
?>
						</ul>
					</li>
<?
					endforeach;
				endif;
?>
				</ul>
			</li>
		</ul>
	</nav>
	<?= wfRenderModule('AccountNavigation') ?>
	<? if( $wg->EnableWallExt ) echo wfRenderModule('WallNotifications'); ?>
	<img src="<?= $wg->BlankImgUrl ?>" class="banner-corner-left" width="0" height="0">
	<img src="<?= $wg->BlankImgUrl ?>" class="banner-corner-right" width="0" height="0">
</header>
