<?php if ( isset( $model['subtitle'] ) ): ?>
<div class="wds-global-navigation__account-menu-dropdown-caption"><?= DesignSystemHelper::renderText( $model['subtitle'] ) ?></div>
<?php endif; ?>
<button class="wds-button wds-is-full-width <?= isset( $model['subtitle'] ) ? 'wds-is-secondary' : ''; ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</button>
