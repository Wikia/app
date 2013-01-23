<nav class="WikiaArticleCategories CategorySelect articlePage<? if ( $showHidden ): ?> showHidden<? endif ?>" id="WikiaArticleCategories">
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
			<li class="add">
				<button class="wikia-button secondary categoryselect-add" id="CategorySelectAdd" type="button"><?= $wf->Message( 'categoryselect-button-add' ); ?></button>
				<?= $app->getView( 'CategorySelect', 'input' ) ?>
			</li>
		<? endif ?>
	</ul>
	<div class="toolbar">
		<button class="wikia-button secondary cancel categoryselect-cancel" id="CategorySelectCancel" type="button"><?= $wf->Message( 'categoryselect-button-cancel' ) ?></button>
		<button class="wikia-button save categoryselect-save" id="CategorySelectSave" type="button"><?= $wf->Message( 'categoryselect-button-save' ) ?></button>
	</div>
</nav>