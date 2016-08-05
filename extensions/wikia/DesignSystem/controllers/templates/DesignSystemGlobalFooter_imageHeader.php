<h2 class="wds-global-footer__<?= Sanitizer::encodeAttribute( $section ) ?>-header">
	<?php if ( $model['type'] === 'link-image' ) : ?>
		<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>">
			<?= DesignSystemHelper::getSvg( $model['image'], 'wds-global-footer__' . Sanitizer::encodeAttribute( $section ) . '-logo', DesignSystemHelper::renderText( $model['title'] ) ) ?>
		</a>
	<?php else : ?>
		<?= DesignSystemHelper::getSvg( $model['image'], 'wds-global-footer__' . Sanitizer::encodeAttribute( $section ) . '-logo', DesignSystemHelper::renderText( $model['title'] ) ) ?>
	<?php endif; ?>
</h2>
