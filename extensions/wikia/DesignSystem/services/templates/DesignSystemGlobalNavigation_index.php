<div class="wds-global-navigation-wrapper">
	<div class="wds-global-navigation wds-search-is-always-visible">
		<div class="wds-global-navigation__content-container">
			<div class="wds-global-navigation__content-bar-left">
				<a
					href="<?= Sanitizer::encodeAttribute( $model['logo']['href'] ); ?>"
					class="wds-global-navigation__logo"
					data-tracking-label="<?= Sanitizer::encodeAttribute( $model['logo']['tracking_label'] ); ?>">
					<?= DesignSystemHelper::renderSvg( $model['logo']['image-data']['name'], 'wds-global-navigation__logo-image' ); ?>
				</a>
				<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'mainNavigation',
					[ 'model' => $model['main_navigation'] ] ); ?>
			</div>
			<div class="wds-global-navigation__content-bar-right">
				<form action="/search" class="wds-global-navigation__search-container">
					<div class="wds-global-navigation__search wds-dropdown">
						<div class="wds-global-navigation__search-toggle">
							<svg class="wds-global-navigation__search-toggle-icon wds-icon wds-icon-small">
								<use xlink:href="#wds-icons-magnifying-glass-small"></use>
							</svg>
							<span class="wds-global-navigation__search-toggle-text">			Search		</span>
						</div>
						<div class="wds-global-navigation__search-input-wrapper wds-dropdown__toggle">
							<input autocomplete="off" placeholder="" class="wds-global-navigation__search-input ember-text-field" type="search">
							<button class="wds-global-navigation__search-close wds-button wds-is-text" type="button">
								<svg class="wds-icon wds-icon-tiny wds-global-navigation__search-close-icon">
									<use xlink:href="#wds-icons-cross"></use>
								</svg>
							</button>
							<button disabled class="wds-global-navigation__search-submit wds-button">
								<svg class="wds-global-navigation__search-submit-icon wds-icon wds-icon-small">
									<use xlink:href="#wds-icons-arrow-small"></use>
								</svg>
							</button>
						</div>
						<div class="wds-global-navigation__search-suggestions wds-dropdown__content">
							<ul class="wds-list wds-is-linked wds-has-ellipsis"></ul>
						</div>
					</div>
				</form>
				<?php if ( !empty( $model['user'] ) ): ?>
					<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'userMenu',
						[ 'model' => $model['user'] ] ); ?>
					<?= $app->renderView( 'DesignSystemGlobalNavigationOnSiteNotificationsService', 'index' ); ?>
					<?= $app->renderPartial( 'DesignSystemGlobalNavigationWallNotificationsService', 'index' ); ?>
				<?php endif; ?>
				<?php if ( !empty( $model['anon'] ) ): ?>
					<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'anonMenu',
						[ 'model' => $model['anon'] ] ); ?>
				<?php endif; ?>
				<div class="wds-global-navigation__start-a-wiki">
					<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'linkButton',
						[ 'model' => $model['create_wiki'] ] ); ?>
				</div>
				<?= $app->renderView(
					'DesignSystemGlobalNavigationService',
					'partnerSlot',
					[
						'model' => $model['partner_slot'],
					]
				); ?>
			</div>
		</div>
	</div>
</div>
