<div class="wds-global-navigation__<?= Sanitizer::escapeClass( $type ); ?> wds-dropdown wds-is-active">
	<div class="wds-dropdown__toggle wds-global-navigation__dropdown-toggle">
		<?php if ( $model['header']['type'] === 'line-text' ): ?>
			<span><?= DesignSystemHelper::renderText( $model['header']['title'] ) ?></span>
		<?php elseif ( $model['header']['type'] === 'avatar' ): ?>
			<?= Html::element( 'img', [
				'class' => 'wds-avatar wds-is-circle',
				'src' => $model['header']['url'],
				'alt' => $model['header']['username']['value']
			] ); ?>
		<?php endif; ?>
		<?= DesignSystemHelper::getSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
		) ?>
	</div>
	<div class="wds-dropdown__content wds-global-navigation__dropdown-content <?= $rightAligned ? 'wds-is-right-aligned' : ''; ?>">
		<ul class="wds-list">
			<?php foreach ( $model['links'] as $link ): ?>
				<li><?= $app->renderView( 'DesignSystemGlobalNavigationService', 'dropdownLink', [ 'model' => $link ] ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
