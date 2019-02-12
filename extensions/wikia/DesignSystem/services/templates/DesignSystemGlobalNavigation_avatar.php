<div class="wds-avatar" title="<?= Sanitizer::encodeAttribute( $alt ); ?>">
	<?php if($src): ?>
		<img src="<?= Sanitizer::encodeAttribute( $src ); ?>" alt="<?= Sanitizer::encodeAttribute( $alt ); ?>" title="<?= Sanitizer::encodeAttribute( $alt ); ?>" class="wds-avatar__image">
	<?php else: ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-avatar', 'wds-avatar__image', $alt ); ?>
	<?php endif; ?>
</div>
