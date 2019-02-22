require(['jquery', 'EditDraftSaving'], function (jquery, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-mw',
		editForm = document.forms["editform"];

	EditDraftSaving.log('Initializing EditDraftSaving for ' + EDITOR_TYPE);

	function getContent() {
		return jquery('#wpTextbox1').val();
	}

	function saveDraft() {
		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			draftText: getContent(),
			startTime: editForm.wpStarttime.value
		});
	}

	jquery(function () {
		EditDraftSaving.storeOriginalContent(getContent());

		var draftData = EditDraftSaving.readDraft();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			jquery('#wpTextbox1').val(draftData.draftText);

			EditDraftSaving.checkDraftConflict(draftData.startTime, EDITOR_TYPE);
			EditDraftSaving.onDraftRestore(EDITOR_TYPE);
		}

		// register draft saving function
		setInterval(saveDraft, EditDraftSaving.SAVES_INTERVAL);
	});
});
