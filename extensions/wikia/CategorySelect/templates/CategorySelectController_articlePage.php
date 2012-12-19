<nav class="WikiaArticleCategories CategorySelect articlePage<? if ( $showHidden ): ?> showHidden<? endif ?>" id="WikiaArticleCategories">
	<h2><?= $categoriesLink ?></h2>
	<div class="container">
		<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories ) ) ?>
		<? if ( $userCanEdit ): ?>
			<?= $app->getView( 'CategorySelect', 'input' ) ?>
		<? endif ?>
	</div>
	<div class="editToolbar">
		<button class="wikia-button save" id="CategorySelectSave" type="button"><?= $wf->Message( 'categoryselect-button-save' ) ?></button>
		<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= $wf->Message( 'categoryselect-button-cancel' ) ?></button>
	</div>
</nav>