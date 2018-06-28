<div class="wds-dropdown wds-global-navigation__user-menu wds-has-shadow wds-global-navigation__user-logged-in">
	<div class="wds-dropdown__toggle">
		<?= $app->renderPartial( 'DesignSystemGlobalNavigationService',
			'avatar', [ 'src' => $model['avatar_url'], 'alt' => $model['username'] ] ); ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
	</div>
	<div class="wds-dropdown__content">
		<ul class="wds-list wds-is-linked">
			<?php foreach ( $model['items'] as $item ): ?>
				<li>
					<?php if ( $item['type'] === 'link-text' ): ?>
						<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'linkText',
							[ 'model' => $item ] ); ?>
					<?php else: ?>
						<?= $app->renderPartial( 'DesignSystemGlobalNavigationService',
							'linkLogout', [ 'model' => $item ] ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
