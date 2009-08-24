/* -- (c) Aaron Schulz, Daniel Arnold 2008 */

/* Every time you change this JS please bump $wgFlaggedRevStyleVersion in FlaggedRevs.php */

/* Hide rating clutter */
function enable_showhide() {
	var toggle = document.getElementById('mw-revisiontoggle');
	if( !toggle ) return;
	toggle.style.display = 'inline';
	var ratings = document.getElementById('mw-revisionratings');
	if( !ratings ) return;
	ratings.style.display = 'none';
}

/* Toggles ratings */
function toggleRevRatings() {
	var ratings = document.getElementById('mw-revisionratings');
	if( !ratings ) return;
	if( ratings.style.display == 'none' ) {
		ratings.style.display = 'inline';
	} else {
		ratings.style.display = 'none';
	}
}

/*
* a) Disable submit in case of invalid input.
* b) Update colors when select changes (Opera already does this).
* c) Also remove comment box clutter in case of invalid input.
*/
function updateRatingForm() {
	var ratingform = document.getElementById('mw-ratingselects');
	if( !ratingform ) return;
	var disabled = document.getElementById('fr-rating-controls-disabled');
	if( disabled ) return;

	var quality = true;
	var allzero = true;
	var somezero = false;

	for( tag in wgFlaggedRevsParams.tags ) {
		var controlName = "wp" + tag;
		var levels = document.getElementsByName(controlName);
		var selectedlevel = 0; // default

		if( levels[0].nodeName == 'SELECT' ) {
			selectedlevel = levels[0].selectedIndex;
			// Update color. Opera does this already, and doing so
			// seems to kill custom pretty opera skin form styling.
			if( navigator.appName != 'Opera') {
				levels[0].className = 'fr-rating-option-' + selectedlevel;
			}
		} else if( levels[0].type == 'radio' ) {
			for( i = 0; i < levels.length; i++ ) {
				if( levels[i].checked ) {
					selectedlevel = i;
					break;
				}
			}
		} else if( levels[0].type == 'checkbox' ) {
			selectedlevel = (levels[0].checked) ? 1: 0;
		} else {
			return; // error: should not happen
		}

		// Get quality level for this tag
		qualityLevel = wgFlaggedRevsParams.tags[tag];

		if( selectedlevel < qualityLevel ) {
			quality = false; // not a quality review
		}
		if( selectedlevel > 0 ) {
			allzero = false;
		} else {
			somezero = true;
		}
	}
	// Show note box only for quality revs
	var notebox = document.getElementById('mw-notebox');
	if( notebox ) {
		notebox.style.display = quality ? 'inline' : 'none';
	}
	// If only a few levels are zero, don't show submit link
	var submit = document.getElementById('submitreview');
	submit.disabled = ( somezero && !allzero ) ? 'disabled' : '';
	// Clear note box data if not shown
	var notes = document.getElementById('wpNotes');
	if( notes ) {
		notes.value = quality ? notes.value : '';
	}
}

/*
* Update colors when select changes (Opera already does this).
*/
function updateFeedbackForm() {
	var allzero = true;
	var ratingform = document.getElementById('mw-feedbackselects');
	if( !ratingform ) return;
	for( tag in wgFlaggedRevsParams2.tags ) {
		var controlName = "wp" + tag;
		var levels = document.getElementsByName(controlName);
		var selectedlevel = 2; // default
		if( levels[0].nodeName == 'SELECT' ) {
			selectedlevel = levels[0].selectedIndex;
			// Update color. Opera does this already, and doing so
			// seems to kill custom pretty opera skin form styling.
			if( navigator.appName != 'Opera') {
				levels[0].className = 'fr-rating-option-' + (4 - selectedlevel);
			}
			if( selectedlevel <= 4 ) {
				allzero = false;
			}
		}
	}
	var submit = document.getElementById('submitfeedback');
	submit.disabled = allzero ? 'disabled' : '';
}

addOnloadHook(enable_showhide);
addOnloadHook(updateRatingForm);
addOnloadHook(updateFeedbackForm);

// dependencies:
// * ajax.js:
  /*extern sajax_init_object, sajax_do_call */
