<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>"
	class="wds-global-navigation__link"
	data-tracking-label="<?= Sanitizer::encodeAttribute( $model['title']['key'] ) ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
