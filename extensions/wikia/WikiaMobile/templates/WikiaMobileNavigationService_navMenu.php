<?
/**
 * @var $wg WikiaGlobalRegistry
 * @var $wf WikiaFunctionWrapper
 * @var $parseErrors array
 * @var $wikiaMenuNodes array
 * @var $wikiMenuNodes array
 * @var $blacklist
 */
?>
<nav class=cur1 id=wkNavMenu<? if ( !empty( $parseErrors ) ) :?> data-error="<?= implode( '; ', $parseErrors ) ;?>"<? endif ;?>>
	<header>
		<button id=wkNavBack class=wkBtn><?= $wf->MsgExt( 'wikiamobile-back', array( 'parseinline' ) );?></button>
		<h1 class='collSec addChev'><?= $wf->MsgForContent( 'wikiamobile-menu' ); ?></h1>
		<a id=wkNavLink class=chvRgt></a>
	</header>
<ul id=lvl1 class=wkLst>
<?
	foreach ( array( $wikiaMenuNodes, $wikiMenuNodes ) as $menuNodes ) {
		if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
			$levelOutput0 = '';
			$processed0 = 0;
			$blocked0 = 0;

			foreach ($menuNodes[0][NavigationService::CHILDREN] as $level0) {
				$menuNode0 = $menuNodes[$level0];
				$isAllowed = !in_array( $menuNode0[ NavigationService::HREF ], $blacklist );
				$isLink = $menuNode0[NavigationService::HREF] != '#';

				if ( !empty( $menuNode0[NavigationService::TEXT] ) && $isAllowed ) {
					$levelOutput0 .= '<li>';
					$levelOutput1 = '';

					if ( $isLink ) {
						$levelOutput0 .= "<a href=\"{$menuNode0[NavigationService::HREF]}\">{$menuNode0[NavigationService::TEXT]}</a>";
					} else {
						$levelOutput0 .= "<span>{$menuNode0[NavigationService::TEXT]}</span>";
					}

					if ( isset( $menuNodes[$level0][NavigationService::CHILDREN] ) ) {
						$processed1 = 0;
						$blocked1 = 0;
						$levelOutput1 .= '<ul class=lvl2>';

						foreach ($menuNodes[$level0][ NavigationService::CHILDREN ] as $level1) {
							$menuNode1 = $menuNodes[$level1];
							$isAllowed = !in_array( $menuNode1[ NavigationService::HREF ], $blacklist );
							$isLink = $menuNode1[NavigationService::HREF] != '#';

							if ( !empty( $menuNode1[NavigationService::TEXT] ) && $isAllowed ) {
								$levelOutput1 .= '<li>';
								$levelOutput2 = '';

								if ( $isLink ) {
									$levelOutput1 .= "<a href=\"{$menuNode1[NavigationService::HREF]}\">{$menuNode1[NavigationService::TEXT]}</a>";
								} else {
									$levelOutput1 .= "<span>{$menuNode1[NavigationService::TEXT]}</span>";
								}

								if ( isset( $menuNode1[ NavigationService::CHILDREN ] ) ) {
									$processed2 = 0;
									$blocked2 = 0;
									$levelOutput2 .= '<ul class=lvl3>';

									foreach ( $menuNode1[NavigationService::CHILDREN] as $level2 ) {
										$menuNode2 = $menuNodes[$level2];
										$isAllowed = !in_array( $menuNode2[ NavigationService::HREF ], $blacklist );
										$isLink = $menuNode2[NavigationService::HREF] != '#';

										if ( !empty( $menuNode2[NavigationService::TEXT] ) && $isAllowed ) {
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

										$processed2++;
									}

									if ( $blocked2 == $processed2 ) {
										$levelOutput2 = '';
									} else {
										$levelOutput2 .= '</ul>';
									}
								}

								$levelOutput1 .= "{$levelOutput2}</li>";
							} else {
								$blocked1++;
							}

							$processed1++;
						}

						if ( $blocked1 == $processed1 ) {
							$levelOutput1 = '';
						} else {
							$levelOutput1 .= '</ul>';
						}
					}

					$levelOutput0 .= "{$levelOutput1}</li>";
				} else {
					$blocked0++;
				}

				$processed0++;
			}

			if ( $blocked0 == $processed0 ) {
				$levelOutput0 = '';
			}
?>
		<?= $levelOutput0 ;?>
<?
		}
	}
?>
</ul>
</nav>