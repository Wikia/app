<? if ( in_array( $variant['letter'], [ 'C', 'D' ] ) ) : ?>
	<?= $app->renderView( 'PremiumDesignABTest', $variant['letter'] . '_rightrail') ?>
<? endif;
