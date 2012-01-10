jQuery.getSassCommonURL = function(scssFilePath, params) {
	return wgCdnRootUrl + wgAssetsManagerQuery.
		replace('%1$s', 'sass').
		replace('%2$s', scssFilePath).
		replace('%3$s', encodeURIComponent(params || window.sassParams)).
		replace('%4$d', wgStyleVersion);
}

//see http://jamazon.co.uk/web/2008/07/21/jquerygetscript-does-not-cache
$.ajaxSetup({cache: true});

// replace stock function for getting rid of response-speed related issues in Firefox
// @see http://stackoverflow.com/questions/1130921/is-the-callback-on-jquerys-getscript-unreliable-or-am-i-doing-something-wrong
jQuery.getScript = function(url, callback, failureFn) {
	jQuery.ajax({
		type: "GET",
		url: url,
		success: function(xhr) {
			if (typeof callback == 'function') {
				try {
					callback();
				}
				catch(e) {
					// TODO: is this fallback still needed? consider using promise pattern
					eval(xhr);
					callback();
					$().log('eval() fallback applied for ' + url, 'getScript');
				}
			}
		},
		error: typeof failureFn == 'function' ? failureFn : $.noop,
		dataType: 'script'
	});
}

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

		// where should modal be inserted?
		var insertionPoint = (skin == "oasis") ? "body" : "#positioned_elements";

		// get modal content via AJAX
		$.get(url, function(html) {
			$(insertionPoint).append(html);

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
		var dialog, header;

		$().log('showModal: plugin loaded');

		if (skin == 'oasis') {
			header = $('<h1>').html(title);
			dialog = $('<div>').html(content).prepend(header).appendTo('body');
		}
		else {
			dialog = $('<div class="modalContent">').html(content).attr('title', title).appendTo('#positioned_elements');
		}

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

		var insertionPoint = (skin == "oasis") ? "body" : "#positioned_elements";

		var dialog = $('<div>').
			appendTo(insertionPoint).
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
		{id:'ok', defaultButton:true, message:'OK', handler:function(){alert('ok');}},
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

		var insertionPoint = (skin == "oasis") ? "body" : "#positioned_elements";
		$(insertionPoint).append(dialog);

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

// send POST request and parse returned JSON
jQuery.postJSON = function(u, d, callback) {
	return jQuery.post(u, d, callback, "json");
}

// load YUI if not yet loaded
$.loadYUI = function(callback) {
	if (typeof YAHOO == 'undefined') {
		if ( (typeof isYUIloading != 'undefined') && isYUIloading ) {
			$().log('is loading add call back to line', 'YUI');
			loadYUICallBackFIFO.push(callback);
			return true;
		}

		isYUIloading = true;
		loadYUICallBackFIFO = new Array();
		loadYUICallBackFIFO.push(callback)

		$().log('loading on-demand', 'YUI');

		var YUIloadingCallBack = function(){
			$().log('loaded', 'YUI');

			for (var i = 0; i < loadYUICallBackFIFO.length; i++ ){
				loadYUICallBackFIFO[i].caller = $.loadYUI;
				loadYUICallBackFIFO[i]();
			}
			loadYUICallBackFIFO = null;
			isYUIloading = false;
		};
		$().log('rq start', 'YUI');

		$.getScript(wgYUIPackageURL, YUIloadingCallBack);
	} else {
		$().log('already loaded', 'YUI');
		callback();
	}
}

// load various jQuery libraries (if not yet loaded)
$.loadJQueryUI = function(callback) {
	$.loadLibrary('jQueryUI',
		stylepath + '/common/jquery/jquery-ui-1.8.14.custom.js?' + wgStyleVersion,
		typeof jQuery.ui,
		callback
	);
}

$.loadJQueryAutocomplete = function(callback) {
	$.loadLibrary('jQuery Autocomplete',
		stylepath + '/common/jquery/jquery.autocomplete.js?' + wgStyleVersion,
		typeof jQuery.fn.pluginAutocomplete,
		callback
	);
}

$.loadWikiaTooltip = function(callback) {
	$.loadLibrary('Wikia Tooltip',
		stylepath + '/common/jquery/jquery.wikia.tooltip.js?' + wgStyleVersion,
		typeof jQuery.fn.wikiaTooltip,
		callback
	);
}

$.loadJQueryAIM = function(callback) {
	$.loadLibrary('jQuery AIM',
		stylepath + '/common/jquery/jquery.aim.js?' + wgStyleVersion,
		typeof jQuery.AIM,
		callback
	);
}

$.loadModalJS = function(callback) {
	$.loadLibrary('makeModal()',
		stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion,
		typeof jQuery.fn.makeModal,
		callback
	);
}

$.loadGoogleMaps = function(callback) {
	window.onGoogleMapsLoaded = function() {
		delete window.onGoogleMapsLoaded;
		if (typeof callback === 'function') {
			callback();
		}
	}

	$.loadLibrary('GoogleMaps',
		'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
		typeof (window.google && google.maps),
		function() {}
	);

	if (typeof (window.google && google.maps) != 'undefined') {
		callback();
	}
}

$.loadFacebookAPI = function(callback) {
	$.loadLibrary('Facebook API',
		window.fbScript || '//connect.facebook.net/en_US/all.js',
		typeof window.FB,
		callback
	);
}

$.loadGooglePlusAPI = function(callback) {
	$.loadLibrary('Google Plus API',
		'//apis.google.com/js/plusone.js',
		typeof (window.gapi && window.gapi.plusone),
		callback
	);
}

$.loadTwitterAPI = function(callback) {
	$.loadLibrary('Twitter API',
		'//platform.twitter.com/widgets.js',
		typeof (window.twttr && window.twttr.widgets),
		callback
	);
}

/**
 * Loads library file if it's not already loaded and fires callback
 */
$.loadLibrary = function(name, file, typeCheck, callback, failureFn) {
	if (typeCheck === 'undefined') {
		$().log('loading ' + name, 'loadLibrary');

		$.getScript(file, function() {
			$().log(name + ' loaded', 'loadLibrary');

			if (typeof callback == 'function') callback();
		},failureFn);
	}
	else {
		$().log(name + ' already loaded', 'loadLibrary');

		if (typeof callback == 'function') callback();
	}
}

$.chainFn = function(fn1,fn2) {
	var fns = Array.prototype.slice.call(arguments,0);
	return function() {
		var args = Array.prototype.slice.call(arguments,0);
		var ex = {};
		for (var i=0;i<fns.length;i++) {
			if (typeof fns[i] != 'function')
				continue;
			try {
				fns[i].apply(this,args);
			} catch (e) {
				ex[i] = e;
			}
		}
		for (var i=0;i<fns.length;i++) {
			if (ex[i]) throw ex[i];
		}
		return true;
	};
}

$.bulkLoad = function(list,success,failure) {
	var count = list.length, done = 0;
	var successFn = function() { if (done >= 0) done++; if (done >= count) success(); };
	var failureFn = function() { failure(); done = -1; };
	for (var i=0;i<list.length;i++) {
		var el = list[i];
		switch (typeof el) {
		case 'string':
			var fn = {
				'yui': $.loadYUI,
				'autocomplete': $.loadJQueryAutocomplete,
				'tooltip': $.loadWikiaTooltip,
				'jquery-ui': $.loadJQueryUI,
				'jquery-aim': $.loadJQueryAIM,
				'modal': $.loadModalJS
			}[el];
			if (fn) {
				fn.call(window,successFn,failureFn);
				continue;
			}
			$().log(el,'$.bulkLoad(): unknown list item');
			break;
		case 'object':
			var options = $.extend({},el,{
				success: $.chainFn(el.success,successFn),
				error: $.chainFn(el.error,failureFn)
			});
			$.ajax(options);
			break;
		default:
			$().log(el,'$.bulkLoad(): unknown list item');
		}
	}
	return true;
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
	_urlVars: null,
	getUrlVars: function() {
		if($._urlVars === null){
			var hash,
			hashes = window.location.search.slice(window.location.search.indexOf('?') + 1).split('&');
			$._urlVars = {};
			for (var i = 0, j = hashes.length; i < j; i++) {
				hash = hashes[i].split('=');
				$._urlVars[hash[0]] = hash[1];
			}
		}
		return $._urlVars;
	},
	getUrlVar: function(name) {
		return $.getUrlVars()[name];
	}
});

// see http://www.texotela.co.uk/code/jquery/reverse/
jQuery.fn.reverse = function() {
	return this.pushStack(this.get().reverse(), arguments);
};

jQuery.fn.isChrome = function() {
	if ( $.browser.webkit && !$.browser.opera && !$.browser.msie && !$.browser.mozilla ) {
		var userAgent = navigator.userAgent.toLowerCase();
		if ( userAgent.indexOf("chrome") >  -1 ) {
			return true;
		}
	}
	return false;
};

// https://github.com/Modernizr/Modernizr/issues/84
jQuery.fn.isTouchscreen = function() {
	return ('ontouchstart' in window);
}

/**
 * Tests whether first element in current collection is a child of node matching selector provided
 *
 * @return boolean
 * @param string a jQuery selector
 *
 * @author Macbre
 */
$.fn.hasParent = function(selector) {
	// use just the first element from current collection
	return this.first().parent().closest(selector).exists();
}

// macbre: page loading times (onDOMready / window onLoad)
$(function() {
	if (typeof wgNow != 'undefined') {
		var loadTime = (new Date()).getTime() - wgNow.getTime();
		$().log('DOM ready after ' + loadTime + ' ms', window.skin);
	}
});

$(window).bind('load', function() {
	if (typeof wgNow != 'undefined') {
		var loadTime = (new Date()).getTime() - wgNow.getTime();
		$().log('window onload after ' + loadTime + ' ms', window.skin);
	}
});



/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * HTML5 placeholder attribute fallback for HTML5-disabled browsers.
 * A placeholder CSS class should be defined (use the forms mixin in Oasis)
 */
jQuery.fn.placeholder = function() {
	 //feature detection
	var hasNativeSupport = 'placeholder' in document.createElement('input');

	if(!hasNativeSupport){
		this.each(function() {
			var input = $(this);
			var text = input.attr('placeholder');

			if(input.val() == ''){
				input
					.addClass('placeholder')
					.val(text);
			}

			input.focus(function(){
				if(input.val() == text){
					input.val('');
				}

				input.removeClass('placeholder');
			});

			input.blur(function(){
				if(input.val() == ''){
					input
						.addClass('placeholder')
						.val(text);
				}
			});

			//clear the field is a submit event is fired somewhere around here
			input.closest('form').submit(function(){
				if(input.val() == text){
					input.val('');
				}
			});
		});
	}
}

$(function() {
	$('input[placeholder], textarea[placeholder]').placeholder();
});

/**
 * @author Marcin Maciejewski <marcin@wikia-inc.com>
 *
 * Plugin for easy creating Ajax Loading visualization.
 * after using it selected elements content will apply proper css class
 * and in the middle of it throbber will be displayed.
 */
jQuery.fn.startThrobbing = function() {
	this.append('<div id="wikiaThrobber"></div>');
}
jQuery.fn.stopThrobbing = function() {
	this.find('#wikiaThrobber').remove();
}

$.htmlentities = function ( s ) {
	return String(s).replace(/\&/g,'&'+'amp;').replace(/</g,'&'+'lt;')
    	.replace(/>/g,'&'+'gt;').replace(/\'/g,'&'+'apos;').replace(/\"/g,'&'+'quot;');
}

$.extend({
	createClass: function (sc,o) {
//		$().log(sc,'createClass-superclass');
//		$().log(o,'createClass-overrides');
		var constructor = o.constructor;
		if (typeof constructor != 'function' || constructor == Object.prototype.constructor) {
			constructor = function(){sc.apply(this,arguments);};
//			$().log('constructor created','createClass');
		}
		var bc = constructor;
		var f = function() {};
		f.prototype = sc.prototype || {};
		bc.prototype = new f();

		// macbre: support static members
		if (typeof o.statics == 'object') {
			bc = $.extend(bc, o.statics);
			delete o.statics;
		}

		for (var m in o)
			bc.prototype[m] = o[m];
		bc.prototype.constructor = bc;
		bc.superclass = sc.prototype;
		return bc;
	}
});

$.extend({
	proxyBind: function (fn,thisObject,baseArgs) {
		return function() {
			var args = baseArgs.slice(0).concat(Array.prototype.call(arguments,0));
			return fn.apply(thisObject,args);
		}
	}
});

Observable = $.createClass(Object,{
	constructor: function() {
		Observable.superclass.constructor.apply(this,arguments);
		this.events = {};
	},

	bind: function(e,cb,scope) {
		if (typeof e == 'object') {
			scope = cb;
			for (var i in e) {
				if (i !== 'scope') {
					this.bind(i,e[i],e.scope||scope);
				}
			}
		} else if ($.isArray(cb)) {
			for (var i=0;i<cb.length;i++) {
				this.bind(e,cb[i],scope);
			}
		} else {
			scope = scope || this;
			this.events[e] = this.events[e] || [];
			this.events[e].push({
				fn: cb,
				scope: scope
			});
		}
		return true;
	},

	unbind: function(e,cb,scope) {
		if (typeof e == 'object') {
			scope = cb;
			var ret = false;
			for (var i in e) {
				if (i !== 'scope') {
					ret = this.unbind(i,e[i],e.scope||scope) || ret;
				}
			}
			return ret;
		} else if ($.isArray(cb)) {
			var ret = false;
			for (var i=0;i<cb.length;i++) {
				ret = this.unbind(e,cb[i],scope) || ret;
			}
			return ret;
		} else {
			if (!this.events[e]) {
				return false;
			}
			scope = scope || this;
			for (var i in this.events[e]) {
				if (this.events[e][i].fn == cb && this.events[e][i].scope == scope) {
					delete this.events[e][i];
					return true;
				}
			}
			return false;
		}
	},

	on: function(e,cb) {
		this.bind.apply(this,arguments);
	},

	un: function(e,cb) {
		this.unbind.apply(this,arguments);
	},

	relayEvents: function(o,e,te) {
		te = te || e;
		o.bind(e,function() {
			var a = [te].concat(arguments);
			this.fire.apply(this,a);
		},this);
	},

	fire: function(e) {
		var a = Array.prototype.slice.call(arguments,1);
		if (!this.events[e])
			return true;
		var ee = this.events[e];
		for (var i=0;i<ee.length;i++) {
			if (typeof ee[i].fn == 'function') {
				var scope = ee[i].scope || this;
				if (ee[i].fn.apply(scope,a) === false) {
					return false;
				}
			}
		}
		return true;
	},

	debugEvents: function( list ) {
		var fns = list ? list : ['bind','unbind','fire','relayEvents'];
		for (var i=0;i<fns.length;i++) {
			(function(fn){
				if (typeof this['nodebug-'+fn] == 'undefined') {
					var f = this['nodebug-'+fn] = this[fn];
					this[fn] = function() {
						window.console && console.log && console.log(this,fn,arguments);
						return f.apply(this,arguments);
					}
				}
			}).call(this,fns[i]);
		}
	}

});

GlobalTriggers = (function(){
	var GlobalTriggersClass = $.createClass(Observable,{

		fired: null,

		constructor: function() {
			GlobalTriggersClass.superclass.constructor.apply(this);
			this.fired = {};
		},

		bind: function(e,cb,scope) {
			GlobalTriggersClass.superclass.bind.apply(this,arguments);
			if (typeof e == 'object' || $.isArray(cb)) {
				return;
			}

			if (typeof this.fired[e] != 'undefined') {
				var a = this.fired[e].slice(0);
				setTimeout(function(){
					for (i=0;i<a.length;i++) {
						cb.apply(scope||window,a[i]);
					}
				},10);
			}
		},

		fire: function(e) {
			var a = Array.prototype.slice.call(arguments,1);
			this.fired[e] = this.fired[e] || [];
			this.fired[e].push(a);
			GlobalTriggersClass.superclass.fire.apply(this,arguments);
		}

	});
	return new GlobalTriggersClass();
})();

Timer = $.createClass(Object,{

	callback: null,
	timeout: 1000,
	timer: null,

	constructor: function ( callback, timeout ) {
		this.callback = callback;
		this.timeout = (typeof timeout == 'number') ? timeout : this.timeout;
	},

	run: function () {
		this.callback.apply(window);
	},

	start: function ( timeout ) {
		this.stop();
		timeout = (typeof timeout == 'number') ? timeout : this.timeout;
		this.timer = setTimeout(this.callback,timeout);
	},

	stop: function () {
		if (this.timer != null) {
			clearTimeout(this.timer);
			this.timer = null;
		}
	}

});

$.extend(Timer,{

	create: function( callback, timeout ) {
		var timer = new Timer(callback,timeout);
		return timer;
	},

	once: function ( callback, timeout ) {
		var timer = Timer.create(callback,timeout);
		timer.start();
		return timer;
	}

});

/**
 * Fetches given list of JS / CSS / SASS files and then fires callback (RT #70163)
 *
 * @author macbre
 */
jQuery.getResources = function(resources, callback) {
	var isJs = /.js(\?(.*))?$/,
		isCss = /.css(\?(.*))?$/,
		isSass = /.scss/,
		remaining = resources.length;

	var onComplete = function() {
		remaining--;

		// all files have been downloaded
		if (remaining == 0) {
			if (typeof callback == 'function') {
				callback();
			}
		}
	};

	// download files
	for (var n=0; n<resources.length; n++) {
		var resource = resources[n];

		// "loader" function: $.loadYUI, $.loadJQueryUI
		if (typeof resource == 'function') {
			resource.call(jQuery, onComplete);
		}
		// JS files
		else if (isJs.test(resource)) {
			$.getScript(resource, onComplete);
		}
		// CSS /SASS files
		else if (isCss.test(resource) || isSass.test(resource)) {
			$.getCSS(resource, onComplete);
		}
	}
};



/**
*
*  MD5 (Message-Digest Algorithm)
*  http://www.webtoolkit.info/
*
**/

jQuery.md5 = function (string) {

	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}

	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
 	}

 	function F(x,y,z) { return (x & y) | ((~x) & z); }
 	function G(x,y,z) { return (x & z) | (y & (~z)); }
 	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }

	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};

	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};

	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";

		for (var n = 0; n < string.length; n++) {

			var c = string.charCodeAt(n);

			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}

		return utftext;
	};

	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;

	string = Utf8Encode(string);

	x = ConvertToWordArray(string);

	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}

	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

	return temp.toLowerCase();
}

