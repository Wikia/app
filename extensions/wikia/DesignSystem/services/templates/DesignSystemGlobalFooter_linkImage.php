<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>"
   class="wds-global-footer__link"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'] ) ?>">
	<?= DesignSystemHelper::renderApiImage( $model['image-data'], 'wds-global-footer__image wds-icon' ) ?>
</a>