// * wikibits.js:
  /*extern hookEvent, jsMsg */

// These should have been initialized in the generated js
if( typeof wgAjaxFeedback === "undefined" || !wgAjaxFeedback ) {
	wgAjaxFeedback = {
		sendingMsg: "Submitting...",
		sentMsg: "Thank you!"
	};
}

wgAjaxFeedback.supported = true; // supported on current page and by browser
wgAjaxFeedback.inprogress = false; // ajax request in progress
wgAjaxFeedback.timeoutID = null; // see wgAjaxFeedback.ajaxCall

wgAjaxFeedback.ajaxCall = function() {
	if( !wgAjaxFeedback.supported ) {
		return true;
	} else if( wgAjaxFeedback.inprogress ) {
		return false;
	}
	if( !wfSupportsAjax() ) {
		// Lazy initialization so we don't toss up
		// ActiveX warnings on initial page load
		// for IE 6 users with security settings.
		wgAjaxFeedback.supported = false;
		return true;
	}
	var form = document.getElementById("mw-feedbackform");
	var submit = document.getElementById("submitfeedback");
	if( !form || !submit ) {
		return false;
	}
	wgAjaxFeedback.inprogress = true;
	submit.disabled = "disabled";
	submit.value = wgAjaxFeedback.sendingMsg;
	// Build up arguments
	var args = [];
	var inputs = form.getElementsByTagName("input");
	for( var i=0; i < inputs.length; i++) {
		// Ignore some useless items...
		if( inputs[i].name != "title" && inputs[i].type != "submit" ) {
			args.push( inputs[i].name + "|" + inputs[i].value );
		}
	}
	var selects = form.getElementsByTagName("select");
	for( var i=0; i < selects.length; i++) {
		// Get the selected tag level...
		if( selects[i].selectedIndex >= 0 ) {
			var soption = selects[i].getElementsByTagName("option")[selects[i].selectedIndex];
			args.push( selects[i].name + "|" + soption.value );
		}
		selects[i].disabled = "disabled";
	}
	// Send!
	sajax_do_call( "ReaderFeedback::AjaxReview", args, wgAjaxFeedback.processResult );
	// If the request isn't done in 10 seconds, allow user to try again
	wgAjaxFeedback.timeoutID = window.setTimeout(
		function() { wgAjaxFeedback.inprogress = false; wgAjaxFeedback.unlockForm(); },
		10000
	);
	return false;
};

wgAjaxFeedback.unlockForm = function() {
	var form = document.getElementById("mw-feedbackform");
	var submit = document.getElementById("submitfeedback");
	if( !form || !submit ) {
		return false;
	}
	submit.disabled = "";
	var selects = form.getElementsByTagName("select");
	for( var i=0; i < selects.length; i++) {
		selects[i].disabled = "";
	}
};

wgAjaxFeedback.processResult = function(request) {
	if( !wgAjaxFeedback.supported ) {
		return;
	}
	var response = request.responseText;
	if( msg = response.substr(6) ) {
		jsMsg( msg, 'feedback' );
		window.scroll(0,0);
	}
	wgAjaxFeedback.inprogress = false;
	if( wgAjaxFeedback.timeoutID ) {
		window.clearTimeout(wgAjaxFeedback.timeoutID);
	}
	var submit = document.getElementById("submitfeedback");
	if( submit ) {
		submit.value = wgAjaxFeedback.sentMsg;
	}
};

wgAjaxFeedback.onLoad = function() {
	var submit = document.getElementById("submitfeedback");
	if( submit ) {
		submit.onclick = wgAjaxFeedback.ajaxCall;
	}
};

hookEvent("load", wgAjaxFeedback.onLoad);

// These should have been initialized in the generated js
if( typeof wgAjaxReview === "undefined" || !wgAjaxReview ) {
	wgAjaxReview = {
		sendingMsg: "Submitting...",
		sentMsg: "Submitted",
		actioncomplete: "Action complete"
	};
}

wgAjaxReview.supported = true; // supported on current page and by browser
wgAjaxReview.inprogress = false; // ajax request in progress
wgAjaxReview.timeoutID = null; // see wgAjaxFeedback.ajaxCall

