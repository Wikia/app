<div class="wds-dropdown wds-global-navigation__link-group wds-has-dark-shadow">
	<div class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle wds-global-navigation__link">
		<span><?= DesignSystemHelper::renderText( $model['title'] ) ?></span>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
	</div>
	<div class="wds-dropdown__content wds-global-navigation__dropdown-content">
		<ul class="wds-list wds-is-linked">
			<?php foreach ( $model['items'] as $item ): ?>
				<li>
					<?php if ( $item['type'] === 'link-text' ): ?>
						<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'linkText',
							[ 'model' => $item ] ); ?>
					<?php else: ?>
						<?= $app->renderPartial( 'DesignSystemGlobalNavigationService',
							'linkButton', [ 'model' => $item ] ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
