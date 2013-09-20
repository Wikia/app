<nav class="WikiaArticleCategories CategorySelect articlePage<?= $userCanEdit ? ' userCanEdit' : '' ?>" id="WikiaArticleCategories">
	<div class="container">
		<div class="special-categories"><?= $categoriesLink ?>:</div>
		<ul class="categories<?= $showHidden ? ' showHidden' : '' ?>">
			<?= $app->renderView( 'CategorySelectController', 'categories', array(
				'categories' => $categories
			)) ?>
			<? if ( $userCanEdit ): ?>
				<li class="last">
					<button class="wikia-button secondary add" id="CategorySelectAdd" type="button"><?= wfMessage( 'categoryselect-button-add' )->text() ?></button>
					<?= $app->getView( 'CategorySelect', 'input' ) ?>
				</li>
			<? endif ?>
		</ul>
	</div>
	<? if ( $userCanEdit ): ?>
		<div class="toolbar">
			<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= wfMessage( 'categoryselect-button-cancel' )->text() ?></button>
			<button class="wikia-button save" id="CategorySelectSave" type="button" disabled="disabled"><?= wfMessage( 'categoryselect-button-save' )->text() ?></button>
		</div>
	<? endif ?>
</nav>