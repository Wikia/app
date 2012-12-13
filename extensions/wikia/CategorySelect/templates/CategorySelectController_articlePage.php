<nav class="WikiaArticleCategories CategorySelect articlePage<? if ( $showHidden ): ?> showHidden<? endif ?>" id="WikiaArticleCategories">
	<div class="padded">
		<?= $categoriesLink ?>
		<div class="shifted">
			<?= $app->getView( 'CategorySelect', 'categories', array( 'categories' => $categories ) ) ?>
			<? if ( $userCanEdit ): ?>
				<div class="edit">
					<ul class="newCategories"></ul>
					<button class="wikia-button add" id="CategorySelectAdd" type="button"><?= $wf->Message( 'categoryselect-button-add' ) ?></button>
					<?= $app->getView( 'CategorySelect', 'input', array( 'className' => 'hide' ) ) ?>
				</div>
			<? endif ?>
		</div>
	</div>
	<div class="toolbar">
		<button class="wikia-button save" id="CategorySelectSave" type="button"><?= $wf->Message( 'categoryselect-button-save' ) ?></button>
		<button class="wikia-button secondary cancel" id="CategorySelectCancel" type="button"><?= $wf->Message( 'categoryselect-button-cancel' ) ?></button>
	</div>
</nav>