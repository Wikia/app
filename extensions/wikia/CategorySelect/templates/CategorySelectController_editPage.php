<div class="CategorySelect editPage" id="CategorySelect">
	<?= $app->getView( 'CategorySelect', 'input' ) ?>
	<ul class="categories">
		<? foreach( $categories as $category ): ?>
			<?= $app->renderView( 'CategorySelectController', 'category', $category ) ?>
		<? endforeach ?>
	</ul>
</div>
