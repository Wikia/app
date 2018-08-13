<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>"
   class="wds-global-footer__link wds-is-<?= Sanitizer::encodeAttribute( $model['brand'] ) ?>"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'] ) ?>">
	<div><?= DesignSystemHelper::renderText( $model['title'] ) ?></div>
</a>
