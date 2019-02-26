require(['jquery', 'EditDraftSaving'], function ($, EditDraftSaving) {
	var EDITOR_TYPE = 'editor-mw',
		editForm = document.forms["editform"];

	EditDraftSaving.log('Initializing EditDraftSaving for ' + EDITOR_TYPE);

	function getContent() {
		return $('#wpTextbox1').val();
	}

	function saveDraft() {
		EditDraftSaving.storeDraft({
			editor: EDITOR_TYPE,
			draftText: getContent(),
			startTime: editForm.wpStarttime.value
		});
	}

	$(function () {
		EditDraftSaving.storeOriginalContent(getContent());

		var draftData = EditDraftSaving.readDraft();

		// make sure that this draft comes from this editor
		if (draftData && draftData.editor === EDITOR_TYPE) {
			$('#wpTextbox1').val(draftData.draftText);

			EditDraftSaving.checkDraftConflict(draftData.startTime, EDITOR_TYPE);
			EditDraftSaving.onDraftRestore(
				EDITOR_TYPE,
				// selector of an element to append a notification bar to
				'#EditPageEditorWrapper',
				// function to be called when the draft is discarded,
				// callback will get the original editor content
				function(content) {
					$('#wpTextbox1').val(content);
				}
			);
		}

		// register draft saving function that binds to change event
		// @see https://developer.mozilla.org/en-US/docs/Web/Events/change
		var draftSavingTimeout;

		$('#wpTextbox1').on('input change', function() {
			EditDraftSaving.log('Editor content has changed');

			// wait a second after user stops making changes
			if (draftSavingTimeout) clearTimeout(draftSavingTimeout);
			draftSavingTimeout = setTimeout(saveDraft, 1000);
		});
	});
});
