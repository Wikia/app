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
		var draftData = EditDraftSaving.readDraft();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			var draftText = draftData.draftText;

			// @see https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-setMode
			RTE.getInstance().setMode(
				draftData.mode,
				function() {
					RTE.getInstance().setData(draftText)
				}
			);

			alert(window.mediaWiki.message('edit-draft-loaded').text());

			EditDraftSaving.trackDraftRestore(EDITOR_TYPE);
		}

		// register draft saving function
		setInterval(saveDraft, EditDraftSaving.SAVES_INTERVAL);
	});

});
