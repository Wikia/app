<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>"<?= !empty($standaloneLink) ? ' class="wds-global-navigation__link"' : '' ?>
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking-label'] ); ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
