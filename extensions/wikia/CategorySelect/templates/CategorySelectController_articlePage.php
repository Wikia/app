<div class="CategorySelect articlePage" id="CategorySelect">
	<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories )) ?>
	<?= $app->getView( 'CategorySelect', 'addCategory' ) ?>
</div>