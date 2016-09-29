<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>"
   class="wds-global-footer__link"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'] ) ?>">
	<?= DesignSystemHelper::getSvg( $model['image'], 'wds-global-footer__image wds-icon' ) ?>
</a>
