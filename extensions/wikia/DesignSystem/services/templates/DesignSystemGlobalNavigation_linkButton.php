<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>"
   class="wds-button wds-is-secondary wds-global-navigation__link-button"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking-label'] ); ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
