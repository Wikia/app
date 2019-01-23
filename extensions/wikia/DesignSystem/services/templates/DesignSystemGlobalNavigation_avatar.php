<div class="wds-avatar">
	<?php if($src): ?>
		<img src="<?= Sanitizer::encodeAttribute( $src ); ?>" alt="<?= Sanitizer::encodeAttribute( $alt ); ?>" title="<?= Sanitizer::encodeAttribute( $alt ); ?>" class="wds-avatar__image">
	<?php else: ?>
		<div class="wds-avatar__inner-border" alt="<?= Sanitizer::encodeAttribute( $alt ); ?>" title="<?= Sanitizer::encodeAttribute( $alt ); ?>"></div>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-user-avatar', 'wds-avatar__image',
			$alt ); ?>
	<?php endif; ?>
</div>
