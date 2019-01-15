<div class="wds-avatar<?= !$src ? ' is-default' : ''?>" title="<?= Sanitizer::encodeAttribute( $alt ); ?>">
	<?php if($src): ?>
		<img src="<?= Sanitizer::encodeAttribute( $src ); ?>" alt="<?= Sanitizer::encodeAttribute( $alt ); ?>" title="<?= Sanitizer::encodeAttribute( $alt ); ?>" class="wds-avatar__image">
	<?php else: ?>
		<?= DesignSystemHelper::renderSvg( 'wds-avatar-icon-user', 'wds-avatar__image',
			$alt ); ?>
	<?php endif; ?>
</div>
