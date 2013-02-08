<div class="CategorySelect editPage" id="CategorySelect">
	<?= $app->getView( 'CategorySelect', 'input' ) ?>
	<ul class="categories">
		<? foreach( $categories as $category ): ?>
			<?= $app->renderView( 'CategorySelectController', 'category', array(
				'name' => $category[ 'name' ]
			)) ?>
		<? endforeach ?>
	</ul>
</div>
