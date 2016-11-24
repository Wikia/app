
		<ul class="first-level">
			<? if ( is_array( $menuNodes ) && isset( $menuNodes[ 0 ] ) ): ?>
				<? foreach ( $menuNodes[ 0 ][ NavigationModel::CHILDREN ] as $level0 ): ?>
					<? $menuNode0 = $menuNodes[ $level0 ] ?>
					<? if ( $menuNode0[ NavigationModel::TEXT ] ): ?>
						<li class="first-level-item">
							<a class="spacer"<? if ( !empty( $menuNode0[ NavigationModel::SPECIAL ] ) ):
								?> data-extra="<?= $menuNode0[ NavigationModel::SPECIAL ] ?>"<? endif
							?> href="<?= $menuNode0[ NavigationModel::HREF ]
							?>"><?= $menuNode0[ NavigationModel::TEXT ] ?></a>

							<? if ( isset( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] ) ): ?>
								<ul class="second-level">
									<? foreach ( $menuNodes[ $level0 ][ NavigationModel::CHILDREN ] as $level1 ): ?>
										<?
										$menuNode1 = $menuNodes[ $level1 ];
										$hasChildNodes = isset( $menuNode1[ NavigationModel::CHILDREN ] );
										?>
										<li class="second-level-level-item">
											<a<? if ( !empty( $menuNode1[ NavigationModel::SPECIAL ] ) ):
												?> data-extra="<?= $menuNode1[ NavigationModel::SPECIAL ] ?>"<? endif
											?> href="<?= $menuNode1[ NavigationModel::HREF ] ?>"<? if ( !empty( $menuNode1[ NavigationModel::CANONICAL_NAME ] ) ):
												?> data-canonical="<?= strtolower( $menuNode1[ NavigationModel::CANONICAL_NAME ] ) ?>"<? endif
											?>><?= $menuNode1[ NavigationModel::TEXT ] ?><? if ( $hasChildNodes ):
													?><?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny' ); ?><? endif ?></a>

											<? if ( $hasChildNodes ): ?>
												<ul class="third-level" style="display: none;">
													<? foreach ( $menuNode1[ NavigationModel::CHILDREN ] as $level2 ): ?>
														<? $menuNode2 = $menuNodes[ $level2 ] ?>
														<li class="third-level-item">
															<a<? if ( !empty( $menuNode2[ NavigationModel::SPECIAL ] ) ):
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
