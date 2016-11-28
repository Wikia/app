<div class="rwe-page-header-nav__dropdown wds-dropdown__content">
	<ul class="rwe-page-header-nav__dropdown-first-level">

		<? if ( is_array( $menuNodes ) && isset( $menuNodes[ 0 ] ) ): ?>
			<? foreach ( $menuNodes[ 0 ][ NavigationModel::CHILDREN ] as $level0 ): ?>
				<? $menuNode0 = $menuNodes[ $level0 ] ?>
				<? if ( $menuNode0[ NavigationModel::TEXT ] ): ?>
					<li class="rwe-page-header-nav__dropdown-first-level-item">
						<a class="rwe-page-header-nav__link" data-tracking="first-level"<? if ( !empty( $menuNode0[ NavigationModel::SPECIAL ] ) ):
							?> data-extra="<?= $menuNode0[ NavigationModel::SPECIAL ] ?>"<? endif
						?> href="<?= $menuNode0[ NavigationModel::HREF ]
						?>"><?= $menuNode0[ NavigationModel::TEXT ] ?><? if ( isset( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] ) ):
								?><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny' ); ?><? endif ?></a>

						<? if ( isset( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] ) ): ?>
							<ul class="rwe-page-header-nav__dropdown-second-level">
								<? foreach ( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] as $level1 ): ?>
									<?
									$menuNode1 = $menuNodes[ $level1 ];
									$hasChildNodes = isset( $menuNode1[ NavigationModel::CHILDREN ] );
									?>
									<li class="rwe-page-header-nav__dropdown-second-level-item">
										<a class="rwe-page-header-nav__link" data-tracking="second-level"<? if ( !empty( $menuNode1[ NavigationModel::SPECIAL ] ) ):
											?> data-extra="<?= $menuNode1[ NavigationModel::SPECIAL ] ?>"<? endif
										?> href="<?= $menuNode1[ NavigationModel::HREF ] ?>"<? if ( !empty( $menuNode1[ NavigationModel::CANONICAL_NAME ] ) ):
											?> data-canonical="<?= strtolower( $menuNode1[ NavigationModel::CANONICAL_NAME ] ) ?>"<? endif
										?>><?= $menuNode1[ NavigationModel::TEXT ] ?><? if ( $hasChildNodes ):
												?><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny' ); ?><? endif ?></a>

										<? if ( $hasChildNodes ): ?>
											<ul class="rwe-page-header-nav__dropdown-third-level">
												<? foreach ( $menuNode1[ NavigationModel::CHILDREN ] as $level2 ): ?>
													<? $menuNode2 = $menuNodes[ $level2 ] ?>
													<li class="rwe-page-header-nav__dropdown-third-level-item">
														<a class="rwe-page-header-nav__link" data-tracking="third-level"<? if ( !empty( $menuNode2[ NavigationModel::SPECIAL ] ) ):
															?> data-extra="<?= $menuNode2[ NavigationModel::SPECIAL ] ?>"<? endif
														?> href="<?= $menuNode2[ NavigationModel::HREF ]
														?>"><?= $menuNode2[ NavigationModel::TEXT ] ?></a>
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
