<div class="CategorySelect editPage" id="CategorySelect">
	<input type="text" class="addCategory" id="CategorySelectAdd" name="CategorySelectAdd" placeholder="<?= wfMsg( 'categoryselect-addcategory-edit' ) ?>" data-placeholder="<?= wfMsg( 'categoryselect-addcategory-edit' ) ?>">	
	<ul class="categories">
	<? if ( count( $categories ) ): ?>
		<? foreach( $categories as $index => $category ): ?>
			<?= $app->renderView( 'CategorySelectController', 'category', array(
				'index' => $index,
				'category' => $category
			)) ?>
		<? endforeach ?>
	<? endif ?>
	</ul>
</div>
