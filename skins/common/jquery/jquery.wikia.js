jQuery.getSassCommonURL = function(scssFilePath, params) {
	return jQuery.getSassURL(wgCdnRootUrl, scssFilePath, params);
}

jQuery.getSassLocalURL = function(scssFilePath, params) {
	return jQuery.getSassURL(wgServer, scssFilePath, params);
}

jQuery.getSassURL = function(rootURL, scssFilePath, params) {
	return rootURL + wgAssetsManagerQuery.
		replace('%1$s', 'sass').
		replace('%2$s', scssFilePath).
		replace('%3$s', encodeURIComponent($.param(params || window.sassParams))).
		replace('%4$d', wgStyleVersion);
}

//see http://jamazon.co.uk/web/2008/07/21/jquerygetscript-does-not-cache
$.ajaxSetup({cache: true});

// replace stock function for getting rid of response-speed related issues in Firefox
// @see http://stackoverflow.com/questions/1130921/is-the-callback-on-jquerys-getscript-unreliable-or-am-i-doing-something-wrong
jQuery.getScript = function(url, callback, failureFn) {
	return jQuery.ajax({
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
		error: (typeof failureFn == 'function' ? failureFn : $.noop),
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
			'<button id="WikiaConfirmCancel" class="wikia-button secondary">' + (options.cancelMsg || 'Cancel') + '</button>' +
			'<button id="WikiaConfirmOk" class="wikia-button">' + (options.okMsg || 'Ok') + '</button>' +
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

		var modal = dialog.makeModal(options);

		// fire callback if provided
		if (typeof options.callback == 'function') {
			options.callback(modal);
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
	return $.loadLibrary('jQueryUI',
		stylepath + '/common/jquery/jquery-ui-1.8.14.custom.js',
		typeof jQuery.ui,
		callback
	);
}

$.loadJQueryAutocomplete = function(callback) {
	return $.loadLibrary('jQuery Autocomplete',
		stylepath + '/common/jquery/jquery.autocomplete.js',
		typeof jQuery.fn.pluginAutocomplete,
		callback
	);
}

$.loadWikiaTooltip = function(callback) {
	return $.loadLibrary('Wikia Tooltip',
		[
			stylepath + '/common/jquery/jquery.wikia.tooltip.js',
			$.getSassCommonURL("skins/oasis/css/modules/WikiaTooltip.scss")
		],
		typeof jQuery.fn.wikiaTooltip,
		callback
	);
}

$.loadJQueryAIM = function(callback) {
	return $.loadLibrary('jQuery AIM',
		stylepath + '/common/jquery/jquery.aim.js',
		typeof jQuery.AIM,
		callback
	);
}

$.loadModalJS = function(callback) {
	return $.loadLibrary('makeModal()',
		stylepath + '/common/jquery/jquery.wikia.modal.js',
		typeof jQuery.fn.makeModal,
		callback
	);
}

$.loadGoogleMaps = function(callback) {
	var dfd = new jQuery.Deferred(),
		onLoaded = function() {
			if (typeof callback === 'function') {
				callback();
			}
			dfd.resolve();
		};

	// Google Maps API is loaded
	if (typeof (window.google && google.maps) != 'undefined') {
		onLoaded();
	}
	else {
		window.onGoogleMapsLoaded = function() {
			delete window.onGoogleMapsLoaded;
			onLoaded();
		}

		// load GoogleMaps main JS and provide a name of the callback to be called when API is fully initialized
		$.loadLibrary('GoogleMaps',
			'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
			typeof (window.google && google.maps)
		).
		// error handling
		fail(function() {
			dfd.reject();
		});
	}

	return dfd.promise();
}

$.loadFacebookAPI = function(callback) {
	return $.loadLibrary('Facebook API',
		window.fbScript || '//connect.facebook.net/en_US/all.js',
		typeof window.FB,
		callback
	);
}

$.loadGooglePlusAPI = function(callback) {
	return $.loadLibrary('Google Plus API',
		'//apis.google.com/js/plusone.js',
		typeof (window.gapi && window.gapi.plusone),
		callback
	);
}

$.loadTwitterAPI = function(callback) {
	return $.loadLibrary('Twitter API',
		'//platform.twitter.com/widgets.js',
		typeof (window.twttr && window.twttr.widgets),
		callback
	);
}

/**
 * Loads library file if it's not already loaded and fires callback
 */
$.loadLibrary = function(name, files, typeCheck, callback, failureFn) {
	var dfd = new jQuery.Deferred();

	if (typeCheck === 'undefined') {
		$().log('loading ' + name, 'loadLibrary');

		// cast single string to an array
		files = (typeof files == 'string') ? [files] : files;

		$.getResources(files, function() {
			$().log(name + ' loaded', 'loadLibrary');

			if (typeof callback == 'function') {
				callback();
			}
		},failureFn).
			// implement promise pattern
			then(function() {
				dfd.resolve();
			}).
			fail(function() {
				dfd.reject();
			});
	}
	else {
		$().log(name + ' already loaded', 'loadLibrary');

		if (typeof callback == 'function') {
			callback();
		}

		dfd.resolve();
	}

	return dfd.promise();
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

	return this.each(function() {

		if(!hasNativeSupport){
			var input = $(this);
			var text = input.attr('placeholder');

			if(input.val() == ''){
				input
					.addClass('placeholder')
					.val(text);
			}

			input.bind('focus.placeholder', function(){
				if(input.val() == text){
					input.val('');
				}

				input.removeClass('placeholder');
			});

			input.bind('blur.placeholder', function(){
				if(input.val() == ''){
					input
						.addClass('placeholder')
						.val(text);
				}
			});

			//clear the field is a submit event is fired somewhere around here
			input.closest('form').bind('submit.placeholder', function(){
				if(input.val() == text){
					input.val('');
				}
			});
		}
	})
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

	proxy: function(func) {
		return $.proxy(func, this);
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
 * FIXME: added support for asset manager groups, but it assumes they are javascript (which is not always true)
 */
jQuery.getResources = function(resources, callback) {
	var isJs = /.js(\?(.*))?$/,
		isCss = /.css(\?(.*))?$/,
		isSass = /.scss/,
		isGroup = /__am\/\d+\/group/,
		remaining = resources.length,
		dfd = new jQuery.Deferred();

	var onComplete = function() {
		remaining--;

		// all files have been downloaded
		// TODO: add error handling
		if (remaining == 0) {
			if (typeof callback == 'function') {
				callback();
			}

			// resolve deferred object
			dfd.resolve();
		}
	};

	// download files
	for (var n=0; n<resources.length; n++) {
		var resource = resources[n];

		// "loader" function: $.loadYUI, $.loadJQueryUI
		if (typeof resource == 'function') {
			resource.call(jQuery, onComplete);
		}
		// JS files and Asset Manager groups are scripts
		else if (isJs.test(resource) || isGroup.test(resource)) {
			$.getScript(resource, onComplete).
			// error handling
			fail(function() {
				dfd.reject();
			})
		}
		// CSS /SASS files
		else if (isCss.test(resource) || isSass.test(resource)) {
			$.getCSS(resource, onComplete);
		}
	}

	return dfd.promise();
};

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

	var url = (typeof attr.scriptPath == 'undefined') ? wgScriptPath : attr.scriptPath;

	return $.ajax({
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
	return jQuery.nirvana.ajaxJson(
		controller,
		method,
		data,
		callback,
		onErrorCallback,
		'GET'
	);
}

jQuery.nirvana.postJson = function(controller, method, data, callback, onErrorCallback) {
	return jQuery.nirvana.ajaxJson(
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

	return jQuery.nirvana.sendRequest({
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

$(function() {
	//beacon_id cookie
	if ( window.beacon_id ) {
		$.cookies.set( 'wikia_beacon_id', window.beacon_id, { path: wgCookiePath, domain: wgCookieDomain });
	}
	window.wgWikiaDOMReady = true;	// for selenium tests
});

// http://bit.ly/ishiv | WTFPL License
// IE < 9 fix for inserting HTML5 elements into the dom.
//
// Add 2nd param of False to return jQuery-friendly object instead of document fragment
//
// http://jdbartlett.com/innershiv/ says:
//
// STOP! Don't use innerShiv!
// html5shiv now patches for the innerHTML issue! Update html5shiv and you won't have to use innerShiv anymore
var innerShiv = function(){
	function h(c,e,b){
		return /^(?:area|br|col|embed|hr|img|input|link|meta|param)$/i.test(b)?c:e+"></"+b+">";
	}
	var c,e=document,j,
		g="abbr article aside audio canvas datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video".split(" ");
	return function (d, i) {
	    if (!c &&
	        (c = e.createElement("div"), c.innerHTML = "<nav></nav>", j = c.childNodes.length !== 1)) {
	        for (var b = e.createDocumentFragment(), f = g.length; f--;) {
	            b.createElement(g[f]);
	        }
	        b.appendChild(c);
	    }
	    d = d.replace(/^\s\s*/, "").replace(/\s\s*$/, "").replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, "").replace(/(<([\w:]+)[^>]*?)\/>/g, h);
	    c.innerHTML = (b = d.match(/^<(tbody|tr|td|col|colgroup|thead|tfoot)/i)) ? "<table>" + d + "</table>" : d;
	    b = b ? c.getElementsByTagName(b[1])[0].parentNode : c;
	    if (i === false) {
	        return b.childNodes;
	    }
	    for (var f = e.createDocumentFragment(), k = b.childNodes.length; k--;) {
	        f.appendChild(b.firstChild);
	    }
	    return f;
	}
}();
