var DS =
	/******/ (function(modules) { // webpackBootstrap
	/******/ 	// The module cache
	/******/ 	var installedModules = {};
	/******/
	/******/ 	// The require function
	/******/ 	function __webpack_require__(moduleId) {
		/******/
		/******/ 		// Check if module is in cache
		/******/ 		if(installedModules[moduleId]) {
			/******/ 			return installedModules[moduleId].exports;
			/******/ 		}
		/******/ 		// Create a new module (and put it into the cache)
		/******/ 		var module = installedModules[moduleId] = {
			/******/ 			i: moduleId,
			/******/ 			l: false,
			/******/ 			exports: {}
			/******/ 		};
		/******/
		/******/ 		// Execute the module function
		/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
		/******/
		/******/ 		// Flag the module as loaded
		/******/ 		module.l = true;
		/******/
		/******/ 		// Return the exports of the module
		/******/ 		return module.exports;
		/******/ 	}
	/******/
	/******/
	/******/ 	// expose the modules object (__webpack_modules__)
	/******/ 	__webpack_require__.m = modules;
	/******/
	/******/ 	// expose the module cache
	/******/ 	__webpack_require__.c = installedModules;
	/******/
	/******/ 	// identity function for calling harmony imports with the correct context
	/******/ 	__webpack_require__.i = function(value) { return value; };
	/******/
	/******/ 	// define getter function for harmony exports
	/******/ 	__webpack_require__.d = function(exports, name, getter) {
		/******/ 		if(!__webpack_require__.o(exports, name)) {
			/******/ 			Object.defineProperty(exports, name, {
				/******/ 				configurable: false,
				/******/ 				enumerable: true,
				/******/ 				get: getter
				/******/ 			});
			/******/ 		}
		/******/ 	};
	/******/
	/******/ 	// getDefaultExport function for compatibility with non-harmony modules
	/******/ 	__webpack_require__.n = function(module) {
		/******/ 		var getter = module && module.__esModule ?
			/******/ 			function getDefault() { return module['default']; } :
			/******/ 			function getModuleExports() { return module; };
		/******/ 		__webpack_require__.d(getter, 'a', getter);
		/******/ 		return getter;
		/******/ 	};
	/******/
	/******/ 	// Object.prototype.hasOwnProperty.call
	/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
	/******/
	/******/ 	// __webpack_public_path__
	/******/ 	__webpack_require__.p = "";
	/******/
	/******/ 	// Load entry module and return exports
	/******/ 	return __webpack_require__(__webpack_require__.s = 10);
	/******/ })
