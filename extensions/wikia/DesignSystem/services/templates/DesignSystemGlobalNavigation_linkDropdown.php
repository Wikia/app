<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>"
	class="wds-global-navigation__dropdown-link"
	data-tracking-label="<?= Sanitizer::encodeAttribute( $model['title']['key'] ) ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
