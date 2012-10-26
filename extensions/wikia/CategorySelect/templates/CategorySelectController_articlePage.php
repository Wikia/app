<div id="csMainContainer" class="csViewMode">
	<div id="csSuggestContainer">
		<div id="csHintContainer"><?= wfMsg('categoryselect-suggest-hint') ?></div>
	</div>
	<div id="csItemsContainer" class="clearfix">
		<input id="csCategoryInput" type="text" style="display: none; outline: none;" />
	</div>
	<div id="csButtonsContainer" class="color1">
		<input type="button" id="csSave" onclick="csSave()" value="' . wfMsg('categoryselect-button-save') . '" />
		<input type="button" id="csCancel" onclick="csCancel()" value="' . wfMsg('categoryselect-button-cancel') . '" ' . ( ( F::app()->checkSkin( 'oasis' ) ) ? 'class="secondary" ' : '' ) . '/>
	</div>
</div>