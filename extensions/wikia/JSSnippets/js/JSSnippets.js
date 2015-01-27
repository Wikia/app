/* global JSSnippetsStack: true, wgCdnRootUrl, wgResourceBasePath, wgAssetsManagerQuery, wgStyleVersion */
/**
 * JSSnippets client-side API
 *
 * @author Maciej Brencz (Macbre) <macbre(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 *
 * WARNING: This code is shared between Oasis/Monobook and WikiaMobile, please don't introduce library-specific code
 * (e.g jQuery, the $ calls in this file have been checked)
 *
 * TODO: remove any $ reference when we complete the transition to the Wikia namespace
 */

window.JSSnippets = (function () {
	'use strict';

	/** @private **/
	var stack,
		fullUrlRegex = new RegExp('^(http|https):\\/\\/', 'i'),
		extensionRegex = new RegExp('\\.([^.]+)$'),
		cacheBusterRegex = new RegExp('\\?cb=[0-9]+$', 'i'),
		slashRegex = new RegExp('^\\/'),
		debugMode = window.mw && mw.config ? mw.config.get('debug') : window.debug;

	/**
	 * Resolve dependencies, load them and initialize features
	 */
	function init() {
		if (!window.JSSnippetsStack || !JSSnippetsStack.length) {
			window.JSSnippetsStack = [];
			afterInit();
			return;
		}

		stack = JSSnippetsStack;

		// create unique list of dependencies (both static files and libraries loader functions) and callbacks
		var dependencies = [],
			callbacks = {},
			options = {},
			entry,
			x,
			len = stack.length;

		for (x = 0; x < len; x++) {
			entry = stack[x];

			if (entry.dependencies) {
				pushDependencies(dependencies, entry);
			}

			// get "loader" JS functions
			if (typeof entry.getLoaders === 'function') {
				pushLoaders(dependencies, entry);
			}

			if (dependencies.length === 0) {
				continue;
			}

			if (typeof entry.callback === 'function') {
				// register unique callback for each "type" of the code using JS snippets
				callbacks[entry.id] = entry.callback;

				// create a stack of options passed to each type of callback
				options[entry.id] = options[entry.id] || [];

				// push options to it
				options[entry.id].push(entry.options);
			}
		}

		if (dependencies.length === 0) {
			afterInit();
			return;
		}

		// remove duplicated dependencies
		dependencies = unique(dependencies);

		// load all dependencies in parallel and then fire all callbacks
		require(['wikia.loader', 'wikia.log'], function (loader, log) {
			loader.apply(
					loader,
					dependencies
				).done(
				function () {
					try {
						for (var id in callbacks) {
							for (x = 0, len = options[id].length; x < len; x++) {
								callbacks[id](options[id][x]);
							}
						}
					} catch (e) {
						log('Skipping running callback, cause: ' + e, log.levels.error);
					}
				}
			);
		});

		afterInit();
	}

	/**
	 * Handle any tasks that need to be preformed after the init method is done.
	 */
	function afterInit() {
		clearStack();
		updatePush();
	}

	// @see http://net.tutsplus.com/tutorials/javascript-ajax/javascript-from-null-utility-functions-and-debugging/
	function unique(origArr) {
		var newArr = [],
			origLen = origArr.length,
			found,
			x, y, l,
			elm;

		for (x = 0; x < origLen; x++) {
			found = undefined;
			elm = origArr[x].url || origArr[x];

			for (y = 0, l = newArr.length; y < l; y++) {
				if (elm === (newArr[y].url ? newArr[y].url : newArr[y])) {
					found = true;
					break;
				}
			}

			if (!found) {
				newArr.push(origArr[x]);
			}
		}

		return newArr;
	}

	/*
	 * Empty the array of items to process
	 */
	function clearStack() {
		//setting length to 0 is faster and takes less memory than re-creating the array
		window.JSSnippetsStack.length = 0;
	}

	/**
	 * Override the push method of the JSSnippetsStack so we can continue to add callbacks to JSSnippetsStack
	 * after initialization.
	 */
	function updatePush() {
		window.JSSnippetsStack.push = function (callback) {
			Array.prototype.push.apply(JSSnippetsStack, [callback]);
			init();
		};
	}

	/**
	 * Update the format of the dependency string so that it may be passed to loader() and loaded.
	 * @param {string} dependency String representing an asset that is a dependency of a given feature
	 * @returns {string}
	 */
	function formatDependency(dependency) {
		var ext;

		if (fullUrlRegex.test(dependency) || cacheBusterRegex.test(dependency)) {
			return dependency;
		}

		ext = dependency.match(extensionRegex);

		if (ext && ext.length > 0) {
			if (ext[1] === 'scss') {
				// fetch SCSS files via SASS processor
				dependency = $.getSassCommonURL(dependency);
			} else if (slashRegex.test(dependency)) {
				if (debugMode) {
					/*
					 * Handle allinone=0 mode
					 */
					dependency = wgResourceBasePath + dependency;
				} else {
					/*
					 * paths rewrite for CSS and JS files
					 * use AssetsManager to get minified CSS and JS files (when relative path is provided)
					 * for instance: /extensions/wikia/FooFeature/js/Foo.js
					 */
					dependency = wgCdnRootUrl + wgAssetsManagerQuery.
						replace('%1$s', 'one').
						replace('%2$s', dependency.replace(slashRegex, '')). // remove first slash
						replace('%3$s', '-').
						replace('%4$d', wgStyleVersion);
				}
			}
		}
		return dependency;
	}

	/**
	 * Process all assets that are dependencies for this feature
	 * @param {array} dependencies Running list of dependencies sent to JSSnippets
	 * @param {object} entry Current item in the JSSnippets stack loop
	 */
	function pushDependencies(dependencies, entry) {
		var dependency,
			y,
			len = entry.dependencies.length;

		// get list of JS/CSS files to load
		for (y = 0; y < len; y++) {
			dependency = entry.dependencies[y];

			if (typeof dependency === 'string' && dependency !== '') {
				dependency = formatDependency(dependency);
			}

			dependencies.push(dependency);
		}
	}

	/**
	 * Process all loader function shortcuts that are dependencies for this feature
	 * @param {array} dependencies
	 * @param {object} entry
	 */
	function pushLoaders(dependencies, entry) {
		var loaders = entry.getLoaders(),
			loaderFn,
			y,
			len = loaders.length;

		for (y = 0; y < len; y++) {
			loaderFn = loaders[y];

			if (typeof loaderFn === 'function') {
				dependencies.push(loaderFn);
			}
		}
	}

	$(init);

	/** @public **/

	return {
		init: init,
		clear: clearStack
	};
})();
