require(['EditDraftSaving'], function (EditDraftSaving) {
	var EDITOR_TYPE = 'editor-ck',
		RTE = window.RTE;

	EditDraftSaving.log('Initializing EditDraftSaving for ' + EDITOR_TYPE);

	function saveDraft() {
		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			mode: RTE.getInstance().mode,
			draftText: RTE.getInstance().getData()
		});
	}

	CKEDITOR.on('instanceReady', function () {
		var draftData = EditDraftSaving.readDraft(),
			CKinstance = RTE.getInstance();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			var draftText = draftData.draftText;

			// @see https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-setMode
			if (CKinstance.mode !== draftData.mode) {
				// we need to switch mode to apply a draft in a right one
				CKinstance.setMode(
					draftData.mode,
					function () {
						CKinstance.setData(draftText);
					}
				);
			} else {
				// we're in the right mode
				CKinstance.setData(draftText);
			}

			EditDraftSaving.onDraftRestore(EDITOR_TYPE);
		}

		// register draft saving function
		setInterval(saveDraft, EditDraftSaving.SAVES_INTERVAL);
	});

});
