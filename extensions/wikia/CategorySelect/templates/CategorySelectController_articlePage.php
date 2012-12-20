<nav class="WikiaArticleCategories CategorySelect articlePage<? if ( $showHidden ): ?> showHidden<? endif ?>" id="WikiaArticleCategories">
	<h2><?= $categoriesLink ?></h2>
	<div class="container">
		<ul class="categories">
			<? if ( count( $categories ) ): ?>
				<? foreach( $categories as $index => $category ): ?>
					<?= $app->renderView( 'CategorySelectController', 'category', array(
						'index' => $index,
						'category' => $category,
						'className' => !empty( $category[ 'type' ] ) ? $category[ 'type' ] : 'normal'
					)) ?>
				<? endforeach ?>
			<? endif ?>
			<? if ( $userCanEdit ): ?>
				<li class="add">
					<?= $app->getView( 'CategorySelect', 'input' ) ?>
				</li>
			<? endif ?>
		</ul>
	</div>
	<div class="toolbar">
		<button class="wikia-button save" id="CategorySelectSave" type="button"><?= $wf->Message( 'categoryselect-button-save' ) ?></button>
		<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= $wf->Message( 'categoryselect-button-cancel' ) ?></button>
	</div>
</nav>