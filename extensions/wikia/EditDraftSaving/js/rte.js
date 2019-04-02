require(['jquery', 'EditDraftSaving'], function ($, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-ck',
		editForm = document.forms["editform"],
		RTE = window.RTE;

	EditDraftSaving.log('Initializing EditDraftSaving for ' + EDITOR_TYPE);

	function saveDraft() {
		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			mode: RTE.getInstance().mode,
			draftText: RTE.getInstance().getData(),
		});
	}

	function setContent(mode, draftText) {
		var CKinstance = RTE.getInstance();

		// @see https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-setMode
		if (CKinstance.mode !== mode) {
			// we need to switch mode to apply a draft in a right one
			CKinstance.setMode(
				mode,
				function () {
					CKinstance.setData(draftText);
				}
			);
		} else {
			// we're in the right mode
			CKinstance.setData(draftText);
		}
	}

	CKEDITOR.on('instanceReady', function () {
		var draftData = EditDraftSaving.readDraft(),
			initialMode = RTE.getInstance().mode;

		EditDraftSaving.storeOriginalContent(RTE.getInstance().getData());

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			var draftText = draftData.draftText;
			setContent(draftData.mode, draftText);

			EditDraftSaving.checkDraftConflict(draftData.startTime, EDITOR_TYPE);
			EditDraftSaving.onDraftRestore(
				EDITOR_TYPE,
				// selector of an element to prepend a notification bar to
				'#cke_1_contents',
				// function to be called when the draft is discarded,
				// callback will get the original editor content
				function(content) {
					setContent(initialMode, content);
				},
				draftData.mode
			);
		}

		// register draft saving function
		setInterval(saveDraft, EditDraftSaving.SAVES_INTERVAL);
	});

});
