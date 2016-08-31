<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>"
	class="wds-global-navigation__link wds-is-<?= Sanitizer::encodeAttribute( $model['brand'] ) ?>"
	data-tracking-label="<?= Sanitizer::encodeAttribute( $model['title']['key'] ) ?>">
	<div><?= DesignSystemHelper::renderText( $model['title'] ) ?></div>
</a>
