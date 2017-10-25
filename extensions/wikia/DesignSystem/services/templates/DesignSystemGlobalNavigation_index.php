<div class="wds-global-navigation-wrapper">
	<div id="globalNavigation" class="wds-global-navigation <?= isset( $model['fandom_overview'] ) ? '' : ' wds-search-is-always-visible'; ?>">
		<div class="wds-global-navigation__content-bar">
			<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'logo', [ 'model' => $model['logo'] ] ); ?>
			<div class="wds-global-navigation__links-and-search">
				<?php
				if ( isset( $model['fandom_overview'] ) ):
					foreach ( $model['fandom_overview']['links'] as $link ):
				?>
						<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'linkBranded', [ 'model' => $link ] ); ?>
				<?php
					endforeach;
				endif;
				?>
				<?= $app->renderView(
					'DesignSystemGlobalNavigationService',
					'links',
					[
						'model' => $model['wikis'],
						'type' => 'wikis-menu'
					]
				); ?>
				<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'search', [ 'model' => $model['search'] ] ); ?>
			</div>
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
				<?= $app->renderView( 'DesignSystemGlobalNavigationOnSiteNotificationsService', 'index' ); ?>
				<?= $app->renderView( 'DesignSystemGlobalNavigationWallNotificationsService', 'index' ); ?>
			<?php elseif ( isset( $model['anon'] ) ): ?>
				<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'accountNavigation', [ 'model' => $model['anon'] ] ); ?>
			<?php endif; ?>
			<div class="wds-global-navigation__start-a-wiki <?= isset( $model['user'] ) ? ' wds-user-is-logged-in' : ''; ?>">
				<a href="<?= Sanitizer::encodeAttribute( $model['create_wiki']['header']['href'] ); ?>" class="wds-global-navigation__start-a-wiki-button wds-button wds-is-squished wds-is-secondary" data-tracking-label="<?= Sanitizer::encodeAttribute( $model['create_wiki']['header']['tracking_label'] ) ?>">
					<span class="wds-global-navigation__start-a-wiki-caption"><?= DesignSystemHelper::renderText( $model['create_wiki']['header']['title'] ) ?></span>
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-plus',
						'wds-global-navigation__start-a-wiki-icon wds-icon'
					) ?>
				</a>
			</div>
		</div>
		<?php if ( isset( $model['partner_slot'] ) ): ?>
			<?= $app->renderView(
				'DesignSystemGlobalNavigationService',
				'partnerSlot',
				[
					'model' => $model['partner_slot'],
				]
			); ?>
		<?php endif ?>
	</div>
</div>
