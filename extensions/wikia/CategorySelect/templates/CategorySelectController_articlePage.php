<nav class="WikiaArticleCategories CategorySelect articlePage<?= $showHidden ? ' showHidden' : '' ?><?= $userCanEdit ? ' userCanEdit' : '' ?>" id="WikiaArticleCategories">
	<div class="container">
		<div class="special-categories"><?= $categoriesLink ?>:</div>
		<ul class="categories">
			<? if ( count( $categories ) ): ?>
				<? foreach( $categories as $index => $category ): ?>
					<?= $app->renderView( 'CategorySelectController', 'category', array(
						'index' => $index,
						'category' => $category
					)) ?>
				<? endforeach ?>
			<? endif ?>
			<? if ( $userCanEdit ): ?>
				<li class="last">
					<button class="wikia-button secondary add" id="CategorySelectAdd" type="button"><?= $wf->Message( 'categoryselect-button-add' ); ?></button>
					<?= $app->getView( 'CategorySelect', 'input' ) ?>
				</li>
			<? endif ?>
		</ul>
	</div>
	<div class="toolbar">
		<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= $wf->Message( 'categoryselect-button-cancel' ) ?></button>
		<button class="wikia-button save" id="CategorySelectSave" type="button" disabled="disabled"><?= $wf->Message( 'categoryselect-button-save' ) ?></button>
	</div>
</nav>