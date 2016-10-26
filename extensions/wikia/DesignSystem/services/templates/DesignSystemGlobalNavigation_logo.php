<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>"
   class="wds-global-navigation__logo wds-is-<?= $model['header']['image-data']['name'] ?>"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['header']['tracking_label'] ); ?>">
	<?= DesignSystemHelper::renderApiImage(
		$model['header']['image-data'],
		'wds-global-navigation__logo-image',
		DesignSystemHelper::renderText( $model['header']['title'] )
	) ?>
</a>
