<a href="<?= Sanitizer::cleanUrl( $model['href'] ) ?>" class="wds-global-footer__link wds-is-<?= Sanitizer::encodeAttribute( $model['brand'] ) ?>">
	<div><?= wfMessage( $model['title']['key'] )->escaped() ?></div>
	<?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-global-footer__image wds-icon' ) ?>
</a>
