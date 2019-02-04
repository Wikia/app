define('EditDraftSaving', ['jquery', 'wikia.log'], function(jquery, logger) {

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
			log('Storing a draft...');

			localStorage.setItem(
				getDraftKey(),
				JSON.stringify(draftData)
			);
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
			log('Reading a draft...');

			return JSON.parse(
				localStorage.getItem(getDraftKey())
			);
		} catch (e) {
			console.log(e);
			return null;
		}
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
		// getDraftKey: getDraftKey,
		storeDraft: storeDraft,
		readDraft: readDraft
	}
});
