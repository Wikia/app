<nav class="WikiaArticleCategories CategorySelect articlePage<?= $userCanEdit ? ' userCanEdit' : '' ?>" id="WikiaArticleCategories">
	<div class="container">
		<div class="special-categories"><?= $categoriesLink ?>:</div>
		<ul class="categories">
			<? foreach( $categoryLinks as $link ): ?>
				<?= $app->renderView( 'CategorySelectController', 'category', array(
					'name' => $link
				)) ?>
			<? endforeach ?>
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