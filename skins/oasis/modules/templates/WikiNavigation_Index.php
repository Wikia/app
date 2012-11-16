<ul class="nav"<? if ( !empty( $parseErrors ) ): ?> data-parse-errors="true"<? endif ?>>
	<?
		$counter = 0;
		$firstChild = true;
	?>
	<? foreach ( array( $wikiaMenuNodes, $wikiMenuNodes ) as $menuNodes ): ?>
		<? if ( is_array( $menuNodes ) && isset( $menuNodes[ 0 ] ) && $showMenu ): ?>
			<? foreach ( $menuNodes[ 0 ][ NavigationService::CHILDREN ] as $level0 ): ?>
				<? $menuNode0 = $menuNodes[ $level0 ] ?>
				<? if ( $menuNode0[ NavigationService::TEXT ] ): ?>
					<li class="nav-item<? if ( $counter == 0 ): $counter++ ?> marked<? endif ?>">
						<a<? if ( !empty( $menuNode0[ NavigationService::SPECIAL ] ) ):
							?> data-extra="<?= $menuNode0[ NavigationService::SPECIAL ] ?>"<? endif
							?> href="<?= $menuNode0[ NavigationService::HREF ]
							?>"><?= $menuNode0[ NavigationService::TEXT ] ?></a>

						<? if ( isset( $menuNodes[ $level0 ][ NavigationService::CHILDREN ] ) ): ?>
							<ul class="subnav-2 accent<? if ( $firstChild ): ?><? $firstChild = false ?> firstChild<? endif ?>">
								<? foreach ( $menuNodes[ $level0 ][ NavigationService::CHILDREN ] as $level1 ): ?>
									<?
										$menuNode1 = $menuNodes[ $level1 ];
										$hasChildNodes = isset( $menuNode1[ NavigationService::CHILDREN ] );
									?>
									<li class="subnav-2-item">
										<a class="subnav-2a"<? if ( !empty( $menuNode1[ NavigationService::SPECIAL ] ) ):
											?> data-extra="<?= $menuNode1[ NavigationService::SPECIAL ] ?>"<? endif
											?> href="<?= $menuNode1[ NavigationService::HREF ] ?>"<? if ( !empty( $menuNode1[ NavigationService::CANONICAL_NAME ] ) ):
											?> data-canonical="<?= strtolower( $menuNode1[ NavigationService::CANONICAL_NAME ] ) ?>"<? endif
											?>><?= $menuNode1[ NavigationService::TEXT ] ?><? if ( $hasChildNodes ):
											?><img src="<?= $wf->BlankImgUrl() ?>" class="chevron"><? endif ?></a>

										<? if ( $hasChildNodes ): ?>
											<ul class="subnav-3 subnav">
												<? foreach ( $menuNode1[ NavigationService::CHILDREN ] as $level2 ): ?>
													<? $menuNode2 = $menuNodes[ $level2 ] ?>
													<li class="subnav-3-item">
														<a class="subnav-3a"<? if ( !empty( $menuNode2[ NavigationService::SPECIAL ] ) ):
															?> data-extra="<?= $menuNode2[ NavigationService::SPECIAL ] ?>"<? endif
															?> href="<?= $menuNode2[ NavigationService::HREF ]
															?>"><?= $menuNode2[ NavigationService::TEXT ] ?></a>
													</li>
												<? endforeach ?>
											</ul>
										<? endif ?>
									</li>
								<? endforeach ?>
								<? if ( !empty( $wikiaMenuLocalNodes ) && isset( $wikiaMenuLocalNodes[ 0 ] ) && isset( $wikiaMenuLocalNodes[ 0 ][ NavigationService::CHILDREN ] ) ): ?>
									<? foreach ( $wikiaMenuLocalNodes[ 0 ][ NavigationService::CHILDREN ] as $level1 ): ?>
										<li class="subnav-2-item">
											<a class="subnav-2a"<? if ( !empty( $wikiaMenuLocalNodes[ $level1 ][ NavigationService::SPECIAL ] ) ):
												?> data-extra="<?= $wikiaMenuLocalNodes[ $level1 ][ NavigationService::SPECIAL ] ?>"<? endif
												?> href="<?= $wikiaMenuLocalNodes[ $level1 ][ NavigationService::HREF ] ?>">
												<?= $wikiaMenuLocalNodes[$level1][ NavigationService::TEXT ] ?>
											</a>

											<? if ( isset( $wikiaMenuLocalNodes[ $level1 ][ NavigationService::CHILDREN ] ) ): ?>
												<ul class="subnav-3 subnav">
													<? foreach ( $wikiaMenuLocalNodes[ $level1 ][ NavigationService::CHILDREN ] as $level2 ): ?>
														<li class="subnav-3-item">
															<a class="subnav-3a"<? if ( !empty( $wikiaMenuLocalNodes[ $level2 ][ NavigationService::SPECIAL ] ) ):
																?> data-extra="<?= $wikiaMenuLocalNodes[ $level2 ][ NavigationService::SPECIAL ] ?>"<? endif
																?> href="<?= $wikiaMenuLocalNodes[ $level2 ][ NavigationService::HREF ]
																?>"><?= $wikiaMenuLocalNodes[$level2][ NavigationService::TEXT ] ?></a>
														</li>
													<? endforeach ?>
												</ul>
											<? endif ?>
										</li>
									<? endforeach ?>
								<? endif ?>
							</ul>
						<? endif ?>
					</li>
				<? endif ?>
			<? endforeach ?>
		<? endif ?>
	<? endforeach ?>
</ul>

<div class="navbackground">
	<div></div>
	<img src="<?= $wg->BlankImgUrl; ?>" class="chevron">
</div>