<figure class="wds-global-footer__image">
	<?= DesignSystemHelper::renderApiImage( $model, 'wds-icon' ) ?>
	<?php if ( !empty( $model['caption'] ) ) : ?>
		<figcaption class="wds-global-footer__image-caption">
			<?= DesignSystemHelper::renderText( $model['caption'] ) ?>
		</figcaption>
	<?php endif; ?>
</figure>

