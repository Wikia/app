		<ul>

<?php
$counter = 0;
$firstChild = true;
foreach ( array( $wikiaMenuNodes, $wikiMenuNodes ) as $menuNodes )
if ( is_array($menuNodes) && isset($menuNodes[0]) && $showMenu) {
	foreach ($menuNodes[0][ NavigationService::CHILDREN ] as $level0) {
?>
			<li<?php echo ($counter == 0 ) ? ' class="marked"' : '';
				$counter++;
			?>>
				<a<?= empty( $menuNodes[$level0][ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$menuNodes[$level0][ NavigationService::SPECIAL ].'"' ?> href="<?= $menuNodes[$level0][ NavigationService::HREF ] ?>"><?= $menuNodes[$level0][ NavigationService::TEXT ] ?></a>
<?php
		if (isset($menuNodes[$level0][ NavigationService::CHILDREN ])) {
?>
				<ul class="subnav-2 accent"<? if ( $firstChild ){ echo ' style="display:block"'; $firstChild = false; } ?>>
<?php
			foreach ($menuNodes[$level0][ NavigationService::CHILDREN ] as $level1) {
?>
					<li>
						<a class="subnav-2a"<?= empty( $menuNodes[$level1][ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$menuNodes[$level1][ NavigationService::SPECIAL ].'"' ?> href="<?= $menuNodes[$level1][ NavigationService::HREF ] ?>"><?= $menuNodes[$level1][ NavigationService::TEXT ] ?></a>
<?php
				if (isset($menuNodes[$level1][ NavigationService::CHILDREN ])) {
?>
						<ul class="subnav subnav-3">
<?php
					foreach ($menuNodes[$level1][ NavigationService::CHILDREN ] as $level2) {
?>
							<li>
								<a class="subnav-3a"<?= empty( $menuNodes[$level2][ NavigationService::SPECIAL ] ) ? '' : ' data-extra="'.$menuNodes[$level2][ NavigationService::SPECIAL ].'"' ?> href="<?= $menuNodes[$level2][ NavigationService::HREF ] ?>"><?= $menuNodes[$level2][ NavigationService::TEXT ] ?></a>
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
?>
		</ul>

		<div class="navbackground"><div></div><img src="<?= $wgBlankImgUrl; ?>" class="chevron" width="0" height="0"></div>
