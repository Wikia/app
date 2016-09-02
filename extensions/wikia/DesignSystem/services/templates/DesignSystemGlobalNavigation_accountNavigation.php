<div class="wds-global-navigation__account-menu wds-dropdown">
	<div class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle">
		<?= DesignSystemHelper::getSvg(
			$model['header']['image'],
			'wds-icon wds-icon-small wds-icon'
		) ?>
		<span class="wds-global-navigation__account-menu-caption"><?= DesignSystemHelper::renderText( $model['header']['title'] ); ?></span>
		<?= DesignSystemHelper::getSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
		) ?>
	</div>
	<div class="wds-dropdown__content wds-global-navigation__dropdown-content wds-is-right-aligned">
		<ul class="wds-list wds-has-lines-between">
			<?php foreach ( $model['links'] as $link ): ?>
				<li><?= $app->renderView( 'DesignSystemGlobalNavigationService', 'linkAuthentication', [ 'model' => $link ] ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
