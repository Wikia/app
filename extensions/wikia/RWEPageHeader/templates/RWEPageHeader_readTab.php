<? $firstLvlItemSelected = $secondLvlItemSelected = false; ?>
<div class="rwe-page-header-nav__dropdown wds-dropdown__content rwe-page-header-nav__read">
	<ul class="rwe-page-header-nav__dropdown-first-level rwe-page-header-nav__dropdown-list">
		<? if ( is_array( $menuNodes ) && isset( $menuNodes[ 0 ] ) ): ?>
			<? foreach ( $menuNodes[ 0 ][ NavigationModel::CHILDREN ] as $level0 ): ?>
				<? $menuNode0 = $menuNodes[ $level0 ] ?>
				<? if ( $menuNode0[ NavigationModel::TEXT ] ): ?>
					<?
					$itemSelected = '';
					if ( isset( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] ) && !$firstLvlItemSelected ) {
						$itemSelected = 'item-selected';
						$firstLvlItemSelected = true;
					}
					?>

					<li class="rwe-page-header-nav__dropdown-item rwe-page-header-nav__dropdown-first-level-item <?= $itemSelected ?>">
						<div class="rwe-page-header-nav__dropdown-link-wrapper">
							<a class="rwe-page-header-nav__link" data-tracking="first-level"<? if ( !empty( $menuNode0[ NavigationModel::SPECIAL ] ) ):
									?> data-extra="<?= $menuNode0[ NavigationModel::SPECIAL ] ?>"<? endif
								?> href="<?= $menuNode0[ NavigationModel::HREF ]
								?>"><?= $menuNode0[ NavigationModel::TEXT ] ?>
							</a>
							<? if ( isset( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] ) ):
								?><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny' ); ?><? endif ?>
						</div>

						<? if ( isset( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] ) ): ?>
							<ul class="rwe-page-header-nav__dropdown-second-level">
								<? foreach ( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] as $level1 ): ?>
									<?
									$menuNode1 = $menuNodes[ $level1 ];
									$hasChildNodes = isset( $menuNode1[ NavigationModel::CHILDREN ] );
									$itemSelected = '';
									if ( $hasChildNodes && !$secondLvlItemSelected ) {
										$itemSelected = 'item-selected';
										$secondLvlItemSelected = true;
									}
									?>
									<li class="rwe-page-header-nav__dropdown-item rwe-page-header-nav__dropdown-second-level-item <?= $itemSelected ?>">
										<div class="rwe-page-header-nav__dropdown-link-wrapper">
											<a class="rwe-page-header-nav__link" data-tracking="second-level"<? if ( !empty( $menuNode1[ NavigationModel::SPECIAL ] ) ):
													?> data-extra="<?= $menuNode1[ NavigationModel::SPECIAL ] ?>"<? endif
												?> href="<?= $menuNode1[ NavigationModel::HREF ] ?>"<? if ( !empty( $menuNode1[ NavigationModel::CANONICAL_NAME ] ) ):
													?> data-canonical="<?= strtolower( $menuNode1[ NavigationModel::CANONICAL_NAME ] ) ?>"<? endif
												?>><?= $menuNode1[ NavigationModel::TEXT ] ?>
											</a>
											<? if ( $hasChildNodes ):
												?><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny' ); ?><? endif ?>
										</div>

										<? if ( $hasChildNodes ): ?>
											<ul class="rwe-page-header-nav__dropdown-third-level">
												<? foreach ( $menuNode1[ NavigationModel::CHILDREN ] as $level2 ): ?>
													<? $menuNode2 = $menuNodes[ $level2 ] ?>
													<li class="rwe-page-header-nav__dropdown-item rwe-page-header-nav__dropdown-third-level-item">
														<div class="rwe-page-header-nav__dropdown-link-wrapper">
															<a class="rwe-page-header-nav__link" data-tracking="third-level"<? if ( !empty( $menuNode2[ NavigationModel::SPECIAL ] ) ):
																?> data-extra="<?= $menuNode2[ NavigationModel::SPECIAL ] ?>"<? endif
															?> href="<?= $menuNode2[ NavigationModel::HREF ]
															?>"><?= $menuNode2[ NavigationModel::TEXT ] ?></a>
														</div>
													</li>
												<? endforeach ?>
											</ul>
										<? endif ?>

									</li>
								<? endforeach ?>
							</ul>
						<? endif ?>
					</li>
				<? endif ?>
			<? endforeach ?>
		<? endif ?>
	</ul>
</div>
