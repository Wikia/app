<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>"
   class="wds-global-footer__link wds-is-<?= Sanitizer::encodeAttribute( $model['brand'] ) ?>"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['title']['key'] ) ?>">
	<div><?= DesignSystemHelper::renderText( $model['title'] ) ?></div>
	<?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-global-footer__image wds-icon' ) ?>
</a>
