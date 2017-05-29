<header
	style="background-image: url(<?= $backgroundImageUrl ?>);"
	class="wds-community-header">
	<? if ( $wordmark->hasWordmark() ) : ?>
		<div class="wds-community-header__wordmark">
			<a accesskey="z" href="<?= $wordmark->href ?>">
				<img src="<?= $wordmark->image->url ?>"
					 width="<?= $wordmark->image->width ?>"
					 height="<?= $wordmark->image->height ?>"
					 alt="<?= $wordmark->label->render() ?>">
			</a>
		</div>
	<? endif; ?>
	<div class="wds-community-header__top-container">
		<div class="wds-community-header__sitename">
			<a href="<?= $sitename->url ?>"><?= $sitename->titleText->render() ?></a>
		</div>
		<div class="wds-community-header__counter">
			<span class="wds-community-header__counter-value"><?= $counter->value ?></span>
			<span class="wds-community-header__counter-label"><?= $counter->label->render() ?></span>
		</div>
		<div class="wds-community-header__wiki-buttons wds-button-group">
			<?php foreach ( $wikiButtons as $wikiButton ): ?>
				<a class="wds-button wds-is-squished wds-is-secondary"
				   href="<?= $wikiButton->href ?>"<?php if ( !empty( $wikiButton->title ) ): ?> title="<?= $wikiButton->title->render() ?>"<?php endif; ?>>
					<?= DesignSystemHelper::renderSvg( $wikiButton->icon, 'wds-icon wds-icon-small' ) ?>
					<?php if ( !empty( $wikiButton->label ) ): ?>
						<span><?= $wikiButton->label->render() ?></span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<nav class="wds-community-header__local-navigation">
		<ul class="wds-tabs">
			<? foreach( $navigation->localNavigation as $firstLevelItem ): ?>
				<li class="wds-tabs__tab">
					<? if ( !empty( $firstLevelItem['children'] ) ): ?>
						<div class="wds-dropdown">
							<div class="wds-tabs__tab-label wds-dropdown__toggle">
								<a href="<?= $firstLevelItem['href'] ?? '#' ?>">
									<span><?= $firstLevelItem['textEscaped'] ?></span>
								</a>
								<?= DesignSystemHelper::renderSvg('wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'); ?>
							</div>
							<div class="wds-is-not-scrollable wds-dropdown__content">
								<ul class="wds-list wds-is-linked wds-has-bolded-items">
									<? foreach( $firstLevelItem['children'] as $index => $secondLevelItem ): ?>
										<? if ( array_key_exists( 'children', $secondLevelItem ) && !empty( $secondLevelItem['children'] ) ): ?>
											<li class="<?= $index > count($secondLevelItem['children']) - 1 ? 'wds-is-sticked-to-parent ' : '' ?>wds-dropdown-level-2">
												<a href="<?= $secondLevelItem['href'] ?? '#' ?>" class="wds-dropdown-level-2__toggle">
													<span><?= $secondLevelItem['textEscaped'] ?></span>
													<?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny wds-dropdown-chevron' ); ?>
												</a>
												<div class="wds-is-not-scrollable wds-dropdown-level-2__content">
													<ul class="wds-list wds-is-linked">
														<? foreach( $secondLevelItem['children'] as $thirdLevelItem ): ?>
															<li>
																<a href="<?= $thirdLevelItem['href'] ?? '#' ?>"><?= $thirdLevelItem['textEscaped'] ?></a>
															</li>
														<? endforeach; ?>
													</ul>
												</div>
											</li>
										<? else : ?>
											<li>
												<a href="<?= $secondLevelItem['href'] ?? '#' ?>"><?= $secondLevelItem['textEscaped'] ?></a>
											</li>
										<? endif; ?>
									<? endforeach; ?>
								</ul>
							</div>
						</div>
					<? else : ?>
					<div class="wds-tabs__tab-label">
						<a href="<?= $firstLevelItem['href'] ?? '#' ?>">
							<span><?= $firstLevelItem['textEscaped'] ?></span>
						</a>
					</div>
					<? endif; ?>
				</li>
			<? endforeach; ?>
			<li class="wds-tabs__tab">
				<div class="wds-dropdown">
					<div class="wds-tabs__tab-label wds-dropdown__toggle">
						<?= DesignSystemHelper::renderSvg( 'wds-icons-explore-small', 'wds-icon-tiny wds-icon' ); ?>
						<span><?= $navigation->exploreLabel->render() ?></span>
						<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
					</div>
					<div class="wds-is-not-scrollable wds-dropdown__content">
						<ul class="wds-list wds-is-linked wds-has-bolded-items">
							<? foreach( $navigation->exploreItems as $exploreItem ): ?>
								<li>
									<a href="<?= $exploreItem->href ?>"><?= $exploreItem->label->render( true ) ?></a>
								</li>
							<? endforeach; ?>
						</ul>
					</div>
				</div>
			</li>
			<? if ( !empty( $navigation->discussLink ) ): ?>
				<li class="wds-tabs__tab">
					<div class="wds-tabs__tab-label">
						<a href="<?= $navigation->discussLink->href ?>">
							<?= DesignSystemHelper::renderSvg( 'wds-icons-reply-small', 'wds-icon-tiny wds-icon' ); ?>
							<span><?= $navigation->discussLink->label->render( true ) ?></span>
						</a>
					</div>
				</li>
			<? endif; ?>
		</ul>
	</nav>
</header>
