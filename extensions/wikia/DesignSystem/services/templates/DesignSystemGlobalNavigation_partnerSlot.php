<div class="wds-global-navigation__partner-slot">
	<a href="<?= Sanitizer::encodeAttribute( $model['href'])?>"
		data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'])?>"
		class="wds-global-navigation__partner-slot-link">
		<?= DesignSystemHelper::renderApiImage(
			$model['image-data'],
			'wds-global-navigation__partner-slot-image',
			DesignSystemHelper::renderText( $model['title'] )
		) ?>
	</a>
</div>
