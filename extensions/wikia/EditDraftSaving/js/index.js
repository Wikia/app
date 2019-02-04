define('EditDraftSaving', ['jquery', 'wikia.log', 'wikia.tracker'], function(jquery, logger, tracker) {

	// keep in sync with PHP code in EditDraftSavingHooks.class.php file
	var EDIT_DRAFT_KEY_HIDDEN_FIELD = 'wpEditDraftKey';

	/**
	 * @param msg {string}
	 */
	function log(msg) {
		logger(msg, logger.levels.info, 'EditDraftSaving');
	}

	/**
	 * Get a key that will be used by local storage when saving a draft
	 * @returns {string}
	 */
	function getDraftKey() {
		return window.wgPageName + '-draft';
	}

	/**
	 * Save a draft data to local storage
	 * @param draftData {object}
	 */
	function storeDraft(draftData) {
		try {
			localStorage.setItem(
				getDraftKey(),
				JSON.stringify(draftData)
			);
			log('Stored a draft');
		} catch (e) {
			console.error(e);
		}
	}

	/**
	 * Read draft data from local storage
	 * @returns {object}?
	 */
	function readDraft() {
		try {
			log('Reading a draft...');
			return JSON.parse(localStorage.getItem(getDraftKey()));
		} catch (e) {
			console.error(e);
			return null;
		}
	}

	/**
	 * Send a tracking beacon when we managed to restore a draft
	 */
	function trackDraftRestore(editorType) {
		log('Restored a draft for ' + editorType);

		// Wikia.Tracker:  trackingevent draft-restore/impression/ckeditor/ [analytics track]
		tracker.track({
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.IMPRESSION,
			category: 'draft-restore',
			label: editorType
		});
	}

	// store the draft key in the form as a hidden field
	jquery(function () {
		jquery('#editform').append(
			jquery('<input>').
				attr('type', 'hidden').
				attr('name', EDIT_DRAFT_KEY_HIDDEN_FIELD).
				attr('value', getDraftKey())
		);
	});

	return {
		SAVES_INTERVAL: 5000, // in [ms]

		log: log,
		trackDraftRestore: trackDraftRestore,

		// getDraftKey: getDraftKey,
		storeDraft: storeDraft,
		readDraft: readDraft
	}
});
