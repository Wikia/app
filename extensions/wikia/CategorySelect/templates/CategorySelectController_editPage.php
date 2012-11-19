<div class="CategorySelect editPage" id="CategorySelect">
	<?= $app->getView( 'CategorySelect', 'addCategory' ) ?>
	<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories )) ?>
</div>
