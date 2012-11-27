<ul class="categories">
	<? if ( count( $categories ) ): ?>
		<? foreach( $categories as $index => $category ): ?>
			<?= $app->renderView( 'CategorySelectController', 'category', array(
				'index' => $index,
				'category' => $category,
				'className' => !empty( $category[ 'type' ] ) ? $category[ 'type' ] : 'normal'
			)) ?>
		<? endforeach ?>
	<? endif ?>
</ul>