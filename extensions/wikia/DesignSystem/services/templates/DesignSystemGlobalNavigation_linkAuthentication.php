<?php if ( isset( $model['subtitle'] ) ): ?>
	<div class="wds-global-navigation__account-menu-dropdown-caption"><?= DesignSystemHelper::renderText( $model['subtitle'] ) ?></div>
<?php endif; ?>
<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>" id="<?= Sanitizer::encodeAttribute( $model['title']['key'] ); ?>" class="wds-button wds-is-full-width <?= isset($model['subtitle'] ) ? 'wds-is-secondary' : ''; ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
