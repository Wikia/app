<a href="<?= Sanitizer::encodeAttribute( $model['module']['main']['href'] ); ?>"
   class="wds-global-navigation__logo"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['module']['main']['tracking_label'] ); ?>">
	<?= DesignSystemHelper::renderApiImage(
		$model['module']['main']['image-data'],
		'wds-global-navigation__logo-image wds-is-' . $model['module']['main']['image-data']['name'],
		DesignSystemHelper::renderText( $model['module']['main']['title'] )
	) ?>
	<?php if ( !empty( $model['module']['tagline'] ) ) : ?>
		<?= DesignSystemHelper::renderApiImage(
			$model['module']['tagline']['image-data'],
			'wds-global-navigation__logo-image wds-is-' . $model['module']['tagline']['image-data']['name'],
			DesignSystemHelper::renderText( $model['module']['tagline']['title'] )
		) ?>
	<?php endif; ?>
</a>
