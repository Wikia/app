<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>" class="wds-global-footer__link">
	<?= DesignSystemHelper::getSvg( $model['image'], 'wds-global-footer__image wds-icon', DesignSystemHelper::renderText( $model['title'] ) ) ?>
</a>
