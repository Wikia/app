<nav class="WikiaArticleCategories CategorySelect articlePage<? if ( $showHidden ): ?> showHidden<? endif ?>" id="WikiaArticleCategories">
	<div class="padded">
		<?= $categoriesLink ?>
		<div class="shifted">
			<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories ) ) ?>
			<?= $app->getView( 'CategorySelect', 'addCategory' ) ?>
		</div>
	</div>
	<div class="toolbar">
		<button class="wikia-button save" id="CategorySelectSave" type="button"><?= $wf->Message( 'categoryselect-button-save' ) ?></button>
		<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= $wf->Message( 'categoryselect-button-cancel' ) ?></button>
	</div>
</nav>