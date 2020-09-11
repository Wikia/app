<nav class="wds-community-header__local-navigation">
	<ul class="wds-tabs">
		<? foreach ( $navigation->localNavigation as $firstLevelItem ): ?>
			<li class="wds-tabs__tab">
				<? if ( !empty( $firstLevelItem['items'] ) ): ?>
					<div class="wds-dropdown">
						<div class="wds-tabs__tab-label wds-dropdown__toggle">
							<a href="<?= Sanitizer::encodeAttribute( $firstLevelItem['href'] ) ?? '#' ?>"
								<? if ( $isPreview ): ?> target="_blank"<? endif; ?>
								data-tracking="<?= $firstLevelItem['tracking_label'] ?>">
								<span><?= $firstLevelItem['title']['value'] ?></span>
							</a>
							<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
						</div>
						<div class="wds-is-not-scrollable wds-dropdown__content">
							<ul class="wds-list wds-is-linked wds-has-bolded-items">
								<? foreach ( $firstLevelItem['items'] as $index => $secondLevelItem ): ?>
									<? if ( array_key_exists( 'items', $secondLevelItem ) && !empty( $secondLevelItem['items'] ) ): ?>
										<li class="<?= $index > count( $secondLevelItem['items'] ) - 1 ? 'wds-is-sticked-to-parent ' : '' ?>wds-dropdown-level-2">
											<a href="<?= Sanitizer::encodeAttribute( $secondLevelItem['href'] ) ?? '#' ?>"
												<? if ( $isPreview ): ?>target="_blank"<? endif; ?>
												class="wds-dropdown-level-2__toggle"
												data-tracking="<?= $secondLevelItem['tracking_label'] ?>"
											>
												<span><?= $secondLevelItem['title']['value'] ?></span>
												<?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny wds-dropdown-chevron' ); ?>
											</a>
											<div class="wds-is-not-scrollable wds-dropdown-level-2__content">
												<ul class="wds-list wds-is-linked">
													<? foreach ( $secondLevelItem['items'] as $thirdLevelItem ): ?>
														<li>
															<a href="<?= Sanitizer::encodeAttribute( $thirdLevelItem['href'] ) ?? '#' ?>"
																<? if ( $isPreview ): ?>target="_blank"<? endif; ?>
																data-tracking="<?= $thirdLevelItem['tracking_label'] ?>"
															><?= $thirdLevelItem['title']['value'] ?></a>
														</li>
													<? endforeach; ?>
												</ul>
											</div>
										</li>
									<? else : ?>
										<li>
											<a href="<?= Sanitizer::encodeAttribute( $secondLevelItem['href'] ) ?? '#' ?>"
												<? if ( $isPreview ): ?>target="_blank"<? endif; ?>
												data-tracking="<?= $secondLevelItem['tracking_label'] ?>"
											>
												<?= $secondLevelItem['title']['value'] ?>
											</a>
										</li>
									<? endif; ?>
								<? endforeach; ?>
							</ul>
						</div>
					</div>
				<? else : ?>
					<div class="wds-tabs__tab-label">
						<a href="<?= Sanitizer::encodeAttribute( $firstLevelItem['href'] ) ?? '#' ?>"
							<? if ( $isPreview ): ?> target="_blank"<? endif; ?>
							data-tracking="<?= $firstLevelItem['tracking_label'] ?>"
						>
							<span><?= $firstLevelItem['title']['value'] ?></span>
						</a>
					</div>
				<? endif; ?>
			</li>
		<? endforeach; ?>
		<li class="wds-tabs__tab">
			<div class="wds-dropdown">
				<div class="wds-tabs__tab-label wds-dropdown__toggle">
					<?= DesignSystemHelper::renderSvg( $navigation->exploreLabel->iconKey, 'wds-icon-tiny wds-icon' ); ?>
					<span><?= $navigation->exploreLabel->renderInContentLang() ?></span>
					<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
				</div>
				<div class="wds-is-not-scrollable wds-dropdown__content">
					<ul class="wds-list wds-is-linked wds-has-bolded-items">
						<? foreach (  $navigation->exploreItems as $index => $exploreItem ): ?>
							<? if ( property_exists( $exploreItem, 'items' ) && !empty( $exploreItem->items ) ): ?>
								<li class="<?= $index > count( $exploreItem->items ) - 1 ? 'wds-is-sticked-to-parent ' : '' ?>wds-dropdown-level-2">
									<a href="<?= Sanitizer::encodeAttribute( $exploreItem->href ) ?? '#' ?>"
										<? if ( $isPreview ): ?>target="_blank"<? endif; ?>
										class="wds-dropdown-level-2__toggle"
										data-tracking="<?= $exploreItem->tracking ?>"
									>
										<span><?= $exploreItem->label->renderInContentLang() ?></span>
										<?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny wds-dropdown-chevron' ); ?>
									</a>
									<div class="wds-is-not-scrollable wds-dropdown-level-2__content">
										<ul class="wds-list wds-is-linked">
											<? foreach ( $exploreItem->items as $thirdLevelItem ): ?>
												<li>
													<a href="<?= Sanitizer::encodeAttribute( $thirdLevelItem->href ) ?? '#' ?>"
														<? if ( $isPreview ): ?>target="_blank"<? endif; ?>
														data-tracking="<?= $thirdLevelItem->tracking ?>"
													><?= $thirdLevelItem->label->renderInContentLang() ?></a>
												</li>
											<? endforeach; ?>
										</ul>
									</div>
								</li>
							<? else : ?>
								<li>
									<a href="<?= $exploreItem->href ?>"
										<? if ( $isPreview ): ?>target="_blank"<? endif; ?>
										data-tracking="<?= $exploreItem->tracking ?>"
									><?= $exploreItem->label->renderInContentLang() ?></a>
								</li>
							<? endif; ?>
						<? endforeach; ?>
					</ul>
				</div>
			</div>
		</li>
		<? if ( empty( $navigation->mainPageLink ) && !empty( $navigation->discussLink ) ): ?>
			<?= $app->renderPartial( 'CommunityHeaderService', 'tab',
				[ 'link' => $navigation->discussLink, 'isPreview' => $isPreview ] ) ?>
		<? endif; ?>
		<? if ( !empty( $navigation->mainPageLink ) ): ?>
			<?= $app->renderPartial( 'CommunityHeaderService', 'tab',
				[ 'link' => $navigation->mainPageLink, 'isPreview' => $isPreview ] ) ?>
		<? endif; ?>
	</ul>
</nav>
