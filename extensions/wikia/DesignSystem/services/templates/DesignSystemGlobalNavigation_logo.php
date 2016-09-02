<? if ( !isset( $model['header']['subtitle'] ) ): ?>
<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>" class="wds-global-navigation__logo">
	<?= DesignSystemHelper::getSvg(
		$model['header']['image'],
		'wds-global-navigation__logo-fandom'
	) ?>
</a>
<? else: ?>
<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>" class="wds-global-navigation__logo wds-global-navigation__logo-wikia">
	<?= DesignSystemHelper::getSvg(
		$model['header']['image'],
		'wds-global-navigation__logo-wikia-icon'
	) ?>
	<span class="wds-global-navigation__logo-wikia-caption"><?= DesignSystemHelper::renderText(
			$model['header']['subtitle']
		) ?></span>
</a>
<? endif; ?>
