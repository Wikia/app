//see http://jamazon.co.uk/web/2008/07/21/jquerygetscript-does-not-cache
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

// show modal dialog with content fetched via AJAX request
jQuery.fn.getModal = function(url, id, options) {
	// get modal plugin
	$.loadModalJS(function() {
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

// show modal popup with static title and content provided
jQuery.showModal = function(title, content, options) {
	options = (typeof options != 'object') ? {} : options;

	$.loadModalJS(function() {
		$().log('showModal: plugin loaded');

		var dialog = $('<div class="modalContent">').html(content).attr('title', title);

		$("#positioned_elements").append(dialog);

		// fire callbackBefore if provided
		if (typeof options.callbackBefore == 'function') {
			options.callbackBefore();
		}

		dialog.makeModal(options);

		// fire callback if provided
		if (typeof options.callback == 'function') {
			options.callback();
		}
	});
}

// show modal version of confirm()
jQuery['confirm'] = function(options) {
	// init options
	options = (typeof options != 'object') ? {} : options;
	options.id = 'WikiaConfirm';

	$.loadModalJS(function() {
		$().log('confirm: plugin loaded');

		var html = '<p>' + (options.content || '') + '</p>' +
			'<div class="neutral modalToolbar">' +
			'<a id="WikiaConfirmCancel" class="wikia-button secondary">' + (options.cancelMsg || 'Cancel') + '</a>' +
			'<a id="WikiaConfirmOk" class="wikia-button">' + (options.okMsg || 'Ok') + '</a>' +
			'</div>';

		var dialog = $('<div>').
			appendTo('#positioned_elements').
			html(html).
			attr('title', options.title || '');

		// fire callbackBefore if provided
		if (typeof options.callbackBefore == 'function') {
			options.callbackBefore();
		}

		// handle clicks on Ok
		$('#WikiaConfirmOk').click(function() {
			 $('#WikiaConfirm').closeModal();

			 // try to call callback when Ok is pressed
			 if (typeof options.onOk == 'function') {
				 options.onOk();
			 }
		});

		// handle clicks on Cancel
		$('#WikiaConfirmCancel').click(function() {
			$('#WikiaConfirm').closeModal();
		});

		dialog.makeModal(options);

		// fire callback if provided
		if (typeof options.callback == 'function') {
			options.callback();
		}
	});
}

/* example of usage
$.showCustomModal('title', '<b>content</b>',
	{buttons: [
		{id:'ok', default:true, message:'OK', handler:function(){alert('ok');}},
		{id:'cancel', message:'Cancel', handler:function(){alert('cancel');}}
	]}
);
*/
// show modal popup with title, content and set ot buttons
jQuery.showCustomModal = function(title, content, options) {
	options = (typeof options != 'object') ? {} : options;

	$.loadModalJS(function() {
		$().log('showCustomModal: plugin loaded');

		var buttons = '';
		if (options.buttons) {
			buttons = $('<div class="neutral modalToolbar"></div>');
			for (var buttonNo = 0; buttonNo < options.buttons.length; buttonNo++) {
				var button = '<a id="' + options.buttons[buttonNo].id + '" class="wikia-button' + (options.buttons[buttonNo].defaultButton ? '' : ' secondary') + '">' + options.buttons[buttonNo].message + '</a>';
				$(button).bind('click', options.buttons[buttonNo].handler).appendTo(buttons);
			}
		}

		var dialog = $('<div>').html(content).attr('title', title).append(buttons);

		$("#positioned_elements").append(dialog);

		// fire callbackBefore if provided
		if (typeof options.callbackBefore == 'function') {
			options.callbackBefore();
		}

		dialog.makeModal(options);

		// fire callback if provided
		if (typeof options.callback == 'function') {
			options.callback();
		}
	});
}

//load jquery.wikia.modal if necessary and run callback function
jQuery.loadModalJS = function(callback) {
	//check if we already loaded jquery.wikia.modal.js
	if (typeof $().makeModal != 'function') {
		$().log('modal plugin loading...');
		$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, callback);
	} else {
		callback();
	}
}

// send POST request and parse returned JSON
jQuery.postJSON = function(u, d, callback) {
	return jQuery.post(u, d, callback, "json");
}

// load YUI if not yet loaded
$.loadYUI = function(callback) {
	if (typeof YAHOO == 'undefined') {
		if ( (typeof isYUIloading != 'undefined') && isYUIloading ) {
			$().log('YUI: is loading add call back to line');
			loadYUICallBackFIFO.push(callback);
			return true;
		}

		isYUIloading = true;
		loadYUICallBackFIFO = new Array();
		loadYUICallBackFIFO.push(callback)

		$().log('YUI: loading on-demand');

		var YUIloadingCallBack = function(){
			for (var i = 0; i < loadYUICallBackFIFO.length; i++ ){
				loadYUICallBackFIFO[i]();
			}
			loadYUICallBackFIFO = null;
		};
		$().log('YUI: rq start ');

		$.getScript(wgYUIPackageURL, YUIloadingCallBack);
	} else {
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
 * Returns the value of param from url.
 * @method getUrlVal
 * @return mixed or "".
 */


$.getUrlVal = function ( name )
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return "";
	else
		return results[1];
}

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

//see http://jquery-howto.blogspot.com/2009/09/get-url-parameters-values-with-jquery.html
$.extend({
	getUrlVars: function(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	},
	getUrlVar: function(name){
		return $.getUrlVars()[name];
	}
});

// see http://www.texotela.co.uk/code/jquery/reverse/
jQuery.fn.reverse = function() {
	return this.pushStack(this.get().reverse(), arguments);
};
