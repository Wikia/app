/* JavaScript for Drafts extension */

/* Classes */

var wgAjaxSaveDraft = {};

// Fields

wgAjaxSaveDraft.inprogress = false;
wgAjaxSaveDraft.insync = true;
wgAjaxSaveDraft.autosavetimer = null;
wgAjaxSaveDraft.autosavewait = null;

// Actions

wgAjaxSaveDraft.save = function() {
	wgAjaxSaveDraft.call(
		document.editform.wpDraftToken.value,
		document.editform.wpEditToken.value,
		document.editform.wpDraftID.value,
		document.editform.wpDraftTitle.value,
		document.editform.wpSection.value,
		document.editform.wpStarttime.value,
		document.editform.wpEdittime.value,
		document.editform.wpTextbox1.scrollTop,
		document.editform.wpTextbox1.value,
		document.editform.wpSummary.value,
		document.editform.wpMinoredit.checked ? 1 : 0
	);

	// Ensure timer is cleared in case we saved manually before it expired
	clearTimeout( wgAjaxSaveDraft.autosavetimer );
}

wgAjaxSaveDraft.change = function() {
	wgAjaxSaveDraft.insync = false;
	wgAjaxSaveDraft.setControlsUnsaved();

	// Clear if timer is pending
	if( wgAjaxSaveDraft.autosavetimer ) {
		clearTimeout( wgAjaxSaveDraft.autosavetimer );
	}
	// Set timer to save automatically
	if( wgAjaxSaveDraft.autosavewait && wgAjaxSaveDraft.autosavewait > 0 ) {
		wgAjaxSaveDraft.autosavetimer = setTimeout(
			"wgAjaxSaveDraft.save()",
			wgAjaxSaveDraft.autosavewait * 1000
		);
	}
}

wgAjaxSaveDraft.setControlsSaved = function() {
	document.editform.wpDraftSave.disabled = true;
	document.editform.wpDraftSave.value = document.editform.wpMsgSaved.value;
}
wgAjaxSaveDraft.setControlsUnsaved = function() {
	document.editform.wpDraftSave.disabled = false;
	document.editform.wpDraftSave.value = document.editform.wpMsgSaveDraft.value;
}
wgAjaxSaveDraft.setControlsError = function() {
	document.editform.wpDraftSave.disabled = true;
	document.editform.wpDraftSave.value = document.editform.wpMsgError.value;
}

// Events

wgAjaxSaveDraft.onLoad = function() {
	// Check to see that the form and controls exist
	if ( document.editform && document.editform.wpDraftSave ) {
		// Handle saving
		addHandler(document.editform.wpDraftSave, 'click', wgAjaxSaveDraft.save);
		
		// Detect changes
		addHandler(document.editform.wpTextbox1, 'keypress', wgAjaxSaveDraft.change);
		addHandler(document.editform.wpTextbox1, 'paste', wgAjaxSaveDraft.change);
		addHandler(document.editform.wpTextbox1, 'cut', wgAjaxSaveDraft.change);
		addHandler(document.editform.wpSummary, 'keypress', wgAjaxSaveDraft.change);
		addHandler(document.editform.wpSummary, 'paste', wgAjaxSaveDraft.change);
		addHandler(document.editform.wpSummary, 'cut', wgAjaxSaveDraft.change);
		addHandler(document.editform.wpMinoredit, 'change', wgAjaxSaveDraft.change);
	
		// Use the configured autosave wait time
		wgAjaxSaveDraft.autosavewait = document.editform.wpDraftAutoSaveWait.value;
	}
}

wgAjaxSaveDraft.call = function( dtoken, etoken, id, title, section, starttime, edittime, scrolltop, text, summary, minoredit ) {
	// If in progress, exit now
	if( wgAjaxSaveDraft.inprogress )
		return;

	// Otherwise, declare we are now in progress
	wgAjaxSaveDraft.inprogress = true;

	// Perform Ajax call
	var old = sajax_request_type;
	sajax_request_type = "POST";
	sajax_do_call(
		"DraftHooks::AjaxSave",
		[ dtoken, etoken, id, title, section, starttime, edittime, scrolltop, text, summary, minoredit ],
		wgAjaxSaveDraft.processResult
	);
	sajax_request_type = old;

	// Reallow request if it is not done in 2 seconds
	wgAjaxSaveDraft.timeoutID = window.setTimeout( function() {
		wgAjaxSaveDraft.inprogress = false;
	}, 2000 );
}

wgAjaxSaveDraft.processResult = function( request ) {
	// Change UI state
	if( request.responseText > -1 ) {
		wgAjaxSaveDraft.setControlsSaved();
		document.editform.wpDraftID.value = request.responseText;
	} else {
		wgAjaxSaveDraft.setControlsError();
	}

	// Change object state
	wgAjaxSaveDraft.inprogress = false;
}

hookEvent( "load", wgAjaxSaveDraft.onLoad );
