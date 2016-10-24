<div class="wds-global-navigation__right-slot">
	<a href="<?= Sanitizer::encodeAttribute( $model['href'])?>"
		data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'])?>"
		class="wds-global-navigation__right-slot-link">
		<?= DesignSystemHelper::getApiImage(
			$model['image-data'],
			'wds-global-navigation__right-slot-image',
			DesignSystemHelper::renderText( $model['title'] )
		) ?>
	</a>
</div>
