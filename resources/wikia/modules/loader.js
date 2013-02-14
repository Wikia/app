/**
 * Single place to call when you want to load something from server
 *
 * Think of it as a replacment for ResourceLoader and AssetsManager
 *
 * @author Jakub Olek <jolek@wikia-inc.com>
 */
(function(context){
	'use strict';

	function loader(w, mw, nirvana, log){
		var loader,
			doc = w.document,
			head = doc.head || doc.getElementsByTagName('head')[0],
			loadedCompleteRegExp = /loaded|complete/,
			style = 'stylesheet',
			styleType = 'text/css',
			multiAllowedOptions = ['templates', 'scripts', 'styles', 'messages', 'mustache'],
			slashRegex = /^\\/,
			rExtension = /(js|s?css)$/,
			getURL = function(path, type, params){
				if(~path.indexOf('__am')) {
					//most definatelly you already have proper url to asset
					return path;
				} else {
					//we might convert links to go through AssetManager
					//so we can minify them all!! YAY!
					path = path.replace(wgCdnRootUrl, '').replace(/__cb\d*/, '');

					if (type == 'groups' && path instanceof Array) {
						path = path.join(',');
					}

					if (type == 'sass') {
						params = params || w.wgSassParams;
					}

					return wgCdnRootUrl + wgAssetsManagerQuery.
						replace('%1$s', type).
						replace('%2$s', path.replace(slashRegex, '')). // remove first slash
						replace('%3$s', params ? encodeURIComponent($.param(params)) : '-').
						replace('%4$d', wgStyleVersion);
				}
			},

			// TODO: ease mocking
			get = function(url, success, failure, type){
				var element,
					timer;

				if(type == loader.CSS || type == loader.SCSS){
					element = doc.createElement('link');
					element.rel   = style;
					element.type  = styleType;
					element.href  = url;
				}else{
					element = doc.createElement('script');
					element.src = url;
				}

				if (element.readyState) {
					element.onreadystatechange = function () {
						if (loadedCompleteRegExp.test(element.readyState)) {
							success();
							element.onreadystatechange = null;
						}
					};
				}
				// If onload is available, use it
				// don't use it when loading CSS in WebKit
				else if(element.onload === null && (element.all /* exclude WebKit */ || type !== loader.CSS)) {
					element.onload = success;
					element.onerror = function(){failure()};
				}
				// use polling when loading CSS in Webkit :(
				else if (type === loader.CSS) {
					timer = w.setInterval(function () {
						var stylesheet,
							stylesheets = doc.styleSheets,
							i = stylesheets.length;

						while (i--) {
							stylesheet = stylesheets[i];
							if ((url == stylesheet.href)) {
								try {
									// We store so that minifiers don't remove the code
									var r = stylesheet.cssRules;
									// Webkit:
									// Webkit browsers don't create the stylesheet object
									// before the link has been loaded.
									// When requesting rules for crossDomain links
									// they simply return nothing (no exception thrown)
									// Gecko:
									// NS_ERROR_DOM_INVALID_ACCESS_ERR thrown if the stylesheet is not loaded
									// If the stylesheet is loaded:
									//  * no error thrown for same-domain
									//  * NS_ERROR_DOM_SECURITY_ERR thrown for cross-domain
									throw 'SECURITY';
								} catch(e) {
									// Gecko: catch NS_ERROR_DOM_SECURITY_ERR
									// Webkit: catch SECURITY
									if (/SECURITY/.test(e) || /SECURITY/i.test(e.name)) {
										timer = w.clearInterval(timer);
										success();
									}
								}
							}
						}
					}, 13);
				}

				log('[' + type + '] ' + url, log.levels.info, 'loader');

				head.appendChild(element);
			},

			librariesMap = {
				jqueryUI: 'wikia.jquery.ui',
				yui: 'wikia.yui',
				mustache: 'jquery.mustache',
				jqueryAutocomplete: 'jquery.autocomplete',
				jqueryAIM: 'wikia.aim',
				twitter: {
					file: '//platform.twitter.com/widgets.js',
					check: function(){
						return typeof (w.twttr && w.twttr.widgets);
					}
				},
				googleplus: {
					file: '//apis.google.com/js/plusone.js',
					check: function(){
						return typeof (w.gapi && w.gapi.plusone);
					}
				},
				facebook: {
					file: w.fbScript || '//connect.facebook.net/en_US/all.js',
					check: function(){
						return typeof w.FB;
					},
					addition: function(callbacks) {
						// always initialize FB API when SDK is loaded on-demand
						if (typeof w.onFBloaded === 'function') {
							w.onFBloaded();
						}

						if (typeof callbacks.success === 'function') {
							callbacks.success();
						}

						return callbacks;
					}
				},
				googlemaps: {
					file: 'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
					check: function(){
						return typeof (w.google && w.google.maps);
					},
					addition: function(callbacks){
						w.onGoogleMapsLoaded = (function(callback) {
							return function(){
								delete w.onGoogleMapsLoaded;

								callback();
							}
						})(callbacks.success);

						callbacks.success = null;
						return callbacks;
					}
				}
			},

			/**
			 * Loads library file if it's not already loaded and fires callback
			 *
			 * @example:
			 * loader({
			 * 		type: loader.LIBRARY,
			 * 		resources: ['facebook', 'googlemaps']
			 * });
			 */
			getLibrary =  function(libs, callback, failure) {
				if(!(libs instanceof Array)) {
					libs = [libs];
				}

				var use = [],
					useNames = [],
					internal = [],
					lib,
					l = libs.length,
					load = 0,
					fail = function(f, failed){
						return function(){
							f(failed);
						}
					};

				//find libraries to be loaded
				//from libraryMap
				while(l--) {
					var name = libs[l],
						n = librariesMap[name];

					if(!n) throw "Library not known " + name;

					if(typeof n == 'string'){
						use.push(n);
						useNames.push(name)
					}else{
						n.name = name;
						internal.push(n);
					}
				}

				if(mw && use.length) {
					mw.loader.use(use).done(callback).fail(fail(failure, {type: loader.LIBRARY, resources: useNames}));
					load += use.length;
				}

				if(internal.length){
					l = internal.length;
					load += l;

					while(l--) {
						lib = internal[l];

						if(lib.check() == 'undefined') {
							if(lib.addition) {
								var callbacks = lib.addition({success: callback, failure: failure});
								get(lib.file, callbacks.success, fail(callbacks.failure, {type: loader.LIBRARY, resources: [lib.name]}));
							}else{
								get(lib.file, callback, fail(failure, {type: loader.LIBRARY, resources: [lib.name]}));
							}
						} else {
							callback();
						}
					}
				}

				return --load;
			},

			/**
			 *	request - json of key value pairs
			 *  keys:
			 *		templates - an array of objects with the following fields: controller, method and an optional params (parameters for the controller method)
			 *		styles - comma-separated list of SASS files
			 *		scripts - comma-separated list of AssetsManager groups
			 *		messages - comma-separated list of JSMessages packages (messages are registered automagically)
			 * 		mustache - comma-separated list of paths to Mustache-powered templates
			 *		ttl - cache period for both Varnish and Browser (in seconds), is overridden by varnishTTL and BrowserTTL
			 *		varnishTTL - cache period for varnish and browser (in seconds)
			 *		browserTTL - cache period for browser (in seconds)
			 *		params - an object with all the additional parameters for the request (e.g. useskin, forceprofile, etc.)
			 *		callback - function to be called with fetched JSON object
			 *
			 *  Returns object with all requested resources
			 *
			 *  @example: loader({
			 *  	type: loader.MULTI,
			 *  	resources: {
			 *  	    messages: 'EditPageLayout',
			 *			scripts: 'oasis_jquery,yui',
			 *			styles: 'path/to/style/file'
			 *			mustache: 'extensions/wikia/MyExy/templates/index.mustache',
			 *			templates: [{
			 *				controller: 'MyController',
			 *				method: 'getPage',
			 *				params: {
			 *					page: 1
			 *				}
			 *			}],
			 *			params: {
			 *				useskin: 'skinname'
			 *			}
			 *  	}
			 *	});
			 */
			getMultiTypePackage = function(options, complete, failure){
				var templates = options.templates,
					send = false;

				if(typeof templates != 'undefined'){
					// JSON encode templates entry
					options.templates = (typeof templates === 'object') ? JSON.stringify(templates) : templates;
				}

				for(var prop in options) {
					if(options.hasOwnProperty(prop) && ~multiAllowedOptions.indexOf(prop)) {
						send = true;
						break;
					}
				}

				if(send){
					if(typeof options.params == 'object'){
						options = $.extend(options, options.params);
						delete options.params;
					}

					// add a cache buster
					options.cb = wgStyleVersion;

					nirvana.getJson(
						'AssetsManager',
						'getMultiTypePackage',
						options
					).done(
						function(resources, event) {
							// "register" JS messages
							if (resources.messages) {
								w.wgMessages = $.extend(wgMessages, resources.messages);
							}

							complete(event, resources);
						}
					).fail(failure);
				}else{
					failure()
				}
			};

		return (function(){
			/**
			 * Fetches a list of resources and fires a callback when they have all finished loading.
			 *
			 * If it failes it'll call onFail callback passing you packages that it couldn't load (in IE8 only onSuccess works :()
			 *
			 * @supports JS, CSS, SASS, AM Groups, Libraries, Multi type packages
			 *
			 * @example: loader('/path/to/file.js').done(onSucess).fail(onFail);
			 * @example: loader({
			 *     type: loader.JS,
			 *     resources: 'path/to/file.js'
			 *	},
			 * '/path/to/file.scss'
			 * ).then(onSuccess, onFail);
			 *
			 * @author macbre
			 * @author kflorence
			 * @author Jakub Olek <jolek@wikia-inc.com>
			 */
			loader = function() {
				var l = remaining = arguments.length,
					matches,
					remaining,
					dfd = new $.Deferred(),
					failed = [],
					func,
					result,
					onEnd = function(){
						remaining--;

						log(remaining + ' remaining...', log.levels.info, 'loader');

						// All files have been downloaded
						if ( remaining < 1 ) {

							if(!failed.length) {
								// Resolve the deferred object
								dfd.resolve(result);
							}else{
								dfd.reject({
									error: loader.NOT_LOADED,
									resources: failed
								});
							}

						}
					},
					failure = function(res){
						log(res, log.levels.error, 'loader');

						return function(override){
							failed.push(override || res);
							onEnd();
						}
					},
					// This will be called everytime a resource is loaded
					complete = function(ev, res) {
						/*
							res is saved locally and the only function here that returns it is getMultiTypePackage
							but I can not ensure that this is last to be loaded

							This means there is lack for multiple getMultiTypePackage calls - but should be discouraged
						 */
						if(res){
							result = res;
						}
						onEnd();
					};

				// Nothing to load
				if (!l) {
					complete();
				}

				while (l--) {
					var resource = arguments[l],
						files,
						type,
						params;

					// URI string
					if (typeof resource === 'string') {
						matches = resource.match(rExtension);

						type = matches ? matches[0] : loader.UNKNOWN;
						files = resource;
					}
					// function returning a promise
					else if (typeof resource === 'function') {
						resource().
							done(complete).
							fail(failure);

						continue;
					}
					else {
						type = resource.type;
						files  = resource.resources || resource.url;
						params = resource.params;
					}

					func = get;

					if (type && files) {
						switch(type) {
							case loader.MULTI:
								func = getMultiTypePackage;
								break;
							case loader.LIBRARY:
								func = getLibrary;
								break;
							case loader.JS:
								files = getURL(files, 'one', params);
								break;
							case loader.AM_GROUPS:
								files = getURL(files, 'groups', params);
								break;
							case loader.CSS:
								files = getURL(files, 'one', params);
								break;
							case loader.SCSS:
								files = getURL(files, 'sass', params);
								break;
							case loader.UNKNOWN:
							default:
								failure({type: type, resources: files})();
								continue;
						}

						/*
							this is for letting the loader know that current function will fire more onEnd callbacks than 1

							used by getLibrary which is called once but might load more files

							~~ is an 'better' version of parseInt as it'll return 0 instead of a NaN
							when unexpected value is passed to it ie. undefined or 'string'

							ie. loader({
									type: loader.LIBRARY,
									resources: ['googlemaps', 'facebook']
								});

							before I run function that loads files I don't know how many files will be loaded
						 */
						remaining += ~~func(files, complete, failure({type: type, resources: files}), type);

					} else {
						dfd.reject({
							error: loader.CORRUPT_FORMAT,
							resource: resource
						});
					}
				}

				return dfd.promise();
			};

			//list of types
			loader.JS = 'js';
			loader.MULTI = 'multi';
			loader.SCSS = 'scss';
			loader.CSS = 'css';
			loader.LIBRARY = 'library';
			loader.AM_GROUPS = 'amgroups';
			loader.UNKNOWN = 'unknown';

			//errors:
			loader.NOT_LOADED = 'Some of resources not loaded';
			loader.CORRUPT_FORMAT = 'Wrong object format';

			/**
			 * Evaluate given JS code by adding an inline <script> tag to document <body> tag
			 *
			 * js - JS code to be evaluated
			 */
			loader.processScript = function(js) {
				var script = doc.createElement('script');

				script.type = 'text/javascript';
				script.text = js;

				// add it to DOM
				head.appendChild(script);
			};

			/**
			 * Apply given CSS code by adding an inline <style> tag to document <body> tag
			 *
			 * css - CSS code to be applied
			 */
			loader.processStyle = function(css) {
				var style = doc.createElement('style');

				style.type = styleType;

				if (style.styleSheet) {
					// for *&$#^# IE
					style.styleSheet.cssText = css;
				} else {
					// for web browsers
					style.appendChild(doc.createTextNode(css));
				}

				head.appendChild(style);
			};

			return loader;
		})();
	}

	if (context.jQuery) {
		context.Loader = loader(context, context.mw, jQuery.nirvana, context.Wikia.log);
	}

	if (context.define && context.define.amd) {
		//there is no mw module in WikiaMobile
		context.define('wikia.loader', ['wikia.window', require.optional('wikia.mw'), 'wikia.nirvana', 'wikia.log'], loader);
	}
})(this);
