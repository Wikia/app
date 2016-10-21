<div class="wds-global-navigation__right-slot">
	<a href="<?= Sanitizer::encodeAttribute( $model['href'])?>"
		data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'])?>"
		class="wds-global-navigation__right-slot-link">
		<img src="<?= Sanitizer::encodeAttribute( $model['img']['url'])?>"
			class="wds-global-navigation__right-slot-image"
			alt="<?= DesignSystemHelper::renderText( $model['title'] )?>"/>
	</a>
</div>
