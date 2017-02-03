<? if ( in_array( $variant['letter'], [ 'A', 'B' ] ) ) : ?>
	<?= $app->renderView( 'PremiumDesignABTest', $variant['letter'] . '_header') ?>
<? endif;