/************************************************************************/
/******/ ([
	/* 0 */
	/***/ (function(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_dropdown_dropdown_js__ = __webpack_require__(1);
		/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_test_component_test_component_js__ = __webpack_require__(2);
		/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_dropdown_dropdown_css__ = __webpack_require__(9);
		/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_dropdown_dropdown_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_dropdown_dropdown_css__);
		/* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "dropdown", function() { return __WEBPACK_IMPORTED_MODULE_0_dropdown_dropdown_js__; });
		/* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "testComponent", function() { return __WEBPACK_IMPORTED_MODULE_1_test_component_test_component_js__; });



		// if you want to add styles, just require them below and let Webpack do it's magic




		/***/ }),
	/* 1 */
	/***/ (function(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_closest_element__ = __webpack_require__(3);
		/* harmony export (immutable) */ __webpack_exports__["hookDropdown"] = hookDropdown;


		var dropdownClass = 'wds-dropdown';
		var dropdownToggleClass = 'wds-dropdown__toggle';
		var dropdownContentClass = 'wds-dropdown__content';

		var activeClass = 'wds-is-active';

		/**
		 * Close all dropdowns except current
		 * @param   {Element} dropdownToKeepOpen
		 * @returns {void}
		 */
		function closeEveryDropdown(dropdownToKeepOpen) {
			var activeDropdowns = document.querySelectorAll('.' + dropdownClass + '.' + activeClass);

			if (dropdownToKeepOpen) {
				[].forEach.call(activeDropdowns, function (dropdown) {
					if (dropdown !== dropdownToKeepOpen) {
						dropdown.classList.remove(activeClass);
					}
				});
			} else {
				[].forEach.call(activeDropdowns, function (dropdown) {
					dropdown.classList.remove(activeClass);
				});
			}
		}

		var hookedToBody = false;

		/**
		 * Function that opens given dropdown and closes anything else
		 *
		 * @param   {Element} dropdown
		 * @returns {void}
		 */
		function openDropdown(dropdown) {
			closeEveryDropdown(dropdown);
			dropdown.classList.add(activeClass);
		}

		/**
		 * Function that hooks to the `<body>` and listens on click to close dropdowns
		 * @returns {void}
		 */
		function hookToBody() {
			if (hookedToBody) {
				return;
			}

			hookedToBody = true;

			document.addEventListener('click', function (ev) {
				var closest = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__utils_closest_element__["a" /* default */])(ev.target, '.' + dropdownClass);
				closeEveryDropdown(closest);
			});
		}

		/**
		 * Hook to the element
		 * @param   {Element} dropdown
		 * @returns {void}
		 */
		function hookDropdown(dropdown) {
			hookToBody();

			dropdown.querySelector('.' + dropdownToggleClass).addEventListener('click', function () {
				if (dropdown.classList.contains(activeClass)) {
					dropdown.classList.remove(activeClass);
				} else {
					openDropdown(dropdown);
				}
			});
		}

		/* harmony default export */ __webpack_exports__["default"] = ({
			hookDropdown: hookDropdown
		});

		/***/ }),
	/* 2 */
	/***/ (function(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
		/* harmony export (immutable) */ __webpack_exports__["init"] = init;
		function init() {
			console.log('hi from test-component');
		}

		/* harmony default export */ __webpack_exports__["default"] = ({
			init: init
		});

		/***/ }),
	/* 3 */
	/***/ (function(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__element_matches__ = __webpack_require__(4);
		/* harmony export (immutable) */ __webpack_exports__["a"] = closestElement;

		/**
		 * Get the closest ancestor element that matches a give selector
		 * Similar to jQuery's $.fn.closest
		 * @param {Element} elem
		 * @param {string} selector
		 * @returns {Element|null}
		 */
		function closestElement(elem, selector) {
			if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__element_matches__["a" /* default */])(elem, selector)) {
				return elem;
			}

			if (!elem.parentElement) {
				return null;
			}

			return closestElement(elem.parentElement, selector);
		}

		/***/ }),
	/* 4 */
	/***/ (function(module, __webpack_exports__, __webpack_require__) {

		"use strict";
		/* harmony export (immutable) */ __webpack_exports__["a"] = elementMatches;
		/**
		 * Is this element queryable by the given selector?
		 * Similar to jQuery's $.fn.is
		 *
		 * @param {Element} element
		 * @param {string} selector
		 * @returns {boolean}
		 */
		function elementMatches(element, selector) {
			var selectorElements = (element.document || element.ownerDocument).querySelectorAll(selector);
			var matches = false;

			[].forEach.call(selectorElements, function (selectorElement) {
				if (selectorElement === element) {
					matches = true;
				}
			});

			return matches;
		}

		/***/ }),
	/* 5 */
	/***/ (function(module, exports, __webpack_require__) {

		exports = module.exports = __webpack_require__(6)(undefined);
		// imports


		// module
		exports.push([module.i, ".wds-dropdown {\n\t--content-z-index: 1;\n\n\tdisplay: inline-block;\n\tposition: relative;\n}\n\n.wds-dropdown__toggle {\n\tcursor: pointer;\n\tposition: relative;\n\t/* dropdown content has shadow that should be hidden below the toggle*/\n\tz-index: calc(var(--content-z-index) + 1);\n}\n\n.wds-dropdown__content {\n\tdisplay: none;\n\tleft: 0;\n\tposition: absolute;\n\ttop: 100%;\n\tz-index: var(--content-z-index);\n}\n\n.wds-dropdown.wds-is-active .wds-dropdown__content {\n\t display: inline-block;\n }\n", ""]);

		// exports


		/***/ }),
	/* 6 */
	/***/ (function(module, exports) {

		/*
		 MIT License http://www.opensource.org/licenses/mit-license.php
		 Author Tobias Koppers @sokra
		 */
		// css base code, injected by the css-loader
		module.exports = function(useSourceMap) {
			var list = [];

			// return the list of modules as css string
			list.toString = function toString() {
				return this.map(function (item) {
					var content = cssWithMappingToString(item, useSourceMap);
					if(item[2]) {
						return "@media " + item[2] + "{" + content + "}";
					} else {
						return content;
					}
				}).join("");
			};

			// import a list of modules into the list
			list.i = function(modules, mediaQuery) {
				if(typeof modules === "string")
					modules = [[null, modules, ""]];
				var alreadyImportedModules = {};
				for(var i = 0; i < this.length; i++) {
					var id = this[i][0];
					if(typeof id === "number")
						alreadyImportedModules[id] = true;
				}
				for(i = 0; i < modules.length; i++) {
					var item = modules[i];
					// skip already imported module
					// this implementation is not 100% perfect for weird media query combinations
					//  when a module is imported multiple times with different media queries.
					//  I hope this will never occur (Hey this way we have smaller bundles)
					if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
						if(mediaQuery && !item[2]) {
							item[2] = mediaQuery;
						} else if(mediaQuery) {
							item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
						}
						list.push(item);
					}
				}
			};
			return list;
		};

		function cssWithMappingToString(item, useSourceMap) {
			var content = item[1] || '';
			var cssMapping = item[3];
			if (!cssMapping) {
				return content;
			}

			if (useSourceMap && typeof btoa === 'function') {
				var sourceMapping = toComment(cssMapping);
				var sourceURLs = cssMapping.sources.map(function (source) {
					return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
				});

				return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
			}

			return [content].join('\n');
		}

		// Adapted from convert-source-map (MIT)
		function toComment(sourceMap) {
			// eslint-disable-next-line no-undef
			var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
			var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

			return '/*# ' + data + ' */';
		}


		/***/ }),
	/* 7 */
	/***/ (function(module, exports, __webpack_require__) {

		/*
		 MIT License http://www.opensource.org/licenses/mit-license.php
		 Author Tobias Koppers @sokra
		 */
		var stylesInDom = {},
			memoize = function(fn) {
				var memo;
				return function () {
					if (typeof memo === "undefined") memo = fn.apply(this, arguments);
					return memo;
				};
			},
			isOldIE = memoize(function() {
				// Test for IE <= 9 as proposed by Browserhacks
				// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
				// Tests for existence of standard globals is to allow style-loader
				// to operate correctly into non-standard environments
				// @see https://github.com/webpack-contrib/style-loader/issues/177
				return window && document && document.all && !window.atob;
			}),
			getElement = (function(fn) {
				var memo = {};
				return function(selector) {
					if (typeof memo[selector] === "undefined") {
						memo[selector] = fn.call(this, selector);
					}
					return memo[selector]
				};
			})(function (styleTarget) {
				return document.querySelector(styleTarget)
			}),
			singletonElement = null,
			singletonCounter = 0,
			styleElementsInsertedAtTop = [],
			fixUrls = __webpack_require__(8);

		module.exports = function(list, options) {
			if(typeof DEBUG !== "undefined" && DEBUG) {
				if(typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
			}

			options = options || {};
			options.attrs = typeof options.attrs === "object" ? options.attrs : {};

			// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
			// tags it will allow on a page
			if (typeof options.singleton === "undefined") options.singleton = isOldIE();

			// By default, add <style> tags to the <head> element
			if (typeof options.insertInto === "undefined") options.insertInto = "head";

			// By default, add <style> tags to the bottom of the target
			if (typeof options.insertAt === "undefined") options.insertAt = "bottom";

			var styles = listToStyles(list);
			addStylesToDom(styles, options);

			return function update(newList) {
				var mayRemove = [];
				for(var i = 0; i < styles.length; i++) {
					var item = styles[i];
					var domStyle = stylesInDom[item.id];
					domStyle.refs--;
					mayRemove.push(domStyle);
				}
				if(newList) {
					var newStyles = listToStyles(newList);
					addStylesToDom(newStyles, options);
				}
				for(var i = 0; i < mayRemove.length; i++) {
					var domStyle = mayRemove[i];
					if(domStyle.refs === 0) {
						for(var j = 0; j < domStyle.parts.length; j++)
							domStyle.parts[j]();
						delete stylesInDom[domStyle.id];
					}
				}
			};
		};

		function addStylesToDom(styles, options) {
			for(var i = 0; i < styles.length; i++) {
				var item = styles[i];
				var domStyle = stylesInDom[item.id];
				if(domStyle) {
					domStyle.refs++;
					for(var j = 0; j < domStyle.parts.length; j++) {
						domStyle.parts[j](item.parts[j]);
					}
					for(; j < item.parts.length; j++) {
						domStyle.parts.push(addStyle(item.parts[j], options));
					}
				} else {
					var parts = [];
					for(var j = 0; j < item.parts.length; j++) {
						parts.push(addStyle(item.parts[j], options));
					}
					stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
				}
			}
		}

		function listToStyles(list) {
			var styles = [];
			var newStyles = {};
			for(var i = 0; i < list.length; i++) {
				var item = list[i];
				var id = item[0];
				var css = item[1];
				var media = item[2];
				var sourceMap = item[3];
				var part = {css: css, media: media, sourceMap: sourceMap};
				if(!newStyles[id])
					styles.push(newStyles[id] = {id: id, parts: [part]});
				else
					newStyles[id].parts.push(part);
			}
			return styles;
		}

		function insertStyleElement(options, styleElement) {
			var styleTarget = getElement(options.insertInto)
			if (!styleTarget) {
				throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
			}
			var lastStyleElementInsertedAtTop = styleElementsInsertedAtTop[styleElementsInsertedAtTop.length - 1];
			if (options.insertAt === "top") {
				if(!lastStyleElementInsertedAtTop) {
					styleTarget.insertBefore(styleElement, styleTarget.firstChild);
				} else if(lastStyleElementInsertedAtTop.nextSibling) {
					styleTarget.insertBefore(styleElement, lastStyleElementInsertedAtTop.nextSibling);
				} else {
					styleTarget.appendChild(styleElement);
				}
				styleElementsInsertedAtTop.push(styleElement);
			} else if (options.insertAt === "bottom") {
				styleTarget.appendChild(styleElement);
			} else {
				throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
			}
		}

		function removeStyleElement(styleElement) {
			styleElement.parentNode.removeChild(styleElement);
			var idx = styleElementsInsertedAtTop.indexOf(styleElement);
			if(idx >= 0) {
				styleElementsInsertedAtTop.splice(idx, 1);
			}
		}

		function createStyleElement(options) {
			var styleElement = document.createElement("style");
			options.attrs.type = "text/css";

			attachTagAttrs(styleElement, options.attrs);
			insertStyleElement(options, styleElement);
			return styleElement;
		}

		function createLinkElement(options) {
			var linkElement = document.createElement("link");
			options.attrs.type = "text/css";
			options.attrs.rel = "stylesheet";

			attachTagAttrs(linkElement, options.attrs);
			insertStyleElement(options, linkElement);
			return linkElement;
		}

		function attachTagAttrs(element, attrs) {
			Object.keys(attrs).forEach(function (key) {
				element.setAttribute(key, attrs[key]);
			});
		}

		function addStyle(obj, options) {
			var styleElement, update, remove;

			if (options.singleton) {
				var styleIndex = singletonCounter++;
				styleElement = singletonElement || (singletonElement = createStyleElement(options));
				update = applyToSingletonTag.bind(null, styleElement, styleIndex, false);
				remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true);
			} else if(obj.sourceMap &&
			          typeof URL === "function" &&
			          typeof URL.createObjectURL === "function" &&
			          typeof URL.revokeObjectURL === "function" &&
			          typeof Blob === "function" &&
			          typeof btoa === "function") {
				styleElement = createLinkElement(options);
				update = updateLink.bind(null, styleElement, options);
				remove = function() {
					removeStyleElement(styleElement);
					if(styleElement.href)
						URL.revokeObjectURL(styleElement.href);
				};
			} else {
				styleElement = createStyleElement(options);
				update = applyToTag.bind(null, styleElement);
				remove = function() {
					removeStyleElement(styleElement);
				};
			}

			update(obj);

			return function updateStyle(newObj) {
				if(newObj) {
					if(newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap)
						return;
					update(obj = newObj);
				} else {
					remove();
				}
			};
		}

		var replaceText = (function () {
			var textStore = [];

			return function (index, replacement) {
				textStore[index] = replacement;
				return textStore.filter(Boolean).join('\n');
			};
		})();

		function applyToSingletonTag(styleElement, index, remove, obj) {
			var css = remove ? "" : obj.css;

			if (styleElement.styleSheet) {
				styleElement.styleSheet.cssText = replaceText(index, css);
			} else {
				var cssNode = document.createTextNode(css);
				var childNodes = styleElement.childNodes;
				if (childNodes[index]) styleElement.removeChild(childNodes[index]);
				if (childNodes.length) {
					styleElement.insertBefore(cssNode, childNodes[index]);
				} else {
					styleElement.appendChild(cssNode);
				}
			}
		}

		function applyToTag(styleElement, obj) {
			var css = obj.css;
			var media = obj.media;

			if(media) {
				styleElement.setAttribute("media", media)
			}

			if(styleElement.styleSheet) {
				styleElement.styleSheet.cssText = css;
			} else {
				while(styleElement.firstChild) {
					styleElement.removeChild(styleElement.firstChild);
				}
				styleElement.appendChild(document.createTextNode(css));
			}
		}

		function updateLink(linkElement, options, obj) {
			var css = obj.css;
			var sourceMap = obj.sourceMap;

			/* If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
			 and there is no publicPath defined then lets turn convertToAbsoluteUrls
			 on by default.  Otherwise default to the convertToAbsoluteUrls option
			 directly
			 */
			var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

			if (options.convertToAbsoluteUrls || autoFixUrls){
				css = fixUrls(css);
			}

			if(sourceMap) {
				// http://stackoverflow.com/a/26603875
				css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
			}

			var blob = new Blob([css], { type: "text/css" });

			var oldSrc = linkElement.href;

			linkElement.href = URL.createObjectURL(blob);

			if(oldSrc)
				URL.revokeObjectURL(oldSrc);
		}


		/***/ }),
	/* 8 */
	/***/ (function(module, exports) {


		/**
		 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
		 * embed the css on the page. This breaks all relative urls because now they are relative to a
		 * bundle instead of the current page.
		 *
		 * One solution is to only use full urls, but that may be impossible.
		 *
		 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
		 *
		 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
		 *
		 */

		module.exports = function (css) {
			// get current location
			var location = typeof window !== "undefined" && window.location;

			if (!location) {
				throw new Error("fixUrls requires window.location");
			}

			// blank or null?
			if (!css || typeof css !== "string") {
				return css;
			}

			var baseUrl = location.protocol + "//" + location.host;
			var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

			// convert each url(...)
			/*
			 This regular expression is just a way to recursively match brackets within
			 a string.

			 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
			 (  = Start a capturing group
			 (?:  = Start a non-capturing group
			 [^)(]  = Match anything that isn't a parentheses
			 |  = OR
			 \(  = Match a start parentheses
			 (?:  = Start another non-capturing groups
			 [^)(]+  = Match anything that isn't a parentheses
			 |  = OR
			 \(  = Match a start parentheses
			 [^)(]*  = Match anything that isn't a parentheses
			 \)  = Match a end parentheses
			 )  = End Group
			 *\) = Match anything and then a close parens
			 )  = Close non-capturing group
			 *  = Match anything
			 )  = Close capturing group
			 \)  = Match a close parens

			 /gi  = Get all matches, not the first.  Be case insensitive.
			 */
			var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function(fullMatch, origUrl) {
				// strip quotes (if they exist)
				var unquotedOrigUrl = origUrl
					.trim()
					.replace(/^"(.*)"$/, function(o, $1){ return $1; })
					.replace(/^'(.*)'$/, function(o, $1){ return $1; });

				// already a full url? no change
				if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(unquotedOrigUrl)) {
					return fullMatch;
				}

				// convert the url to a full url
				var newUrl;

				if (unquotedOrigUrl.indexOf("//") === 0) {
					//TODO: should we add protocol?
					newUrl = unquotedOrigUrl;
				} else if (unquotedOrigUrl.indexOf("/") === 0) {
					// path should be relative to the base url
					newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
				} else {
					// path should be relative to current directory
					newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
				}

				// send back the fixed url(...)
				return "url(" + JSON.stringify(newUrl) + ")";
			});

			// send back the fixed css
			return fixedCss;
		};


		/***/ }),
	/* 9 */
	/***/ (function(module, exports, __webpack_require__) {

		// style-loader: Adds some css to the DOM by adding a <style> tag

		// load the styles
		var content = __webpack_require__(5);
		if(typeof content === 'string') content = [[module.i, content, '']];
		// add the styles to the DOM
		var update = __webpack_require__(7)(content, {"convertToAbsoluteUrls":false,"sourceMap":false});
		if(content.locals) module.exports = content.locals;
		// Hot Module Replacement
		if(false) {
			// When the styles change, update the <style> tags
			if(!content.locals) {
				module.hot.accept("!!../../node_modules/css-loader/index.js??ref--0-1!../../node_modules/postcss-loader/index.js!./dropdown.css", function() {
					var newContent = require("!!../../node_modules/css-loader/index.js??ref--0-1!../../node_modules/postcss-loader/index.js!./dropdown.css");
					if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
					update(newContent);
				});
			}
			// When the module is disposed, remove the <style> tags
			module.hot.dispose(function() { update(); });
		}

		/***/ }),
	/* 10 */
	/***/ (function(module, exports, __webpack_require__) {

		module.exports = __webpack_require__(0);


		/***/ })
	/******/ ]);
