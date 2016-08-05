<h2 class="wds-global-footer__<?= $section ?>-header">
	<?php if ( $model['type'] === 'link-image' ) : ?>
		<a href="<?= $model['href'] ?>">
			<?= DesignSystemHelper::getSvg( $model['image'], 'wds-global-footer__' . $section . '-logo' ) ?>
		</a>
	<?php else : ?>
		<?= DesignSystemHelper::getSvg( $model['image'], 'wds-global-footer__' . $section . '-logo' ) ?>
	<?php endif; ?>
</h2>