/**
 * original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * revised by: Kankrelune (http://www.webfaktory.info/)
 * note 1: Uses an internal counter (in php_js global) to avoid collision
 * example 1: uniqid();
 * returns 1: 'a30285b160c14'
 * example 2: uniqid('foo');
 * returns 2: 'fooa30285b1cd361'
 * example 3: uniqid('bar', true);
 * returns 3: 'bara20285b23dfd1.31879087'
*/
jQuery.uniqueId = function(prefix, more_entropy) {
    if (typeof prefix == 'undefined') {
        prefix = "";
    }

    var retId;
    var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10).toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
            return Array(1 + (reqWidth - seed.length)).join('0') + seed;
        }
        return seed;
    };

    // BEGIN REDUNDANT
    if (!this.php_js) {
        this.php_js = {};
    }
    // END REDUNDANT
    if (!this.php_js.uniqidSeed) { // init seed with big random int
        this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    this.php_js.uniqidSeed++;

    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
    retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10).toFixed(8).toString();
    }

    return retId;
}


//Extension to jQuery.support to detect browsers/platforms that don't support
//CSS directive position:fixed
if(jQuery.support){
	jQuery.support.fileUpload = jQuery.support.keyboardShortcut = jQuery.support.positionFixed = !( navigator.platform in {'iPad':'', 'iPhone':'', 'iPod':''} || (navigator.userAgent.match(/android/i) != null));
}

