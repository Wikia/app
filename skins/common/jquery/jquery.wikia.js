//@see http://jamazon.co.uk/web/2008/07/21/jquerygetscript-does-not-cache
$.ajaxSetup({cache: true});

jQuery.fn.log = function (msg, group) {
	if (typeof console != 'undefined') {
		if (group) {
			// nice formatting of objects with group prefix
			console.log((typeof msg != 'object' ? '%s: %s' : '%s: %o'), group, msg);
		}
		else {
			console.log(msg);
		}
	}
	else if (typeof opera != 'undefined') {
		opera.postError((group ? (group + ': ') : '') + msg);
	}
	return this;
};

jQuery.fn.exists = function() {
	return this.length > 0;
}

jQuery.fn.getModal = function(url, id, options) {
	// get modal plugin
	$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
		$().log('getModal: plugin loaded');

		// get modal content via AJAX
		$.get(url, function(html) {
			$("#positioned_elements").append(html);

			// fire callbackBefore if provided
			if (typeof options == 'object' && typeof options.callbackBefore == 'function') {
				options.callbackBefore();
			}

			// makeModal() if requested
			if (typeof id == 'string') {
				$(id).makeModal(options);
				$().log('getModal: ' + id + ' modal made');
			}

			// fire callback if provided
			if (typeof options == 'object' && typeof options.callback == 'function') {
				options.callback();
			}
		});
	});
}

// load YUI if not yet loaded
$.loadYUI = function(callback) {
	if (typeof YAHOO == 'undefined') {
		$().log('YUI: loading on-demand');
		$.getScript(wgExtensionsPath + '/wikia/StaticChute/?type=js&packages=yui&cb=' + wgStyleVersion, callback);
	}
	else {
		$().log('YUI: already loaded');
		callback();
	}
}

// RT #19369: TabView
$(function() {
	if (typeof window.__FlyTabs == 'undefined') {
		return;
	}

	$.getScript(stylepath + '/common/jquery/jquery.flytabs.js?' + wgStyleVersion, function() {
		$().log(window.__FlyTabs, 'TabView');

		for(t=0; t<window.__FlyTabs.length; t++) {
			var tab = window.__FlyTabs[t];

			$('#flytabs_' + tab.id).flyTabs.config({align: 'none', effect: 'no'});

			for (s=0; s<tab.options.length; s++) {
				$('#flytabs_' + tab.id).flyTabs.addTab(tab.options[s]);
			}
		}
	});
});

/*
Copyright (c) 2008, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.net/yui/license.txt
version: 2.5.2
*/

/**
 * Returns the current height of the viewport.
 * @method getViewportHeight
 * @return {Int} The height of the viewable area of the page (excludes scrollbars).
 */
$.getViewportHeight = function() {
    var height = self.innerHeight; // Safari, Opera
    var mode = document.compatMode;

    if ( (mode || $.browser.msie) && !$.browser.opera ) { // IE, Gecko
	height = (mode == 'CSS1Compat') ?
		document.documentElement.clientHeight : // Standards
		document.body.clientHeight; // Quirks
    }

    return height;
};

/**
 * Returns the current width of the viewport.
 * @method getViewportWidth
 * @return {Int} The width of the viewable area of the page (excludes scrollbars).
 */

$.getViewportWidth = function() {
    var width = self.innerWidth;  // Safari
    var mode = document.compatMode;

    if (mode || $.browser.msie) { // IE, Gecko, Opera
	width = (mode == 'CSS1Compat') ?
		document.documentElement.clientWidth : // Standards
		document.body.clientWidth; // Quirks
    }
    return width;
};

/**
* Finds the event in the window object, the caller's arguments, or
* in the arguments of another method in the callstack.  This is
* executed automatically for events registered through the event
* manager, so the implementer should not normally need to execute
* this function at all.
* @method getEvent
* @param {Event} e the event parameter from the handler
* @param {HTMLElement} boundEl the element the listener is attached to
* @return {Event} the event
* @static
*/
$.getEvent = function(e, boundEl) {
	var ev = e || window.event;

	if (!ev) {
		var c = this.getEvent.caller;
		while (c) {
			ev = c.arguments[0];
			if (ev && Event == ev.constructor) {
				break;
			}
			c = c.caller;
		}
	}

	return ev;
};
