define('EditDraftSaving', ['jquery', 'wikia.log', 'wikia.tracker'], function(jquery, logger, tracker) {

	// keep in sync with PHP code in EditDraftSavingHooks.class.php file
	var EDIT_DRAFT_KEY_HIDDEN_FIELD = 'wpEditDraftKey';

	// get MediaWiki edit form
	var editForm = jquery('#editform');

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
	 * Track draft restore and show the modal with a message saying what just happened
	 */
	function onDraftRestore(editorType) {
		log('Restored a draft for ' + editorType);

		// Wikia.Tracker:  trackingevent editor-ck/impression/draft-loaded/ [analytics track]
		tracker.track({
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.IMPRESSION,
			category: editorType,
			label: 'draft-loaded'
		});

		jquery.showModal(window.wgPageName, window.mediaWiki.message('edit-draft-loaded').text());

		// bind to editform submit event to track successful edits form draft restore
		editForm.on('submit', function() {
			tracker.track({
				trackingMethod: 'analytics',
				action: tracker.ACTIONS.IMPRESSION,
				category: editorType,
				label: 'draft-publish'
			});
		});
	}

	// store the draft key in the form as a hidden field
	jquery(function () {
		editForm.append(
			jquery('<input>').
				attr('type', 'hidden').
				attr('name', EDIT_DRAFT_KEY_HIDDEN_FIELD).
				attr('value', getDraftKey())
		);
	});

	return {
		SAVES_INTERVAL: 5000, // in [ms]

		log: log,
		onDraftRestore: onDraftRestore,

		// getDraftKey: getDraftKey,
		storeDraft: storeDraft,
		readDraft: readDraft
	}
});
