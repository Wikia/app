<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>" class="wds-global-navigation__logo" data-tracking-label="<?= Sanitizer::encodeAttribute( $model['header']['tracking_label'] ); ?>">
	<?= DesignSystemHelper::renderApiImage(
		$model['header']['image-data'],
		'wds-global-navigation__logo-fandom',
		DesignSystemHelper::renderText( $model['header']['title'] )
	) ?>
</a>
