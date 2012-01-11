<nav id=wkNavMenu<? if ( !empty( $parseErrors ) ) :?>data-error="<?= implode( '; ', $parseErrors ) ;?>"<? endif ;?>>
	<h1 class=collSec><?= $wf->MsgForContent( 'wikiamobile-menu' ); ?><span class="chev"></span></h1>
	<ul class=lvl1>
<?
	$firstChild = true;

	foreach ( array( $wikiaMenuNodes, $wikiMenuNodes ) as $menuNodes ) {
		if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
			foreach ($menuNodes[0][NavigationService::CHILDREN] as $level0) {
				$menuNode0 = $menuNodes[$level0];
				$isSpecialPage = !empty( $menuNode0[NavigationService::CANONICAL_NAME] );
				$isAllowed = !$isSpecialPage || ( $isSpecialPage && !in_array( $menuNode0[ NavigationService::CANONICAL_NAME ], $wg->WikiaMobileNavigationBlacklist ) );
				$isLink = $menuNode0[NavigationService::HREF] != '#';
		
				if ( !empty( $menuNode0[NavigationService::TEXT] ) && $isAllowed ) :?>
			<li>
				<? if ( $isLink ) :?><a href="<?= $menuNode0[NavigationService::HREF] ;?>"><? endif ;?><?= $menuNode0[NavigationService::TEXT] ;?><? if ( $isLink ) :?></a><? endif ;?>
				<? if ( isset( $menuNodes[$level0][NavigationService::CHILDREN] ) ) :?>
					<ul class=lvl2>
<?
						foreach ($menuNodes[$level0][ NavigationService::CHILDREN ] as $level1) {
							$menuNode1 = $menuNodes[$level1];
							$isSpecialPage = !empty( $menuNode1[NavigationService::CANONICAL_NAME] );
							$isAllowed = !$isSpecialPage || ( $isSpecialPage && !in_array( $menuNode1[ NavigationService::CANONICAL_NAME ], $wg->WikiaMobileNavigationBlacklist ) );
							$isLink = $menuNode1[NavigationService::HREF] != '#';
							
							if ( !empty( $menuNode1[NavigationService::TEXT] ) && $isAllowed ) :?>
							<li>
								<? if ( $isLink ) :?><a href="<?= $menuNode1[NavigationService::HREF] ?>"><? endif ;?><?= $menuNode1[NavigationService::TEXT] ?><? if ( $isLink ) :?></a><? endif ;?>
								<? if ( isset( $menuNode1[ NavigationService::CHILDREN ] ) ) :?>
									<ul class=lvl3>
<?
									foreach ( $menuNode1[NavigationService::CHILDREN] as $level2 ) {
										$menuNode2 = $menuNodes[$level2];
										$isSpecialPage = !empty( $menuNode2[NavigationService::CANONICAL_NAME] );
										$isAllowed = !$isSpecialPage || ( $isSpecialPage && !in_array( $menuNode2[ NavigationService::CANONICAL_NAME ], $wg->WikiaMobileNavigationBlacklist ) );
										$isLink = $menuNode2[NavigationService::HREF] != '#';
										
										if ( !empty( $menuNode2[NavigationService::TEXT] ) && $isAllowed ) :?>
?>
										<li>
											<? if ( $isLink ) :?><a href="<?= $menuNode2[NavigationService::HREF] ;?>"><? endif ;?><?= $menuNode2[NavigationService::TEXT] ;?><? if ( $isLink ) :?></a><? endif ;?>
										</li>
										<? endif; ?>
<?
									}
?>
									</ul>
								<? endif ;?>
							</li>
							<? endif ;?>
<?
						}
?>
					</ul>
				<? endif ;?>
			<? endif ;?>
			</li>
<?
			}
		}
	}
?>
	</ul>
</nav>