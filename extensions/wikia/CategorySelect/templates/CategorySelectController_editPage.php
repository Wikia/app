<div class="CategorySelect editPage" id="CategorySelect">
	<?= $app->getView( 'CategorySelect', 'input' ) ?>
	<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories )) ?>
</div>
