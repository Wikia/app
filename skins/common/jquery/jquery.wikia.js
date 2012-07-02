jQuery.getSassCommonURL = function(scssFilePath, params) {
	return jQuery.getSassURL(wgCdnRootUrl, scssFilePath, params);
};

jQuery.getSassLocalURL = function(scssFilePath, params) {
	return jQuery.getSassURL(wgServer, scssFilePath, params);
};

jQuery.getSassURL = function(rootURL, scssFilePath, params) {
	return rootURL + wgAssetsManagerQuery.
		replace('%1$s', 'sass').
		replace('%2$s', scssFilePath).
		replace('%3$s', encodeURIComponent($.param(params || window.sassParams))).
		replace('%4$d', wgStyleVersion);
};

jQuery.getSassLocalURL = function(scssFilePath, params) {
	return wgAssetsManagerQuery.
		replace('%1$s', 'sass').
		replace('%2$s', scssFilePath).
		replace('%3$s', encodeURIComponent($.param(params || window.sassParams))).
		replace('%4$d', wgStyleVersion);
};

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
};

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
	return this;
};

jQuery.fn.exists = function() {
	return this.length > 0;
};

// show modal dialog with content fetched via AJAX request
jQuery.fn.getModal = function(url, id, options) {
	// get modal plugin

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
};

// show modal popup with static title and content provided
jQuery.showModal = function(title, content, options) {
	options = (typeof options != 'object') ? {} : options;

	var dialog, header, wrapper;

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

    wrapper = dialog.makeModal(options);

	// fire callback if provided
	if (typeof options.callback == 'function') {
		options.callback();
	}

    return wrapper;
};

// show modal version of confirm()
jQuery['confirm'] = function(options) {
	// init options
	options = (typeof options != 'object') ? {} : options;
	options.id = 'WikiaConfirm';

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
};

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
};

// send POST request and parse returned JSON
jQuery.postJSON = function(u, d, callback) {
	return jQuery.post(u, d, callback, "json");
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
 * @author Marcin Maciejewski <marcin@wikia-inc.com>
 *
 * Plugin for easy creating Ajax Loading visualization.
 * after using it selected elements content will apply proper css class
 * and in the middle of it throbber will be displayed.
 */
jQuery.fn.startThrobbing = function() {
	this.append('<div id="wikiaThrobber"></div>');
};
jQuery.fn.stopThrobbing = function() {
	this.find('#wikiaThrobber').remove();
};

$.htmlentities = function ( s ) {
	return String(s).replace(/\&/g,'&'+'amp;').replace(/</g,'&'+'lt;')
    	.replace(/>/g,'&'+'gt;').replace(/\'/g,'&'+'apos;').replace(/\"/g,'&'+'quot;');
};

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

		for (var m in o) {
			bc.prototype[m] = o[m];
		}

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

var Observable = $.createClass(Object,{
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

var GlobalTriggers = (function(){
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

var Timer = $.createClass(Object,{

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
};

jQuery.nirvana.getJson = function(controller, method, data, callback, onErrorCallback) {
	return jQuery.nirvana.ajaxJson(
		controller,
		method,
		data,
		callback,
		onErrorCallback,
		'GET'
	);
};

jQuery.nirvana.postJson = function(controller, method, data, callback, onErrorCallback) {
	return jQuery.nirvana.ajaxJson(
		controller,
		method,
		data,
		callback,
		onErrorCallback,
		'POST'
	);
};

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
};

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

// add Array.filter function in IE8
if (!Array.prototype.filter){
	Array.prototype.filter = function(fun, t){
		var len = this.length,
			res = [];

		for (var i = 0; i < len; i++){
			if (fun.call(t, this[i], i, this)) res[res.length] = this[i];
		}

		return res;
	};
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
//
// @deprecated
// @see resources/wikia/libraries/html5/html5.min.js
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
