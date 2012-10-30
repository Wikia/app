<div class="CategorySelect editPage" id="CategorySelect">
	<input type="text" class="addCategory" id="CategorySelectAdd" name="CategorySelectAdd" placeholder="<?= wfMsg( 'categoryselect-addcategory-edit' ) ?>" data-placeholder="<?= wfMsg( 'categoryselect-addcategory-edit' ) ?>">
	<textarea class="wikitext" id="CategorySelectWikitext" name="CategorySelectWikitext" placeholder="<?= wfMsg( 'categoryselect-code-view-placeholder' ) ?>" data-initial-value="<?= htmlspecialchars( $categories ) ?>"><?= htmlspecialchars( $categories ) ?></textarea>
	<ul class="categories"></ul>
</div>