define('EditDraftSaving', ['jquery', 'wikia.log', 'wikia.tracker'], function($, logger, tracker) {

	// keep in sync with PHP code in EditDraftSavingHooks.class.php file
	var EDIT_DRAFT_KEY_HIDDEN_FIELD = 'wpEditDraftKey';

	// get MediaWiki edit form
	var editForm = $('#editform');

	// was draft conflict triggered?
	var inDraftConflict = false;

	// CORE-110 | initial content that will be used when user discards an edit
	var initialContent;

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

	function storeOriginalContent(content) {
		log('Stored original content: ' + content);
		initialContent = content;
	}

	/**
	 * Take edit draft timestamp and check if we're in edit conflict. Handle it accordingly.
	 *
	 * @see CORE-84
	 */
	function checkDraftConflict(draftStartTime, editorType) {
		if (draftStartTime) {
			var wpEdittime = editForm.find('[name="wpEdittime"]').val();

			// restore "wpStarttime" field value in edit form to allow MediaWiki
			// to handle edit conflicts when edit page is submitted
			editForm.find('[name="wpStarttime"]').val(draftStartTime);

			log('Checking conflict - our edit started at "' + draftStartTime + '", ' +
				'the most recent article edit was at "' + wpEdittime + '"');

			// and compare it with the wpEdittime value
			if (draftStartTime < wpEdittime) {
				// Set wpEdittime to a timestamp that is before the current article revision timestamp.
				// This will trigger a condition in EditPage line 1320
				// "# Article exists. Check for edit conflict."
				editForm.find('[name="wpEdittime"]').val(draftStartTime);

				onDraftConflict(editorType);
			}
		}
	}

	/**
	 * Track draft conflict and show the modal with a message saying what just happened
	 */
	function onDraftConflict(editorType) {
		log('Draft conflict for ' + editorType);

		// Wikia.Tracker:  trackingevent editor-ck/impression/draft-conflict/ [analytics track]
		tracker.track({
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.IMPRESSION,
			category: editorType,
			label: 'draft-conflict'
		});

		$.showModal(window.wgPageName, window.mediaWiki.message('edit-draft-edit-conflict').text());

		inDraftConflict = true;
	}

	/**
	 * Track draft restore and show the modal with a message saying what just happened
	 */
	function onDraftRestore(editorType, prependTo, onDismiss) {
		log('Restored a draft for ' + editorType);

		// Wikia.Tracker:  trackingevent editor-ck/impression/draft-loaded/ [analytics track]
		tracker.track({
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.IMPRESSION,
			category: editorType,
			label: 'draft-loaded'
		});

		// CORE-84: in case of a conflict, let's only show the conflict notice
		if (!inDraftConflict) {
			$(prependTo).prepend(
			'<div id="draft-restore-message" class="wds-banner-notification__container">' +
				'<div class="wds-banner-notification wds-message">' +
					'<div class="wds-banner-notification__icon">' +
						'<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">' +
							'<path d="M3 11h10.586l-3.293-3.293a.999.999 0 0 1 0-1.414L13.586 3H3v8zm-1 7a1 1 0 0 1-1-1V1a1 1 0 0 1 2 0h13a1.002 1.002 0 0 1 .707 1.707L12.414 7l4.293 4.293A1 1 0 0 1 16 13H3v4a1 1 0 0 1-1 1z" fill-rule="evenodd"/>' +
						'</svg>' +
					'</div>' +
					'<span class="wds-banner-notification__text">' + window.mediaWiki.message('edit-draft-loaded').text() + '</span>' +
					'<button type="button" id="discard" class="wds-button wds-is-text primary-only">' + window.mediaWiki.message('edit-draft-discard').text().toUpperCase() + '</button>' +
					'<button type="button" id="keep" class="wds-button wds-is-text primary-only">' + window.mediaWiki.message('edit-draft-keep').text().toUpperCase() + '</button>' +
				'</div>'  +
			'</div>'
			);

			var bar = $('#draft-restore-message');

			bar.find('#keep').on('click', function() {
				bar.hide();
			});

			bar.find('#discard').on('click', function() {
				bar.hide();

				log('Dismissing a draft');
				tracker.track({
					trackingMethod: 'analytics',
					action: tracker.ACTIONS.IMPRESSION,
					category: editorType,
					label: 'draft-discard'
				});

				onDismiss(initialContent);
			});
		}

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
	$(function () {
		editForm.append(
			$('<input>').
				attr('type', 'hidden').
				attr('name', EDIT_DRAFT_KEY_HIDDEN_FIELD).
				attr('value', getDraftKey())
		);
	});

	return {
		SAVES_INTERVAL: 5000, // in [ms]

		log: log,

		checkDraftConflict: checkDraftConflict,
		onDraftRestore: onDraftRestore,

		// getDraftKey: getDraftKey,
		storeDraft: storeDraft,
		readDraft: readDraft,

		storeOriginalContent: storeOriginalContent
	}
});
