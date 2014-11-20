<nav class="WikiaArticleCategories CategorySelect articlePage<?= $userCanEdit ? ' userCanEdit' : '' ?>" id="WikiaArticleCategories">
	<h2><?= wfMessage( 'pagecategories' )->escaped() ?></h2>
		<ul class="categories<?= $showHidden ? ' showHidden' : '' ?>">
			<?= $app->renderView( 'CategorySelectController', 'categories', array(
				'categories' => $categories
			)) ?>
			<? if ( $userCanEdit ): ?>
				<li class="add-toolbar last">
					<button class="wikia-button secondary add" id="CategorySelectAdd" type="button"><?= wfMessage( 'categoryselect-button-add' )->escaped() ?></button>
					<?= $app->getView( 'CategorySelect', 'input' ) ?>
				</li>
			<? endif ?>
		</ul>
	<? if ( $userCanEdit ): ?>
		<div class="submit-toolbar">
			<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= wfMessage( 'categoryselect-button-cancel' )->escaped() ?></button>
			<button class="wikia-button save" id="CategorySelectSave" type="button" disabled="disabled"><?= wfMessage( 'categoryselect-button-save' )->escaped() ?></button>
		</div>
	<? endif ?>
</nav>
