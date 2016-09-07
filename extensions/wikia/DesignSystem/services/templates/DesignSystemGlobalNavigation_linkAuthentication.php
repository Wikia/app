<?php if ( $model['title']['key'] === 'global-navigation-anon-register' ): ?>
	<div class="wds-global-navigation__account-menu-dropdown-caption"><?= DesignSystemHelper::renderText( $model['subtitle'] ) ?></div>
<?php endif; ?>
<a href="<?= Sanitizer::encodeAttribute( $href ); ?>" id="<?= Sanitizer::encodeAttribute( $model['title']['key'] ); ?>" class="wds-button wds-is-full-width <?= $model['title']['key'] === 'global-navigation-anon-register' ? 'wds-is-secondary' : ''; ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
