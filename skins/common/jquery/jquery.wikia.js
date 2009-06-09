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
