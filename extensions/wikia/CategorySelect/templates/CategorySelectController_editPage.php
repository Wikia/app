<div class="csEditMode" id="csMainContainer">
	<?= $text ?>
	<input placeholder="<?= wfMsg('categoryselect-addcategory-edit') ?>" data-placeholder="<?= wfMsg('categoryselect-addcategory-edit') ?>" id="csCategoryInput" type="text" />
	<div id="csSuggestContainer">
		<div id="csHintContainer"><?= wfMsg('categoryselect-suggest-hint') ?></div>
	</div>
	<div id="csItemsContainerDiv">
		<ul id="csItemsContainer"></ul>
	</div>
	<div id="csWikitextContainer">
		<textarea id="csWikitext" name="csWikitext" placeholder="<?= wfMsg('categoryselect-code-view-placeholder') ?>" rows="4" data-initial-value="<?= htmlspecialchars( $categories ) ?>"><?= htmlspecialchars( $categories ) ?></textarea>
	</div>
	<div class="clearfix"></div>
</div>