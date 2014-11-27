<aside class="article-categories<?= $userCanEdit ? ' userCanEdit' : '' ?>" id="articleCategories">
	<h3><?= wfMessage( 'pagecategories' )->escaped() ?></h3>
		<ul class="categories<?= $showHidden ? ' showHidden' : '' ?>">
			<?= $app->renderView( 'CategorySelectController', 'categories', array(
				'categories' => $categories
			)) ?>
			<? if ( $userCanEdit ): ?>
				<li class="add-toolbar last">
					<button class="wikia-button secondary add" id="categorySelectAdd" type="button"><?= wfMessage( 'categoryselect-button-add' )->escaped() ?></button>
					<?= $app->getView( 'CategorySelect', 'input' ) ?>
				</li>
			<? endif ?>
		</ul>
	<? if ( $userCanEdit ): ?>
		<div class="submit-toolbar">
			<button class="wikia-button secondary cancel" id="categorySelectCancel" type="button"><?= wfMessage( 'categoryselect-button-cancel' )->escaped() ?></button>
			<button class="wikia-button save" id="categorySelectSave" type="button" disabled="disabled"><?= wfMessage( 'categoryselect-button-save' )->escaped() ?></button>
		</div>
	<? endif ?>
</aside>
