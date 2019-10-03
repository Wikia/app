<figure class="wds-global-footer__image">
	<?= DesignSystemHelper::renderApiImage( $image, 'wds-icon' ) ?>
	<?php if ( !empty( $image['caption'] ) ) : ?>
		<figcaption class="wds-global-footer__image-caption">
			<?= DesignSystemHelper::renderText( $image['caption'] ) ?>
		</figcaption>
	<?php endif; ?>
</figure>

