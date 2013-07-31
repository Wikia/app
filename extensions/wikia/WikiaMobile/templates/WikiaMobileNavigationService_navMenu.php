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
		<button id=wkNavBack class=wkBtn><?= wfMsgExt( 'wikiamobile-back', array( 'parseinline' ) );?></button>
		<h1 class='collSec addChev'><?= wfMsgForContent( 'wikiamobile-menu' ); ?></h1>
		<a id=wkNavLink class=chvRgt></a>
	</header>
<ul id=lvl1 class=wkLst>
<?
	foreach ( $wikiNav as $menuNodes ) {
		if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
			$levelOutput0 = '';
			$processed0 = 0;
			$blocked0 = 0;

			foreach ($menuNodes[0][NavigationModel::CHILDREN] as $level0) {
				$menuNode0 = $menuNodes[$level0];
				$isAllowed = !in_array( $menuNode0[ NavigationModel::HREF ], $blacklist );
				$isLink = $menuNode0[NavigationModel::HREF] != '#';

				if ( !empty( $menuNode0[NavigationModel::TEXT] ) && $isAllowed ) {
					$levelOutput0 .= '<li>';
					$levelOutput1 = '';

					if ( $isLink ) {
						$levelOutput0 .= "<a href=\"{$menuNode0[NavigationModel::HREF]}\">{$menuNode0[NavigationModel::TEXT]}</a>";
					} else {
						$levelOutput0 .= "<span>{$menuNode0[NavigationModel::TEXT]}</span>";
					}

					if ( isset( $menuNodes[$level0][NavigationModel::CHILDREN] ) ) {
						$processed1 = 0;
						$blocked1 = 0;
						$levelOutput1 .= '<ul class=lvl2>';

						foreach ($menuNodes[$level0][ NavigationModel::CHILDREN ] as $level1) {
							$menuNode1 = $menuNodes[$level1];
							$isAllowed = !in_array( $menuNode1[ NavigationModel::HREF ], $blacklist );
							$isLink = $menuNode1[NavigationModel::HREF] != '#';

							if ( !empty( $menuNode1[NavigationModel::TEXT] ) && $isAllowed ) {
								$levelOutput1 .= '<li>';
								$levelOutput2 = '';

								if ( $isLink ) {
									$levelOutput1 .= "<a href=\"{$menuNode1[NavigationModel::HREF]}\">{$menuNode1[NavigationModel::TEXT]}</a>";
								} else {
									$levelOutput1 .= "<span>{$menuNode1[NavigationModel::TEXT]}</span>";
								}

								if ( isset( $menuNode1[ NavigationModel::CHILDREN ] ) ) {
									$processed2 = 0;
									$blocked2 = 0;
									$levelOutput2 .= '<ul class=lvl3>';

									foreach ( $menuNode1[NavigationModel::CHILDREN] as $level2 ) {
										$menuNode2 = $menuNodes[$level2];
										$isAllowed = !in_array( $menuNode2[ NavigationModel::HREF ], $blacklist );
										$isLink = $menuNode2[NavigationModel::HREF] != '#';

										if ( !empty( $menuNode2[NavigationModel::TEXT] ) && $isAllowed ) {
											$levelOutput2 .= '<li>';

											if ( $isLink ) {
												$levelOutput2 .= "<a href=\"{$menuNode2[NavigationModel::HREF]}\">{$menuNode2[NavigationModel::TEXT]}</a>";
											} else {
												$levelOutput2 .= "<span>{$menuNode2[NavigationModel::TEXT]}</span>";
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