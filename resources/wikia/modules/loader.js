/*global define, require*/
/**
 * Single place to call when you want to load something from server
 *
 * Think of it as a replacement for ResourceLoader and AssetsManager
 *
 * @author Jakub Olek <jolek@wikia-inc.com>
 *
 */
define('wikia.loader', [
		'wikia.window',
		require.optional('mw'),
		'wikia.nirvana',
		'jquery',
		'wikia.log',
		'wikia.fbLocale'
	],
	function loader (window, mw, nirvana, $, log, fbLocale) {
	'use strict';

	var loader,
		doc = window.document,
		head = doc.head || doc.getElementsByTagName('head')[0],
		loadedCompleteRegExp = /loaded|complete/,
		style = 'stylesheet',
		styleType = 'text/css',
		multiAllowedOptions = ['templates', 'scripts', 'styles', 'messages', 'mustache'],
		slashRegex = /^\//,
		rExtension = /(js|s?css)$/,
		isArray = function (obj) {
			return obj instanceof Array;
		},
		createElement = function (type, options) {
			var element = doc.createElement(type);

			return options ? $.extend(element, options) : element;
		},
		getUrl = function (path, type, params) {
			if (path.indexOf('__am') !== -1 || path.search(/^https?:/i) !== -1) {
				//most definitely you already have proper url to asset
				//or full url was passed
				return path;
			} else {
				//we might convert links to go through AssetManager
				//so we can minify them all!! YAY!
				path = path.replace(window.wgCdnRootUrl, '').replace(/__cb\d*/, '');

				if (type === 'sass') {
					params = params || window.wgSassParams;
				}

				return window.wgCdnRootUrl + window.wgAssetsManagerQuery.
					replace('%1$s', type).
					replace('%2$s', path.replace(slashRegex, '')). // remove first slash
					replace('%3$s', params ? encodeURIComponent($.param(params)) : '-').
					replace('%4$d', window.wgStyleVersion);
			}
		},
		getUrls = function (path, type, params) {
			var i = 0,
				url;

			if (isArray(path)) {
				if (type === 'groups'){
					path = path.join(',');
				} else {
					for (i = 0; i < path.length ; i++) {
						url = path[i];
						path[i] = getUrl(url, type, params);
					}

					return path;
				}
			}

			return getUrl(path, type, params);
		},
		addScript = function (content) {
			head.appendChild(createElement('script', {text: content}));
		},
		// TODO: ease mocking
		get = function (urls, success, failure, type) {
			var element,
				url,
				i = 0,
				errorFunction = function () {
					failure(this.src || this.href);
				},
				makeSuccessFunction = function (element) {
					return function () {
						if (loadedCompleteRegExp.test(element.readyState)) {
							success();
							element.onreadystatechange = null;
						}
					};
				};

			if (!isArray(urls)) {
				urls = [urls];
			}

			while ((url = urls[i++])) {
				if (type === loader.CSS || type === loader.SCSS) {
					element = createElement('link', {
						rel: style,
						type: styleType,
						href: url
					});
				} else {
					element = createElement('script', {src: url});
				}

				if (element.readyState) {
					element.onreadystatechange = makeSuccessFunction(element);
				} else if (element.onload === null) {
					// If onload is available, use it
					element.onload = success;
					element.onerror = errorFunction;
				}

				log('[' + type + '] ' + url, log.levels.info, 'loader');

				head.appendChild(element);
			}
			return urls.length - 1;
		},
		librariesMap = {
			jqueryUI: 'wikia.jquery.ui',
			yui: 'wikia.yui',
			mustache: 'jquery.mustache',
			jqueryAutocomplete: 'jquery.autocomplete',
			jqueryAIM: 'wikia.aim',
			twitter: {
				file: '//platform.twitter.com/widgets.js',
				check: function () {
					return typeof (window.twttr && window.twttr.widgets);
				}
			},
			googleplus: {
				file: '//apis.google.com/js/plusone.js',
				check: function () {
					return typeof (window.gapi && window.gapi.plusone);
				}
			},
			facebook: {
				file: window.fbScript || fbLocale.getSdkUrl(window.wgUserLanguage),
				check: function () {
					return typeof window.FB;
				},
				addition: function (callbacks) {
					callbacks.success = (function (callback) {
						return function () {
							// always initialize FB API when SDK is loaded on-demand
							if (typeof window.onFBloaded === 'function') {
								window.onFBloaded();
							}

							callback();
						};
					})(callbacks.success);

					return callbacks;
				}
			},
			googlemaps: {
				file: 'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
				check: function () {
					return typeof (window.google && window.google.maps);
				},
				addition: function (callbacks) {
					window.onGoogleMapsLoaded = (function (callback) {
						return function () {
							delete window.onGoogleMapsLoaded;

							callback();
						};
					})(callbacks.success);

					callbacks.success = null;
					return callbacks;
				}
			},
			vk: {
				file: '//vk.com/js/api/openapi.js',
				check: function () {
					return typeof (window.VK && window.VK.Widgets);
				}
			}
		},

		/**
		 * Loads library file if it's not already loaded and fires callback
		 *
		 * @example:
		 * loader({
		 *   type: loader.LIBRARY,
		 *   resources: ['facebook', 'googlemaps']
		 * });
		 */
		getLibrary = function (libs, callback, failure) {
			if (!isArray(libs)) {
				libs = [libs];
			}

			var use = [],
				useNames = [],
				internal = [],
				lib,
				libLength = libs.length,
				load = 0,
				name,
				n,
				callbacks,
				fail = function (f, failed) {
					return function () {
						f(failed);
					};
				};

			//find libraries to be loaded from libraryMap
			while (libLength--) {
				name = libs[libLength];
				n = librariesMap[name];

				if (!n) {
					throw 'Library unknown: ' + name;
				}

				if (typeof n === 'string') {
					use.push(n);
					useNames.push(name);
				} else {
					n.name = name;
					internal.push(n);
				}
			}

			if (mw && use.length) {
				mw.loader.using(use)
					.done(callback)
					.fail(fail(failure, {type: loader.LIBRARY, resources: useNames}));
				load += use.length;
			}

			if (internal.length) {
				libLength = internal.length;
				load += libLength;

				while (libLength--) {
					lib = internal[libLength];

					if (lib.check() === 'undefined') {
						if (lib.addition) {
							callbacks = lib.addition({success: callback, failure: failure});
							get(lib.file,
								callbacks.success,
								fail(callbacks.failure, {type: loader.LIBRARY, resources: [lib.name]}));
						} else {
							get(lib.file,
								callback,
								fail(failure, {type: loader.LIBRARY, resources: [lib.name]}));
						}
					} else {
						callback();
					}
				}
			}

			return load - 1;
		},

		/**
		 *	request - json of key value pairs
		 *  keys:
		 *		templates - an array of objects with the following fields: controller, method and an optional
		 *                  params (parameters for the controller method)
		 *		styles - comma-separated list of SASS files
		 *		scripts - comma-separated list of AssetsManager groups
		 *		messages - comma-separated list of JSMessages packages (messages are registered automagically)
		 *		mustache - comma-separated list of paths to Mustache-powered templates
		 *		params - an object with all the additional parameters for the request (e.g. useskin,
		 *              forceprofile, etc.)
		 *		callback - function to be called with fetched JSON object
		 *
		 *  Returns object with all requested resources
		 *
		 *  @example: loader({
		 *      type: loader.MULTI,
		 *      resources: {
		 *          messages: 'EditPageLayout',
		 *          scripts: 'oasis_jquery,yui',
		 *          styles: 'path/to/style/file'
		 *          mustache: 'extensions/wikia/MyExy/templates/index.mustache',
		 *          templates: [{
		 *              controller: 'MyController',
		 *              method: 'getPage',
		 *              params: {
		 *                  page: 1
		 *              }
		 *          }],
		 *          params: {
		 *              useskin: 'skinname'
		 *          }
		 *      }
		 *  });
		 */
		getMultiTypePackage = function (options, complete, failure) {
			var templates = options.templates,
				send = false,
				prop;

			if (typeof templates !== 'undefined'){
				// JSON encode templates entry
				options.templates = (typeof templates === 'object') ? JSON.stringify(templates) : templates;
			}

			for (prop in options) {
				if (options.hasOwnProperty(prop) && multiAllowedOptions.indexOf(prop) !== -1) {
					send = true;
					break;
				}
			}

			if (send) {
				if (typeof options.params === 'object') {
					options = $.extend(options, options.params);
					delete options.params;
				}

				// add a cache buster
				options.cb = window.wgStyleVersion;

				if (typeof options.styles !== 'undefined') {
					// Add sass params to ensure per-theme colors Varnish cache and mcache
					options.sassParams = options.sassParams || window.wgSassParams;
				}

				if (typeof window.wgUserLanguage !== 'undefined' && typeof options.messages  !== 'undefined') {
					// Add language to avoid cache pollution
					options.uselang = window.wgUserLanguage;
				}

				nirvana.getJson(
					'AssetsManager',
					'getMultiTypePackage',
					options
				).done(
					function (resources, event) {
						// "register" JS messages
						if (resources.messages) {
							window.wgMessages = $.extend(window.wgMessages, resources.messages);
						}

						complete(event, resources);
					}
				).fail(failure);
			} else {
				failure();
			}
		};

	return (function () {
		/**
		 * Fetches a list of resources and fires a callback when they have all finished loading.
		 *
		 * If it fails it'll call onFail callback passing you packages that it couldn't load (in IE8
		 * only onSuccess works :()
		 *
		 * @supports JS, CSS, SASS, AM Groups, Libraries, Multi type packages
		 *
		 * @example: loader('/path/to/file.js').done(onSuccess).fail(onFail);
		 * @example: loader({
			 *     type: loader.JS,
			 *     resources: 'path/to/file.js'
			 *	},
		 * '/path/to/file.scss'
		 * ).then(onSuccess, onFail);
		 *
		 * You can also pass arrays of files to be loaded
		 * @example loader({type: JS, resources: ['one.js', 'some/other/file']})
		 *
		 * @author macbre
		 * @author kflorence
		 * @author Jakub Olek <jolek@wikia-inc.com>
		 */
		loader = function () {
			var assetsLength = arguments.length,
				remaining = arguments.length,
				matches,
				dfd = $.Deferred(),
				failed = [],
				func,
				result,
				resource,
				files,
				type,
				params,
				affected,
				complete = function (ev, res) {

					// res is saved locally and the only function here that returns it is getMultiTypePackage
					// but I can not ensure that this is last to be loaded
					// This means there is lack for multiple getMultiTypePackage calls - but should be discouraged
					if (res) {
						result = res;
					}

					remaining--;

					log(remaining + ' remaining...', log.levels.info, 'loader');

					// All files have been downloaded
					if (remaining <= 0) {
						if (!failed.length) {
							// Resolve the deferred object

							dfd.resolve(result);
						} else {
							dfd.reject({
								error: loader.NOT_LOADED,
								resources: failed,
								result: result
							});
						}

					}
				},
				failure = function (res) {
					return function (override) {
						log({errorLoading: res}, log.levels.error, 'loader');

						failed.push(override || res);
						complete();
					};
				};

			// Nothing to load
			if (!assetsLength) {
				complete();
			}

			while (assetsLength--) {
				resource = arguments[assetsLength];

				// URI string
				if (typeof resource === 'string') {
					matches = resource.match(rExtension);

					type = matches ? matches[0] : loader.UNKNOWN;
					files = resource;
				} else if (typeof resource === 'function') {
					// function returning a promise
					resource().
						done(complete).
						fail(failure);

					continue;
				} else {
					type = resource.type;
					files  = resource.resources || resource.url;
					params = resource.params;
				}

				func = get;

				if (type && files) {
					switch (type) {
						case loader.MULTI:
							func = getMultiTypePackage;
							break;
						case loader.LIBRARY:
							func = getLibrary;
							break;
						case loader.JS:
							files = getUrls(files, 'one', params);
							break;
						case loader.AM_GROUPS:
							files = getUrls(files, 'groups', params);
							break;
						case loader.CSS:
							files = getUrls(files, 'one', params);
							break;
						case loader.SCSS:
							files = getUrls(files, 'sass', params);
							break;
						default:
							failure({type: type, resources: files})();
							continue;
					}

					// This lets the loader know that current function will fire more than one complete callback
					// Used by get and getLibrary as they accept arrays as resources
					affected = func(files, complete, failure({type: type, resources: files}), type);
					if (affected > 0) {
						remaining += affected;
					}

				} else {
					dfd.reject({
						error: loader.CORRUPT_FORMAT,
						resource: resource
					});
				}
			}

			return dfd.promise();
		};

		//list of types:
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
		loader.processScript = function (js) {
			var i, l;
			if (isArray(js)) {
				for (i = 0, l = js.length; i < l; i++) {
					addScript(js[i]);
				}
			} else {
				addScript(js);
			}
		};

		/**
		 * Apply given CSS code by adding an inline <style> tag to document <body> tag
		 *
		 * css - CSS code to be applied
		 */
		loader.processStyle = function (css) {
			var style = createElement('style', {type: styleType});

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
});
