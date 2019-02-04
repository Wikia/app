define('EditDraftSaving', ['jquery', 'wikia.log', 'wikia.tracker'], function(jquery, logger, tracker) {

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
			var draftDataJSON = JSON.stringify(draftData);
			localStorage.setItem(
				getDraftKey(),
				draftDataJSON
			);
			log('Stored a draft: ' + draftDataJSON);
		} catch (e) {
			console.log(e);
		}
	}

	/**
	 * Read draft data from local storage
	 * @returns {object}?
	 */
	function readDraft() {
		try {
			var draftData = localStorage.getItem(getDraftKey());
			log('Read a draft: ' + draftData);
			return  JSON.parse(draftData);
		} catch (e) {
			console.log(e);
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
				attr('name', 'wpEditDraftKey').
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
