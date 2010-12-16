/* -- (c) Aaron Schulz 2008 */

/* Every time you change this JS please bump $wgFeedbackStyleVersion in ReaderFeedback.php */

/*
* Update colors when select changes (Opera already does this).
*/
function updateFeedbackForm() {
	var allzero = true;
	var ratingform = document.getElementById('mw-feedbackselects');
	if( !ratingform ) return;
	for( tag in wgFeedbackParams.tags ) {
		var controlName = "wp" + tag;
		var levels = document.getElementsByName(controlName);
		var selectedlevel = 2; // default
		if( levels[0].nodeName == 'SELECT' ) {
			selectedlevel = levels[0].selectedIndex;
			// Update color. Opera does this already, and doing so
			// seems to kill custom pretty opera skin form styling.
			if( navigator.appName != 'Opera') {
				levels[0].className = 'rfb-rating-option-' + (4 - selectedlevel);
			}
			if( selectedlevel <= 4 ) {
				allzero = false;
			}
		}
	}
	var submit = document.getElementById('submitfeedback');
	submit.disabled = allzero ? 'disabled' : '';
}

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
	sajax_do_call( "ReaderFeedbackPage::AjaxReview", args, wgAjaxFeedback.processResult );
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
