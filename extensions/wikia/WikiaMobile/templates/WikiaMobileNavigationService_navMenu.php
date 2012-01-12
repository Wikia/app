<nav id=wkNavMenu<? if ( !empty( $parseErrors ) ) :?>data-error="<?= implode( '; ', $parseErrors ) ;?>"<? endif ;?>>
	<h1 class=collSec><?= $wf->MsgForContent( 'wikiamobile-menu' ); ?><span class="chev"></span></h1>
	<ul class=lvl1>
<?
	foreach ( array( $wikiaMenuNodes, $wikiMenuNodes ) as $menuNodes ) {
		if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
			$levelOutput0 = '';

			foreach ($menuNodes[0][NavigationService::CHILDREN] as $level0) {
				$menuNode0 = $menuNodes[$level0];
				$isSpecialPage = !empty( $menuNode0[NavigationService::CANONICAL_NAME] );
				$isAllowed = !$isSpecialPage || ( $isSpecialPage && !in_array( $menuNode0[ NavigationService::CANONICAL_NAME ], $wg->WikiaMobileNavigationBlacklist ) );
				$isLink = $menuNode0[NavigationService::HREF] != '#';
				$passed0 = 0;
				$blocked0 = 0;

				if ( !empty( $menuNode0[NavigationService::TEXT] ) && $isAllowed ) {
					$passed0++;
					$levelOutput0 .= '<li>';
					$levelOutput1 = '';

					if ( $isLink ) {
						$levelOutput0 .= "<a href=\"{$menuNode0[NavigationService::HREF]}\">{$menuNode0[NavigationService::TEXT]}</a>";
					} else {
						$levelOutput0 .= "<span>{$menuNode0[NavigationService::TEXT]}</span>";
					}

					if ( isset( $menuNodes[$level0][NavigationService::CHILDREN] ) ) {
						$passed1 = 0;
						$blocked1 = 0;
						$levelOutput1 .= '<ul class=lvl2>';

						foreach ($menuNodes[$level0][ NavigationService::CHILDREN ] as $level1) {
							$menuNode1 = $menuNodes[$level1];
							$isSpecialPage = !empty( $menuNode1[NavigationService::CANONICAL_NAME] );
							$isAllowed = !$isSpecialPage || ( $isSpecialPage && !in_array( $menuNode1[ NavigationService::CANONICAL_NAME ], $wg->WikiaMobileNavigationBlacklist ) );
							$isLink = $menuNode1[NavigationService::HREF] != '#';

							if ( !empty( $menuNode1[NavigationService::TEXT] ) && $isAllowed ) {
								$passed1++;
								$levelOutput1 .= '<li>';
								$levelOutput2 = '';

								if ( $isLink ) {
									$levelOutput1 .= "<a href=\"{$menuNode1[NavigationService::HREF]}\">{$menuNode1[NavigationService::TEXT]}</a>";
								} else {
									$levelOutput1 .= "<span>{$menuNode1[NavigationService::TEXT]}</span>";
								}

								if ( isset( $menuNode1[ NavigationService::CHILDREN ] ) ) {
									$passed2 = 0;
									$blocked2 = 0;
									$levelOutput2 .= '<ul class=lvl3>';

									foreach ( $menuNode1[NavigationService::CHILDREN] as $level2 ) {
										$menuNode2 = $menuNodes[$level2];
										$isSpecialPage = !empty( $menuNode2[NavigationService::CANONICAL_NAME] );
										$isAllowed = !$isSpecialPage || ( $isSpecialPage && !in_array( $menuNode2[ NavigationService::CANONICAL_NAME ], $wg->WikiaMobileNavigationBlacklist ) );
										$isLink = $menuNode2[NavigationService::HREF] != '#';

										if ( !empty( $menuNode2[NavigationService::TEXT] ) && $isAllowed ) {
											$passed2++;
											$levelOutput2 .= '<li>';

											if ( $isLink ) {
												$levelOutput2 .= "<a href=\"{$menuNode2[NavigationService::HREF]}\">{$menuNode2[NavigationService::TEXT]}</a>";
											} else {
												$levelOutput2 .= "<span>{$menuNode2[NavigationService::TEXT]}</span>";
											}

											$levelOutput2 .= '</li>';
										} else {
											$blocked2++;
										}
									}

									if ( $blocked2 >= $passed2 ) {
										$levelOutput2 = '';
									} else {
										$levelOutput2 .= '</ul>';
									}
								}

								$levelOutput1 .= "{$levelOutput2}</li>";
							} else {
								$blocked1++;
							}
						}

						if ( $blocked1 >= $passed1 ) {
							$levelOutput1 = '';
						} else {
							$levelOutput1 .= '</ul>';
						}
					}

					$levelOutput0 .= "{$levelOutput1}</li>";
				} else {
					$blocked0++;
				}
			}

			if ( $blocked0 >= $passed0 ) {
				$levelOutput0 = '';
			} else {
				$levelOutput0 .= '</li>';
			}
?>
		<?= $levelOutput0 ;?>
<?
		}
	}
?>
	</ul>
</nav>