<? foreach( $categories as $category ): ?>
	<?= $app->renderView( 'CategorySelectController', 'category', $category ) ?>
<? endforeach; ?>