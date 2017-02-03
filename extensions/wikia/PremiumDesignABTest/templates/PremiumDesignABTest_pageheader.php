<? if ( in_array( $variant['letter'], [ 'A', 'B', 'C', 'D' ] ) ) : ?>
	<?= $app->renderView( 'PremiumDesignABTest', $variant['letter'] . '_pageheader') ?>
<?endif;
