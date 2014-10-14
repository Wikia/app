/**
 * This is a Wikia 'framework'
 * or rather bunch of util functions to help developing
 * WikiaMobile skin
 *
 * we decided not to use any frameworks as all we actually need is
 * addEventListener, find some elements and do some operations on array
 *
 * Frameworks like Zepto or jqMobi are nice
 * but with a cost of downloading another 9/10kb of data
 * If we don't have to load it its a win, and we don't
 *
 * This is just a place for functions that otherwise need some bigger boilerplates
 */
(function(w){
	"use strict";

	var htmlProto = HTMLElement.prototype,
		fired,
		slice = Array.prototype.slice;

	//'polyfill' for a conistent matchesSelector
	htmlProto.matchesSelector = htmlProto.matchesSelector ||
		htmlProto.webkitMatchesSelector ||
		htmlProto.mozMatchesSelector ||
		htmlProto.oMatchesSelector;

	w.addEventListener('DOMContentLoaded', function(){
		fired = true;
	});

	var $ = function(func){
		fired ? func() : w.addEventListener('DOMContentLoaded', func);
	};

	$.findPos = function(obj) {
		var curtop = 0;

		if (obj.offsetParent) {
			do {
				curtop += obj.offsetTop;
			} while (obj = obj.offsetParent)
			return curtop;
		}
	};

	$.not = function(selector, elements){
		var ret = [];

		if(elements && selector){
			elements = slice.call(elements);

			for(var i = 0, l = elements.length; i < l; i++){
				if(!elements[i].matchesSelector(selector)){
					ret[ret.length] = elements[i];
				}
			}
		}

		return ret;
	};

	$.param = function(params){
		var ret = [];

		if(params) {
			for(var param in params){
				if(params.hasOwnProperty(param)){
					ret[ret.length] = (param + '=' + params[param]);
				}
			}
		}

		return ret.join('&');
	};

	$.ajax = function(attr){
		var dfd = new Wikia.Deferred(),
			type = (attr.type && attr.type.toUpperCase()) || 'GET',
			dataType = (attr.dataType && attr.dataType.toLowerCase()) || 'json',
			data = attr.data || {},
			url = attr.url || wgScriptPath,
			async = (attr.async !== false),
			req = new XMLHttpRequest();

		if(type === 'GET' && data){
			url += (url.indexOf('?') > -1 ? '&' : '?') + $.param(data);
			data = null;
		}

		req.open(type, url, async);
		req.onreadystatechange = function (ev) {
			if (req.readyState === 4) {
				var data = ev.target.responseText,
					status = req.status;

				if((status >= 200 && status < 300) || status === 304){
					if(dataType === 'json'){
						try {
							dfd.resolve(JSON.parse(data));
						} catch(e) {
							dfd.reject({
								error: data,
								status: status,
								request: req,
								exception: e
							})
						}
					}else{
						dfd.resolve(data);
					}


				} else {
					dfd.reject({
						error: data,
						status: status,
						request: req
					});
				}

			}
		};
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		req.send(data ? $.param(data) : null);

		return dfd.promise();
	};

	$.extend = function(target){
		var args = slice.call(arguments, 1),
			l = args.length,
			i = 0,
			arg;

		for(; i < l; i++){
			arg = args[i];
			for (var key in arg)
				if (arg[key] !== undefined) target[key] = arg[key];
		}

		return target;
	};

	/**
	 * @param {HTMLElement} el
	 * @param {Array} cls
	 */
	$.addClass = function(el, cls) {
		el.className += ((el.className !== '') ? ' ' : '') + cls.join(' ');
	};

	/**
	 * @param {HTMLElement} el
	 * @param {Array} cls
	 */
	$.removeClass = function(el, cls) {
		el.className = el.className
			.replace(new RegExp('\\b(?:' + cls.join('|') + ')\\b', 'g'), '')
			//trim is supported starting from IE9
			//and that's the least version on WP7
			.trim();
	};

	//expose it to the world
	//$ is forbackward compatability
	if(!w.$) w.$ = $;

	//AMD
	if (w.define && w.define.amd) {
		w.define('wikia.utils', function() {
			return $;
		});
	}
})(this);
