<?php if ( !empty( $model['header'] ) ) : ?>
	<div class="wds-global-navigation__<?= Sanitizer::escapeClass( $type ); ?> wds-dropdown">
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
		<div class="wds-dropdown__content wds-global-navigation__dropdown-content <?= $dropdownRightAligned ? 'wds-is-right-aligned' : ''; ?>">
			<ul class="wds-list">
				<?php foreach ( $model['links'] as $link ): ?>
					<li><?= $app->renderView( 'DesignSystemGlobalNavigationService', 'linkDropdown', [ 'model' => $link ] ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php else : ?>
	<?php foreach ( $model['links'] as $link ): ?>
		<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'link', [ 'model' => $link ] ); ?>
	<?php endforeach; ?>
<?php endif; ?>