//Simple JavaScript Templating
//John Resig - http://ejohn.org/ - MIT Licensed
$.tmpl = function tmpl(str, data) {

	// Figure out if we're getting a template, or if we need to
	// load the template - and be sure to cache the result.
	try {
		var fn = new Function("obj",
				"var p=[],print=function(){p.push.apply(p,arguments);};"
						+

						// Introduce the data as local variables using with(){}
						"with(obj){p.push('"
						+
						// Convert the template into pure JavaScript
						str.replace(/[\r\t\n]/g, " ").split("<%")
								.join("\t")
								.replace(/((^|%>)[^\t]*)'/g, "$1\r")
								.replace(/\t=(.*?)%>/g, "',$1,'")
								.split("\t")
								.join("');").split("%>").join("p.push('")
								.split("\r").join("\\'")
						+ "');}return p.join('');");
	}
	catch(e) {
		$().log(e, '$.tmpl');
		$().log(str, '$.tmpl');
	}
	// Provide some basic currying to the user
	return data ? fn(data) : fn;
};

jQuery.nirvana = {};

/**
 * Helper to send ajax request to nirvana controller
 *
 * @author TomekO
 */
jQuery.nirvana.sendRequest = function(attr) {
	var type = (typeof attr.type == 'undefined') ? 'POST' : attr.type.toUpperCase();
	var format = (typeof attr.format == 'undefined') ?  'json' : attr.format.toLowerCase();
	var data = (typeof attr.data == 'undefined') ? {} : attr.data;
	var callback = (typeof attr.callback == 'undefined') ? function(){} : attr.callback;
	var onErrorCallback = (typeof attr.onErrorCallback == 'undefined') ? function(){} : attr.onErrorCallback;

	if((typeof attr.controller == 'undefined') || (typeof attr.method == 'undefined')) {
		throw "controller and method are required";
	}

	if( !(format === 'json' || format === 'html'  || format === 'jsonp' ) ) {
		throw "Only Json,Jsonp and Html format are allowed";
	}

	$().log(data, 'request to nirvana');

	var url = (typeof attr.scriptPath == 'undefined') ? wgScriptPath:attr.scriptPath;

	$.ajax({
		url: url + '/wikia.php?' + $.param({
			//Iowa strips out POST parameters, Nirvana requires these to be set
			//so we're passing them in the GET part of the request
			controller: attr.controller,
			method: attr.method,
			format: format
		}),
		dataType: format,
		type: type,
		data: data,
		success: callback,
		error: onErrorCallback
	});
}

jQuery.nirvana.getJson = function(controller, method, data, callback, onErrorCallback) {
	jQuery.nirvana.ajaxJson(
		controller,
		method,
		data,
		callback,
		onErrorCallback,
		'GET'
	);
}

jQuery.nirvana.postJson = function(controller, method, data, callback, onErrorCallback) {
	jQuery.nirvana.ajaxJson(
		controller,
		method,
		data,
		callback,
		onErrorCallback,
		'POST'
	);
}

jQuery.nirvana.ajaxJson = function(controller, method, data, callback, onErrorCallback, requestType) {

	// data parameter can be omitted
	if ( typeof data == 'function' ) {
		callback = data;
		data = {};
	}

	jQuery.nirvana.sendRequest({
		controller: controller,
		method: method,
		data: data,
		type: requestType,
		format: 'json',
		callback: callback,
		onErrorCallback: onErrorCallback
	});

}

jQuery.openPopup = function(url, name, moduleName, width, height) {
	if (wgUserName) {
		window.open(
			url,
			name,
			'width='+width+',height='+height+',menubar=no,status=no,location=no,toolbar=no,scrollbars=no,resizable=yes'
		);
	}
	else {
		showComboAjaxForPlaceHolder(false, "", function() {
			AjaxLogin.doSuccess = function() {
				$('.modalWrapper').children().not('.close').not('.modalContent').not('h1').remove();
				$('.modalContent').load(
					wgServer +
					wgScript +
					'?action=ajax&rs=moduleProxy&moduleName=' + moduleName + '&actionName=AnonLoginSuccess&outputType=html'
				);
			}
		}, false, message); // show the 'login required for this action' message.
	}
}

// add Array.indexOf function in IE8
// @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/indexOf
if (typeof [].indexOf == 'undefined') {
	Array.prototype.indexOf = function(val, fromIndex) {
		fromIndex = fromIndex || 0;
		for (var i = fromIndex, m = this.length; i < m; i++) {
			if (this[i] === val) {
				return i;
			}
		}
		return -1;
	}
}

//beacon_id cookie
$(function() {
	if ( window.beacon_id ) {
		$.cookies.set( 'wikia_beacon_id', window.beacon_id, { path: wgCookiePath, domain: wgCookieDomain });
	}
});

