<?php if ( isset( $model['subtitle'] ) ): ?>
	<div class="wds-global-navigation__account-menu-dropdown-caption"><?= DesignSystemHelper::renderText( $model['subtitle'] ) ?></div>
<?php endif; ?>
<a href="<?= Sanitizer::encodeAttribute( $href ); ?>"
   rel="nofollow"
   id="<?= Sanitizer::encodeAttribute( $model['title']['key'] ); ?>"
   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'] ) ?>"
   class="<?= $classNames ?>">
	<?= DesignSystemHelper::renderText( $model['title'] ) ?>
</a>
