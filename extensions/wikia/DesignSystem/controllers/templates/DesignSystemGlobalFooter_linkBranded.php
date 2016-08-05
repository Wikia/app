<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>" class="wds-global-footer__link wds-is-<?= Sanitizer::encodeAttribute( $model['brand'] ) ?>">
	<div><?= DesignSystemHelper::renderText( $model['title'] ) ?></div>
	<?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-global-footer__image wds-icon', DesignSystemHelper::renderText( $model['title'] ) ) ?>
</a>
