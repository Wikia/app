		<ul<?= !empty($parseErrors) ? ' data-parse-errors="true"' : '' ?>>
<?php
$counter = 0;
$firstChild = true;
foreach ( array( $wikiaMenuNodes, $wikiMenuNodes ) as $menuNodes )
if ( is_array($menuNodes) && isset($menuNodes[0]) && $showMenu) {
	foreach ($menuNodes[0][ NavigationService::CHILDREN ] as $level0) {
		$menuNode0 = $menuNodes[$level0];

		if ($menuNode0[ NavigationService::TEXT ]) {
?>
			<li<?php echo ($counter == 0 ) ? ' class="marked"' : '';
				$counter++;
			?>>
				<a<?= empty( $menuNode0[ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$menuNode0[ NavigationService::SPECIAL ].'"' ?> href="<?= $menuNode0[ NavigationService::HREF ] ?>"><?= $menuNode0[ NavigationService::TEXT ] ?></a>
<?php
			if (isset($menuNodes[$level0][ NavigationService::CHILDREN ])) {
?>
				<ul class="subnav-2 accent"<? if ( $firstChild ){ echo ' style="display:block"'; $firstChild = false; } ?>>
<?php
				foreach ($menuNodes[$level0][ NavigationService::CHILDREN ] as $level1) {
					$menuNode1 = $menuNodes[$level1];
					$hasChildNodes = isset($menuNode1[ NavigationService::CHILDREN ]);
?>
					<li>
						<a class="subnav-2a"<?= empty( $menuNode1[ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$menuNode1[ NavigationService::SPECIAL ].'"' ?> href="<?= $menuNode1[ NavigationService::HREF ] ?>"<?= empty( $menuNode1[ NavigationService::CANONICAL_NAME ] ) ? '' : ' data-canonical="'.strtolower($menuNode1[ NavigationService::CANONICAL_NAME ]).'"' ?>><?= $menuNode1[ NavigationService::TEXT ] ?><?php if($hasChildNodes):?><img src="<?= wfBlankImgUrl() ?>" class="chevron"><?php endif; ?></a>
<?php
					if ($hasChildNodes) {
?>
						<ul class="subnav subnav-3">
<?php
						foreach ($menuNode1[ NavigationService::CHILDREN ] as $level2) {
							$menuNode2 = $menuNodes[$level2];
?>
							<li>
								<a class="subnav-3a"<?= empty( $menuNode2[ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$menuNode2[ NavigationService::SPECIAL ].'"' ?> href="<?= $menuNode2[ NavigationService::HREF ] ?>"><?= $menuNode2[ NavigationService::TEXT ] ?></a>
							</li>
<?php
						}
?>
						</ul>
<?php
					}
?>
					</li>
<?php
				}
?>
<?php
				if (
					!empty( $wikiaMenuLocalNodes ) &&
					isset( $wikiaMenuLocalNodes[0] ) &&
					isset( $wikiaMenuLocalNodes[0][ NavigationService::CHILDREN ] )
				)
					foreach ( $wikiaMenuLocalNodes[0][ NavigationService::CHILDREN ] as $level1 ){
?>
					<li>
						<a class="subnav-2a"<?= empty( $wikiaMenuLocalNodes[$level1][ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$wikiaMenuLocalNodes[$level1][ NavigationService::SPECIAL ].'"' ?> href="<?= $wikiaMenuLocalNodes[$level1][ NavigationService::HREF ] ?>">
							<?= $wikiaMenuLocalNodes[$level1][ NavigationService::TEXT ] ?>
						</a>
<?php
					if (isset($wikiaMenuLocalNodes[$level1][ NavigationService::CHILDREN ])) {
?>
						<ul class="subnav subnav-3">
<?php
						foreach ($wikiaMenuLocalNodes[$level1][ NavigationService::CHILDREN ] as $level2) {
?>
							<li>
								<a class="subnav-3a"<?= empty( $wikiaMenuLocalNodes[$level2][ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$wikiaMenuLocalNodes[$level2][ NavigationService::SPECIAL ].'"' ?> href="<?= $wikiaMenuLocalNodes[$level2][ NavigationService::HREF ] ?>"><?= $wikiaMenuLocalNodes[$level2][ NavigationService::TEXT ] ?></a>
							</li>
<?php
						}
?>
						</ul>
<?php
					}
?>
					</li>
<?php
				}
?>
				</ul>
<?php
			}
?>
			</li>
<?php
		}
	}
}
?>
		</ul>

		<div class="navbackground"><div></div><img src="<?= $wg->BlankImgUrl; ?>" class="chevron" width="0" height="0"></div>
