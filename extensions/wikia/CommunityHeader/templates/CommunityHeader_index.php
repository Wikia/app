<header
	style="background-image: url(http://static.wikia.nocookie.net/c4a1302b-476b-468d-8766-2f36a6ace398);"
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
			<span
				class="wds-community-header__counter-label"><?= $counter->label->render() ?></span>
		</div>
		<div class="wds-community-header__wiki-buttons wds-button-group">
			<?php foreach ( $wikiButtons as $wikiButton ): ?>
				<a class="wds-button wds-is-squished wds-is-secondary"
				   href="<?= $wikiButton->href ?>"<?php if ( !empty( $wikiButton->title ) ): ?> title="<?= $wikiButton->title->render() ?>"<?php endif; ?>>
					<?= DesignSystemHelper::renderSvg( $wikiButton->icon,
						'wds-icon wds-icon-small' ) ?>
					<?php if ( !empty( $wikiButton->label ) ): ?>
						<span><?= $wikiButton->label->render() ?></span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<nav class="wds-community-header__local-navigation">
		<ul class="wds-tabs">
			<li class="wds-tabs__tab">
				<div class="wds-dropdown">
					<div class="wds-tabs__tab-label wds-dropdown__toggle">
						<a href="#">
							<span>						label 1				</span>
						</a>
						<svg class="wds-icon wds-icon-tiny wds-dropdown__toggle-chevron">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-dropdown-tiny"></use>
						</svg>
					</div>
					<div class="wds-is-not-scrollable wds-dropdown__content">
						<ul class="wds-list wds-is-linked wds-has-bolded-items">
							<li>
								<a href="#"> label 1.1 </a>
							</li>
							<li>
								<a href="#"> label 1.2 </a>
							</li>
							<li>
								<a href="#"> label 1.3 </a>
							</li>
							<li>
								<a href="#"> label 1.4 </a>
							</li>
							<li class="wds-is-sticked-to-parent wds-dropdown-level-2">
								<a href="#" class="wds-dropdown-level-2__toggle">
									<span>				label 1.5		</span>
									<svg class="wds-icon wds-icon-tiny wds-dropdown-chevron">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
											 xlink:href="#wds-icons-menu-control-tiny"></use>
									</svg>
								</a>
								<div class="wds-is-not-scrollable wds-dropdown-level-2__content">
									<ul class="wds-list wds-is-linked">
										<li>
											<a href="#">label 1.5.1</a>
										</li>
										<li>
											<a href="#">label 1.5.2</a>
										</li>
										<li>
											<a href="#">label 1.5.3</a>
										</li>
										<li>
											<a href="#">label 1.5.4</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</li>
			<li class="wds-tabs__tab">
				<div class="wds-dropdown">
					<div class="wds-tabs__tab-label wds-dropdown__toggle">
						<a href="#">
							<span>						label 2				</span>
						</a>
						<svg class="wds-icon wds-icon-tiny wds-dropdown__toggle-chevron">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-dropdown-tiny"></use>
						</svg>
					</div>
					<div class="wds-is-not-scrollable wds-dropdown__content">
						<ul class="wds-list wds-is-linked wds-has-bolded-items">
							<li class="wds-dropdown-level-2">
								<a href="#" class="wds-dropdown-level-2__toggle">
									<span>				label 2.1		</span>
									<svg class="wds-icon wds-icon-tiny wds-dropdown-chevron">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
											 xlink:href="#wds-icons-menu-control-tiny"></use>
									</svg>
								</a>
								<div class="wds-is-not-scrollable wds-dropdown-level-2__content">
									<ul class="wds-list wds-is-linked">
										<li>
											<a href="#">label 2.5.1</a>
										</li>
										<li>
											<a href="#">label 2.5.2</a>
										</li>
										<li>
											<a href="#">label 2.5.3</a>
										</li>
										<li>
											<a href="#">label 2.5.4</a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="#"> label 2.2 </a>
							</li>
							<li>
								<a href="#"> label 2.3 </a>
							</li>
							<li>
								<a href="#"> label 2.4 </a>
							</li>
							<li>
								<a href="#"> label 2.5 </a>
							</li>
						</ul>
					</div>
				</div>
			</li>
			<li class="wds-tabs__tab">
				<div class="wds-dropdown">
					<div class="wds-tabs__tab-label wds-dropdown__toggle">
						<a href="#">
							<span>						label 3				</span>
						</a>
						<svg class="wds-icon wds-icon-tiny wds-dropdown__toggle-chevron">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-dropdown-tiny"></use>
						</svg>
					</div>
					<div class="wds-is-not-scrollable wds-dropdown__content">
						<ul class="wds-list wds-is-linked wds-has-bolded-items">
							<li>
								<a href="#"> label 3.1 </a>
							</li>
							<li>
								<a href="#"> label 3.2 </a>
							</li>
							<li class="wds-dropdown-level-2">
								<a href="#" class="wds-dropdown-level-2__toggle">
									<span>				label 3.3		</span>
									<svg class="wds-icon wds-icon-tiny wds-dropdown-chevron">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
											 xlink:href="#wds-icons-menu-control-tiny"></use>
									</svg>
								</a>
								<div class="wds-is-not-scrollable wds-dropdown-level-2__content">
									<ul class="wds-list wds-is-linked">
										<li>
											<a href="#">label 3.5.1</a>
										</li>
										<li>
											<a href="#">label 3.5.2</a>
										</li>
										<li>
											<a href="#">label 3.5.3</a>
										</li>
										<li>
											<a href="#">label 3.5.4</a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="#"> label 3.4 </a>
							</li>
							<li>
								<a href="#"> label 3.5 </a>
							</li>
						</ul>
					</div>
				</div>
			</li>
			<li class="wds-tabs__tab">
				<div class="wds-dropdown">
					<div class="wds-tabs__tab-label wds-dropdown__toggle">
						<a href="#">
							<span>						label 4				</span>
						</a>
						<svg class="wds-icon wds-icon-tiny wds-dropdown__toggle-chevron">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-dropdown-tiny"></use>
						</svg>
					</div>
					<div class="wds-is-not-scrollable wds-dropdown__content">
						<ul class="wds-list wds-is-linked wds-has-bolded-items">
							<li>
								<a href="#"> label 4.1 </a>
							</li>
							<li>
								<a href="#"> label 4.2 </a>
							</li>
							<li>
								<a href="#"> label 4.3 </a>
							</li>
							<li>
								<a href="#"> label 4.4 </a>
							</li>
							<li>
								<a href="#"> label 4.5 </a>
							</li>
						</ul>
					</div>
				</div>
			</li>
			<li class="wds-tabs__tab">
				<div class="wds-dropdown">
					<div class="wds-tabs__tab-label wds-dropdown__toggle">
						<svg class="wds-icon-tiny wds-icon">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-explore-small"></use>
						</svg>
						<span>					Explore			</span>
						<svg class="wds-icon wds-icon-tiny wds-dropdown__toggle-chevron">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-dropdown-tiny"></use>
						</svg>
					</div>
					<div class="wds-is-not-scrollable wds-dropdown__content">
						<ul class="wds-list wds-is-linked wds-has-bolded-items">
							<li>
								<a href=""> Wiki Activity </a>
							</li>
							<li>
								<a href=""> Random page </a>
							</li>
							<li>
								<a href=""> Community </a>
							</li>
							<li>
								<a href=""> Videos </a>
							</li>
							<li>
								<a href=""> Images </a>
							</li>
						</ul>
					</div>
				</div>
			</li>
			<li class="wds-tabs__tab">
				<div class="wds-tabs__tab-label">
					<a href="#">
						<svg class="wds-icon-tiny wds-icon">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#wds-icons-reply-small"></use>
						</svg>
						<span>								Forum						</span>
					</a>
				</div>
			</li>
		</ul>
	</nav>
</header>
