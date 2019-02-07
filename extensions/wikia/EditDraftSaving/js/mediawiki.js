require(['jquery', 'EditDraftSaving'], function (jquery, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-mw',
		editForm = document.forms["editform"];

	EditDraftSaving.log('Initializing EditDraftSaving for ' + EDITOR_TYPE);

	function saveDraft() {
		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			draftText: jquery('#wpTextbox1').val(),
			startTime: editForm.wpStarttime.value
		});
	}

	jquery(function () {
		var draftData = EditDraftSaving.readDraft();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {

			// CORE-84: restore "wpStarttime" field value
			if (draftData.startTime) {
				editForm.wpStarttime.value = draftData.startTime;

				// and compare it with the wpEdittime value
				if (draftData.startTime > editForm.wpEdittime.value) {
					jquery.showModal(window.wgPageName, window.mediaWiki.message('edit-draft-edit-conflict').text());
				}
			}

			jquery('#wpTextbox1').val(draftData.draftText);

			EditDraftSaving.onDraftRestore(EDITOR_TYPE);
		}

		// register draft saving function
		setInterval(saveDraft, EditDraftSaving.SAVES_INTERVAL);
	});
});
