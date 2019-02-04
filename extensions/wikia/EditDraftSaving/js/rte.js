require(['EditDraftSaving'], function (EditDraftSaving) {
	var EDITOR_TYPE = 'ckeditor';
	EditDraftSaving.log('Initializing EditDraftSaving for ' + EDITOR_TYPE);

	function saveDraft() {
		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			mode: RTE.getInstance().mode,
			draftText: RTE.getInstance().getData()
		});
	}

	CKEDITOR.on('instanceReady', function () {
		var draftData = EditDraftSaving.readDraft();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			EditDraftSaving.log('Restoring a draft');
			RTE.getInstance().setMode(
				draftData.mode,
				RTE.getInstance().setData(draftData.draftText)
			);
		}

		// register draft saving function
		setInterval(saveDraft, EditDraftSaving.SAVES_INTERVAL);
	});

});
