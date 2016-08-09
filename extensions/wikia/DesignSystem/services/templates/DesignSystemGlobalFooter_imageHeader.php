<h2 class="wds-global-footer__<?= Sanitizer::encodeAttribute( $section ) ?>-header">
	<?php if ( $model['type'] === 'link-image' ) : ?>
		<a href="<?= Sanitizer::encodeAttribute( $model['href'] ) ?>" data-tracking-label="<?= Sanitizer::encodeAttribute( $model['title']['key'] ) ?>">
			<?= DesignSystemHelper::getSvg(
				$model['image'],
				'wds-global-footer__' . Sanitizer::encodeAttribute( $section ) . '-logo'
			) ?>
		</a>
	<?php else : ?>
		<?= DesignSystemHelper::getSvg(
			$model['image'],
			'wds-global-footer__' . Sanitizer::encodeAttribute( $section ) . '-logo'
		) ?>
	<?php endif; ?>
</h2>