wgAjaxReview.ajaxCall = function() {
	if( !wgAjaxReview.supported ) {
		return true;
	} else if( wgAjaxReview.inprogress ) {
		return false;
	}
	if( !wfSupportsAjax() ) {
		// Lazy initialization so we don't toss up
		// ActiveX warnings on initial page load
		// for IE 6 users with security settings.
		wgAjaxReview.supported = false;
		return true;
	}
	var form = document.getElementById("mw-reviewform");
	var notes = document.getElementById("wpNotes");
	var reason = document.getElementById("wpReason");
	if( !form ) {
		return false;
	}
	wgAjaxReview.inprogress = true;
	// Build up arguments
	var args = [];
	var inputs = form.getElementsByTagName("input");
	for( var i=0; i < inputs.length; i++) {
		// Different input types may occur depending on tags...
		if( inputs[i].name == "title" || inputs[i].name == "action" ) {
			// No need to send these...
		} else if( inputs[i].type == "submit" ) {
			inputs[i].value = wgAjaxReview.sendingMsg;
		} else if( inputs[i].type == "checkbox" ) {
			args.push( inputs[i].name + "|" + (inputs[i].checked ? 1 : 0) );
		} else if( inputs[i].type != "radio" || inputs[i].checked ) {
			args.push( inputs[i].name + "|" + inputs[i].value );
		}
		inputs[i].disabled = "disabled";
	}
	if( notes ) {
		args.push( notes.name + "|" + notes.value );
		notes.disabled = "disabled";
	}
	var selects = form.getElementsByTagName("select");
	for( var i=0; i < selects.length; i++) {
		// Get the selected tag level...
		if( selects[i].selectedIndex >= 0 ) {
			var soption = selects[i].getElementsByTagName("option")[selects[i].selectedIndex];
			args.push( selects[i].name + "|" + soption.value );
		}
		selects[i].disabled = "disabled";
	}
	// Send!
	var old = sajax_request_type;
	sajax_request_type = "POST";
	sajax_do_call( "RevisionReview::AjaxReview", args, wgAjaxReview.processResult );
	sajax_request_type = old;
	// If the request isn't done in 30 seconds, allow user to try again
	wgAjaxReview.timeoutID = window.setTimeout(
		function() { wgAjaxReview.inprogress = false; wgAjaxReview.unlockForm(); },
		30000
	);
	return false;
};

wgAjaxReview.unlockForm = function() {
	var form = document.getElementById("mw-reviewform");
	var submit = document.getElementById("submitreview");
	var notes = document.getElementById("wpNotes");
	var reason = document.getElementById("wpReason");
	if( !form || !submit ) {
		return false;
	}
	submit.disabled = "";
	var inputs = form.getElementsByTagName("input");
	for( var i=0; i < inputs.length; i++) {
		inputs[i].disabled = "";
	}
	if( notes ) {
		notes.disabled = "";
	}
	if( reason ) {
		reason.disabled = "";
	}
	var selects = form.getElementsByTagName("select");
	for( var i=0; i < selects.length; i++) {
		selects[i].disabled = "";
	}
};

wgAjaxReview.processResult = function(request) {
	if( !wgAjaxReview.supported ) {
		return;
	}
	var response = request.responseText;
	if( msg = response.substr(6) ) {
		jsMsg( msg, 'review' );
		window.scroll(0,0);
	}
	wgAjaxReview.inprogress = false;
	if( wgAjaxReview.timeoutID ) {
		window.clearTimeout(wgAjaxReview.timeoutID);
	}
	var submit = document.getElementById("submitreview");
	if( submit ) {
		submit.value = wgAjaxReview.sentMsg;
	}
	if( response.indexOf('<suc#>') == 0 ) {
		wgAjaxReview.unlockForm();
	}
	document.title = wgAjaxReview.actioncomplete;
};

wgAjaxReview.onLoad = function() {
	var submit = document.getElementById("submitreview");
	if( submit ) {
		submit.onclick = wgAjaxReview.ajaxCall;
	}
};

hookEvent("load", wgAjaxReview.onLoad);
