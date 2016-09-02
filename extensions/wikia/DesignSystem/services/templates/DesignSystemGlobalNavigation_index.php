<div class="wds-global-navigation <?= isset( $model['fandom_overview'] ) ? '' : ' wds-search-is-always-visible'; ?>">
	<div class="wds-global-navigation__content-bar">
		<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'logo', [ 'model' => $model['logo'] ] ); ?>
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
		<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $model['search']['module']['results']['url'] ); ?>">
			<div class="wds-global-navigation__search-input-wrapper">
				<label class="wds-global-navigation__search-label">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-magnifying-glass',
						'wds-icon wds-icon-small'
					) ?>
					<input class="wds-global-navigation__search-input" name="search" placeholder="<?= DesignSystemHelper::renderText( $model['search']['module']['placeholder-inactive'] ); ?>"/>
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
			<?= $app->renderView( 'DesignSystemGlobalNavigationWallNotificationsService', 'index' ); ?>
		<?php elseif ( isset( $model['anon'] ) ): ?>
			<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'accountNavigation', [ 'model' => $model['anon'] ] ); ?>
		<?php endif; ?>
		<div class="wds-global-navigation__start-a-wiki <?= isset( $model['user'] ) ? ' wds-user-is-logged-in' : ''; ?>">
			<a href="<?= Sanitizer::encodeAttribute( $model['create_wiki']['header']['href'] ); ?>" class="wds-button wds-is-squished wds-is-secondary">
				<span class="wds-global-navigation__start-a-wiki-caption"><?= DesignSystemHelper::renderText( $model['create_wiki']['header']['title'] ) ?></span>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-plus',
					'wds-global-navigation__start-a-wiki-icon wds-icon'
				) ?>
			</a>
		</div>
	</div>
</div>
