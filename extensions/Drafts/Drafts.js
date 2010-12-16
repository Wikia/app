/* JavaScript for Drafts extension */

function Draft() {
	
	/* Private Members */
	
	// Reference to object's self
	var self = this;
	// Configuration settings
	var configuration = null;
	// Language specific messages
	var messages = null;
	// State of the draft as it pertains to asynchronous saving
	var state = 'unchanged';
	// Timer handle for auto-saving
	var timer = null;
	// Reference to edit form draft is being edited with
	var form = null;
	
	/* Functions */
	
	/**
	 * Sets the state of the draft
	 * @param {String} newState
	 */
	this.setState = function(
		newState
	) {
		// Stores state information
		state = newState;
		// Updates UI elements
		switch ( state ) {
			case 'unchanged':
				form.wpDraftSave.disabled = true;
				form.wpDraftSave.value = messages.saveDraft;
				break;
			case 'changed':
				form.wpDraftSave.disabled = false;
				form.wpDraftSave.value = messages.saveDraft;
				break;
			case 'saved':
				form.wpDraftSave.disabled = true;
				form.wpDraftSave.value = messages.saved;
				break;
			case 'saving':
				form.wpDraftSave.disabled = true;
				form.wpDraftSave.value = messages.saving;
				break;
			case 'error':
				form.wpDraftSave.disabled = true;
				form.wpDraftSave.value = messages.error;
				break;
			default: break;
		}
	}
	
	/**
	 * Gets the state of the draft
	 */
	this.getState = function() {
		return state;
	}
	
	/**
	 * Sends draft data to server to be saved
	 */
	this.save = function() {
		// Checks if a save is already taking place
		if ( state == 'saving' ) {
			// Exits function immediately
			return;
		}
		// Sets state to saving
		self.setState( 'saving' );
		// Saves current request type
		var oldRequestType = sajax_request_type;
		// Changes request type to post
		sajax_request_type = "POST";
		// Performs asynchronous save on server
		sajax_do_call(
			"DraftHooks::save",
			[
				form.wpDraftToken.value,
				form.wpEditToken.value,
				form.wpDraftID.value,
				form.wpDraftTitle.value,
				form.wpSection.value,
				form.wpStarttime.value,
				form.wpEdittime.value,
				form.wpTextbox1.scrollTop,
				form.wpTextbox1.value,
				form.wpSummary.value,
				form.wpMinoredit.checked ? 1 : 0
			],
			new Function( "request", "wgDraft.respond( request )" )
		);
		// Restores current request type
		sajax_request_type = oldRequestType;
		// Re-allow request if it is not done in 10 seconds
		self.timeoutID = window.setTimeout(
			"wgDraft.setState( 'changed' )", 10000
		);
		// Ensure timer is cleared in case we saved manually before it expired
		clearTimeout( timer );
	}

	/**
	 * Updates the user interface to represent being out of sync with the server
	 */
	this.change = function() {
		// Sets state to changed
		self.setState( 'changed' );
		// Checks if timer is pending
		if ( timer ) {
			// Clears pending timer
			clearTimeout( timer );
		}
		// Checks if auto-save wait time was set, and that it's greater than 0
		if ( configuration.autoSaveWait && configuration.autoSaveWait > 0 ) {
			// Sets timer to save automatically after a period of time
			timer = setTimeout(
				"wgDraft.save()", configuration.autoSaveWait * 1000
			);
		}
	}
	
	/**
	 * Initializes the user interface
	 */
	this.initialize = function() {
		// Cache edit form reference
		form = document.editform;
		// Check to see that the form and controls exist
		if ( form && form.wpDraftSave ) {
			// Handle manual draft saving through clicking the save draft button
			addHandler( form.wpDraftSave, 'click', self.save );
			// Handle keeping track of state by watching for changes to fields
			addHandler( form.wpTextbox1, 'keypress', self.change );
			addHandler( form.wpTextbox1, 'keyup', self.change );
			addHandler( form.wpTextbox1, 'keydown', self.change );
			addHandler( form.wpTextbox1, 'paste', self.change );
			addHandler( form.wpTextbox1, 'cut', self.change );
			addHandler( form.wpSummary, 'keypress', self.change );
			addHandler( form.wpSummary, 'keyup', self.change );
			addHandler( form.wpSummary, 'keydown', self.change );
			addHandler( form.wpSummary, 'paste', self.change );
			addHandler( form.wpSummary, 'cut', self.change );
			addHandler( form.wpMinoredit, 'change', self.change );
			// Gets configured specific values
			configuration = {
				autoSaveWait: form.wpDraftAutoSaveWait.value,
				autoSaveTimeout: form.wpDraftAutoSaveTimeout.value
			};
			// Gets language-specific messages
			messages = {
				saveDraft: form.wpMsgSaveDraft.value,
				saving: form.wpMsgSaving.value,
				saved: form.wpMsgSaved.value,
				error: form.wpMsgError.value
			};
		}
	}

	/**
	 * Responds to the server after a save request has been handled
	 * @param {Object} request
	 */
	this.respond = function(
		request
	) {
		// Checks that an error did not occur
		if ( request.responseText > -1 ) {
			// Changes state to saved
			self.setState( 'saved' );
			// Gets id of newly inserted draft (or updates if it already exists)
			// and stores it in a hidden form field
			form.wpDraftID.value = request.responseText;
		} else {
			// Changes state to error
			self.setState( 'error' );
		}
	}
}
// Instantiates a draft object
var wgDraft = new Draft();
// Registers hooks
hookEvent( "load", wgDraft.initialize );
