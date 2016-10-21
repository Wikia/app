<div class="wds-global-navigation__right-slot">
	<a href="<?= Sanitizer::encodeAttribute( $model['href'])?>" data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'])?>">
		<img src="<?= Sanitizer::encodeAttribute( $model['image_url'])?>"
			 width="<?= Sanitizer::encodeAttribute( $model['width'])?>px"
			 height="<?= Sanitizer::encodeAttribute( $model['height'])?>px"
			 alt="<?= DesignSystemHelper::renderText( $model['title'] )?>"/>
	</a>
</div>
