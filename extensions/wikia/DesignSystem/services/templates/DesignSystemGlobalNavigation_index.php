<div class="wds-global-navigation">
	<div class="wds-global-navigation__content-bar">
		<a href="<?= Sanitizer::encodeAttribute( $model['logo']['links'][0]['href'] ); ?>" class="wds-global-navigation__logo">
			<?= ''
			/* Uncomment when we have the SVG
			 * DesignSystemHelper::getSvg(
				$model['logo']['links'][0]['image'],
				'wds-global-navigation__logo-fandom'
			)*/ ?>
		</a>
		<?php
		if ( isset( $model['fandom_overview'] ) ):
			foreach ( $model['fandom_overview']['links'] as $link ):
		?>
				<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'linkBranded', [ 'model' => $link ] ); ?>
		<?php
			endforeach;
		endif;
		?>
		<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'links', [ 'model' => $model['wikis'] ] ); ?>
		<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $model['search']['results']['url'] ); ?>">
			<div class="wds-global-navigation__search-input-wrapper">
				<label class="wds-global-navigation__search-label">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-magnifying-glass',
						'wds-icon wds-icon-small'
					) ?>
					<input class="wds-global-navigation__search-input" name="search" placeholder="<?= DesignSystemHelper::renderText( $model['search']['placeholder-inactive'] ); ?>"/>
				</label>
				<button class="wds-button wds-is-text wds-global-navigation__search-close">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-cross',
						'wds-icon wds-icon-small wds-global-navigation__search-close-icon',
						wfMessage( 'global-navigation-search-cancel' )->escaped()
					) ?>
				</button>
			</div>
			<button class="wds-button wds-global-navigation__search-submit">
				<?= DesignSystemHelper::getSvg(
					'wds-icons-arrow',
					'wds-icon wds-icon-small wds-global-navigation__search-icon'
				) ?>
			</button>
		</form>
		<?php if ( isset( $model['user'] ) ): ?>
			<?= $app->renderView(
				'DesignSystemGlobalNavigationService',
				'links',
				[
					'model' => $model['user'],
					'type' => 'user-menu',
					'dropdownRightAligned' => true,
				]
			); ?>
		<?php elseif ( isset( $model['anon'] ) ): ?>
			<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'accountNavigation', [ 'model' => $model['anon'] ] ); ?>
		<?php endif; ?>
		<div class="wds-global-navigation__notifications-menu wds-dropdown notifications-entry-point">
			<div class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle">
				<div class="wds-global-navigation__notifications-counter">3</div>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-bell',
					'wds-icon wds-icon-small'
				) ?>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
				) ?>
			</div>
		</div>
		<div class="wds-global-navigation__start-a-wiki">
			<a href="<?= Sanitizer::encodeAttribute( $model['create_wiki']['links'][0]['href'] ); ?>" class="wds-button wds-is-squished wds-is-secondary">
				<span class="wds-global-navigation__start-a-wiki-caption"><?= DesignSystemHelper::renderText( $model['create_wiki']['links'][0]['title'] ) ?></span>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-plus',
					'wds-global-navigation__start-a-wiki-icon wds-icon'
				) ?>
			</a>
		</div>
	</div>
</div>
