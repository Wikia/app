(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
	(function webpackUniversalModuleDefinition(root, factory) {
		if(typeof exports === 'object' && typeof module === 'object')
			module.exports = factory();
		else if(typeof define === 'function' && define.amd)
			define([], factory);
		else if(typeof exports === 'object')
			exports["skatejsWebComponents"] = factory();
		else
			root["skatejsWebComponents"] = factory();
	})(this, function() {
		return /******/ (function(modules) { // webpackBootstrap
			/******/ 	// The module cache
			/******/ 	var installedModules = {};
			/******/
			/******/ 	// The require function
			/******/ 	function __webpack_require__(moduleId) {
				/******/
				/******/ 		// Check if module is in cache
				/******/ 		if(installedModules[moduleId])
				/******/ 			return installedModules[moduleId].exports;
				/******/
				/******/ 		// Create a new module (and put it into the cache)
				/******/ 		var module = installedModules[moduleId] = {
					/******/ 			exports: {},
					/******/ 			id: moduleId,
					/******/ 			loaded: false
					/******/ 		};
				/******/
				/******/ 		// Execute the module function
				/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
				/******/
				/******/ 		// Flag the module as loaded
				/******/ 		module.loaded = true;
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
			/******/ 	// __webpack_public_path__
			/******/ 	__webpack_require__.p = "";
			/******/
			/******/ 	// Load entry module and return exports
			/******/ 	return __webpack_require__(0);
			/******/ })
		/************************************************************************/
		/******/ ([
			/* 0 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				// NOTE!!!
				//
				// We have to load polyfills directly from source as non-minified files are not
				// published by the polyfills. An issue was raised to discuss this problem and
				// to see if it can be resolved.
				//
				// See https://github.com/webcomponents/custom-elements/issues/45

				// ES2015 polyfills required for the polyfills to work in older browsers.
				__webpack_require__(1).shim();
				__webpack_require__(26).shim();
				__webpack_require__(31).polyfill();

				// We have to include this first so that it can patch native. This must be done
				// before any polyfills are loaded.
				__webpack_require__(34);

				// Template polyfill is necessary to use shadycss in IE11
				// this comes before custom elements because of
				// https://github.com/webcomponents/template/blob/master/template.js#L39
				__webpack_require__(35);

				// This comes after the native shim because it requries it to be patched first.
				__webpack_require__(36);

				// Force the polyfill in Safari 10.0.0 and 10.0.1.
				var _window = window,
					navigator = _window.navigator;
				var userAgent = navigator.userAgent;

				var safari = userAgent.indexOf('Safari/60') !== -1;
				var safariVersion = safari && userAgent.match(/Version\/([^\s]+)/)[1];
				var safariVersions = [0, 1].map(function (v) {
					return '10.0.' + v;
				}).concat(['10.0']);

				if (safari && safariVersions.indexOf(safariVersion) > -1) {
					window.ShadyDOM = { force: true };
				}

				// ShadyDOM comes first. Both because it may need to be forced and the
				// ShadyCSS polyfill requires it to function.
				__webpack_require__(51);
				__webpack_require__(67);

				/***/ },
			/* 1 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var define = __webpack_require__(2);

				var implementation = __webpack_require__(6);
				var getPolyfill = __webpack_require__(24);
				var shim = __webpack_require__(25);

				// eslint-disable-next-line no-unused-vars
				var boundFromShim = function from(array) {
					// eslint-disable-next-line no-invalid-this
					return implementation.apply(this || Array, arguments);
				};

				define(boundFromShim, {
					'getPolyfill': getPolyfill,
					'implementation': implementation,
					'shim': shim
				});

				module.exports = boundFromShim;

				/***/ },
			/* 2 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var keys = __webpack_require__(3);
				var foreach = __webpack_require__(5);
				var hasSymbols = typeof Symbol === 'function' && _typeof(Symbol()) === 'symbol';

				var toStr = Object.prototype.toString;

				var isFunction = function isFunction(fn) {
					return typeof fn === 'function' && toStr.call(fn) === '[object Function]';
				};

				var arePropertyDescriptorsSupported = function arePropertyDescriptorsSupported() {
					var obj = {};
					try {
						Object.defineProperty(obj, 'x', { enumerable: false, value: obj });
						/* eslint-disable no-unused-vars, no-restricted-syntax */
						for (var _ in obj) {
							return false;
						}
						/* eslint-enable no-unused-vars, no-restricted-syntax */
						return obj.x === obj;
					} catch (e) {
						/* this is IE 8. */
						return false;
					}
				};
				var supportsDescriptors = Object.defineProperty && arePropertyDescriptorsSupported();

				var defineProperty = function defineProperty(object, name, value, predicate) {
					if (name in object && (!isFunction(predicate) || !predicate())) {
						return;
					}
					if (supportsDescriptors) {
						Object.defineProperty(object, name, {
							configurable: true,
							enumerable: false,
							value: value,
							writable: true
						});
					} else {
						object[name] = value;
					}
				};

				var defineProperties = function defineProperties(object, map) {
					var predicates = arguments.length > 2 ? arguments[2] : {};
					var props = keys(map);
					if (hasSymbols) {
						props = props.concat(Object.getOwnPropertySymbols(map));
					}
					foreach(props, function (name) {
						defineProperty(object, name, map[name], predicates[name]);
					});
				};

				defineProperties.supportsDescriptors = !!supportsDescriptors;

				module.exports = defineProperties;

				/***/ },
			/* 3 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				// modified from https://github.com/es-shims/es5-shim

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var has = Object.prototype.hasOwnProperty;
				var toStr = Object.prototype.toString;
				var slice = Array.prototype.slice;
				var isArgs = __webpack_require__(4);
				var isEnumerable = Object.prototype.propertyIsEnumerable;
				var hasDontEnumBug = !isEnumerable.call({ toString: null }, 'toString');
				var hasProtoEnumBug = isEnumerable.call(function () {}, 'prototype');
				var dontEnums = ['toString', 'toLocaleString', 'valueOf', 'hasOwnProperty', 'isPrototypeOf', 'propertyIsEnumerable', 'constructor'];
				var equalsConstructorPrototype = function equalsConstructorPrototype(o) {
					var ctor = o.constructor;
					return ctor && ctor.prototype === o;
				};
				var excludedKeys = {
					$console: true,
					$external: true,
					$frame: true,
					$frameElement: true,
					$frames: true,
					$innerHeight: true,
					$innerWidth: true,
					$outerHeight: true,
					$outerWidth: true,
					$pageXOffset: true,
					$pageYOffset: true,
					$parent: true,
					$scrollLeft: true,
					$scrollTop: true,
					$scrollX: true,
					$scrollY: true,
					$self: true,
					$webkitIndexedDB: true,
					$webkitStorageInfo: true,
					$window: true
				};
				var hasAutomationEqualityBug = function () {
					/* global window */
					if (typeof window === 'undefined') {
						return false;
					}
					for (var k in window) {
						try {
							if (!excludedKeys['$' + k] && has.call(window, k) && window[k] !== null && _typeof(window[k]) === 'object') {
								try {
									equalsConstructorPrototype(window[k]);
								} catch (e) {
									return true;
								}
							}
						} catch (e) {
							return true;
						}
					}
					return false;
				}();
				var equalsConstructorPrototypeIfNotBuggy = function equalsConstructorPrototypeIfNotBuggy(o) {
					/* global window */
					if (typeof window === 'undefined' || !hasAutomationEqualityBug) {
						return equalsConstructorPrototype(o);
					}
					try {
						return equalsConstructorPrototype(o);
					} catch (e) {
						return false;
					}
				};

				var keysShim = function keys(object) {
					var isObject = object !== null && (typeof object === 'undefined' ? 'undefined' : _typeof(object)) === 'object';
					var isFunction = toStr.call(object) === '[object Function]';
					var isArguments = isArgs(object);
					var isString = isObject && toStr.call(object) === '[object String]';
					var theKeys = [];

					if (!isObject && !isFunction && !isArguments) {
						throw new TypeError('Object.keys called on a non-object');
					}

					var skipProto = hasProtoEnumBug && isFunction;
					if (isString && object.length > 0 && !has.call(object, 0)) {
						for (var i = 0; i < object.length; ++i) {
							theKeys.push(String(i));
						}
					}

					if (isArguments && object.length > 0) {
						for (var j = 0; j < object.length; ++j) {
							theKeys.push(String(j));
						}
					} else {
						for (var name in object) {
							if (!(skipProto && name === 'prototype') && has.call(object, name)) {
								theKeys.push(String(name));
							}
						}
					}

					if (hasDontEnumBug) {
						var skipConstructor = equalsConstructorPrototypeIfNotBuggy(object);

						for (var k = 0; k < dontEnums.length; ++k) {
							if (!(skipConstructor && dontEnums[k] === 'constructor') && has.call(object, dontEnums[k])) {
								theKeys.push(dontEnums[k]);
							}
						}
					}
					return theKeys;
				};

				keysShim.shim = function shimObjectKeys() {
					if (Object.keys) {
						var keysWorksWithArguments = function () {
							// Safari 5.0 bug
							return (Object.keys(arguments) || '').length === 2;
						}(1, 2);
						if (!keysWorksWithArguments) {
							var originalKeys = Object.keys;
							Object.keys = function keys(object) {
								if (isArgs(object)) {
									return originalKeys(slice.call(object));
								} else {
									return originalKeys(object);
								}
							};
						}
					} else {
						Object.keys = keysShim;
					}
					return Object.keys || keysShim;
				};

				module.exports = keysShim;

				/***/ },
			/* 4 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var toStr = Object.prototype.toString;

				module.exports = function isArguments(value) {
					var str = toStr.call(value);
					var isArgs = str === '[object Arguments]';
					if (!isArgs) {
						isArgs = str !== '[object Array]' && value !== null && (typeof value === 'undefined' ? 'undefined' : _typeof(value)) === 'object' && typeof value.length === 'number' && value.length >= 0 && toStr.call(value.callee) === '[object Function]';
					}
					return isArgs;
				};

				/***/ },
			/* 5 */
			/***/ function(module, exports) {

				'use strict';

				var hasOwn = Object.prototype.hasOwnProperty;
				var toString = Object.prototype.toString;

				module.exports = function forEach(obj, fn, ctx) {
					if (toString.call(fn) !== '[object Function]') {
						throw new TypeError('iterator must be a function');
					}
					var l = obj.length;
					if (l === +l) {
						for (var i = 0; i < l; i++) {
							fn.call(ctx, obj[i], i, obj);
						}
					} else {
						for (var k in obj) {
							if (hasOwn.call(obj, k)) {
								fn.call(ctx, obj[k], k, obj);
							}
						}
					}
				};

				/***/ },
			/* 6 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var ES = __webpack_require__(7);
				var supportsDescriptors = __webpack_require__(2).supportsDescriptors;

				/*! https://mths.be/array-from v0.2.0 by @mathias */
				module.exports = function from(arrayLike) {
					var defineProperty = supportsDescriptors ? Object.defineProperty : function put(object, key, descriptor) {
						object[key] = descriptor.value;
					};
					var C = this;
					if (arrayLike === null || typeof arrayLike === 'undefined') {
						throw new TypeError('`Array.from` requires an array-like object, not `null` or `undefined`');
					}
					var items = ES.ToObject(arrayLike);

					var mapFn, T;
					if (typeof arguments[1] !== 'undefined') {
						mapFn = arguments[1];
						if (!ES.IsCallable(mapFn)) {
							throw new TypeError('When provided, the second argument to `Array.from` must be a function');
						}
						if (arguments.length > 2) {
							T = arguments[2];
						}
					}

					var len = ES.ToLength(items.length);
					var A = ES.IsCallable(C) ? ES.ToObject(new C(len)) : new Array(len);
					var k = 0;
					var kValue, mappedValue;
					while (k < len) {
						kValue = items[k];
						if (mapFn) {
							mappedValue = typeof T === 'undefined' ? mapFn(kValue, k) : ES.Call(mapFn, T, [kValue, k]);
						} else {
							mappedValue = kValue;
						}
						defineProperty(A, k, {
							'configurable': true,
							'enumerable': true,
							'value': mappedValue,
							'writable': true
						});
						k += 1;
					}
					A.length = len;
					return A;
				};

				/***/ },
			/* 7 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var toStr = Object.prototype.toString;
				var hasSymbols = typeof Symbol === 'function' && _typeof(Symbol.iterator) === 'symbol';
				var symbolToStr = hasSymbols ? Symbol.prototype.toString : toStr;

				var $isNaN = __webpack_require__(8);
				var $isFinite = __webpack_require__(9);
				var MAX_SAFE_INTEGER = Number.MAX_SAFE_INTEGER || Math.pow(2, 53) - 1;

				var assign = __webpack_require__(10);
				var sign = __webpack_require__(11);
				var mod = __webpack_require__(12);
				var isPrimitive = __webpack_require__(13);
				var toPrimitive = __webpack_require__(14);
				var parseInteger = parseInt;
				var bind = __webpack_require__(19);
				var strSlice = bind.call(Function.call, String.prototype.slice);
				var isBinary = bind.call(Function.call, RegExp.prototype.test, /^0b[01]+$/i);
				var isOctal = bind.call(Function.call, RegExp.prototype.test, /^0o[0-7]+$/i);
				var nonWS = ['\x85', '\u200B', '\uFFFE'].join('');
				var nonWSregex = new RegExp('[' + nonWS + ']', 'g');
				var hasNonWS = bind.call(Function.call, RegExp.prototype.test, nonWSregex);
				var invalidHexLiteral = /^[\-\+]0x[0-9a-f]+$/i;
				var isInvalidHexLiteral = bind.call(Function.call, RegExp.prototype.test, invalidHexLiteral);

				// whitespace from: http://es5.github.io/#x15.5.4.20
				// implementation from https://github.com/es-shims/es5-shim/blob/v3.4.0/es5-shim.js#L1304-L1324
				var ws = ['\t\n\x0B\f\r \xA0\u1680\u180E\u2000\u2001\u2002\u2003', '\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028', '\u2029\uFEFF'].join('');
				var trimRegex = new RegExp('(^[' + ws + ']+)|([' + ws + ']+$)', 'g');
				var replace = bind.call(Function.call, String.prototype.replace);
				var trim = function trim(value) {
					return replace(value, trimRegex, '');
				};

				var ES5 = __webpack_require__(21);

				var hasRegExpMatcher = __webpack_require__(23);

				// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-abstract-operations
				var ES6 = assign(assign({}, ES5), {

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-call-f-v-args
					Call: function Call(F, V) {
						var args = arguments.length > 2 ? arguments[2] : [];
						if (!this.IsCallable(F)) {
							throw new TypeError(F + ' is not a function');
						}
						return F.apply(V, args);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-toprimitive
					ToPrimitive: toPrimitive,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-toboolean
					// ToBoolean: ES5.ToBoolean,

					// http://www.ecma-international.org/ecma-262/6.0/#sec-tonumber
					ToNumber: function ToNumber(argument) {
						var value = isPrimitive(argument) ? argument : toPrimitive(argument, 'number');
						if ((typeof value === 'undefined' ? 'undefined' : _typeof(value)) === 'symbol') {
							throw new TypeError('Cannot convert a Symbol value to a number');
						}
						if (typeof value === 'string') {
							if (isBinary(value)) {
								return this.ToNumber(parseInteger(strSlice(value, 2), 2));
							} else if (isOctal(value)) {
								return this.ToNumber(parseInteger(strSlice(value, 2), 8));
							} else if (hasNonWS(value) || isInvalidHexLiteral(value)) {
								return NaN;
							} else {
								var trimmed = trim(value);
								if (trimmed !== value) {
									return this.ToNumber(trimmed);
								}
							}
						}
						return Number(value);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-tointeger
					// ToInteger: ES5.ToNumber,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-toint32
					// ToInt32: ES5.ToInt32,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-touint32
					// ToUint32: ES5.ToUint32,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-toint16
					ToInt16: function ToInt16(argument) {
						var int16bit = this.ToUint16(argument);
						return int16bit >= 0x8000 ? int16bit - 0x10000 : int16bit;
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-touint16
					// ToUint16: ES5.ToUint16,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-toint8
					ToInt8: function ToInt8(argument) {
						var int8bit = this.ToUint8(argument);
						return int8bit >= 0x80 ? int8bit - 0x100 : int8bit;
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-touint8
					ToUint8: function ToUint8(argument) {
						var number = this.ToNumber(argument);
						if ($isNaN(number) || number === 0 || !$isFinite(number)) {
							return 0;
						}
						var posInt = sign(number) * Math.floor(Math.abs(number));
						return mod(posInt, 0x100);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-touint8clamp
					ToUint8Clamp: function ToUint8Clamp(argument) {
						var number = this.ToNumber(argument);
						if ($isNaN(number) || number <= 0) {
							return 0;
						}
						if (number >= 0xFF) {
							return 0xFF;
						}
						var f = Math.floor(argument);
						if (f + 0.5 < number) {
							return f + 1;
						}
						if (number < f + 0.5) {
							return f;
						}
						if (f % 2 !== 0) {
							return f + 1;
						}
						return f;
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-tostring
					ToString: function ToString(argument) {
						if ((typeof argument === 'undefined' ? 'undefined' : _typeof(argument)) === 'symbol') {
							throw new TypeError('Cannot convert a Symbol value to a string');
						}
						return String(argument);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-toobject
					ToObject: function ToObject(value) {
						this.RequireObjectCoercible(value);
						return Object(value);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-topropertykey
					ToPropertyKey: function ToPropertyKey(argument) {
						var key = this.ToPrimitive(argument, String);
						return (typeof key === 'undefined' ? 'undefined' : _typeof(key)) === 'symbol' ? symbolToStr.call(key) : this.ToString(key);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-tolength
					ToLength: function ToLength(argument) {
						var len = this.ToInteger(argument);
						if (len <= 0) {
							return 0;
						} // includes converting -0 to +0
						if (len > MAX_SAFE_INTEGER) {
							return MAX_SAFE_INTEGER;
						}
						return len;
					},

					// http://www.ecma-international.org/ecma-262/6.0/#sec-canonicalnumericindexstring
					CanonicalNumericIndexString: function CanonicalNumericIndexString(argument) {
						if (toStr.call(argument) !== '[object String]') {
							throw new TypeError('must be a string');
						}
						if (argument === '-0') {
							return -0;
						}
						var n = this.ToNumber(argument);
						if (this.SameValue(this.ToString(n), argument)) {
							return n;
						}
						return void 0;
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-requireobjectcoercible
					RequireObjectCoercible: ES5.CheckObjectCoercible,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-isarray
					IsArray: Array.isArray || function IsArray(argument) {
						return toStr.call(argument) === '[object Array]';
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-iscallable
					// IsCallable: ES5.IsCallable,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-isconstructor
					IsConstructor: function IsConstructor(argument) {
						return typeof argument === 'function' && !!argument.prototype; // unfortunately there's no way to truly check this without try/catch `new argument`
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-isextensible-o
					IsExtensible: function IsExtensible(obj) {
						if (!Object.preventExtensions) {
							return true;
						}
						if (isPrimitive(obj)) {
							return false;
						}
						return Object.isExtensible(obj);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-isinteger
					IsInteger: function IsInteger(argument) {
						if (typeof argument !== 'number' || $isNaN(argument) || !$isFinite(argument)) {
							return false;
						}
						var abs = Math.abs(argument);
						return Math.floor(abs) === abs;
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-ispropertykey
					IsPropertyKey: function IsPropertyKey(argument) {
						return typeof argument === 'string' || (typeof argument === 'undefined' ? 'undefined' : _typeof(argument)) === 'symbol';
					},

					// http://www.ecma-international.org/ecma-262/6.0/#sec-isregexp
					IsRegExp: function IsRegExp(argument) {
						if (!argument || (typeof argument === 'undefined' ? 'undefined' : _typeof(argument)) !== 'object') {
							return false;
						}
						if (hasSymbols) {
							var isRegExp = argument[Symbol.match];
							if (typeof isRegExp !== 'undefined') {
								return ES5.ToBoolean(isRegExp);
							}
						}
						return hasRegExpMatcher(argument);
					},

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-samevalue
					// SameValue: ES5.SameValue,

					// https://people.mozilla.org/~jorendorff/es6-draft.html#sec-samevaluezero
					SameValueZero: function SameValueZero(x, y) {
						return x === y || $isNaN(x) && $isNaN(y);
					},

					Type: function Type(x) {
						if ((typeof x === 'undefined' ? 'undefined' : _typeof(x)) === 'symbol') {
							return 'Symbol';
						}
						return ES5.Type(x);
					},

					// http://www.ecma-international.org/ecma-262/6.0/#sec-speciesconstructor
					SpeciesConstructor: function SpeciesConstructor(O, defaultConstructor) {
						if (this.Type(O) !== 'Object') {
							throw new TypeError('Assertion failed: Type(O) is not Object');
						}
						var C = O.constructor;
						if (typeof C === 'undefined') {
							return defaultConstructor;
						}
						if (this.Type(C) !== 'Object') {
							throw new TypeError('O.constructor is not an Object');
						}
						var S = hasSymbols && Symbol.species ? C[Symbol.species] : undefined;
						if (S == null) {
							return defaultConstructor;
						}
						if (this.IsConstructor(S)) {
							return S;
						}
						throw new TypeError('no constructor found');
					}
				});

				delete ES6.CheckObjectCoercible; // renamed in ES6 to RequireObjectCoercible

				module.exports = ES6;

				/***/ },
			/* 8 */
			/***/ function(module, exports) {

				"use strict";

				module.exports = Number.isNaN || function isNaN(a) {
						return a !== a;
					};

				/***/ },
			/* 9 */
			/***/ function(module, exports) {

				'use strict';

				var $isNaN = Number.isNaN || function (a) {
						return a !== a;
					};

				module.exports = Number.isFinite || function (x) {
						return typeof x === 'number' && !$isNaN(x) && x !== Infinity && x !== -Infinity;
					};

				/***/ },
			/* 10 */
			/***/ function(module, exports) {

				"use strict";

				var has = Object.prototype.hasOwnProperty;
				module.exports = Object.assign || function assign(target, source) {
						for (var key in source) {
							if (has.call(source, key)) {
								target[key] = source[key];
							}
						}
						return target;
					};

				/***/ },
			/* 11 */
			/***/ function(module, exports) {

				"use strict";

				module.exports = function sign(number) {
					return number >= 0 ? 1 : -1;
				};

				/***/ },
			/* 12 */
			/***/ function(module, exports) {

				"use strict";

				module.exports = function mod(number, modulo) {
					var remain = number % modulo;
					return Math.floor(remain >= 0 ? remain : remain + modulo);
				};

				/***/ },
			/* 13 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				module.exports = function isPrimitive(value) {
					return value === null || typeof value !== 'function' && (typeof value === 'undefined' ? 'undefined' : _typeof(value)) !== 'object';
				};

				/***/ },
			/* 14 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var hasSymbols = typeof Symbol === 'function' && _typeof(Symbol.iterator) === 'symbol';

				var isPrimitive = __webpack_require__(15);
				var isCallable = __webpack_require__(16);
				var isDate = __webpack_require__(17);
				var isSymbol = __webpack_require__(18);

				var ordinaryToPrimitive = function OrdinaryToPrimitive(O, hint) {
					if (typeof O === 'undefined' || O === null) {
						throw new TypeError('Cannot call method on ' + O);
					}
					if (typeof hint !== 'string' || hint !== 'number' && hint !== 'string') {
						throw new TypeError('hint must be "string" or "number"');
					}
					var methodNames = hint === 'string' ? ['toString', 'valueOf'] : ['valueOf', 'toString'];
					var method, result, i;
					for (i = 0; i < methodNames.length; ++i) {
						method = O[methodNames[i]];
						if (isCallable(method)) {
							result = method.call(O);
							if (isPrimitive(result)) {
								return result;
							}
						}
					}
					throw new TypeError('No default value');
				};

				var GetMethod = function GetMethod(O, P) {
					var func = O[P];
					if (func !== null && typeof func !== 'undefined') {
						if (!isCallable(func)) {
							throw new TypeError(func + ' returned for property ' + P + ' of object ' + O + ' is not a function');
						}
						return func;
					}
				};

				// http://www.ecma-international.org/ecma-262/6.0/#sec-toprimitive
				module.exports = function ToPrimitive(input, PreferredType) {
					if (isPrimitive(input)) {
						return input;
					}
					var hint = 'default';
					if (arguments.length > 1) {
						if (PreferredType === String) {
							hint = 'string';
						} else if (PreferredType === Number) {
							hint = 'number';
						}
					}

					var exoticToPrim;
					if (hasSymbols) {
						if (Symbol.toPrimitive) {
							exoticToPrim = GetMethod(input, Symbol.toPrimitive);
						} else if (isSymbol(input)) {
							exoticToPrim = Symbol.prototype.valueOf;
						}
					}
					if (typeof exoticToPrim !== 'undefined') {
						var result = exoticToPrim.call(input, hint);
						if (isPrimitive(result)) {
							return result;
						}
						throw new TypeError('unable to convert exotic object to primitive');
					}
					if (hint === 'default' && (isDate(input) || isSymbol(input))) {
						hint = 'string';
					}
					return ordinaryToPrimitive(input, hint === 'default' ? 'number' : hint);
				};

				/***/ },
			/* 15 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				module.exports = function isPrimitive(value) {
					return value === null || typeof value !== 'function' && (typeof value === 'undefined' ? 'undefined' : _typeof(value)) !== 'object';
				};

				/***/ },
			/* 16 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var fnToStr = Function.prototype.toString;

				var constructorRegex = /^\s*class /;
				var isES6ClassFn = function isES6ClassFn(value) {
					try {
						var fnStr = fnToStr.call(value);
						var singleStripped = fnStr.replace(/\/\/.*\n/g, '');
						var multiStripped = singleStripped.replace(/\/\*[.\s\S]*\*\//g, '');
						var spaceStripped = multiStripped.replace(/\n/mg, ' ').replace(/ {2}/g, ' ');
						return constructorRegex.test(spaceStripped);
					} catch (e) {
						return false; // not a function
					}
				};

				var tryFunctionObject = function tryFunctionObject(value) {
					try {
						if (isES6ClassFn(value)) {
							return false;
						}
						fnToStr.call(value);
						return true;
					} catch (e) {
						return false;
					}
				};
				var toStr = Object.prototype.toString;
				var fnClass = '[object Function]';
				var genClass = '[object GeneratorFunction]';
				var hasToStringTag = typeof Symbol === 'function' && _typeof(Symbol.toStringTag) === 'symbol';

				module.exports = function isCallable(value) {
					if (!value) {
						return false;
					}
					if (typeof value !== 'function' && (typeof value === 'undefined' ? 'undefined' : _typeof(value)) !== 'object') {
						return false;
					}
					if (hasToStringTag) {
						return tryFunctionObject(value);
					}
					if (isES6ClassFn(value)) {
						return false;
					}
					var strClass = toStr.call(value);
					return strClass === fnClass || strClass === genClass;
				};

				/***/ },
			/* 17 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var getDay = Date.prototype.getDay;
				var tryDateObject = function tryDateObject(value) {
					try {
						getDay.call(value);
						return true;
					} catch (e) {
						return false;
					}
				};

				var toStr = Object.prototype.toString;
				var dateClass = '[object Date]';
				var hasToStringTag = typeof Symbol === 'function' && _typeof(Symbol.toStringTag) === 'symbol';

				module.exports = function isDateObject(value) {
					if ((typeof value === 'undefined' ? 'undefined' : _typeof(value)) !== 'object' || value === null) {
						return false;
					}
					return hasToStringTag ? tryDateObject(value) : toStr.call(value) === dateClass;
				};

				/***/ },
			/* 18 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var toStr = Object.prototype.toString;
				var hasSymbols = typeof Symbol === 'function' && _typeof(Symbol()) === 'symbol';

				if (hasSymbols) {
					var symToStr = Symbol.prototype.toString;
					var symStringRegex = /^Symbol\(.*\)$/;
					var isSymbolObject = function isSymbolObject(value) {
						if (_typeof(value.valueOf()) !== 'symbol') {
							return false;
						}
						return symStringRegex.test(symToStr.call(value));
					};
					module.exports = function isSymbol(value) {
						if ((typeof value === 'undefined' ? 'undefined' : _typeof(value)) === 'symbol') {
							return true;
						}
						if (toStr.call(value) !== '[object Symbol]') {
							return false;
						}
						try {
							return isSymbolObject(value);
						} catch (e) {
							return false;
						}
					};
				} else {
					module.exports = function isSymbol(value) {
						// this environment does not support Symbols.
						return false;
					};
				}

				/***/ },
			/* 19 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var implementation = __webpack_require__(20);

				module.exports = Function.prototype.bind || implementation;

				/***/ },
			/* 20 */
			/***/ function(module, exports) {

				'use strict';

				var ERROR_MESSAGE = 'Function.prototype.bind called on incompatible ';
				var slice = Array.prototype.slice;
				var toStr = Object.prototype.toString;
				var funcType = '[object Function]';

				module.exports = function bind(that) {
					var target = this;
					if (typeof target !== 'function' || toStr.call(target) !== funcType) {
						throw new TypeError(ERROR_MESSAGE + target);
					}
					var args = slice.call(arguments, 1);

					var bound;
					var binder = function binder() {
						if (this instanceof bound) {
							var result = target.apply(this, args.concat(slice.call(arguments)));
							if (Object(result) === result) {
								return result;
							}
							return this;
						} else {
							return target.apply(that, args.concat(slice.call(arguments)));
						}
					};

					var boundLength = Math.max(0, target.length - args.length);
					var boundArgs = [];
					for (var i = 0; i < boundLength; i++) {
						boundArgs.push('$' + i);
					}

					bound = Function('binder', 'return function (' + boundArgs.join(',') + '){ return binder.apply(this,arguments); }')(binder);

					if (target.prototype) {
						var Empty = function Empty() {};
						Empty.prototype = target.prototype;
						bound.prototype = new Empty();
						Empty.prototype = null;
					}

					return bound;
				};

				/***/ },
			/* 21 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var $isNaN = __webpack_require__(8);
				var $isFinite = __webpack_require__(9);

				var sign = __webpack_require__(11);
				var mod = __webpack_require__(12);

				var IsCallable = __webpack_require__(16);
				var toPrimitive = __webpack_require__(22);

				// https://es5.github.io/#x9
				var ES5 = {
					ToPrimitive: toPrimitive,

					ToBoolean: function ToBoolean(value) {
						return Boolean(value);
					},
					ToNumber: function ToNumber(value) {
						return Number(value);
					},
					ToInteger: function ToInteger(value) {
						var number = this.ToNumber(value);
						if ($isNaN(number)) {
							return 0;
						}
						if (number === 0 || !$isFinite(number)) {
							return number;
						}
						return sign(number) * Math.floor(Math.abs(number));
					},
					ToInt32: function ToInt32(x) {
						return this.ToNumber(x) >> 0;
					},
					ToUint32: function ToUint32(x) {
						return this.ToNumber(x) >>> 0;
					},
					ToUint16: function ToUint16(value) {
						var number = this.ToNumber(value);
						if ($isNaN(number) || number === 0 || !$isFinite(number)) {
							return 0;
						}
						var posInt = sign(number) * Math.floor(Math.abs(number));
						return mod(posInt, 0x10000);
					},
					ToString: function ToString(value) {
						return String(value);
					},
					ToObject: function ToObject(value) {
						this.CheckObjectCoercible(value);
						return Object(value);
					},
					CheckObjectCoercible: function CheckObjectCoercible(value, optMessage) {
						/* jshint eqnull:true */
						if (value == null) {
							throw new TypeError(optMessage || 'Cannot call method on ' + value);
						}
						return value;
					},
					IsCallable: IsCallable,
					SameValue: function SameValue(x, y) {
						if (x === y) {
							// 0 === -0, but they are not identical.
							if (x === 0) {
								return 1 / x === 1 / y;
							}
							return true;
						}
						return $isNaN(x) && $isNaN(y);
					},

					// http://www.ecma-international.org/ecma-262/5.1/#sec-8
					Type: function Type(x) {
						if (x === null) {
							return 'Null';
						}
						if (typeof x === 'undefined') {
							return 'Undefined';
						}
						if (typeof x === 'function' || (typeof x === 'undefined' ? 'undefined' : _typeof(x)) === 'object') {
							return 'Object';
						}
						if (typeof x === 'number') {
							return 'Number';
						}
						if (typeof x === 'boolean') {
							return 'Boolean';
						}
						if (typeof x === 'string') {
							return 'String';
						}
					}
				};

				module.exports = ES5;

				/***/ },
			/* 22 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var toStr = Object.prototype.toString;

				var isPrimitive = __webpack_require__(15);

				var isCallable = __webpack_require__(16);

				// https://es5.github.io/#x8.12
				var ES5internalSlots = {
					'[[DefaultValue]]': function DefaultValue(O, hint) {
						var actualHint = hint || (toStr.call(O) === '[object Date]' ? String : Number);

						if (actualHint === String || actualHint === Number) {
							var methods = actualHint === String ? ['toString', 'valueOf'] : ['valueOf', 'toString'];
							var value, i;
							for (i = 0; i < methods.length; ++i) {
								if (isCallable(O[methods[i]])) {
									value = O[methods[i]]();
									if (isPrimitive(value)) {
										return value;
									}
								}
							}
							throw new TypeError('No default value');
						}
						throw new TypeError('invalid [[DefaultValue]] hint supplied');
					}
				};

				// https://es5.github.io/#x9
				module.exports = function ToPrimitive(input, PreferredType) {
					if (isPrimitive(input)) {
						return input;
					}
					return ES5internalSlots['[[DefaultValue]]'](input, PreferredType);
				};

				/***/ },
			/* 23 */
			/***/ function(module, exports) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var regexExec = RegExp.prototype.exec;
				var tryRegexExec = function tryRegexExec(value) {
					try {
						regexExec.call(value);
						return true;
					} catch (e) {
						return false;
					}
				};
				var toStr = Object.prototype.toString;
				var regexClass = '[object RegExp]';
				var hasToStringTag = typeof Symbol === 'function' && _typeof(Symbol.toStringTag) === 'symbol';

				module.exports = function isRegex(value) {
					if ((typeof value === 'undefined' ? 'undefined' : _typeof(value)) !== 'object') {
						return false;
					}
					return hasToStringTag ? tryRegexExec(value) : toStr.call(value) === regexClass;
				};

				/***/ },
			/* 24 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var ES = __webpack_require__(7);
				var implementation = __webpack_require__(6);

				var tryCall = function tryCall(fn) {
					try {
						fn();
						return true;
					} catch (e) {
						return false;
					}
				};

				module.exports = function getPolyfill() {
					var implemented = ES.IsCallable(Array.from) && tryCall(function () {
							Array.from({ 'length': -Infinity });
						}) && !tryCall(function () {
							Array.from([], undefined);
						});

					return implemented ? Array.from : implementation;
				};

				/***/ },
			/* 25 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var define = __webpack_require__(2);
				var getPolyfill = __webpack_require__(24);

				module.exports = function shimArrayFrom() {
					var polyfill = getPolyfill();

					define(Array, { 'from': polyfill }, {
						'from': function from() {
							return Array.from !== polyfill;
						}
					});

					return polyfill;
				};

				/***/ },
			/* 26 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var defineProperties = __webpack_require__(2);

				var implementation = __webpack_require__(27);
				var getPolyfill = __webpack_require__(29);
				var shim = __webpack_require__(30);

				var polyfill = getPolyfill();

				defineProperties(polyfill, {
					implementation: implementation,
					getPolyfill: getPolyfill,
					shim: shim
				});

				module.exports = polyfill;

				/***/ },
			/* 27 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				// modified from https://github.com/es-shims/es6-shim

				var keys = __webpack_require__(3);
				var bind = __webpack_require__(19);
				var canBeObject = function canBeObject(obj) {
					return typeof obj !== 'undefined' && obj !== null;
				};
				var hasSymbols = __webpack_require__(28)();
				var toObject = Object;
				var push = bind.call(Function.call, Array.prototype.push);
				var propIsEnumerable = bind.call(Function.call, Object.prototype.propertyIsEnumerable);
				var originalGetSymbols = hasSymbols ? Object.getOwnPropertySymbols : null;

				module.exports = function assign(target, source1) {
					if (!canBeObject(target)) {
						throw new TypeError('target must be an object');
					}
					var objTarget = toObject(target);
					var s, source, i, props, syms, value, key;
					for (s = 1; s < arguments.length; ++s) {
						source = toObject(arguments[s]);
						props = keys(source);
						var getSymbols = hasSymbols && (Object.getOwnPropertySymbols || originalGetSymbols);
						if (getSymbols) {
							syms = getSymbols(source);
							for (i = 0; i < syms.length; ++i) {
								key = syms[i];
								if (propIsEnumerable(source, key)) {
									push(props, key);
								}
							}
						}
						for (i = 0; i < props.length; ++i) {
							key = props[i];
							value = source[key];
							if (propIsEnumerable(source, key)) {
								objTarget[key] = value;
							}
						}
					}
					return objTarget;
				};

				/***/ },
			/* 28 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var keys = __webpack_require__(3);

				module.exports = function hasSymbols() {
					if (typeof Symbol !== 'function' || typeof Object.getOwnPropertySymbols !== 'function') {
						return false;
					}
					if (_typeof(Symbol.iterator) === 'symbol') {
						return true;
					}

					var obj = {};
					var sym = Symbol('test');
					var symObj = Object(sym);
					if (typeof sym === 'string') {
						return false;
					}

					if (Object.prototype.toString.call(sym) !== '[object Symbol]') {
						return false;
					}
					if (Object.prototype.toString.call(symObj) !== '[object Symbol]') {
						return false;
					}

					// temp disabled per https://github.com/ljharb/object.assign/issues/17
					// if (sym instanceof Symbol) { return false; }
					// temp disabled per https://github.com/WebReflection/get-own-property-symbols/issues/4
					// if (!(symObj instanceof Symbol)) { return false; }

					var symVal = 42;
					obj[sym] = symVal;
					for (sym in obj) {
						return false;
					}
					if (keys(obj).length !== 0) {
						return false;
					}
					if (typeof Object.keys === 'function' && Object.keys(obj).length !== 0) {
						return false;
					}

					if (typeof Object.getOwnPropertyNames === 'function' && Object.getOwnPropertyNames(obj).length !== 0) {
						return false;
					}

					var syms = Object.getOwnPropertySymbols(obj);
					if (syms.length !== 1 || syms[0] !== sym) {
						return false;
					}

					if (!Object.prototype.propertyIsEnumerable.call(obj, sym)) {
						return false;
					}

					if (typeof Object.getOwnPropertyDescriptor === 'function') {
						var descriptor = Object.getOwnPropertyDescriptor(obj, sym);
						if (descriptor.value !== symVal || descriptor.enumerable !== true) {
							return false;
						}
					}

					return true;
				};

				/***/ },
			/* 29 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var implementation = __webpack_require__(27);

				var lacksProperEnumerationOrder = function lacksProperEnumerationOrder() {
					if (!Object.assign) {
						return false;
					}
					// v8, specifically in node 4.x, has a bug with incorrect property enumeration order
					// note: this does not detect the bug unless there's 20 characters
					var str = 'abcdefghijklmnopqrst';
					var letters = str.split('');
					var map = {};
					for (var i = 0; i < letters.length; ++i) {
						map[letters[i]] = letters[i];
					}
					var obj = Object.assign({}, map);
					var actual = '';
					for (var k in obj) {
						actual += k;
					}
					return str !== actual;
				};

				var assignHasPendingExceptions = function assignHasPendingExceptions() {
					if (!Object.assign || !Object.preventExtensions) {
						return false;
					}
					// Firefox 37 still has "pending exception" logic in its Object.assign implementation,
					// which is 72% slower than our shim, and Firefox 40's native implementation.
					var thrower = Object.preventExtensions({ 1: 2 });
					try {
						Object.assign(thrower, 'xy');
					} catch (e) {
						return thrower[1] === 'y';
					}
					return false;
				};

				module.exports = function getPolyfill() {
					if (!Object.assign) {
						return implementation;
					}
					if (lacksProperEnumerationOrder()) {
						return implementation;
					}
					if (assignHasPendingExceptions()) {
						return implementation;
					}
					return Object.assign;
				};

				/***/ },
			/* 30 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var define = __webpack_require__(2);
				var getPolyfill = __webpack_require__(29);

				module.exports = function shimAssign() {
					var polyfill = getPolyfill();
					define(Object, { assign: polyfill }, { assign: function assign() {
						return Object.assign !== polyfill;
					} });
					return polyfill;
				};

				/***/ },
			/* 31 */
			/***/ function(module, exports, __webpack_require__) {

				var require;var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/* WEBPACK VAR INJECTION */(function(process, global) {'use strict';

					var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

					/*!
					 * @overview es6-promise - a tiny implementation of Promises/A+.
					 * @copyright Copyright (c) 2014 Yehuda Katz, Tom Dale, Stefan Penner and contributors (Conversion to ES6 API by Jake Archibald)
					 * @license   Licensed under MIT license
					 *            See https://raw.githubusercontent.com/stefanpenner/es6-promise/master/LICENSE
					 * @version   4.0.5
					 */

					(function (global, factory) {
						( false ? 'undefined' : _typeof(exports)) === 'object' && typeof module !== 'undefined' ? module.exports = factory() :  true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory), __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ? (__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) : __WEBPACK_AMD_DEFINE_FACTORY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : global.ES6Promise = factory();
					})(undefined, function () {
						'use strict';

						function objectOrFunction(x) {
							return typeof x === 'function' || (typeof x === 'undefined' ? 'undefined' : _typeof(x)) === 'object' && x !== null;
						}

						function isFunction(x) {
							return typeof x === 'function';
						}

						var _isArray = undefined;
						if (!Array.isArray) {
							_isArray = function _isArray(x) {
								return Object.prototype.toString.call(x) === '[object Array]';
							};
						} else {
							_isArray = Array.isArray;
						}

						var isArray = _isArray;

						var len = 0;
						var vertxNext = undefined;
						var customSchedulerFn = undefined;

						var asap = function asap(callback, arg) {
							queue[len] = callback;
							queue[len + 1] = arg;
							len += 2;
							if (len === 2) {
								// If len is 2, that means that we need to schedule an async flush.
								// If additional callbacks are queued before the queue is flushed, they
								// will be processed by this flush that we are scheduling.
								if (customSchedulerFn) {
									customSchedulerFn(flush);
								} else {
									scheduleFlush();
								}
							}
						};

						function setScheduler(scheduleFn) {
							customSchedulerFn = scheduleFn;
						}

						function setAsap(asapFn) {
							asap = asapFn;
						}

						var browserWindow = typeof window !== 'undefined' ? window : undefined;
						var browserGlobal = browserWindow || {};
						var BrowserMutationObserver = browserGlobal.MutationObserver || browserGlobal.WebKitMutationObserver;
						var isNode = typeof self === 'undefined' && typeof process !== 'undefined' && {}.toString.call(process) === '[object process]';

						// test for web worker but not in IE10
						var isWorker = typeof Uint8ClampedArray !== 'undefined' && typeof importScripts !== 'undefined' && typeof MessageChannel !== 'undefined';

						// node
						function useNextTick() {
							// node version 0.10.x displays a deprecation warning when nextTick is used recursively
							// see https://github.com/cujojs/when/issues/410 for details
							return function () {
								return process.nextTick(flush);
							};
						}

						// vertx
						function useVertxTimer() {
							if (typeof vertxNext !== 'undefined') {
								return function () {
									vertxNext(flush);
								};
							}

							return useSetTimeout();
						}

						function useMutationObserver() {
							var iterations = 0;
							var observer = new BrowserMutationObserver(flush);
							var node = document.createTextNode('');
							observer.observe(node, { characterData: true });

							return function () {
								node.data = iterations = ++iterations % 2;
							};
						}

						// web worker
						function useMessageChannel() {
							var channel = new MessageChannel();
							channel.port1.onmessage = flush;
							return function () {
								return channel.port2.postMessage(0);
							};
						}

						function useSetTimeout() {
							// Store setTimeout reference so es6-promise will be unaffected by
							// other code modifying setTimeout (like sinon.useFakeTimers())
							var globalSetTimeout = setTimeout;
							return function () {
								return globalSetTimeout(flush, 1);
							};
						}

						var queue = new Array(1000);
						function flush() {
							for (var i = 0; i < len; i += 2) {
								var callback = queue[i];
								var arg = queue[i + 1];

								callback(arg);

								queue[i] = undefined;
								queue[i + 1] = undefined;
							}

							len = 0;
						}

						function attemptVertx() {
							try {
								var r = require;
								var vertx = __webpack_require__(33);
								vertxNext = vertx.runOnLoop || vertx.runOnContext;
								return useVertxTimer();
							} catch (e) {
								return useSetTimeout();
							}
						}

						var scheduleFlush = undefined;
						// Decide what async method to use to triggering processing of queued callbacks:
						if (isNode) {
							scheduleFlush = useNextTick();
						} else if (BrowserMutationObserver) {
							scheduleFlush = useMutationObserver();
						} else if (isWorker) {
							scheduleFlush = useMessageChannel();
						} else if (browserWindow === undefined && "function" === 'function') {
							scheduleFlush = attemptVertx();
						} else {
							scheduleFlush = useSetTimeout();
						}

						function then(onFulfillment, onRejection) {
							var _arguments = arguments;

							var parent = this;

							var child = new this.constructor(noop);

							if (child[PROMISE_ID] === undefined) {
								makePromise(child);
							}

							var _state = parent._state;

							if (_state) {
								(function () {
									var callback = _arguments[_state - 1];
									asap(function () {
										return invokeCallback(_state, child, callback, parent._result);
									});
								})();
							} else {
								subscribe(parent, child, onFulfillment, onRejection);
							}

							return child;
						}

						/**
						 `Promise.resolve` returns a promise that will become resolved with the
						 passed `value`. It is shorthand for the following:

						 ```javascript
						 let promise = new Promise(function(resolve, reject){
	      resolve(1);
	    });

						 promise.then(function(value){
	      // value === 1
	    });
						 ```

						 Instead of writing the above, your code now simply becomes the following:

						 ```javascript
						 let promise = Promise.resolve(1);

						 promise.then(function(value){
	      // value === 1
	    });
						 ```

						 @method resolve
						 @static
						 @param {Any} value value that the returned promise will be resolved with
						 Useful for tooling.
						 @return {Promise} a promise that will become fulfilled with the given
						 `value`
						 */
						function resolve(object) {
							/*jshint validthis:true */
							var Constructor = this;

							if (object && (typeof object === 'undefined' ? 'undefined' : _typeof(object)) === 'object' && object.constructor === Constructor) {
								return object;
							}

							var promise = new Constructor(noop);
							_resolve(promise, object);
							return promise;
						}

						var PROMISE_ID = Math.random().toString(36).substring(16);

						function noop() {}

						var PENDING = void 0;
						var FULFILLED = 1;
						var REJECTED = 2;

						var GET_THEN_ERROR = new ErrorObject();

						function selfFulfillment() {
							return new TypeError("You cannot resolve a promise with itself");
						}

						function cannotReturnOwn() {
							return new TypeError('A promises callback cannot return that same promise.');
						}

						function getThen(promise) {
							try {
								return promise.then;
							} catch (error) {
								GET_THEN_ERROR.error = error;
								return GET_THEN_ERROR;
							}
						}

						function tryThen(then, value, fulfillmentHandler, rejectionHandler) {
							try {
								then.call(value, fulfillmentHandler, rejectionHandler);
							} catch (e) {
								return e;
							}
						}

						function handleForeignThenable(promise, thenable, then) {
							asap(function (promise) {
								var sealed = false;
								var error = tryThen(then, thenable, function (value) {
									if (sealed) {
										return;
									}
									sealed = true;
									if (thenable !== value) {
										_resolve(promise, value);
									} else {
										fulfill(promise, value);
									}
								}, function (reason) {
									if (sealed) {
										return;
									}
									sealed = true;

									_reject(promise, reason);
								}, 'Settle: ' + (promise._label || ' unknown promise'));

								if (!sealed && error) {
									sealed = true;
									_reject(promise, error);
								}
							}, promise);
						}

						function handleOwnThenable(promise, thenable) {
							if (thenable._state === FULFILLED) {
								fulfill(promise, thenable._result);
							} else if (thenable._state === REJECTED) {
								_reject(promise, thenable._result);
							} else {
								subscribe(thenable, undefined, function (value) {
									return _resolve(promise, value);
								}, function (reason) {
									return _reject(promise, reason);
								});
							}
						}

						function handleMaybeThenable(promise, maybeThenable, then$$) {
							if (maybeThenable.constructor === promise.constructor && then$$ === then && maybeThenable.constructor.resolve === resolve) {
								handleOwnThenable(promise, maybeThenable);
							} else {
								if (then$$ === GET_THEN_ERROR) {
									_reject(promise, GET_THEN_ERROR.error);
								} else if (then$$ === undefined) {
									fulfill(promise, maybeThenable);
								} else if (isFunction(then$$)) {
									handleForeignThenable(promise, maybeThenable, then$$);
								} else {
									fulfill(promise, maybeThenable);
								}
							}
						}

						function _resolve(promise, value) {
							if (promise === value) {
								_reject(promise, selfFulfillment());
							} else if (objectOrFunction(value)) {
								handleMaybeThenable(promise, value, getThen(value));
							} else {
								fulfill(promise, value);
							}
						}

						function publishRejection(promise) {
							if (promise._onerror) {
								promise._onerror(promise._result);
							}

							publish(promise);
						}

						function fulfill(promise, value) {
							if (promise._state !== PENDING) {
								return;
							}

							promise._result = value;
							promise._state = FULFILLED;

							if (promise._subscribers.length !== 0) {
								asap(publish, promise);
							}
						}

						function _reject(promise, reason) {
							if (promise._state !== PENDING) {
								return;
							}
							promise._state = REJECTED;
							promise._result = reason;

							asap(publishRejection, promise);
						}

						function subscribe(parent, child, onFulfillment, onRejection) {
							var _subscribers = parent._subscribers;
							var length = _subscribers.length;

							parent._onerror = null;

							_subscribers[length] = child;
							_subscribers[length + FULFILLED] = onFulfillment;
							_subscribers[length + REJECTED] = onRejection;

							if (length === 0 && parent._state) {
								asap(publish, parent);
							}
						}

						function publish(promise) {
							var subscribers = promise._subscribers;
							var settled = promise._state;

							if (subscribers.length === 0) {
								return;
							}

							var child = undefined,
								callback = undefined,
								detail = promise._result;

							for (var i = 0; i < subscribers.length; i += 3) {
								child = subscribers[i];
								callback = subscribers[i + settled];

								if (child) {
									invokeCallback(settled, child, callback, detail);
								} else {
									callback(detail);
								}
							}

							promise._subscribers.length = 0;
						}

						function ErrorObject() {
							this.error = null;
						}

						var TRY_CATCH_ERROR = new ErrorObject();

						function tryCatch(callback, detail) {
							try {
								return callback(detail);
							} catch (e) {
								TRY_CATCH_ERROR.error = e;
								return TRY_CATCH_ERROR;
							}
						}

						function invokeCallback(settled, promise, callback, detail) {
							var hasCallback = isFunction(callback),
								value = undefined,
								error = undefined,
								succeeded = undefined,
								failed = undefined;

							if (hasCallback) {
								value = tryCatch(callback, detail);

								if (value === TRY_CATCH_ERROR) {
									failed = true;
									error = value.error;
									value = null;
								} else {
									succeeded = true;
								}

								if (promise === value) {
									_reject(promise, cannotReturnOwn());
									return;
								}
							} else {
								value = detail;
								succeeded = true;
							}

							if (promise._state !== PENDING) {
								// noop
							} else if (hasCallback && succeeded) {
								_resolve(promise, value);
							} else if (failed) {
								_reject(promise, error);
							} else if (settled === FULFILLED) {
								fulfill(promise, value);
							} else if (settled === REJECTED) {
								_reject(promise, value);
							}
						}

						function initializePromise(promise, resolver) {
							try {
								resolver(function resolvePromise(value) {
									_resolve(promise, value);
								}, function rejectPromise(reason) {
									_reject(promise, reason);
								});
							} catch (e) {
								_reject(promise, e);
							}
						}

						var id = 0;
						function nextId() {
							return id++;
						}

						function makePromise(promise) {
							promise[PROMISE_ID] = id++;
							promise._state = undefined;
							promise._result = undefined;
							promise._subscribers = [];
						}

						function Enumerator(Constructor, input) {
							this._instanceConstructor = Constructor;
							this.promise = new Constructor(noop);

							if (!this.promise[PROMISE_ID]) {
								makePromise(this.promise);
							}

							if (isArray(input)) {
								this._input = input;
								this.length = input.length;
								this._remaining = input.length;

								this._result = new Array(this.length);

								if (this.length === 0) {
									fulfill(this.promise, this._result);
								} else {
									this.length = this.length || 0;
									this._enumerate();
									if (this._remaining === 0) {
										fulfill(this.promise, this._result);
									}
								}
							} else {
								_reject(this.promise, validationError());
							}
						}

						function validationError() {
							return new Error('Array Methods must be provided an Array');
						};

						Enumerator.prototype._enumerate = function () {
							var length = this.length;
							var _input = this._input;

							for (var i = 0; this._state === PENDING && i < length; i++) {
								this._eachEntry(_input[i], i);
							}
						};

						Enumerator.prototype._eachEntry = function (entry, i) {
							var c = this._instanceConstructor;
							var resolve$$ = c.resolve;

							if (resolve$$ === resolve) {
								var _then = getThen(entry);

								if (_then === then && entry._state !== PENDING) {
									this._settledAt(entry._state, i, entry._result);
								} else if (typeof _then !== 'function') {
									this._remaining--;
									this._result[i] = entry;
								} else if (c === Promise) {
									var promise = new c(noop);
									handleMaybeThenable(promise, entry, _then);
									this._willSettleAt(promise, i);
								} else {
									this._willSettleAt(new c(function (resolve$$) {
										return resolve$$(entry);
									}), i);
								}
							} else {
								this._willSettleAt(resolve$$(entry), i);
							}
						};

						Enumerator.prototype._settledAt = function (state, i, value) {
							var promise = this.promise;

							if (promise._state === PENDING) {
								this._remaining--;

								if (state === REJECTED) {
									_reject(promise, value);
								} else {
									this._result[i] = value;
								}
							}

							if (this._remaining === 0) {
								fulfill(promise, this._result);
							}
						};

						Enumerator.prototype._willSettleAt = function (promise, i) {
							var enumerator = this;

							subscribe(promise, undefined, function (value) {
								return enumerator._settledAt(FULFILLED, i, value);
							}, function (reason) {
								return enumerator._settledAt(REJECTED, i, reason);
							});
						};

						/**
						 `Promise.all` accepts an array of promises, and returns a new promise which
						 is fulfilled with an array of fulfillment values for the passed promises, or
						 rejected with the reason of the first passed promise to be rejected. It casts all
						 elements of the passed iterable to promises as it runs this algorithm.

						 Example:

						 ```javascript
						 let promise1 = resolve(1);
						 let promise2 = resolve(2);
						 let promise3 = resolve(3);
						 let promises = [ promise1, promise2, promise3 ];

						 Promise.all(promises).then(function(array){
	      // The array here would be [ 1, 2, 3 ];
	    });
						 ```

						 If any of the `promises` given to `all` are rejected, the first promise
						 that is rejected will be given as an argument to the returned promises's
						 rejection handler. For example:

						 Example:

						 ```javascript
						 let promise1 = resolve(1);
						 let promise2 = reject(new Error("2"));
						 let promise3 = reject(new Error("3"));
						 let promises = [ promise1, promise2, promise3 ];

						 Promise.all(promises).then(function(array){
	      // Code here never runs because there are rejected promises!
	    }, function(error) {
	      // error.message === "2"
	    });
						 ```

						 @method all
						 @static
						 @param {Array} entries array of promises
						 @param {String} label optional string for labeling the promise.
						 Useful for tooling.
						 @return {Promise} promise that is fulfilled when all `promises` have been
						 fulfilled, or rejected if any of them become rejected.
						 @static
						 */
						function all(entries) {
							return new Enumerator(this, entries).promise;
						}

						/**
						 `Promise.race` returns a new promise which is settled in the same way as the
						 first passed promise to settle.

						 Example:

						 ```javascript
						 let promise1 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        resolve('promise 1');
	      }, 200);
	    });

						 let promise2 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        resolve('promise 2');
	      }, 100);
	    });

						 Promise.race([promise1, promise2]).then(function(result){
	      // result === 'promise 2' because it was resolved before promise1
	      // was resolved.
	    });
						 ```

						 `Promise.race` is deterministic in that only the state of the first
						 settled promise matters. For example, even if other promises given to the
						 `promises` array argument are resolved, but the first settled promise has
						 become rejected before the other promises became fulfilled, the returned
						 promise will become rejected:

						 ```javascript
						 let promise1 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        resolve('promise 1');
	      }, 200);
	    });

						 let promise2 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        reject(new Error('promise 2'));
	      }, 100);
	    });

						 Promise.race([promise1, promise2]).then(function(result){
	      // Code here never runs
	    }, function(reason){
	      // reason.message === 'promise 2' because promise 2 became rejected before
	      // promise 1 became fulfilled
	    });
						 ```

						 An example real-world use case is implementing timeouts:

						 ```javascript
						 Promise.race([ajax('foo.json'), timeout(5000)])
						 ```

						 @method race
						 @static
						 @param {Array} promises array of promises to observe
						 Useful for tooling.
						 @return {Promise} a promise which settles in the same way as the first passed
						 promise to settle.
						 */
						function race(entries) {
							/*jshint validthis:true */
							var Constructor = this;

							if (!isArray(entries)) {
								return new Constructor(function (_, reject) {
									return reject(new TypeError('You must pass an array to race.'));
								});
							} else {
								return new Constructor(function (resolve, reject) {
									var length = entries.length;
									for (var i = 0; i < length; i++) {
										Constructor.resolve(entries[i]).then(resolve, reject);
									}
								});
							}
						}

						/**
						 `Promise.reject` returns a promise rejected with the passed `reason`.
						 It is shorthand for the following:

						 ```javascript
						 let promise = new Promise(function(resolve, reject){
	      reject(new Error('WHOOPS'));
	    });

						 promise.then(function(value){
	      // Code here doesn't run because the promise is rejected!
	    }, function(reason){
	      // reason.message === 'WHOOPS'
	    });
						 ```

						 Instead of writing the above, your code now simply becomes the following:

						 ```javascript
						 let promise = Promise.reject(new Error('WHOOPS'));

						 promise.then(function(value){
	      // Code here doesn't run because the promise is rejected!
	    }, function(reason){
	      // reason.message === 'WHOOPS'
	    });
						 ```

						 @method reject
						 @static
						 @param {Any} reason value that the returned promise will be rejected with.
						 Useful for tooling.
						 @return {Promise} a promise rejected with the given `reason`.
						 */
						function reject(reason) {
							/*jshint validthis:true */
							var Constructor = this;
							var promise = new Constructor(noop);
							_reject(promise, reason);
							return promise;
						}

						function needsResolver() {
							throw new TypeError('You must pass a resolver function as the first argument to the promise constructor');
						}

						function needsNew() {
							throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
						}

						/**
						 Promise objects represent the eventual result of an asynchronous operation. The
						 primary way of interacting with a promise is through its `then` method, which
						 registers callbacks to receive either a promise's eventual value or the reason
						 why the promise cannot be fulfilled.

						 Terminology
						 -----------

						 - `promise` is an object or function with a `then` method whose behavior conforms to this specification.
						 - `thenable` is an object or function that defines a `then` method.
						 - `value` is any legal JavaScript value (including undefined, a thenable, or a promise).
						 - `exception` is a value that is thrown using the throw statement.
						 - `reason` is a value that indicates why a promise was rejected.
						 - `settled` the final resting state of a promise, fulfilled or rejected.

						 A promise can be in one of three states: pending, fulfilled, or rejected.

						 Promises that are fulfilled have a fulfillment value and are in the fulfilled
						 state.  Promises that are rejected have a rejection reason and are in the
						 rejected state.  A fulfillment value is never a thenable.

						 Promises can also be said to *resolve* a value.  If this value is also a
						 promise, then the original promise's settled state will match the value's
						 settled state.  So a promise that *resolves* a promise that rejects will
						 itself reject, and a promise that *resolves* a promise that fulfills will
						 itself fulfill.


						 Basic Usage:
						 ------------

						 ```js
						 let promise = new Promise(function(resolve, reject) {
	      // on success
	      resolve(value);

	      // on failure
	      reject(reason);
	    });

						 promise.then(function(value) {
	      // on fulfillment
	    }, function(reason) {
	      // on rejection
	    });
						 ```

						 Advanced Usage:
						 ---------------

						 Promises shine when abstracting away asynchronous interactions such as
						 `XMLHttpRequest`s.

						 ```js
						 function getJSON(url) {
	      return new Promise(function(resolve, reject){
	        let xhr = new XMLHttpRequest();

	        xhr.open('GET', url);
	        xhr.onreadystatechange = handler;
	        xhr.responseType = 'json';
	        xhr.setRequestHeader('Accept', 'application/json');
	        xhr.send();

	        function handler() {
	          if (this.readyState === this.DONE) {
	            if (this.status === 200) {
	              resolve(this.response);
	            } else {
	              reject(new Error('getJSON: `' + url + '` failed with status: [' + this.status + ']'));
	            }
	          }
	        };
	      });
	    }

						 getJSON('/posts.json').then(function(json) {
	      // on fulfillment
	    }, function(reason) {
	      // on rejection
	    });
						 ```

						 Unlike callbacks, promises are great composable primitives.

						 ```js
						 Promise.all([
						 getJSON('/posts'),
						 getJSON('/comments')
						 ]).then(function(values){
	      values[0] // => postsJSON
	      values[1] // => commentsJSON

	      return values;
	    });
						 ```

						 @class Promise
						 @param {function} resolver
						 Useful for tooling.
						 @constructor
						 */
						function Promise(resolver) {
							this[PROMISE_ID] = nextId();
							this._result = this._state = undefined;
							this._subscribers = [];

							if (noop !== resolver) {
								typeof resolver !== 'function' && needsResolver();
								this instanceof Promise ? initializePromise(this, resolver) : needsNew();
							}
						}

						Promise.all = all;
						Promise.race = race;
						Promise.resolve = resolve;
						Promise.reject = reject;
						Promise._setScheduler = setScheduler;
						Promise._setAsap = setAsap;
						Promise._asap = asap;

						Promise.prototype = {
							constructor: Promise,

							/**
							 The primary way of interacting with a promise is through its `then` method,
							 which registers callbacks to receive either a promise's eventual value or the
							 reason why the promise cannot be fulfilled.

							 ```js
							 findUser().then(function(user){
	        // user is available
	      }, function(reason){
	        // user is unavailable, and you are given the reason why
	      });
							 ```

							 Chaining
							 --------

							 The return value of `then` is itself a promise.  This second, 'downstream'
							 promise is resolved with the return value of the first promise's fulfillment
							 or rejection handler, or rejected if the handler throws an exception.

							 ```js
							 findUser().then(function (user) {
	        return user.name;
	      }, function (reason) {
	        return 'default name';
	      }).then(function (userName) {
	        // If `findUser` fulfilled, `userName` will be the user's name, otherwise it
	        // will be `'default name'`
	      });

							 findUser().then(function (user) {
	        throw new Error('Found user, but still unhappy');
	      }, function (reason) {
	        throw new Error('`findUser` rejected and we're unhappy');
	      }).then(function (value) {
	        // never reached
	      }, function (reason) {
	        // if `findUser` fulfilled, `reason` will be 'Found user, but still unhappy'.
	        // If `findUser` rejected, `reason` will be '`findUser` rejected and we're unhappy'.
	      });
							 ```
							 If the downstream promise does not specify a rejection handler, rejection reasons will be propagated further downstream.

							 ```js
							 findUser().then(function (user) {
	        throw new PedagogicalException('Upstream error');
	      }).then(function (value) {
	        // never reached
	      }).then(function (value) {
	        // never reached
	      }, function (reason) {
	        // The `PedgagocialException` is propagated all the way down to here
	      });
							 ```

							 Assimilation
							 ------------

							 Sometimes the value you want to propagate to a downstream promise can only be
							 retrieved asynchronously. This can be achieved by returning a promise in the
							 fulfillment or rejection handler. The downstream promise will then be pending
							 until the returned promise is settled. This is called *assimilation*.

							 ```js
							 findUser().then(function (user) {
	        return findCommentsByAuthor(user);
	      }).then(function (comments) {
	        // The user's comments are now available
	      });
							 ```

							 If the assimliated promise rejects, then the downstream promise will also reject.

							 ```js
							 findUser().then(function (user) {
	        return findCommentsByAuthor(user);
	      }).then(function (comments) {
	        // If `findCommentsByAuthor` fulfills, we'll have the value here
	      }, function (reason) {
	        // If `findCommentsByAuthor` rejects, we'll have the reason here
	      });
							 ```

							 Simple Example
							 --------------

							 Synchronous Example

							 ```javascript
							 let result;

							 try {
	        result = findResult();
	        // success
	      } catch(reason) {
	        // failure
	      }
							 ```

							 Errback Example

							 ```js
							 findResult(function(result, err){
	        if (err) {
	          // failure
	        } else {
	          // success
	        }
	      });
							 ```

							 Promise Example;

							 ```javascript
							 findResult().then(function(result){
	        // success
	      }, function(reason){
	        // failure
	      });
							 ```

							 Advanced Example
							 --------------

							 Synchronous Example

							 ```javascript
							 let author, books;

							 try {
	        author = findAuthor();
	        books  = findBooksByAuthor(author);
	        // success
	      } catch(reason) {
	        // failure
	      }
							 ```

							 Errback Example

							 ```js

							 function foundBooks(books) {

	      }

							 function failure(reason) {

	      }

							 findAuthor(function(author, err){
	        if (err) {
	          failure(err);
	          // failure
	        } else {
	          try {
	            findBoooksByAuthor(author, function(books, err) {
	              if (err) {
	                failure(err);
	              } else {
	                try {
	                  foundBooks(books);
	                } catch(reason) {
	                  failure(reason);
	                }
	              }
	            });
	          } catch(error) {
	            failure(err);
	          }
	          // success
	        }
	      });
							 ```

							 Promise Example;

							 ```javascript
							 findAuthor().
							 then(findBooksByAuthor).
							 then(function(books){
	          // found books
	      }).catch(function(reason){
	        // something went wrong
	      });
							 ```

							 @method then
							 @param {Function} onFulfilled
							 @param {Function} onRejected
							 Useful for tooling.
							 @return {Promise}
							 */
							then: then,

							/**
							 `catch` is simply sugar for `then(undefined, onRejection)` which makes it the same
							 as the catch block of a try/catch statement.

							 ```js
							 function findAuthor(){
	        throw new Error('couldn't find that author');
	      }

							 // synchronous
							 try {
	        findAuthor();
	      } catch(reason) {
	        // something went wrong
	      }

							 // async with promises
							 findAuthor().catch(function(reason){
	        // something went wrong
	      });
							 ```

							 @method catch
							 @param {Function} onRejection
							 Useful for tooling.
							 @return {Promise}
							 */
							'catch': function _catch(onRejection) {
								return this.then(null, onRejection);
							}
						};

						function polyfill() {
							var local = undefined;

							if (typeof global !== 'undefined') {
								local = global;
							} else if (typeof self !== 'undefined') {
								local = self;
							} else {
								try {
									local = Function('return this')();
								} catch (e) {
									throw new Error('polyfill failed because global object is unavailable in this environment');
								}
							}

							var P = local.Promise;

							if (P) {
								var promiseToString = null;
								try {
									promiseToString = Object.prototype.toString.call(P.resolve());
								} catch (e) {
									// silently ignored
								}

								if (promiseToString === '[object Promise]' && !P.cast) {
									return;
								}
							}

							local.Promise = Promise;
						}

						// Strange compat..
						Promise.polyfill = polyfill;
						Promise.Promise = Promise;

						return Promise;
					});

					/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(32), (function() { return this; }())))

				/***/ },
			/* 32 */
			/***/ function(module, exports) {

				'use strict';

				// shim for using process in browser
				var process = module.exports = {};

				// cached from whatever global is present so that test runners that stub it
				// don't break things.  But we need to wrap it in a try catch in case it is
				// wrapped in strict mode code which doesn't define any globals.  It's inside a
				// function because try/catches deoptimize in certain engines.

				var cachedSetTimeout;
				var cachedClearTimeout;

				function defaultSetTimout() {
					throw new Error('setTimeout has not been defined');
				}
				function defaultClearTimeout() {
					throw new Error('clearTimeout has not been defined');
				}
				(function () {
					try {
						if (typeof setTimeout === 'function') {
							cachedSetTimeout = setTimeout;
						} else {
							cachedSetTimeout = defaultSetTimout;
						}
					} catch (e) {
						cachedSetTimeout = defaultSetTimout;
					}
					try {
						if (typeof clearTimeout === 'function') {
							cachedClearTimeout = clearTimeout;
						} else {
							cachedClearTimeout = defaultClearTimeout;
						}
					} catch (e) {
						cachedClearTimeout = defaultClearTimeout;
					}
				})();
				function runTimeout(fun) {
					if (cachedSetTimeout === setTimeout) {
						//normal enviroments in sane situations
						return setTimeout(fun, 0);
					}
					// if setTimeout wasn't available but was latter defined
					if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
						cachedSetTimeout = setTimeout;
						return setTimeout(fun, 0);
					}
					try {
						// when when somebody has screwed with setTimeout but no I.E. maddness
						return cachedSetTimeout(fun, 0);
					} catch (e) {
						try {
							// When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
							return cachedSetTimeout.call(null, fun, 0);
						} catch (e) {
							// same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
							return cachedSetTimeout.call(this, fun, 0);
						}
					}
				}
				function runClearTimeout(marker) {
					if (cachedClearTimeout === clearTimeout) {
						//normal enviroments in sane situations
						return clearTimeout(marker);
					}
					// if clearTimeout wasn't available but was latter defined
					if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
						cachedClearTimeout = clearTimeout;
						return clearTimeout(marker);
					}
					try {
						// when when somebody has screwed with setTimeout but no I.E. maddness
						return cachedClearTimeout(marker);
					} catch (e) {
						try {
							// When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
							return cachedClearTimeout.call(null, marker);
						} catch (e) {
							// same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
							// Some versions of I.E. have different rules for clearTimeout vs setTimeout
							return cachedClearTimeout.call(this, marker);
						}
					}
				}
				var queue = [];
				var draining = false;
				var currentQueue;
				var queueIndex = -1;

				function cleanUpNextTick() {
					if (!draining || !currentQueue) {
						return;
					}
					draining = false;
					if (currentQueue.length) {
						queue = currentQueue.concat(queue);
					} else {
						queueIndex = -1;
					}
					if (queue.length) {
						drainQueue();
					}
				}

				function drainQueue() {
					if (draining) {
						return;
					}
					var timeout = runTimeout(cleanUpNextTick);
					draining = true;

					var len = queue.length;
					while (len) {
						currentQueue = queue;
						queue = [];
						while (++queueIndex < len) {
							if (currentQueue) {
								currentQueue[queueIndex].run();
							}
						}
						queueIndex = -1;
						len = queue.length;
					}
					currentQueue = null;
					draining = false;
					runClearTimeout(timeout);
				}

				process.nextTick = function (fun) {
					var args = new Array(arguments.length - 1);
					if (arguments.length > 1) {
						for (var i = 1; i < arguments.length; i++) {
							args[i - 1] = arguments[i];
						}
					}
					queue.push(new Item(fun, args));
					if (queue.length === 1 && !draining) {
						runTimeout(drainQueue);
					}
				};

				// v8 likes predictible objects
				function Item(fun, array) {
					this.fun = fun;
					this.array = array;
				}
				Item.prototype.run = function () {
					this.fun.apply(null, this.array);
				};
				process.title = 'browser';
				process.browser = true;
				process.env = {};
				process.argv = [];
				process.version = ''; // empty string to avoid regexp issues
				process.versions = {};

				function noop() {}

				process.on = noop;
				process.addListener = noop;
				process.once = noop;
				process.off = noop;
				process.removeListener = noop;
				process.removeAllListeners = noop;
				process.emit = noop;

				process.binding = function (name) {
					throw new Error('process.binding is not supported');
				};

				process.cwd = function () {
					return '/';
				};
				process.chdir = function (dir) {
					throw new Error('process.chdir is not supported');
				};
				process.umask = function () {
					return 0;
				};

				/***/ },
			/* 33 */
			/***/ function(module, exports) {

				/* (ignored) */

				/***/ },
			/* 34 */
			/***/ function(module, exports) {

				"use strict";

				window.customElements && eval("/**\n * @license\n * Copyright (c) 2016 The Polymer Project Authors. All rights reserved.\n * This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt\n * The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt\n * The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt\n * Code distributed by Google as part of the polymer project is also\n * subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt\n */\n\n/**\n * This shim allows elements written in, or compiled to, ES5 to work on native\n * implementations of Custom Elements.\n *\n * ES5-style classes don't work with native Custom Elements because the\n * HTMLElement constructor uses the value of `new.target` to look up the custom\n * element definition for the currently called constructor. `new.target` is only\n * set when `new` is called and is only propagated via super() calls. super()\n * is not emulatable in ES5. The pattern of `SuperClass.call(this)`` only works\n * when extending other ES5-style classes, and does not propagate `new.target`.\n *\n * This shim allows the native HTMLElement constructor to work by generating and\n * registering a stand-in class instead of the users custom element class. This\n * stand-in class's constructor has an actual call to super().\n * `customElements.define()` and `customElements.get()` are both overridden to\n * hide this stand-in class from users.\n *\n * In order to create instance of the user-defined class, rather than the stand\n * in, the stand-in's constructor swizzles its instances prototype and invokes\n * the user-defined constructor. When the user-defined constructor is called\n * directly it creates an instance of the stand-in class to get a real extension\n * of HTMLElement and returns that.\n *\n * There are two important constructors: A patched HTMLElement constructor, and\n * the StandInElement constructor. They both will be called to create an element\n * but which is called first depends on whether the browser creates the element\n * or the user-defined constructor is called directly. The variables\n * `browserConstruction` and `userConstruction` control the flow between the\n * two constructors.\n *\n * This shim should be better than forcing the polyfill because:\n *   1. It's smaller\n *   2. All reaction timings are the same as native (mostly synchronous)\n *   3. All reaction triggering DOM operations are automatically supported\n *\n * There are some restrictions and requirements on ES5 constructors:\n *   1. All constructors in a inheritance hierarchy must be ES5-style, so that\n *      they can be called with Function.call(). This effectively means that the\n *      whole application must be compiled to ES5.\n *   2. Constructors must return the value of the emulated super() call. Like\n *      `return SuperClass.call(this)`\n *   3. The `this` reference should not be used before the emulated super() call\n *      just like `this` is illegal to use before super() in ES6.\n *   4. Constructors should not create other custom elements before the emulated\n *      super() call. This is the same restriction as with native custom\n *      elements.\n *\n *  Compiling valid class-based custom elements to ES5 will satisfy these\n *  requirements with the latest version of popular transpilers.\n */\n(() => {\n  'use strict';\n\n  // Do nothing if `customElements` does not exist.\n  if (!window.customElements) return;\n\n  const NativeHTMLElement = window.HTMLElement;\n  const nativeDefine = window.customElements.define;\n  const nativeGet = window.customElements.get;\n\n  /**\n   * Map of user-provided constructors to tag names.\n   *\n   * @type {Map<Function, string>}\n   */\n  const tagnameByConstructor = new Map();\n\n  /**\n   * Map of tag names to user-provided constructors.\n   *\n   * @type {Map<string, Function>}\n   */\n  const constructorByTagname = new Map();\n\n\n  /**\n   * Whether the constructors are being called by a browser process, ie parsing\n   * or createElement.\n   */\n  let browserConstruction = false;\n\n  /**\n   * Whether the constructors are being called by a user-space process, ie\n   * calling an element constructor.\n   */\n  let userConstruction = false;\n\n  window.HTMLElement = function() {\n    if (!browserConstruction) {\n      const tagname = tagnameByConstructor.get(this.constructor);\n      const fakeClass = nativeGet.call(window.customElements, tagname);\n\n      // Make sure that the fake constructor doesn't call back to this constructor\n      userConstruction = true;\n      const instance = new (fakeClass)();\n      return instance;\n    }\n    // Else do nothing. This will be reached by ES5-style classes doing\n    // HTMLElement.call() during initialization\n    browserConstruction = false;\n  };\n  // By setting the patched HTMLElement's prototype property to the native\n  // HTMLElement's prototype we make sure that:\n  //     document.createElement('a') instanceof HTMLElement\n  // works because instanceof uses HTMLElement.prototype, which is on the\n  // ptototype chain of built-in elements.\n  window.HTMLElement.prototype = NativeHTMLElement.prototype;\n\n  window.customElements.define = (tagname, elementClass) => {\n    const elementProto = elementClass.prototype;\n    const StandInElement = class extends NativeHTMLElement {\n      constructor() {\n        // Call the native HTMLElement constructor, this gives us the\n        // under-construction instance as `this`:\n        super();\n\n        // The prototype will be wrong up because the browser used our fake\n        // class, so fix it:\n        Object.setPrototypeOf(this, elementProto);\n\n        if (!userConstruction) {\n          // Make sure that user-defined constructor bottom's out to a do-nothing\n          // HTMLElement() call\n          browserConstruction = true;\n          // Call the user-defined constructor on our instance:\n          elementClass.call(this);\n        }\n        userConstruction = false;\n      }\n    };\n    const standInProto = StandInElement.prototype;\n    StandInElement.observedAttributes = elementClass.observedAttributes;\n    standInProto.connectedCallback = elementProto.connectedCallback;\n    standInProto.disconnectedCallback = elementProto.disconnectedCallback;\n    standInProto.attributeChangedCallback = elementProto.attributeChangedCallback;\n    standInProto.adoptedCallback = elementProto.adoptedCallback;\n\n    tagnameByConstructor.set(elementClass, tagname);\n    constructorByTagname.set(tagname, elementClass);\n    nativeDefine.call(window.customElements, tagname, StandInElement);\n  };\n\n  window.customElements.get = (tagname) => constructorByTagname.get(tagname);\n\n})();\n");

				/***/ },
			/* 35 */
			/***/ function(module, exports) {

				'use strict';

				/**
				 * @license
				 * Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 * This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 * The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 * The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 * Code distributed by Google as part of the polymer project is also
				 * subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				// minimal template polyfill
				(function () {

					var needsTemplate = typeof HTMLTemplateElement === 'undefined';

					// NOTE: Patch document.importNode to work around IE11 bug that
					// casues children of a document fragment imported while
					// there is a mutation observer to not have a parentNode (!?!)
					// It's important that this is the first patch to `importNode` so that
					// dom produced for later patches is correct.
					if (/Trident/.test(navigator.userAgent)) {
						(function () {
							var Native_importNode = Document.prototype.importNode;
							Document.prototype.importNode = function () {
								var n = Native_importNode.apply(this, arguments);
								// Copy all children to a new document fragment since
								// this one may be broken
								if (n.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
									var f = this.createDocumentFragment();
									f.appendChild(n);
									return f;
								} else {
									return n;
								}
							};
						})();
					}

					// NOTE: we rely on this cloneNode not causing element upgrade.
					// This means this polyfill must load before the CE polyfill and
					// this would need to be re-worked if a browser supports native CE
					// but not <template>.
					var Native_cloneNode = Node.prototype.cloneNode;
					var Native_createElement = Document.prototype.createElement;
					var Native_importNode = Document.prototype.importNode;

					// returns true if nested templates cannot be cloned (they cannot be on
					// some impl's like Safari 8 and Edge)
					// OR if cloning a document fragment does not result in a document fragment
					var needsCloning = function () {
						if (!needsTemplate) {
							var t = document.createElement('template');
							var t2 = document.createElement('template');
							t2.content.appendChild(document.createElement('div'));
							t.content.appendChild(t2);
							var clone = t.cloneNode(true);
							return clone.content.childNodes.length === 0 || clone.content.firstChild.content.childNodes.length === 0 || !(document.createDocumentFragment().cloneNode() instanceof DocumentFragment);
						}
					}();

					var TEMPLATE_TAG = 'template';
					var PolyfilledHTMLTemplateElement = function PolyfilledHTMLTemplateElement() {};

					if (needsTemplate) {
						var contentDoc;
						var canDecorate;
						var templateStyle;
						var head;
						var canProtoPatch;
						var escapeDataRegExp;

						(function () {
							var defineInnerHTML = function defineInnerHTML(obj) {
								Object.defineProperty(obj, 'innerHTML', {
									get: function get() {
										var o = '';
										for (var e = this.content.firstChild; e; e = e.nextSibling) {
											o += e.outerHTML || escapeData(e.data);
										}
										return o;
									},
									set: function set(text) {
										contentDoc.body.innerHTML = text;
										PolyfilledHTMLTemplateElement.bootstrap(contentDoc);
										while (this.content.firstChild) {
											this.content.removeChild(this.content.firstChild);
										}
										while (contentDoc.body.firstChild) {
											this.content.appendChild(contentDoc.body.firstChild);
										}
									},
									configurable: true
								});
							};

							var escapeReplace = function escapeReplace(c) {
								switch (c) {
									case '&':
										return '&amp;';
									case '<':
										return '&lt;';
									case '>':
										return '&gt;';
									case '\xA0':
										return '&nbsp;';
								}
							};

							var escapeData = function escapeData(s) {
								return s.replace(escapeDataRegExp, escapeReplace);
							};

							contentDoc = document.implementation.createHTMLDocument('template');
							canDecorate = true;
							templateStyle = document.createElement('style');

							templateStyle.textContent = TEMPLATE_TAG + '{display:none;}';

							head = document.head;

							head.insertBefore(templateStyle, head.firstElementChild);

							/**
							 Provides a minimal shim for the <template> element.
							 */
							PolyfilledHTMLTemplateElement.prototype = Object.create(HTMLElement.prototype);

							// if elements do not have `innerHTML` on instances, then
							// templates can be patched by swizzling their prototypes.
							canProtoPatch = !document.createElement('div').hasOwnProperty('innerHTML');

							/**
							 The `decorate` method moves element children to the template's `content`.
							 NOTE: there is no support for dynamically adding elements to templates.
							 */

							PolyfilledHTMLTemplateElement.decorate = function (template) {
								// if the template is decorated, return fast
								if (template.content) {
									return;
								}
								template.content = contentDoc.createDocumentFragment();
								var child;
								while (child = template.firstChild) {
									template.content.appendChild(child);
								}
								// NOTE: prefer prototype patching for performance and
								// because on some browsers (IE11), re-defining `innerHTML`
								// can result in intermittent errors.
								if (canProtoPatch) {
									template.__proto__ = PolyfilledHTMLTemplateElement.prototype;
								} else {
									template.cloneNode = function (deep) {
										return PolyfilledHTMLTemplateElement._cloneNode(this, deep);
									};
									// add innerHTML to template, if possible
									// Note: this throws on Safari 7
									if (canDecorate) {
										try {
											defineInnerHTML(template);
										} catch (err) {
											canDecorate = false;
										}
									}
								}
								// bootstrap recursively
								PolyfilledHTMLTemplateElement.bootstrap(template.content);
							};

							defineInnerHTML(PolyfilledHTMLTemplateElement.prototype);

							/**
							 The `bootstrap` method is called automatically and "fixes" all
							 <template> elements in the document referenced by the `doc` argument.
							 */
							PolyfilledHTMLTemplateElement.bootstrap = function (doc) {
								var templates = doc.querySelectorAll(TEMPLATE_TAG);
								for (var i = 0, l = templates.length, t; i < l && (t = templates[i]); i++) {
									PolyfilledHTMLTemplateElement.decorate(t);
								}
							};

							// auto-bootstrapping for main document
							document.addEventListener('DOMContentLoaded', function () {
								PolyfilledHTMLTemplateElement.bootstrap(document);
							});

							// Patch document.createElement to ensure newly created templates have content
							Document.prototype.createElement = function () {
								'use strict';

								var el = Native_createElement.apply(this, arguments);
								if (el.localName === 'template') {
									PolyfilledHTMLTemplateElement.decorate(el);
								}
								return el;
							};

							escapeDataRegExp = /[&\u00A0<>]/g;
						})();
					}

					// make cloning/importing work!
					if (needsTemplate || needsCloning) {

						PolyfilledHTMLTemplateElement._cloneNode = function (template, deep) {
							var clone = Native_cloneNode.call(template, false);
							// NOTE: decorate doesn't auto-fix children because they are already
							// decorated so they need special clone fixup.
							if (this.decorate) {
								this.decorate(clone);
							}
							if (deep) {
								// NOTE: use native clone node to make sure CE's wrapped
								// cloneNode does not cause elements to upgrade.
								clone.content.appendChild(Native_cloneNode.call(template.content, true));
								// now ensure nested templates are cloned correctly.
								this.fixClonedDom(clone.content, template.content);
							}
							return clone;
						};

						PolyfilledHTMLTemplateElement.prototype.cloneNode = function (deep) {
							return PolyfilledHTMLTemplateElement._cloneNode(this, deep);
						};

						// Given a source and cloned subtree, find <template>'s in the cloned
						// subtree and replace them with cloned <template>'s from source.
						// We must do this because only the source templates have proper .content.
						PolyfilledHTMLTemplateElement.fixClonedDom = function (clone, source) {
							// do nothing if cloned node is not an element
							if (!source.querySelectorAll) return;
							// these two lists should be coincident
							var s$ = source.querySelectorAll(TEMPLATE_TAG);
							var t$ = clone.querySelectorAll(TEMPLATE_TAG);
							for (var i = 0, l = t$.length, t, s; i < l; i++) {
								s = s$[i];
								t = t$[i];
								if (this.decorate) {
									this.decorate(s);
								}
								t.parentNode.replaceChild(s.cloneNode(true), t);
							}
						};

						// override all cloning to fix the cloned subtree to contain properly
						// cloned templates.
						Node.prototype.cloneNode = function (deep) {
							var dom;
							// workaround for Edge bug cloning documentFragments
							// https://developer.microsoft.com/en-us/microsoft-edge/platform/issues/8619646/
							if (this instanceof DocumentFragment) {
								if (!deep) {
									return this.ownerDocument.createDocumentFragment();
								} else {
									dom = this.ownerDocument.importNode(this, true);
								}
							} else {
								dom = Native_cloneNode.call(this, deep);
							}
							// template.content is cloned iff `deep`.
							if (deep) {
								PolyfilledHTMLTemplateElement.fixClonedDom(dom, this);
							}
							return dom;
						};

						// NOTE: we are cloning instead of importing <template>'s.
						// However, the ownerDocument of the cloned template will be correct!
						// This is because the native import node creates the right document owned
						// subtree and `fixClonedDom` inserts cloned templates into this subtree,
						// thus updating the owner doc.
						Document.prototype.importNode = function (element, deep) {
							if (element.localName === TEMPLATE_TAG) {
								return PolyfilledHTMLTemplateElement._cloneNode(element, deep);
							} else {
								var dom = Native_importNode.call(this, element, deep);
								if (deep) {
									PolyfilledHTMLTemplateElement.fixClonedDom(dom, element);
								}
								return dom;
							}
						};

						if (needsCloning) {
							window.HTMLTemplateElement.prototype.cloneNode = function (deep) {
								return PolyfilledHTMLTemplateElement._cloneNode(this, deep);
							};
						}
					}

					if (needsTemplate) {
						window.HTMLTemplateElement = PolyfilledHTMLTemplateElement;
					}
				})();

				/***/ },
			/* 36 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _CustomElementRegistry = __webpack_require__(40);

				var _CustomElementRegistry2 = _interopRequireDefault(_CustomElementRegistry);

				var _HTMLElement = __webpack_require__(43);

				var _HTMLElement2 = _interopRequireDefault(_HTMLElement);

				var _Document = __webpack_require__(46);

				var _Document2 = _interopRequireDefault(_Document);

				var _Node = __webpack_require__(48);

				var _Node2 = _interopRequireDefault(_Node);

				var _Element = __webpack_require__(49);

				var _Element2 = _interopRequireDefault(_Element);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				/**
				 * @license
				 * Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 * This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 * The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 * The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 * Code distributed by Google as part of the polymer project is also
				 * subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				var priorCustomElements = window['customElements'];

				if (!priorCustomElements || priorCustomElements['forcePolyfill'] || typeof priorCustomElements['define'] != 'function' || typeof priorCustomElements['get'] != 'function') {
					/** @type {!CustomElementInternals} */
					var internals = new _CustomElementInternals2.default();

					(0, _HTMLElement2.default)(internals);
					(0, _Document2.default)(internals);
					(0, _Node2.default)(internals);
					(0, _Element2.default)(internals);

					// The main document is always associated with the registry.
					document.__CE_hasRegistry = true;

					/** @type {!CustomElementRegistry} */
					var customElements = new _CustomElementRegistry2.default(internals);

					Object.defineProperty(window, 'customElements', {
						configurable: true,
						enumerable: true,
						value: customElements
					});
				}

				/***/ },
			/* 37 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				var _CustomElementState = __webpack_require__(39);

				var _CustomElementState2 = _interopRequireDefault(_CustomElementState);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var CustomElementInternals = function () {
					function CustomElementInternals() {
						_classCallCheck(this, CustomElementInternals);

						/** @type {!Map<string, !CustomElementDefinition>} */
						this._localNameToDefinition = new Map();

						/** @type {!Map<!Function, !CustomElementDefinition>} */
						this._constructorToDefinition = new Map();

						/** @type {!Array<!function(!Node)>} */
						this._patches = [];

						/** @type {boolean} */
						this._hasPatches = false;
					}

					/**
					 * @param {string} localName
					 * @param {!CustomElementDefinition} definition
					 */


					_createClass(CustomElementInternals, [{
						key: 'setDefinition',
						value: function setDefinition(localName, definition) {
							this._localNameToDefinition.set(localName, definition);
							this._constructorToDefinition.set(definition.constructor, definition);
						}

						/**
						 * @param {string} localName
						 * @return {!CustomElementDefinition|undefined}
						 */

					}, {
						key: 'localNameToDefinition',
						value: function localNameToDefinition(localName) {
							return this._localNameToDefinition.get(localName);
						}

						/**
						 * @param {!Function} constructor
						 * @return {!CustomElementDefinition|undefined}
						 */

					}, {
						key: 'constructorToDefinition',
						value: function constructorToDefinition(constructor) {
							return this._constructorToDefinition.get(constructor);
						}

						/**
						 * @param {!function(!Node)} listener
						 */

					}, {
						key: 'addPatch',
						value: function addPatch(listener) {
							this._hasPatches = true;
							this._patches.push(listener);
						}

						/**
						 * @param {!Node} node
						 */

					}, {
						key: 'patchTree',
						value: function patchTree(node) {
							var _this = this;

							if (!this._hasPatches) return;

							Utilities.walkDeepDescendantElements(node, function (element) {
								return _this.patch(element);
							});
						}

						/**
						 * @param {!Node} node
						 */

					}, {
						key: 'patch',
						value: function patch(node) {
							if (!this._hasPatches) return;

							if (node.__CE_patched) return;
							node.__CE_patched = true;

							for (var i = 0; i < this._patches.length; i++) {
								this._patches[i](node);
							}
						}

						/**
						 * @param {!Node} root
						 */

					}, {
						key: 'connectTree',
						value: function connectTree(root) {
							var elements = [];

							Utilities.walkDeepDescendantElements(root, function (element) {
								return elements.push(element);
							});

							for (var i = 0; i < elements.length; i++) {
								var element = elements[i];
								if (element.__CE_state === _CustomElementState2.default.custom) {
									this.connectedCallback(element);
								} else {
									this.upgradeElement(element);
								}
							}
						}

						/**
						 * @param {!Node} root
						 */

					}, {
						key: 'disconnectTree',
						value: function disconnectTree(root) {
							var elements = [];

							Utilities.walkDeepDescendantElements(root, function (element) {
								return elements.push(element);
							});

							for (var i = 0; i < elements.length; i++) {
								var element = elements[i];
								if (element.__CE_state === _CustomElementState2.default.custom) {
									this.disconnectedCallback(element);
								}
							}
						}

						/**
						 * Upgrades all uncustomized custom elements at and below a root node for
						 * which there is a definition. When custom element reaction callbacks are
						 * assumed to be called synchronously (which, by the current DOM / HTML spec
						 * definitions, they are *not*), callbacks for both elements customized
						 * synchronously by the parser and elements being upgraded occur in the same
						 * relative order.
						 *
						 * NOTE: This function, when used to simulate the construction of a tree that
						 * is already created but not customized (i.e. by the parser), does *not*
						 * prevent the element from reading the 'final' (true) state of the tree. For
						 * example, the element, during truly synchronous parsing / construction would
						 * see that it contains no children as they have not yet been inserted.
						 * However, this function does not modify the tree, the element will
						 * (incorrectly) have children. Additionally, self-modification restrictions
						 * for custom element constructors imposed by the DOM spec are *not* enforced.
						 *
						 *
						 * The following nested list shows the steps extending down from the HTML
						 * spec's parsing section that cause elements to be synchronously created and
						 * upgraded:
						 *
						 * The "in body" insertion mode:
						 * https://html.spec.whatwg.org/multipage/syntax.html#parsing-main-inbody
						 * - Switch on token:
						 *   .. other cases ..
						 *   -> Any other start tag
						 *      - [Insert an HTML element](below) for the token.
						 *
						 * Insert an HTML element:
						 * https://html.spec.whatwg.org/multipage/syntax.html#insert-an-html-element
						 * - Insert a foreign element for the token in the HTML namespace:
						 *   https://html.spec.whatwg.org/multipage/syntax.html#insert-a-foreign-element
						 *   - Create an element for a token:
						 *     https://html.spec.whatwg.org/multipage/syntax.html#create-an-element-for-the-token
						 *     - Will execute script flag is true?
						 *       - (Element queue pushed to the custom element reactions stack.)
						 *     - Create an element:
						 *       https://dom.spec.whatwg.org/#concept-create-element
						 *       - Sync CE flag is true?
						 *         - Constructor called.
						 *         - Self-modification restrictions enforced.
						 *       - Sync CE flag is false?
						 *         - (Upgrade reaction enqueued.)
						 *     - Attributes appended to element.
						 *       (`attributeChangedCallback` reactions enqueued.)
						 *     - Will execute script flag is true?
						 *       - (Element queue popped from the custom element reactions stack.
						 *         Reactions in the popped stack are invoked.)
						 *   - (Element queue pushed to the custom element reactions stack.)
						 *   - Insert the element:
						 *     https://dom.spec.whatwg.org/#concept-node-insert
						 *     - Shadow-including descendants are connected. During parsing
						 *       construction, there are no shadow-*excluding* descendants.
						 *       However, the constructor may have validly attached a shadow
						 *       tree to itself and added descendants to that shadow tree.
						 *       (`connectedCallback` reactions enqueued.)
						 *   - (Element queue popped from the custom element reactions stack.
						 *     Reactions in the popped stack are invoked.)
						 *
						 * @param {!Node} root
						 * @param {!Set<Node>=} visitedImports
						 */

					}, {
						key: 'patchAndUpgradeTree',
						value: function patchAndUpgradeTree(root) {
							var _this2 = this;

							var visitedImports = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : new Set();

							var elements = [];

							var gatherElements = function gatherElements(element) {
								if (element.localName === 'link' && element.getAttribute('rel') === 'import') {
									// The HTML Imports polyfill sets a descendant element of the link to
									// the `import` property, specifically this is *not* a Document.
									var importNode = /** @type {?Node} */element.import;

									if (importNode instanceof Node && importNode.readyState === 'complete') {
										importNode.__CE_isImportDocument = true;

										// Connected links are associated with the registry.
										importNode.__CE_hasRegistry = true;
									} else {
										// If this link's import root is not available, its contents can't be
										// walked. Wait for 'load' and walk it when it's ready.
										element.addEventListener('load', function () {
											var importNode = /** @type {!Node} */element.import;

											if (importNode.__CE_documentLoadHandled) return;
											importNode.__CE_documentLoadHandled = true;

											importNode.__CE_isImportDocument = true;

											// Connected links are associated with the registry.
											importNode.__CE_hasRegistry = true;

											// Clone the `visitedImports` set that was populated sync during
											// the `patchAndUpgradeTree` call that caused this 'load' handler to
											// be added. Then, remove *this* link's import node so that we can
											// walk that import again, even if it was partially walked later
											// during the same `patchAndUpgradeTree` call.
											var clonedVisitedImports = new Set(visitedImports);
											visitedImports.delete(importNode);

											_this2.patchAndUpgradeTree(importNode, visitedImports);
										});
									}
								} else {
									elements.push(element);
								}
							};

							// `walkDeepDescendantElements` populates (and internally checks against)
							// `visitedImports` when traversing a loaded import.
							Utilities.walkDeepDescendantElements(root, gatherElements, visitedImports);

							if (this._hasPatches) {
								for (var i = 0; i < elements.length; i++) {
									this.patch(elements[i]);
								}
							}

							for (var _i = 0; _i < elements.length; _i++) {
								this.upgradeElement(elements[_i]);
							}
						}

						/**
						 * @param {!Element} element
						 */

					}, {
						key: 'upgradeElement',
						value: function upgradeElement(element) {
							var currentState = element.__CE_state;
							if (currentState !== undefined) return;

							var definition = this.localNameToDefinition(element.localName);
							if (!definition) return;

							definition.constructionStack.push(element);

							var constructor = definition.constructor;
							try {
								try {
									var result = new constructor();
									if (result !== element) {
										throw new Error('The custom element constructor did not produce the element being upgraded.');
									}
								} finally {
									definition.constructionStack.pop();
								}
							} catch (e) {
								element.__CE_state = _CustomElementState2.default.failed;
								throw e;
							}

							element.__CE_state = _CustomElementState2.default.custom;
							element.__CE_definition = definition;

							if (definition.attributeChangedCallback) {
								var observedAttributes = definition.observedAttributes;
								for (var i = 0; i < observedAttributes.length; i++) {
									var name = observedAttributes[i];
									var value = element.getAttribute(name);
									if (value !== null) {
										this.attributeChangedCallback(element, name, null, value, null);
									}
								}
							}

							if (Utilities.isConnected(element)) {
								this.connectedCallback(element);
							}
						}

						/**
						 * @param {!Element} element
						 */

					}, {
						key: 'connectedCallback',
						value: function connectedCallback(element) {
							var definition = element.__CE_definition;
							if (definition.connectedCallback) {
								definition.connectedCallback.call(element);
							}
						}

						/**
						 * @param {!Element} element
						 */

					}, {
						key: 'disconnectedCallback',
						value: function disconnectedCallback(element) {
							var definition = element.__CE_definition;
							if (definition.disconnectedCallback) {
								definition.disconnectedCallback.call(element);
							}
						}

						/**
						 * @param {!Element} element
						 * @param {string} name
						 * @param {?string} oldValue
						 * @param {?string} newValue
						 * @param {?string} namespace
						 */

					}, {
						key: 'attributeChangedCallback',
						value: function attributeChangedCallback(element, name, oldValue, newValue, namespace) {
							var definition = element.__CE_definition;
							if (definition.attributeChangedCallback && definition.observedAttributes.indexOf(name) > -1) {
								definition.attributeChangedCallback.call(element, name, oldValue, newValue, namespace);
							}
						}
					}]);

					return CustomElementInternals;
				}();

				exports.default = CustomElementInternals;

				/***/ },
			/* 38 */
			/***/ function(module, exports) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.isValidCustomElementName = isValidCustomElementName;
				exports.isConnected = isConnected;
				exports.walkDeepDescendantElements = walkDeepDescendantElements;
				exports.setPropertyUnchecked = setPropertyUnchecked;
				var reservedTagList = new Set(['annotation-xml', 'color-profile', 'font-face', 'font-face-src', 'font-face-uri', 'font-face-format', 'font-face-name', 'missing-glyph']);

				/**
				 * @param {string} localName
				 * @returns {boolean}
				 */
				function isValidCustomElementName(localName) {
					var reserved = reservedTagList.has(localName);
					var validForm = /^[a-z][.0-9_a-z]*-[\-.0-9_a-z]*$/.test(localName);
					return !reserved && validForm;
				}

				/**
				 * @private
				 * @param {!Node} node
				 * @return {boolean}
				 */
				function isConnected(node) {
					// Use `Node#isConnected`, if defined.
					var nativeValue = node.isConnected;
					if (nativeValue !== undefined) {
						return nativeValue;
					}

					/** @type {?Node|undefined} */
					var current = node;
					while (current && !(current.__CE_isImportDocument || current instanceof Document)) {
						current = current.parentNode || (window.ShadowRoot && current instanceof ShadowRoot ? current.host : undefined);
					}
					return !!(current && (current.__CE_isImportDocument || current instanceof Document));
				}

				/**
				 * @param {!Node} root
				 * @param {!Node} start
				 * @return {?Node}
				 */
				function nextSiblingOrAncestorSibling(root, start) {
					var node = start;
					while (node && node !== root && !node.nextSibling) {
						node = node.parentNode;
					}
					return !node || node === root ? null : node.nextSibling;
				}

				/**
				 * @param {!Node} root
				 * @param {!Node} start
				 * @return {?Node}
				 */
				function nextNode(root, start) {
					return start.firstChild ? start.firstChild : nextSiblingOrAncestorSibling(root, start);
				}

				/**
				 * @param {!Node} root
				 * @param {!function(!Element)} callback
				 * @param {!Set<Node>=} visitedImports
				 */
				function walkDeepDescendantElements(root, callback) {
					var visitedImports = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : new Set();

					var node = root;
					while (node) {
						if (node.nodeType === Node.ELEMENT_NODE) {
							var element = /** @type {!Element} */node;

							callback(element);

							var localName = element.localName;
							if (localName === 'link' && element.getAttribute('rel') === 'import') {
								// If this import (polyfilled or not) has it's root node available,
								// walk it.
								var importNode = /** @type {!Node} */element.import;
								if (importNode instanceof Node && !visitedImports.has(importNode)) {
									// Prevent multiple walks of the same import root.
									visitedImports.add(importNode);

									for (var child = importNode.firstChild; child; child = child.nextSibling) {
										walkDeepDescendantElements(child, callback, visitedImports);
									}
								}

								// Ignore descendants of import links to prevent attempting to walk the
								// elements created by the HTML Imports polyfill that we just walked
								// above.
								node = nextSiblingOrAncestorSibling(root, element);
								continue;
							} else if (localName === 'template') {
								// Ignore descendants of templates. There shouldn't be any descendants
								// because they will be moved into `.content` during construction in
								// browsers that support template but, in case they exist and are still
								// waiting to be moved by a polyfill, they will be ignored.
								node = nextSiblingOrAncestorSibling(root, element);
								continue;
							}

							// Walk shadow roots.
							var shadowRoot = element.__CE_shadowRoot;
							if (shadowRoot) {
								for (var _child = shadowRoot.firstChild; _child; _child = _child.nextSibling) {
									walkDeepDescendantElements(_child, callback, visitedImports);
								}
							}
						}

						node = nextNode(root, node);
					}
				}

				/**
				 * Used to suppress Closure's "Modifying the prototype is only allowed if the
				 * constructor is in the same scope" warning without using
				 * `@suppress {newCheckTypes, duplicate}` because `newCheckTypes` is too broad.
				 *
				 * @param {!Object} destination
				 * @param {string} name
				 * @param {*} value
				 */
				function setPropertyUnchecked(destination, name, value) {
					destination[name] = value;
				}

				/***/ },
			/* 39 */
			/***/ function(module, exports) {

				"use strict";

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				/**
				 * @enum {number}
				 */
				var CustomElementState = {
					custom: 1,
					failed: 2
				};

				exports.default = CustomElementState;

				/***/ },
			/* 40 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _DocumentConstructionObserver = __webpack_require__(41);

				var _DocumentConstructionObserver2 = _interopRequireDefault(_DocumentConstructionObserver);

				var _Deferred = __webpack_require__(42);

				var _Deferred2 = _interopRequireDefault(_Deferred);

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				/**
				 * @unrestricted
				 */
				var CustomElementRegistry = function () {

					/**
					 * @param {!CustomElementInternals} internals
					 */
					function CustomElementRegistry(internals) {
						_classCallCheck(this, CustomElementRegistry);

						/**
						 * @private
						 * @type {boolean}
						 */
						this._elementDefinitionIsRunning = false;

						/**
						 * @private
						 * @type {!CustomElementInternals}
						 */
						this._internals = internals;

						/**
						 * @private
						 * @type {!Map<string, !Deferred<undefined>>}
						 */
						this._whenDefinedDeferred = new Map();

						/**
						 * The default flush callback triggers the document walk synchronously.
						 * @private
						 * @type {!Function}
						 */
						this._flushCallback = function (fn) {
							return fn();
						};

						/**
						 * @private
						 * @type {boolean}
						 */
						this._flushPending = false;

						/**
						 * @private
						 * @type {!Array<string>}
						 */
						this._unflushedLocalNames = [];

						/**
						 * @private
						 * @type {!DocumentConstructionObserver}
						 */
						this._documentConstructionObserver = new _DocumentConstructionObserver2.default(internals, document);
					}

					/**
					 * @param {string} localName
					 * @param {!Function} constructor
					 */


					_createClass(CustomElementRegistry, [{
						key: 'define',
						value: function define(localName, constructor) {
							var _this = this;

							if (!(constructor instanceof Function)) {
								throw new TypeError('Custom element constructors must be functions.');
							}

							if (!Utilities.isValidCustomElementName(localName)) {
								throw new SyntaxError('The element name \'' + localName + '\' is not valid.');
							}

							if (this._internals.localNameToDefinition(localName)) {
								throw new Error('A custom element with name \'' + localName + '\' has already been defined.');
							}

							if (this._elementDefinitionIsRunning) {
								throw new Error('A custom element is already being defined.');
							}
							this._elementDefinitionIsRunning = true;

							var connectedCallback = void 0;
							var disconnectedCallback = void 0;
							var adoptedCallback = void 0;
							var attributeChangedCallback = void 0;
							var observedAttributes = void 0;
							try {
								(function () {
									var getCallback = function getCallback(name) {
										var callbackValue = prototype[name];
										if (callbackValue !== undefined && !(callbackValue instanceof Function)) {
											throw new Error('The \'' + name + '\' callback must be a function.');
										}
										return callbackValue;
									};

									/** @type {!Object} */
									var prototype = constructor.prototype;
									if (!(prototype instanceof Object)) {
										throw new TypeError('The custom element constructor\'s prototype is not an object.');
									}

									connectedCallback = getCallback('connectedCallback');
									disconnectedCallback = getCallback('disconnectedCallback');
									adoptedCallback = getCallback('adoptedCallback');
									attributeChangedCallback = getCallback('attributeChangedCallback');
									observedAttributes = constructor['observedAttributes'] || [];
								})();
							} catch (e) {
								return;
							} finally {
								this._elementDefinitionIsRunning = false;
							}

							var definition = {
								localName: localName,
								constructor: constructor,
								connectedCallback: connectedCallback,
								disconnectedCallback: disconnectedCallback,
								adoptedCallback: adoptedCallback,
								attributeChangedCallback: attributeChangedCallback,
								observedAttributes: observedAttributes,
								constructionStack: []
							};

							this._internals.setDefinition(localName, definition);

							this._unflushedLocalNames.push(localName);

							// If we've already called the flush callback and it hasn't called back yet,
							// don't call it again.
							if (!this._flushPending) {
								this._flushPending = true;
								this._flushCallback(function () {
									return _this._flush();
								});
							}
						}
					}, {
						key: '_flush',
						value: function _flush() {
							// If no new definitions were defined, don't attempt to flush. This could
							// happen if a flush callback keeps the function it is given and calls it
							// multiple times.
							if (this._flushPending === false) return;

							this._flushPending = false;
							this._internals.patchAndUpgradeTree(document);

							while (this._unflushedLocalNames.length > 0) {
								var localName = this._unflushedLocalNames.shift();
								var deferred = this._whenDefinedDeferred.get(localName);
								if (deferred) {
									deferred.resolve(undefined);
								}
							}
						}

						/**
						 * @param {string} localName
						 * @return {Function|undefined}
						 */

					}, {
						key: 'get',
						value: function get(localName) {
							var definition = this._internals.localNameToDefinition(localName);
							if (definition) {
								return definition.constructor;
							}

							return undefined;
						}

						/**
						 * @param {string} localName
						 * @return {!Promise<undefined>}
						 */

					}, {
						key: 'whenDefined',
						value: function whenDefined(localName) {
							if (!Utilities.isValidCustomElementName(localName)) {
								return Promise.reject(new SyntaxError('\'' + localName + '\' is not a valid custom element name.'));
							}

							var prior = this._whenDefinedDeferred.get(localName);
							if (prior) {
								return prior.toPromise();
							}

							var deferred = new _Deferred2.default();
							this._whenDefinedDeferred.set(localName, deferred);

							var definition = this._internals.localNameToDefinition(localName);
							// Resolve immediately only if the given local name has a definition *and*
							// the full document walk to upgrade elements with that local name has
							// already happened.
							if (definition && this._unflushedLocalNames.indexOf(localName) === -1) {
								deferred.resolve(undefined);
							}

							return deferred.toPromise();
						}
					}, {
						key: 'polyfillWrapFlushCallback',
						value: function polyfillWrapFlushCallback(outer) {
							this._documentConstructionObserver.disconnect();
							var inner = this._flushCallback;
							this._flushCallback = function (flush) {
								return outer(function () {
									return inner(flush);
								});
							};
						}
					}]);

					return CustomElementRegistry;
				}();

				// Closure compiler exports.


				exports.default = CustomElementRegistry;
				window['CustomElementRegistry'] = CustomElementRegistry;
				CustomElementRegistry.prototype['define'] = CustomElementRegistry.prototype.define;
				CustomElementRegistry.prototype['get'] = CustomElementRegistry.prototype.get;
				CustomElementRegistry.prototype['whenDefined'] = CustomElementRegistry.prototype.whenDefined;
				CustomElementRegistry.prototype['polyfillWrapFlushCallback'] = CustomElementRegistry.prototype.polyfillWrapFlushCallback;

				/***/ },
			/* 41 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var DocumentConstructionObserver = function () {
					function DocumentConstructionObserver(internals, doc) {
						_classCallCheck(this, DocumentConstructionObserver);

						/**
						 * @type {!CustomElementInternals}
						 */
						this._internals = internals;

						/**
						 * @type {!Document}
						 */
						this._document = doc;

						/**
						 * @type {MutationObserver|undefined}
						 */
						this._observer = undefined;

						// Simulate tree construction for all currently accessible nodes in the
						// document.
						this._internals.patchAndUpgradeTree(this._document);

						if (this._document.readyState === 'loading') {
							this._observer = new MutationObserver(this._handleMutations.bind(this));

							// Nodes created by the parser are given to the observer *before* the next
							// task runs. Inline scripts are run in a new task. This means that the
							// observer will be able to handle the newly parsed nodes before the inline
							// script is run.
							this._observer.observe(this._document, {
								childList: true,
								subtree: true
							});
						}
					}

					_createClass(DocumentConstructionObserver, [{
						key: 'disconnect',
						value: function disconnect() {
							if (this._observer) {
								this._observer.disconnect();
							}
						}

						/**
						 * @param {!Array<!MutationRecord>} mutations
						 */

					}, {
						key: '_handleMutations',
						value: function _handleMutations(mutations) {
							// Once the document's `readyState` is 'interactive' or 'complete', all new
							// nodes created within that document will be the result of script and
							// should be handled by patching.
							var readyState = this._document.readyState;
							if (readyState === 'interactive' || readyState === 'complete') {
								this.disconnect();
							}

							for (var i = 0; i < mutations.length; i++) {
								var addedNodes = mutations[i].addedNodes;
								for (var j = 0; j < addedNodes.length; j++) {
									var node = addedNodes[j];
									this._internals.patchAndUpgradeTree(node);
								}
							}
						}
					}]);

					return DocumentConstructionObserver;
				}();

				exports.default = DocumentConstructionObserver;

				/***/ },
			/* 42 */
			/***/ function(module, exports) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				/**
				 * @template T
				 */
				var Deferred = function () {
					function Deferred() {
						var _this = this;

						_classCallCheck(this, Deferred);

						/**
						 * @private
						 * @type {T|undefined}
						 */
						this._value = undefined;

						/**
						 * @private
						 * @type {Function|undefined}
						 */
						this._resolve = undefined;

						/**
						 * @private
						 * @type {!Promise<T>}
						 */
						this._promise = new Promise(function (resolve) {
							_this._resolve = resolve;

							if (_this._value) {
								resolve(_this._value);
							}
						});
					}

					/**
					 * @param {T} value
					 */


					_createClass(Deferred, [{
						key: 'resolve',
						value: function resolve(value) {
							if (this._value) {
								throw new Error('Already resolved.');
							}

							this._value = value;

							if (this._resolve) {
								this._resolve(value);
							}
						}

						/**
						 * @return {!Promise<T>}
						 */

					}, {
						key: 'toPromise',
						value: function toPromise() {
							return this._promise;
						}
					}]);

					return Deferred;
				}();

				exports.default = Deferred;

				/***/ },
			/* 43 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				exports.default = function (internals) {
					window['HTMLElement'] = function () {
						/**
						 * @type {function(new: HTMLElement): !HTMLElement}
						 */
						function HTMLElement() {
							// This should really be `new.target` but `new.target` can't be emulated
							// in ES5. Assuming the user keeps the default value of the constructor's
							// prototype's `constructor` property, this is equivalent.
							/** @type {!Function} */
							var constructor = this.constructor;

							var definition = internals.constructorToDefinition(constructor);
							if (!definition) {
								throw new Error('The custom element being constructed was not registered with `customElements`.');
							}

							var constructionStack = definition.constructionStack;

							if (constructionStack.length === 0) {
								var _element = _Native2.default.Document_createElement.call(document, definition.localName);
								Object.setPrototypeOf(_element, constructor.prototype);
								_element.__CE_state = _CustomElementState2.default.custom;
								_element.__CE_definition = definition;
								internals.patch(_element);
								return _element;
							}

							var lastIndex = constructionStack.length - 1;
							var element = constructionStack[lastIndex];
							if (element === _AlreadyConstructedMarker2.default) {
								throw new Error('The HTMLElement constructor was either called reentrantly for this constructor or called multiple times.');
							}
							constructionStack[lastIndex] = _AlreadyConstructedMarker2.default;

							Object.setPrototypeOf(element, constructor.prototype);
							internals.patch( /** @type {!HTMLElement} */element);

							return element;
						}

						HTMLElement.prototype = _Native2.default.HTMLElement.prototype;

						return HTMLElement;
					}();
				};

				var _Native = __webpack_require__(44);

				var _Native2 = _interopRequireDefault(_Native);

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _CustomElementState = __webpack_require__(39);

				var _CustomElementState2 = _interopRequireDefault(_CustomElementState);

				var _AlreadyConstructedMarker = __webpack_require__(45);

				var _AlreadyConstructedMarker2 = _interopRequireDefault(_AlreadyConstructedMarker);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				;

				/**
				 * @param {!CustomElementInternals} internals
				 */

				/***/ },
			/* 44 */
			/***/ function(module, exports) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.default = {
					Document_createElement: window.Document.prototype.createElement,
					Document_createElementNS: window.Document.prototype.createElementNS,
					Document_importNode: window.Document.prototype.importNode,
					Document_prepend: window.Document.prototype['prepend'],
					Document_append: window.Document.prototype['append'],
					Node_cloneNode: window.Node.prototype.cloneNode,
					Node_appendChild: window.Node.prototype.appendChild,
					Node_insertBefore: window.Node.prototype.insertBefore,
					Node_removeChild: window.Node.prototype.removeChild,
					Node_replaceChild: window.Node.prototype.replaceChild,
					Node_textContent: Object.getOwnPropertyDescriptor(window.Node.prototype, 'textContent'),
					Element_attachShadow: window.Element.prototype['attachShadow'],
					Element_innerHTML: Object.getOwnPropertyDescriptor(window.Element.prototype, 'innerHTML'),
					Element_getAttribute: window.Element.prototype.getAttribute,
					Element_setAttribute: window.Element.prototype.setAttribute,
					Element_removeAttribute: window.Element.prototype.removeAttribute,
					Element_getAttributeNS: window.Element.prototype.getAttributeNS,
					Element_setAttributeNS: window.Element.prototype.setAttributeNS,
					Element_removeAttributeNS: window.Element.prototype.removeAttributeNS,
					Element_insertAdjacentElement: window.Element.prototype['insertAdjacentElement'],
					Element_prepend: window.Element.prototype['prepend'],
					Element_append: window.Element.prototype['append'],
					Element_before: window.Element.prototype['before'],
					Element_after: window.Element.prototype['after'],
					Element_replaceWith: window.Element.prototype['replaceWith'],
					Element_remove: window.Element.prototype['remove'],
					HTMLElement: window.HTMLElement,
					HTMLElement_innerHTML: Object.getOwnPropertyDescriptor(window.HTMLElement.prototype, 'innerHTML'),
					HTMLElement_insertAdjacentElement: window.HTMLElement.prototype['insertAdjacentElement']
				};

				/***/ },
			/* 45 */
			/***/ function(module, exports) {

				"use strict";

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				/**
				 * This class exists only to work around Closure's lack of a way to describe
				 * singletons. It represents the 'already constructed marker' used in custom
				 * element construction stacks.
				 *
				 * https://html.spec.whatwg.org/#concept-already-constructed-marker
				 */
				var AlreadyConstructedMarker = function AlreadyConstructedMarker() {
					_classCallCheck(this, AlreadyConstructedMarker);
				};

				exports.default = new AlreadyConstructedMarker();

				/***/ },
			/* 46 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				exports.default = function (internals) {
					Utilities.setPropertyUnchecked(Document.prototype, 'createElement',
						/**
						 * @this {Document}
						 * @param {string} localName
						 * @return {!Element}
						 */
						function (localName) {
							// Only create custom elements if this document is associated with the registry.
							if (this.__CE_hasRegistry) {
								var definition = internals.localNameToDefinition(localName);
								if (definition) {
									return new definition.constructor();
								}
							}

							var result = /** @type {!Element} */
								_Native2.default.Document_createElement.call(this, localName);
							internals.patch(result);
							return result;
						});

					Utilities.setPropertyUnchecked(Document.prototype, 'importNode',
						/**
						 * @this {Document}
						 * @param {!Node} node
						 * @param {boolean=} deep
						 * @return {!Node}
						 */
						function (node, deep) {
							var clone = _Native2.default.Document_importNode.call(this, node, deep);
							// Only create custom elements if this document is associated with the registry.
							if (!this.__CE_hasRegistry) {
								internals.patchTree(clone);
							} else {
								internals.patchAndUpgradeTree(clone);
							}
							return clone;
						});

					var NS_HTML = "http://www.w3.org/1999/xhtml";

					Utilities.setPropertyUnchecked(Document.prototype, 'createElementNS',
						/**
						 * @this {Document}
						 * @param {?string} namespace
						 * @param {string} localName
						 * @return {!Element}
						 */
						function (namespace, localName) {
							// Only create custom elements if this document is associated with the registry.
							if (this.__CE_hasRegistry && (namespace === null || namespace === NS_HTML)) {
								var definition = internals.localNameToDefinition(localName);
								if (definition) {
									return new definition.constructor();
								}
							}

							var result = /** @type {!Element} */
								_Native2.default.Document_createElementNS.call(this, namespace, localName);
							internals.patch(result);
							return result;
						});

					(0, _ParentNode2.default)(internals, Document.prototype, {
						prepend: _Native2.default.Document_prepend,
						append: _Native2.default.Document_append
					});
				};

				var _Native = __webpack_require__(44);

				var _Native2 = _interopRequireDefault(_Native);

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				var _ParentNode = __webpack_require__(47);

				var _ParentNode2 = _interopRequireDefault(_ParentNode);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				;

				/**
				 * @param {!CustomElementInternals} internals
				 */

				/***/ },
			/* 47 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				exports.default = function (internals, destination, builtIn) {
					/**
					 * @param {...(!Node|string)} nodes
					 */
					destination['prepend'] = function () {
						for (var _len = arguments.length, nodes = Array(_len), _key = 0; _key < _len; _key++) {
							nodes[_key] = arguments[_key];
						}

						// TODO: Fix this for when one of `nodes` is a DocumentFragment!
						var connectedBefore = /** @type {!Array<!Node>} */nodes.filter(function (node) {
							// DocumentFragments are not connected and will not be added to the list.
							return node instanceof Node && Utilities.isConnected(node);
						});

						builtIn.prepend.apply(this, nodes);

						for (var i = 0; i < connectedBefore.length; i++) {
							internals.disconnectTree(connectedBefore[i]);
						}

						if (Utilities.isConnected(this)) {
							for (var _i = 0; _i < nodes.length; _i++) {
								var node = nodes[_i];
								if (node instanceof Element) {
									internals.connectTree(node);
								}
							}
						}
					};

					/**
					 * @param {...(!Node|string)} nodes
					 */
					destination['append'] = function () {
						for (var _len2 = arguments.length, nodes = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
							nodes[_key2] = arguments[_key2];
						}

						// TODO: Fix this for when one of `nodes` is a DocumentFragment!
						var connectedBefore = /** @type {!Array<!Node>} */nodes.filter(function (node) {
							// DocumentFragments are not connected and will not be added to the list.
							return node instanceof Node && Utilities.isConnected(node);
						});

						builtIn.append.apply(this, nodes);

						for (var i = 0; i < connectedBefore.length; i++) {
							internals.disconnectTree(connectedBefore[i]);
						}

						if (Utilities.isConnected(this)) {
							for (var _i2 = 0; _i2 < nodes.length; _i2++) {
								var node = nodes[_i2];
								if (node instanceof Element) {
									internals.connectTree(node);
								}
							}
						}
					};
				};

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				/**
				 * @typedef {{
	 *   prepend: !function(...(!Node|string)),
	  *  append: !function(...(!Node|string)),
	 * }}
				 */
				var ParentNodeNativeMethods = void 0;

				/**
				 * @param {!CustomElementInternals} internals
				 * @param {!Object} destination
				 * @param {!ParentNodeNativeMethods} builtIn
				 */
				;

				/***/ },
			/* 48 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				exports.default = function (internals) {
					// `Node#nodeValue` is implemented on `Attr`.
					// `Node#textContent` is implemented on `Attr`, `Element`.

					Utilities.setPropertyUnchecked(Node.prototype, 'insertBefore',
						/**
						 * @this {Node}
						 * @param {!Node} node
						 * @param {?Node} refNode
						 * @return {!Node}
						 */
						function (node, refNode) {
							if (node instanceof DocumentFragment) {
								var insertedNodes = Array.prototype.slice.apply(node.childNodes);
								var _nativeResult = _Native2.default.Node_insertBefore.call(this, node, refNode);

								// DocumentFragments can't be connected, so `disconnectTree` will never
								// need to be called on a DocumentFragment's children after inserting it.

								if (Utilities.isConnected(this)) {
									for (var i = 0; i < insertedNodes.length; i++) {
										internals.connectTree(insertedNodes[i]);
									}
								}

								return _nativeResult;
							}

							var nodeWasConnected = Utilities.isConnected(node);
							var nativeResult = _Native2.default.Node_insertBefore.call(this, node, refNode);

							if (nodeWasConnected) {
								internals.disconnectTree(node);
							}

							if (Utilities.isConnected(this)) {
								internals.connectTree(node);
							}

							return nativeResult;
						});

					Utilities.setPropertyUnchecked(Node.prototype, 'appendChild',
						/**
						 * @this {Node}
						 * @param {!Node} node
						 * @return {!Node}
						 */
						function (node) {
							if (node instanceof DocumentFragment) {
								var insertedNodes = Array.prototype.slice.apply(node.childNodes);
								var _nativeResult2 = _Native2.default.Node_appendChild.call(this, node);

								// DocumentFragments can't be connected, so `disconnectTree` will never
								// need to be called on a DocumentFragment's children after inserting it.

								if (Utilities.isConnected(this)) {
									for (var i = 0; i < insertedNodes.length; i++) {
										internals.connectTree(insertedNodes[i]);
									}
								}

								return _nativeResult2;
							}

							var nodeWasConnected = Utilities.isConnected(node);
							var nativeResult = _Native2.default.Node_appendChild.call(this, node);

							if (nodeWasConnected) {
								internals.disconnectTree(node);
							}

							if (Utilities.isConnected(this)) {
								internals.connectTree(node);
							}

							return nativeResult;
						});

					Utilities.setPropertyUnchecked(Node.prototype, 'cloneNode',
						/**
						 * @this {Node}
						 * @param {boolean=} deep
						 * @return {!Node}
						 */
						function (deep) {
							var clone = _Native2.default.Node_cloneNode.call(this, deep);
							// Only create custom elements if this element's owner document is
							// associated with the registry.
							if (!this.ownerDocument.__CE_hasRegistry) {
								internals.patchTree(clone);
							} else {
								internals.patchAndUpgradeTree(clone);
							}
							return clone;
						});

					Utilities.setPropertyUnchecked(Node.prototype, 'removeChild',
						/**
						 * @this {Node}
						 * @param {!Node} node
						 * @return {!Node}
						 */
						function (node) {
							var nodeWasConnected = Utilities.isConnected(node);
							var nativeResult = _Native2.default.Node_removeChild.call(this, node);

							if (nodeWasConnected) {
								internals.disconnectTree(node);
							}

							return nativeResult;
						});

					Utilities.setPropertyUnchecked(Node.prototype, 'replaceChild',
						/**
						 * @this {Node}
						 * @param {!Node} nodeToInsert
						 * @param {!Node} nodeToRemove
						 * @return {!Node}
						 */
						function (nodeToInsert, nodeToRemove) {
							if (nodeToInsert instanceof DocumentFragment) {
								var insertedNodes = Array.prototype.slice.apply(nodeToInsert.childNodes);
								var _nativeResult3 = _Native2.default.Node_replaceChild.call(this, nodeToInsert, nodeToRemove);

								// DocumentFragments can't be connected, so `disconnectTree` will never
								// need to be called on a DocumentFragment's children after inserting it.

								if (Utilities.isConnected(this)) {
									internals.disconnectTree(nodeToRemove);
									for (var i = 0; i < insertedNodes.length; i++) {
										internals.connectTree(insertedNodes[i]);
									}
								}

								return _nativeResult3;
							}

							var nodeToInsertWasConnected = Utilities.isConnected(nodeToInsert);
							var nativeResult = _Native2.default.Node_replaceChild.call(this, nodeToInsert, nodeToRemove);
							var thisIsConnected = Utilities.isConnected(this);

							if (thisIsConnected) {
								internals.disconnectTree(nodeToRemove);
							}

							if (nodeToInsertWasConnected) {
								internals.disconnectTree(nodeToInsert);
							}

							if (thisIsConnected) {
								internals.connectTree(nodeToInsert);
							}

							return nativeResult;
						});

					function patch_textContent(destination, baseDescriptor) {
						Object.defineProperty(destination, 'textContent', {
							enumerable: baseDescriptor.enumerable,
							configurable: true,
							get: baseDescriptor.get,
							set: /** @this {Node} */function set(assignedValue) {
								// If this is a text node then there are no nodes to disconnect.
								if (this.nodeType === Node.TEXT_NODE) {
									baseDescriptor.set.call(this, assignedValue);
									return;
								}

								var removedNodes = undefined;
								// Checking for `firstChild` is faster than reading `childNodes.length`
								// to compare with 0.
								if (this.firstChild) {
									// Using `childNodes` is faster than `children`, even though we only
									// care about elements.
									var childNodes = this.childNodes;
									var childNodesLength = childNodes.length;
									if (childNodesLength > 0 && Utilities.isConnected(this)) {
										// Copying an array by iterating is faster than using slice.
										removedNodes = new Array(childNodesLength);
										for (var i = 0; i < childNodesLength; i++) {
											removedNodes[i] = childNodes[i];
										}
									}
								}

								baseDescriptor.set.call(this, assignedValue);

								if (removedNodes) {
									for (var _i = 0; _i < removedNodes.length; _i++) {
										internals.disconnectTree(removedNodes[_i]);
									}
								}
							}
						});
					}

					if (_Native2.default.Node_textContent && _Native2.default.Node_textContent.get) {
						patch_textContent(Node.prototype, _Native2.default.Node_textContent);
					} else {
						internals.addPatch(function (element) {
							patch_textContent(element, {
								enumerable: true,
								configurable: true,
								// NOTE: This implementation of the `textContent` getter assumes that
								// text nodes' `textContent` getter will not be patched.
								get: /** @this {Node} */function get() {
									/** @type {!Array<string>} */
									var parts = [];

									for (var i = 0; i < this.childNodes.length; i++) {
										parts.push(this.childNodes[i].textContent);
									}

									return parts.join('');
								},
								set: /** @this {Node} */function set(assignedValue) {
									while (this.firstChild) {
										_Native2.default.Node_removeChild.call(this, this.firstChild);
									}
									_Native2.default.Node_appendChild.call(this, document.createTextNode(assignedValue));
								}
							});
						});
					}
				};

				var _Native = __webpack_require__(44);

				var _Native2 = _interopRequireDefault(_Native);

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				;

				/**
				 * @param {!CustomElementInternals} internals
				 */

				/***/ },
			/* 49 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				exports.default = function (internals) {
					if (_Native2.default.Element_attachShadow) {
						Utilities.setPropertyUnchecked(Element.prototype, 'attachShadow',
							/**
							 * @this {Element}
							 * @param {!{mode: string}} init
							 * @return {ShadowRoot}
							 */
							function (init) {
								var shadowRoot = _Native2.default.Element_attachShadow.call(this, init);
								this.__CE_shadowRoot = shadowRoot;
								return shadowRoot;
							});
					} else {
						console.warn('Custom Elements: `Element#attachShadow` was not patched.');
					}

					function patch_innerHTML(destination, baseDescriptor) {
						Object.defineProperty(destination, 'innerHTML', {
							enumerable: baseDescriptor.enumerable,
							configurable: true,
							get: baseDescriptor.get,
							set: /** @this {Element} */function set(htmlString) {
								var _this = this;

								var isConnected = Utilities.isConnected(this);

								// NOTE: In IE11, when using the native `innerHTML` setter, all nodes
								// that were previously descendants of the context element have all of
								// their children removed as part of the set - the entire subtree is
								// 'disassembled'. This work around walks the subtree *before* using the
								// native setter.
								/** @type {!Array<!Element>|undefined} */
								var removedElements = undefined;
								if (isConnected) {
									removedElements = [];
									Utilities.walkDeepDescendantElements(this, function (element) {
										if (element !== _this) {
											removedElements.push(element);
										}
									});
								}

								baseDescriptor.set.call(this, htmlString);

								if (removedElements) {
									for (var i = 0; i < removedElements.length; i++) {
										var element = removedElements[i];
										if (element.__CE_state === _CustomElementState2.default.custom) {
											internals.disconnectedCallback(element);
										}
									}
								}

								// Only create custom elements if this element's owner document is
								// associated with the registry.
								if (!this.ownerDocument.__CE_hasRegistry) {
									internals.patchTree(this);
								} else {
									internals.patchAndUpgradeTree(this);
								}
								return htmlString;
							}
						});
					}

					if (_Native2.default.Element_innerHTML && _Native2.default.Element_innerHTML.get) {
						patch_innerHTML(Element.prototype, _Native2.default.Element_innerHTML);
					} else if (_Native2.default.HTMLElement_innerHTML && _Native2.default.HTMLElement_innerHTML.get) {
						patch_innerHTML(HTMLElement.prototype, _Native2.default.HTMLElement_innerHTML);
					} else {
						(function () {

							/** @type {HTMLDivElement} */
							var rawDiv = _Native2.default.Document_createElement.call(document, 'div');

							internals.addPatch(function (element) {
								patch_innerHTML(element, {
									enumerable: true,
									configurable: true,
									// Implements getting `innerHTML` by performing an unpatched `cloneNode`
									// of the element and returning the resulting element's `innerHTML`.
									// TODO: Is this too expensive?
									get: /** @this {Element} */function get() {
										return _Native2.default.Node_cloneNode.call(this, true).innerHTML;
									},
									// Implements setting `innerHTML` by creating an unpatched element,
									// setting `innerHTML` of that element and replacing the target
									// element's children with those of the unpatched element.
									set: /** @this {Element} */function set(assignedValue) {
										// NOTE: re-route to `content` for `template` elements.
										// We need to do this because `template.appendChild` does not
										// route into `template.content`.
										/** @type {!Node} */
										var content = this.localName === 'template' ? /** @type {!HTMLTemplateElement} */this.content : this;
										rawDiv.innerHTML = assignedValue;

										while (content.childNodes.length > 0) {
											_Native2.default.Node_removeChild.call(content, content.childNodes[0]);
										}
										while (rawDiv.childNodes.length > 0) {
											_Native2.default.Node_appendChild.call(content, rawDiv.childNodes[0]);
										}
									}
								});
							});
						})();
					}

					Utilities.setPropertyUnchecked(Element.prototype, 'setAttribute',
						/**
						 * @this {Element}
						 * @param {string} name
						 * @param {string} newValue
						 */
						function (name, newValue) {
							// Fast path for non-custom elements.
							if (this.__CE_state !== _CustomElementState2.default.custom) {
								return _Native2.default.Element_setAttribute.call(this, name, newValue);
							}

							var oldValue = _Native2.default.Element_getAttribute.call(this, name);
							_Native2.default.Element_setAttribute.call(this, name, newValue);
							newValue = _Native2.default.Element_getAttribute.call(this, name);
							if (oldValue !== newValue) {
								internals.attributeChangedCallback(this, name, oldValue, newValue, null);
							}
						});

					Utilities.setPropertyUnchecked(Element.prototype, 'setAttributeNS',
						/**
						 * @this {Element}
						 * @param {?string} namespace
						 * @param {string} name
						 * @param {string} newValue
						 */
						function (namespace, name, newValue) {
							// Fast path for non-custom elements.
							if (this.__CE_state !== _CustomElementState2.default.custom) {
								return _Native2.default.Element_setAttributeNS.call(this, namespace, name, newValue);
							}

							var oldValue = _Native2.default.Element_getAttributeNS.call(this, namespace, name);
							_Native2.default.Element_setAttributeNS.call(this, namespace, name, newValue);
							newValue = _Native2.default.Element_getAttributeNS.call(this, namespace, name);
							if (oldValue !== newValue) {
								internals.attributeChangedCallback(this, name, oldValue, newValue, namespace);
							}
						});

					Utilities.setPropertyUnchecked(Element.prototype, 'removeAttribute',
						/**
						 * @this {Element}
						 * @param {string} name
						 */
						function (name) {
							// Fast path for non-custom elements.
							if (this.__CE_state !== _CustomElementState2.default.custom) {
								return _Native2.default.Element_removeAttribute.call(this, name);
							}

							var oldValue = _Native2.default.Element_getAttribute.call(this, name);
							_Native2.default.Element_removeAttribute.call(this, name);
							if (oldValue !== null) {
								internals.attributeChangedCallback(this, name, oldValue, null, null);
							}
						});

					Utilities.setPropertyUnchecked(Element.prototype, 'removeAttributeNS',
						/**
						 * @this {Element}
						 * @param {?string} namespace
						 * @param {string} name
						 */
						function (namespace, name) {
							// Fast path for non-custom elements.
							if (this.__CE_state !== _CustomElementState2.default.custom) {
								return _Native2.default.Element_removeAttributeNS.call(this, namespace, name);
							}

							var oldValue = _Native2.default.Element_getAttributeNS.call(this, namespace, name);
							_Native2.default.Element_removeAttributeNS.call(this, namespace, name);
							// In older browsers, `Element#getAttributeNS` may return the empty string
							// instead of null if the attribute does not exist. For details, see;
							// https://developer.mozilla.org/en-US/docs/Web/API/Element/getAttributeNS#Notes
							var newValue = _Native2.default.Element_getAttributeNS.call(this, namespace, name);
							if (oldValue !== newValue) {
								internals.attributeChangedCallback(this, name, oldValue, newValue, namespace);
							}
						});

					function patch_insertAdjacentElement(destination, baseMethod) {
						Utilities.setPropertyUnchecked(destination, 'insertAdjacentElement',
							/**
							 * @this {Element}
							 * @param {string} where
							 * @param {!Element} element
							 * @return {?Element}
							 */
							function (where, element) {
								var wasConnected = Utilities.isConnected(element);
								var insertedElement = /** @type {!Element} */
									baseMethod.call(this, where, element);

								if (wasConnected) {
									internals.disconnectTree(element);
								}

								if (Utilities.isConnected(insertedElement)) {
									internals.connectTree(element);
								}
								return insertedElement;
							});
					}

					if (_Native2.default.HTMLElement_insertAdjacentElement) {
						patch_insertAdjacentElement(HTMLElement.prototype, _Native2.default.HTMLElement_insertAdjacentElement);
					} else if (_Native2.default.Element_insertAdjacentElement) {
						patch_insertAdjacentElement(Element.prototype, _Native2.default.Element_insertAdjacentElement);
					} else {
						console.warn('Custom Elements: `Element#insertAdjacentElement` was not patched.');
					}

					(0, _ParentNode2.default)(internals, Element.prototype, {
						prepend: _Native2.default.Element_prepend,
						append: _Native2.default.Element_append
					});

					(0, _ChildNode2.default)(internals, Element.prototype, {
						before: _Native2.default.Element_before,
						after: _Native2.default.Element_after,
						replaceWith: _Native2.default.Element_replaceWith,
						remove: _Native2.default.Element_remove
					});
				};

				var _Native = __webpack_require__(44);

				var _Native2 = _interopRequireDefault(_Native);

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _CustomElementState = __webpack_require__(39);

				var _CustomElementState2 = _interopRequireDefault(_CustomElementState);

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				var _ParentNode = __webpack_require__(47);

				var _ParentNode2 = _interopRequireDefault(_ParentNode);

				var _ChildNode = __webpack_require__(50);

				var _ChildNode2 = _interopRequireDefault(_ChildNode);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				;

				/**
				 * @param {!CustomElementInternals} internals
				 */

				/***/ },
			/* 50 */
			/***/ function(module, exports, __webpack_require__) {

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				exports.default = function (internals, destination, builtIn) {
					/**
					 * @param {...(!Node|string)} nodes
					 */
					destination['before'] = function () {
						for (var _len = arguments.length, nodes = Array(_len), _key = 0; _key < _len; _key++) {
							nodes[_key] = arguments[_key];
						}

						// TODO: Fix this for when one of `nodes` is a DocumentFragment!
						var connectedBefore = /** @type {!Array<!Node>} */nodes.filter(function (node) {
							// DocumentFragments are not connected and will not be added to the list.
							return node instanceof Node && Utilities.isConnected(node);
						});

						builtIn.before.apply(this, nodes);

						for (var i = 0; i < connectedBefore.length; i++) {
							internals.disconnectTree(connectedBefore[i]);
						}

						if (Utilities.isConnected(this)) {
							for (var _i = 0; _i < nodes.length; _i++) {
								var node = nodes[_i];
								if (node instanceof Element) {
									internals.connectTree(node);
								}
							}
						}
					};

					/**
					 * @param {...(!Node|string)} nodes
					 */
					destination['after'] = function () {
						for (var _len2 = arguments.length, nodes = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
							nodes[_key2] = arguments[_key2];
						}

						// TODO: Fix this for when one of `nodes` is a DocumentFragment!
						var connectedBefore = /** @type {!Array<!Node>} */nodes.filter(function (node) {
							// DocumentFragments are not connected and will not be added to the list.
							return node instanceof Node && Utilities.isConnected(node);
						});

						builtIn.after.apply(this, nodes);

						for (var i = 0; i < connectedBefore.length; i++) {
							internals.disconnectTree(connectedBefore[i]);
						}

						if (Utilities.isConnected(this)) {
							for (var _i2 = 0; _i2 < nodes.length; _i2++) {
								var node = nodes[_i2];
								if (node instanceof Element) {
									internals.connectTree(node);
								}
							}
						}
					};

					/**
					 * @param {...(!Node|string)} nodes
					 */
					destination['replaceWith'] = function () {
						for (var _len3 = arguments.length, nodes = Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
							nodes[_key3] = arguments[_key3];
						}

						// TODO: Fix this for when one of `nodes` is a DocumentFragment!
						var connectedBefore = /** @type {!Array<!Node>} */nodes.filter(function (node) {
							// DocumentFragments are not connected and will not be added to the list.
							return node instanceof Node && Utilities.isConnected(node);
						});

						var wasConnected = Utilities.isConnected(this);

						builtIn.replaceWith.apply(this, nodes);

						for (var i = 0; i < connectedBefore.length; i++) {
							internals.disconnectTree(connectedBefore[i]);
						}

						if (wasConnected) {
							internals.disconnectTree(this);
							for (var _i3 = 0; _i3 < nodes.length; _i3++) {
								var node = nodes[_i3];
								if (node instanceof Element) {
									internals.connectTree(node);
								}
							}
						}
					};

					destination['remove'] = function () {
						var wasConnected = Utilities.isConnected(this);

						builtIn.remove.call(this);

						if (wasConnected) {
							internals.disconnectTree(this);
						}
					};
				};

				var _CustomElementInternals = __webpack_require__(37);

				var _CustomElementInternals2 = _interopRequireDefault(_CustomElementInternals);

				var _Utilities = __webpack_require__(38);

				var Utilities = _interopRequireWildcard(_Utilities);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				/**
				 * @typedef {{
	 *   before: !function(...(!Node|string)),
	 *   after: !function(...(!Node|string)),
	 *   replaceWith: !function(...(!Node|string)),
	 *   remove: !function(),
	 * }}
				 */
				var ChildNodeNativeMethods = void 0;

				/**
				 * @param {!CustomElementInternals} internals
				 * @param {!Object} destination
				 * @param {!ChildNodeNativeMethods} builtIn
				 */
				;

				/***/ },
			/* 51 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				/**
				 * Patches elements that interacts with ShadyDOM
				 * such that tree traversal and mutation apis act like they would under
				 * ShadowDOM.
				 *
				 * This import enables seemless interaction with ShadyDOM powered
				 * custom elements, enabling better interoperation with 3rd party code,
				 * libraries, and frameworks that use DOM tree manipulation apis.
				 */

				'use strict';

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				var _flush = __webpack_require__(53);

				var _observeChanges = __webpack_require__(54);

				var _nativeMethods = __webpack_require__(55);

				var nativeMethods = _interopRequireWildcard(_nativeMethods);

				var _nativeTree = __webpack_require__(56);

				var nativeTree = _interopRequireWildcard(_nativeTree);

				var _patchBuiltins = __webpack_require__(58);

				var _patchEvents = __webpack_require__(63);

				var _attachShadow = __webpack_require__(64);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				if (utils.settings.inUse) {

					window.ShadyDOM = {
						// TODO(sorvell): remove when Polymer does not depend on this.
						inUse: utils.settings.inUse,
						// TODO(sorvell): remove when Polymer does not depend on this.
						patch: function patch(node) {
							return node;
						},
						isShadyRoot: utils.isShadyRoot,
						enqueue: _flush.enqueue,
						flush: _flush.flush,
						settings: utils.settings,
						filterMutations: _observeChanges.filterMutations,
						observeChildren: _observeChanges.observeChildren,
						unobserveChildren: _observeChanges.unobserveChildren,
						nativeMethods: nativeMethods,
						nativeTree: nativeTree
					};

					// Apply patches to events...
					(0, _patchEvents.patchEvents)();
					// Apply patches to builtins (e.g. Element.prototype) where applicable.
					(0, _patchBuiltins.patchBuiltins)();

					window.ShadowRoot = _attachShadow.ShadyRoot;
				}

				/***/ },
			/* 52 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.isShadyRoot = isShadyRoot;
				exports.ownerShadyRootForNode = ownerShadyRootForNode;
				exports.matchesSelector = matchesSelector;
				exports.extend = extend;
				exports.extendAll = extendAll;
				exports.mixin = mixin;
				exports.patchPrototype = patchPrototype;
				exports.microtask = microtask;
				var settings = exports.settings = window.ShadyDOM || {};

				settings.hasNativeShadowDOM = Boolean(Element.prototype.attachShadow && Node.prototype.getRootNode);

				var desc = Object.getOwnPropertyDescriptor(Node.prototype, 'firstChild');

				settings.hasDescriptors = Boolean(desc && desc.configurable && desc.get);
				settings.inUse = settings.force || !settings.hasNativeShadowDOM;

				function isShadyRoot(obj) {
					return Boolean(obj.__localName === 'ShadyRoot');
				}

				function ownerShadyRootForNode(node) {
					var root = node.getRootNode();
					if (isShadyRoot(root)) {
						return root;
					}
				}

				var p = Element.prototype;
				var matches = p.matches || p.matchesSelector || p.mozMatchesSelector || p.msMatchesSelector || p.oMatchesSelector || p.webkitMatchesSelector;

				function matchesSelector(element, selector) {
					return matches.call(element, selector);
				}

				function copyOwnProperty(name, source, target) {
					var pd = Object.getOwnPropertyDescriptor(source, name);
					if (pd) {
						Object.defineProperty(target, name, pd);
					}
				}

				function extend(target, source) {
					if (target && source) {
						var n$ = Object.getOwnPropertyNames(source);
						for (var i = 0, n; i < n$.length && (n = n$[i]); i++) {
							copyOwnProperty(n, source, target);
						}
					}
					return target || source;
				}

				function extendAll(target) {
					for (var _len = arguments.length, sources = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
						sources[_key - 1] = arguments[_key];
					}

					for (var i = 0; i < sources.length; i++) {
						extend(target, sources[i]);
					}
					return target;
				}

				function mixin(target, source) {
					for (var i in source) {
						target[i] = source[i];
					}
					return target;
				}

				function patchPrototype(obj, mixin) {
					var proto = Object.getPrototypeOf(obj);
					if (!proto.hasOwnProperty('__patchProto')) {
						var patchProto = Object.create(proto);
						patchProto.__sourceProto = proto;
						extend(patchProto, mixin);
						proto.__patchProto = patchProto;
					}
					// old browsers don't have setPrototypeOf
					obj.__proto__ = proto.__patchProto;
				}

				var twiddle = document.createTextNode('');
				var content = 0;
				var queue = [];
				new MutationObserver(function () {
					while (queue.length) {
						// catch errors in user code...
						try {
							queue.shift()();
						} catch (e) {
							// enqueue another record and throw
							twiddle.textContent = content++;
							throw e;
						}
					}
				}).observe(twiddle, { characterData: true });

				// use MutationObserver to get microtask async timing.
				function microtask(callback) {
					queue.push(callback);
					twiddle.textContent = content++;
				}

				/***/ },
			/* 53 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.enqueue = enqueue;
				exports.flush = flush;

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				// render enqueuer/flusher
				var flushList = [];
				var scheduled = void 0;
				function enqueue(callback) {
					if (!scheduled) {
						scheduled = true;
						utils.microtask(flush);
					}
					flushList.push(callback);
				}

				function flush() {
					scheduled = false;
					var didFlush = Boolean(flushList.length);
					while (flushList.length) {
						flushList.shift()();
					}
					return didFlush;
				}

				flush.list = flushList;

				/***/ },
			/* 54 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.unobserveChildren = exports.observeChildren = undefined;

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				exports.filterMutations = filterMutations;

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var AsyncObserver = function () {
					function AsyncObserver() {
						_classCallCheck(this, AsyncObserver);

						this._scheduled = false;
						this.addedNodes = [];
						this.removedNodes = [];
						this.callbacks = new Set();
					}

					_createClass(AsyncObserver, [{
						key: 'schedule',
						value: function schedule() {
							var _this = this;

							if (!this._scheduled) {
								this._scheduled = true;
								utils.microtask(function () {
									_this.flush();
								});
							}
						}
					}, {
						key: 'flush',
						value: function flush() {
							var _this2 = this;

							if (this._scheduled) {
								(function () {
									_this2._scheduled = false;
									var mutations = _this2.takeRecords();
									if (mutations.length) {
										_this2.callbacks.forEach(function (cb) {
											cb(mutations);
										});
									}
								})();
							}
						}
					}, {
						key: 'takeRecords',
						value: function takeRecords() {
							if (this.addedNodes.length || this.removedNodes.length) {
								var mutations = [{
									addedNodes: this.addedNodes,
									removedNodes: this.removedNodes
								}];
								this.addedNodes = [];
								this.removedNodes = [];
								return mutations;
							}
							return [];
						}
					}]);

					return AsyncObserver;
				}();

				// TODO(sorvell): consider instead polyfilling MutationObserver
				// directly so that users do not have to fork their code.
				// Supporting the entire api may be challenging: e.g. filtering out
				// removed nodes in the wrong scope and seeing non-distributing
				// subtree child mutations.


				var observeChildren = exports.observeChildren = function observeChildren(node, callback) {
					node.__shady = node.__shady || {};
					if (!node.__shady.observer) {
						node.__shady.observer = new AsyncObserver();
					}
					node.__shady.observer.callbacks.add(callback);
					var observer = node.__shady.observer;
					return {
						_callback: callback,
						_observer: observer,
						_node: node,
						takeRecords: function takeRecords() {
							return observer.takeRecords();
						}
					};
				};

				var unobserveChildren = exports.unobserveChildren = function unobserveChildren(handle) {
					var observer = handle && handle._observer;
					if (observer) {
						observer.callbacks.delete(handle._callback);
						if (!observer.callbacks.size) {
							handle._node.__shady.observer = null;
						}
					}
				};

				function filterMutations(mutations, target) {
					var targetRootNode = target.getRootNode();
					return mutations.map(function (mutation) {
						var mutationInScope = targetRootNode === mutation.target.getRootNode();
						if (mutationInScope && mutation.addedNodes) {
							var nodes = Array.from(mutation.addedNodes).filter(function (n) {
								return targetRootNode === n.getRootNode();
							});
							if (nodes.length) {
								mutation = Object.create(mutation);
								Object.defineProperty(mutation, 'addedNodes', {
									value: nodes,
									configurable: true
								});
								return mutation;
							}
						} else if (mutationInScope) {
							return mutation;
						}
					}).filter(function (m) {
						return m;
					});
				}

				/***/ },
			/* 55 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				var appendChild = exports.appendChild = Element.prototype.appendChild;
				var insertBefore = exports.insertBefore = Element.prototype.insertBefore;
				var removeChild = exports.removeChild = Element.prototype.removeChild;
				var setAttribute = exports.setAttribute = Element.prototype.setAttribute;
				var removeAttribute = exports.removeAttribute = Element.prototype.removeAttribute;
				var cloneNode = exports.cloneNode = Element.prototype.cloneNode;
				var importNode = exports.importNode = Document.prototype.importNode;
				var addEventListener = exports.addEventListener = Element.prototype.addEventListener;
				var removeEventListener = exports.removeEventListener = Element.prototype.removeEventListener;

				/***/ },
			/* 56 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.parentNode = parentNode;
				exports.firstChild = firstChild;
				exports.lastChild = lastChild;
				exports.previousSibling = previousSibling;
				exports.nextSibling = nextSibling;
				exports.childNodes = childNodes;
				exports.parentElement = parentElement;
				exports.firstElementChild = firstElementChild;
				exports.lastElementChild = lastElementChild;
				exports.previousElementSibling = previousElementSibling;
				exports.nextElementSibling = nextElementSibling;
				exports.children = children;
				exports.innerHTML = innerHTML;
				exports.textContent = textContent;

				var _innerHTML = __webpack_require__(57);

				var nodeWalker = document.createTreeWalker(document, NodeFilter.SHOW_ALL, null, false);

				var elementWalker = document.createTreeWalker(document, NodeFilter.SHOW_ELEMENT, null, false);

				function parentNode(node) {
					nodeWalker.currentNode = node;
					return nodeWalker.parentNode();
				}

				function firstChild(node) {
					nodeWalker.currentNode = node;
					return nodeWalker.firstChild();
				}

				function lastChild(node) {
					nodeWalker.currentNode = node;
					return nodeWalker.lastChild();
				}

				function previousSibling(node) {
					nodeWalker.currentNode = node;
					return nodeWalker.previousSibling();
				}

				function nextSibling(node) {
					nodeWalker.currentNode = node;
					return nodeWalker.nextSibling();
				}

				function childNodes(node) {
					var nodes = [];
					nodeWalker.currentNode = node;
					var n = nodeWalker.firstChild();
					while (n) {
						nodes.push(n);
						n = nodeWalker.nextSibling();
					}
					return nodes;
				}

				function parentElement(node) {
					elementWalker.currentNode = node;
					return elementWalker.parentNode();
				}

				function firstElementChild(node) {
					elementWalker.currentNode = node;
					return elementWalker.firstChild();
				}

				function lastElementChild(node) {
					elementWalker.currentNode = node;
					return elementWalker.lastChild();
				}

				function previousElementSibling(node) {
					elementWalker.currentNode = node;
					return elementWalker.previousSibling();
				}

				function nextElementSibling(node) {
					elementWalker.currentNode = node;
					return elementWalker.nextSibling();
				}

				function children(node) {
					var nodes = [];
					elementWalker.currentNode = node;
					var n = elementWalker.firstChild();
					while (n) {
						nodes.push(n);
						n = elementWalker.nextSibling();
					}
					return nodes;
				}

				function innerHTML(node) {
					return (0, _innerHTML.getInnerHTML)(node, function (n) {
						return childNodes(n);
					});
				}

				function textContent(node) {
					if (node.nodeType !== Node.ELEMENT_NODE) {
						return node.nodeValue;
					}
					var textWalker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, null, false);
					var content = '',
						n = void 0;
					while (n = textWalker.nextNode()) {
						// TODO(sorvell): can't use textContent since we patch it on Node.prototype!
						// However, should probably patch it only on element.
						content += n.nodeValue;
					}
					return content;
				}

				/***/ },
			/* 57 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				// Cribbed from ShadowDOM polyfill
				// https://github.com/webcomponents/webcomponentsjs/blob/master/src/ShadowDOM/wrappers/HTMLElement.js#L28
				/////////////////////////////////////////////////////////////////////////////
				// innerHTML and outerHTML

				// http://www.whatwg.org/specs/web-apps/current-work/multipage/the-end.html#escapingString

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.getOuterHTML = getOuterHTML;
				exports.getInnerHTML = getInnerHTML;
				var escapeAttrRegExp = /[&\u00A0"]/g;
				var escapeDataRegExp = /[&\u00A0<>]/g;

				function escapeReplace(c) {
					switch (c) {
						case '&':
							return '&amp;';
						case '<':
							return '&lt;';
						case '>':
							return '&gt;';
						case '"':
							return '&quot;';
						case '\xA0':
							return '&nbsp;';
					}
				}

				function escapeAttr(s) {
					return s.replace(escapeAttrRegExp, escapeReplace);
				}

				function escapeData(s) {
					return s.replace(escapeDataRegExp, escapeReplace);
				}

				function makeSet(arr) {
					var set = {};
					for (var i = 0; i < arr.length; i++) {
						set[arr[i]] = true;
					}
					return set;
				}

				// http://www.whatwg.org/specs/web-apps/current-work/#void-elements
				var voidElements = makeSet(['area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr']);

				var plaintextParents = makeSet(['style', 'script', 'xmp', 'iframe', 'noembed', 'noframes', 'plaintext', 'noscript']);

				function getOuterHTML(node, parentNode, composed) {
					switch (node.nodeType) {
						case Node.ELEMENT_NODE:
						{
							var tagName = node.localName;
							var s = '<' + tagName;
							var attrs = node.attributes;
							for (var i = 0, attr; attr = attrs[i]; i++) {
								s += ' ' + attr.name + '="' + escapeAttr(attr.value) + '"';
							}
							s += '>';
							if (voidElements[tagName]) {
								return s;
							}
							return s + getInnerHTML(node, composed) + '</' + tagName + '>';
						}
						case Node.TEXT_NODE:
						{
							var data = node.data;
							if (parentNode && plaintextParents[parentNode.localName]) {
								return data;
							}
							return escapeData(data);
						}
						case Node.COMMENT_NODE:
						{
							return '<!--' + node.data + '-->';
						}
						default:
						{
							window.console.error(node);
							throw new Error('not implemented');
						}
					}
				}

				function getInnerHTML(node, composed) {
					if (node.localName === 'template') {
						node = node.content;
					}
					var s = '';
					var c$ = composed ? composed(node) : node.childNodes;
					for (var i = 0, l = c$.length, child; i < l && (child = c$[i]); i++) {
						s += getOuterHTML(child, node, composed);
					}
					return s;
				}

				/***/ },
			/* 58 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.patchBuiltins = patchBuiltins;

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				var _logicalMutation = __webpack_require__(59);

				var mutation = _interopRequireWildcard(_logicalMutation);

				var _patchAccessors = __webpack_require__(62);

				var _logicalProperties = __webpack_require__(60);

				var _patchEvents = __webpack_require__(63);

				var _attachShadow2 = __webpack_require__(64);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function getAssignedSlot(node) {
					mutation.renderRootNode(node);
					return (0, _logicalProperties.getProperty)(node, 'assignedSlot') || null;
				}

				var nodeMixin = {

					addEventListener: _patchEvents.addEventListener,

					removeEventListener: _patchEvents.removeEventListener,

					appendChild: function appendChild(node) {
						return mutation.insertBefore(this, node);
					},
					insertBefore: function insertBefore(node, ref_node) {
						return mutation.insertBefore(this, node, ref_node);
					},
					removeChild: function removeChild(node) {
						return mutation.removeChild(this, node);
					},
					replaceChild: function replaceChild(node, ref_node) {
						this.insertBefore(node, ref_node);
						this.removeChild(ref_node);
						return node;
					},
					cloneNode: function cloneNode(deep) {
						return mutation.cloneNode(this, deep);
					},
					getRootNode: function getRootNode(options) {
						return mutation.getRootNode(this, options);
					},


					get isConnected() {
						// Fast path for distributed nodes.
						var ownerDocument = this.ownerDocument;
						if (ownerDocument && ownerDocument.contains && ownerDocument.contains(this)) return true;
						var ownerDocumentElement = ownerDocument.documentElement;
						if (ownerDocumentElement && ownerDocumentElement.contains && ownerDocumentElement.contains(this)) return true;

						var node = this;
						while (node && !(node instanceof Document)) {
							node = node.parentNode || (node instanceof _attachShadow2.ShadyRoot ? node.host : undefined);
						}
						return !!(node && node instanceof Document);
					}

				};

				// NOTE: For some reason `Text` redefines `assignedSlot`
				var textMixin = {
					get assignedSlot() {
						return getAssignedSlot(this);
					}
				};

				var fragmentMixin = {

					// TODO(sorvell): consider doing native QSA and filtering results.
					querySelector: function querySelector(selector) {
						// match selector and halt on first result.
						var result = mutation.query(this, function (n) {
							return utils.matchesSelector(n, selector);
						}, function (n) {
							return Boolean(n);
						})[0];
						return result || null;
					},
					querySelectorAll: function querySelectorAll(selector) {
						return mutation.query(this, function (n) {
							return utils.matchesSelector(n, selector);
						});
					}
				};

				var slotMixin = {
					assignedNodes: function assignedNodes(options) {
						if (this.localName === 'slot') {
							mutation.renderRootNode(this);
							return this.__shady ? (options && options.flatten ? this.__shady.distributedNodes : this.__shady.assignedNodes) || [] : [];
						}
					}
				};

				var elementMixin = utils.extendAll({
					setAttribute: function setAttribute(name, value) {
						mutation.setAttribute(this, name, value);
					},
					removeAttribute: function removeAttribute(name) {
						mutation.removeAttribute(this, name);
					},
					attachShadow: function attachShadow(options) {
						return (0, _attachShadow2.attachShadow)(this, options);
					},


					get slot() {
						return this.getAttribute('slot');
					},

					set slot(value) {
						this.setAttribute('slot', value);
					},

					get assignedSlot() {
						return getAssignedSlot(this);
					}

				}, fragmentMixin, slotMixin);

				Object.defineProperties(elementMixin, _patchAccessors.ShadowRootAccessor);

				var documentMixin = utils.extendAll({
					importNode: function importNode(node, deep) {
						return mutation.importNode(node, deep);
					}
				}, fragmentMixin);

				Object.defineProperties(documentMixin, {
					_activeElement: _patchAccessors.ActiveElementAccessor.activeElement
				});

				function patchBuiltin(proto, obj) {
					var n$ = Object.getOwnPropertyNames(obj);
					for (var i = 0; i < n$.length; i++) {
						var n = n$[i];
						var d = Object.getOwnPropertyDescriptor(obj, n);
						// NOTE: we prefer writing directly here because some browsers
						// have descriptors that are writable but not configurable (e.g.
						// `appendChild` on older browsers)
						if (d.value) {
							proto[n] = d.value;
						} else {
							Object.defineProperty(proto, n, d);
						}
					}
				}

				// Apply patches to builtins (e.g. Element.prototype). Some of these patches
				// can be done unconditionally (mostly methods like
				// `Element.prototype.appendChild`) and some can only be done when the browser
				// has proper descriptors on the builtin prototype
				// (e.g. `Element.prototype.firstChild`)`. When descriptors are not available,
				// elements are individually patched when needed (see e.g.
				// `patchInside/OutsideElementAccessors` in `patch-accessors.js`).
				function patchBuiltins() {
					// These patches can always be done, for all supported browsers.
					patchBuiltin(window.Node.prototype, nodeMixin);
					patchBuiltin(window.Text.prototype, textMixin);
					patchBuiltin(window.DocumentFragment.prototype, fragmentMixin);
					patchBuiltin(window.Element.prototype, elementMixin);
					patchBuiltin(window.Document.prototype, documentMixin);
					if (window.HTMLSlotElement) {
						patchBuiltin(window.HTMLSlotElement.prototype, slotMixin);
					}
					// These patches can *only* be done
					// on browsers that have proper property descriptors on builtin prototypes.
					// This includes: IE11, Edge, Chrome >= 4?; Safari >= 10, Firefox
					// On older browsers (Chrome <= 4?, Safari 9), a per element patching
					// strategy is used for patching accessors.
					if (utils.settings.hasDescriptors) {
						(0, _patchAccessors.patchAccessors)(window.Node.prototype);
						(0, _patchAccessors.patchAccessors)(window.Text.prototype);
						(0, _patchAccessors.patchAccessors)(window.DocumentFragment.prototype);
						(0, _patchAccessors.patchAccessors)(window.Element.prototype);
						var nativeHTMLElement = window.customElements && customElements.nativeHTMLElement || HTMLElement;
						(0, _patchAccessors.patchAccessors)(nativeHTMLElement.prototype);
						(0, _patchAccessors.patchAccessors)(window.Document.prototype);
						if (window.HTMLSlotElement) {
							(0, _patchAccessors.patchAccessors)(window.HTMLSlotElement.prototype);
						}
					}
				}

				/***/ },
			/* 59 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.getRootNode = getRootNode;
				exports.query = query;
				exports.renderRootNode = renderRootNode;
				exports.setAttribute = setAttribute;
				exports.removeAttribute = removeAttribute;
				exports.insertBefore = insertBefore;
				exports.removeChild = removeChild;
				exports.cloneNode = cloneNode;
				exports.importNode = importNode;

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				var _logicalProperties = __webpack_require__(60);

				var _logicalTree = __webpack_require__(61);

				var logicalTree = _interopRequireWildcard(_logicalTree);

				var _nativeMethods = __webpack_require__(55);

				var nativeMethods = _interopRequireWildcard(_nativeMethods);

				var _nativeTree = __webpack_require__(56);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				// Try to add node. Record logical info, track insertion points, perform
				// distribution iff needed. Return true if the add is handled.
				function addNode(container, node, ref_node) {
					var ownerRoot = utils.ownerShadyRootForNode(container);
					var ipAdded = void 0;
					if (ownerRoot) {
						// optimization: special insertion point tracking
						// TODO(sorvell): verify that the renderPending check here should not be needed.
						if (node.__noInsertionPoint && !ownerRoot._changePending) {
							ownerRoot._skipUpdateInsertionPoints = true;
						}
						// note: we always need to see if an insertion point is added
						// since this saves logical tree info; however, invalidation state
						// needs
						ipAdded = _maybeAddInsertionPoint(node, container, ownerRoot);
						// invalidate insertion points IFF not already invalid!
						if (ipAdded) {
							ownerRoot._skipUpdateInsertionPoints = false;
						}
					}
					if ((0, _logicalProperties.hasProperty)(container, 'firstChild')) {
						logicalTree.recordInsertBefore(node, container, ref_node);
					}
					// if not distributing and not adding to host, do a fast path addition
					// TODO(sorvell): revisit flow since `ipAdded` needed here if
					// node is a fragment that has a patched QSA.
					var handled = _maybeDistribute(node, container, ownerRoot, ipAdded) || container.shadyRoot;
					return handled;
				}

				// Try to remove node: update logical info and perform distribution iff
				// needed. Return true if the removal has been handled.
				// note that it's possible for both the node's host and its parent
				// to require distribution... both cases are handled here.
				function removeNode(node) {
					// important that we want to do this only if the node has a logical parent
					var logicalParent = (0, _logicalProperties.hasProperty)(node, 'parentNode') && (0, _logicalProperties.getProperty)(node, 'parentNode');
					var distributed = void 0;
					var ownerRoot = utils.ownerShadyRootForNode(node);
					if (logicalParent || ownerRoot) {
						// distribute node's parent iff needed
						distributed = maybeDistributeParent(node);
						if (logicalParent) {
							logicalTree.recordRemoveChild(node, logicalParent);
						}
						// remove node from root and distribute it iff needed
						var removedDistributed = ownerRoot && _removeDistributedChildren(ownerRoot, node);
						var addedInsertionPoint = logicalParent && ownerRoot && logicalParent.localName === ownerRoot.getInsertionPointTag();
						if (removedDistributed || addedInsertionPoint) {
							ownerRoot._skipUpdateInsertionPoints = false;
							updateRootViaContentChange(ownerRoot);
						}
					}
					_removeOwnerShadyRoot(node);
					return distributed;
				}

				function _scheduleObserver(node, addedNode, removedNode) {
					var observer = node.__shady && node.__shady.observer;
					if (observer) {
						if (addedNode) {
							observer.addedNodes.push(addedNode);
						}
						if (removedNode) {
							observer.removedNodes.push(removedNode);
						}
						observer.schedule();
					}
				}

				function removeNodeFromParent(node, logicalParent) {
					if (logicalParent) {
						_scheduleObserver(logicalParent, null, node);
						return removeNode(node);
					} else {
						// composed but not logical parent
						if (node.parentNode) {
							nativeMethods.removeChild.call(node.parentNode, node);
						}
						_removeOwnerShadyRoot(node);
					}
				}

				function _hasCachedOwnerRoot(node) {
					return Boolean(node.__ownerShadyRoot !== undefined);
				}

				function getRootNode(node) {
					if (!node || !node.nodeType) {
						return;
					}
					var root = node.__ownerShadyRoot;
					if (root === undefined) {
						if (utils.isShadyRoot(node)) {
							root = node;
						} else {
							var parent = node.parentNode;
							root = parent ? getRootNode(parent) : node;
						}
						// memo-ize result for performance but only memo-ize
						// result if node is in the document. This avoids a problem where a root
						// can be cached while an element is inside a fragment.
						// If this happens and we cache the result, the value can become stale
						// because for perf we avoid processing the subtree of added fragments.
						if (document.documentElement.contains(node)) {
							node.__ownerShadyRoot = root;
						}
					}
					return root;
				}

				function _maybeDistribute(node, container, ownerRoot, ipAdded) {
					// TODO(sorvell): technically we should check non-fragment nodes for
					// <content> children but since this case is assumed to be exceedingly
					// rare, we avoid the cost and will address with some specific api
					// when the need arises.  For now, the user must call
					// distributeContent(true), which updates insertion points manually
					// and forces distribution.
					var insertionPointTag = ownerRoot && ownerRoot.getInsertionPointTag() || '';
					var fragContent = node.nodeType === Node.DOCUMENT_FRAGMENT_NODE && !node.__noInsertionPoint && insertionPointTag && node.querySelector(insertionPointTag);
					var wrappedContent = fragContent && fragContent.parentNode.nodeType !== Node.DOCUMENT_FRAGMENT_NODE;
					var hasContent = fragContent || node.localName === insertionPointTag;
					// There are 3 possible cases where a distribution may need to occur:
					// 1. <content> being inserted (the host of the shady root where
					//    content is inserted needs distribution)
					// 2. children being inserted into parent with a shady root (parent
					//    needs distribution)
					// 3. container is an insertionPoint
					if (hasContent || container.localName === insertionPointTag || ipAdded) {
						if (ownerRoot) {
							// note, insertion point list update is handled after node
							// mutations are complete
							updateRootViaContentChange(ownerRoot);
						}
					}
					var needsDist = _nodeNeedsDistribution(container);
					if (needsDist) {
						updateRootViaContentChange(container.shadyRoot);
					}
					// Return true when distribution will fully handle the composition
					// Note that if a content was being inserted that was wrapped by a node,
					// and the parent does not need distribution, return false to allow
					// the nodes to be added directly, after which children may be
					// distributed and composed into the wrapping node(s)
					return needsDist || hasContent && !wrappedContent;
				}

				/* note: parent argument is required since node may have an out
				 of date parent at this point; returns true if a <content> is being added */
				function _maybeAddInsertionPoint(node, parent, root) {
					var added = void 0;
					var insertionPointTag = root.getInsertionPointTag();
					if (node.nodeType === Node.DOCUMENT_FRAGMENT_NODE && !node.__noInsertionPoint) {
						var c$ = node.querySelectorAll(insertionPointTag);
						for (var i = 0, n, np, na; i < c$.length && (n = c$[i]); i++) {
							np = n.parentNode;
							// don't allow node's parent to be fragment itself
							if (np === node) {
								np = parent;
							}
							na = _maybeAddInsertionPoint(n, np, root);
							added = added || na;
						}
					} else if (node.localName === insertionPointTag) {
						logicalTree.recordChildNodes(parent);
						logicalTree.recordChildNodes(node);
						added = true;
					}
					return added;
				}

				function _nodeNeedsDistribution(node) {
					return node && node.shadyRoot && node.shadyRoot.hasInsertionPoint();
				}

				function _removeDistributedChildren(root, container) {
					var hostNeedsDist = void 0;
					var ip$ = root._insertionPoints;
					for (var i = 0; i < ip$.length; i++) {
						var insertionPoint = ip$[i];
						if (_contains(container, insertionPoint)) {
							var dc$ = insertionPoint.assignedNodes({ flatten: true });
							for (var j = 0; j < dc$.length; j++) {
								hostNeedsDist = true;
								var node = dc$[j];
								var parent = (0, _nativeTree.parentNode)(node);
								if (parent) {
									nativeMethods.removeChild.call(parent, node);
								}
							}
						}
					}
					return hostNeedsDist;
				}

				function _contains(container, node) {
					while (node) {
						if (node == container) {
							return true;
						}
						node = node.parentNode;
					}
				}

				function _removeOwnerShadyRoot(node) {
					// optimization: only reset the tree if node is actually in a root
					if (_hasCachedOwnerRoot(node)) {
						var c$ = node.childNodes;
						for (var i = 0, l = c$.length, n; i < l && (n = c$[i]); i++) {
							_removeOwnerShadyRoot(n);
						}
					}
					node.__ownerShadyRoot = undefined;
				}

				// TODO(sorvell): This will fail if distribution that affects this
				// question is pending; this is expected to be exceedingly rare, but if
				// the issue comes up, we can force a flush in this case.
				function firstComposedNode(insertionPoint) {
					var n$ = insertionPoint.assignedNodes({ flatten: true });
					var root = getRootNode(insertionPoint);
					for (var i = 0, l = n$.length, n; i < l && (n = n$[i]); i++) {
						// means that we're composed to this spot.
						if (root.isFinalDestination(insertionPoint, n)) {
							return n;
						}
					}
				}

				function maybeDistributeParent(node) {
					var parent = node.parentNode;
					if (_nodeNeedsDistribution(parent)) {
						updateRootViaContentChange(parent.shadyRoot);
						return true;
					}
				}

				function updateRootViaContentChange(root) {
					// mark root as mutation based on a mutation
					root._changePending = true;
					root.update();
				}

				function distributeAttributeChange(node, name) {
					if (name === 'slot') {
						maybeDistributeParent(node);
					} else if (node.localName === 'slot' && name === 'name') {
						var root = utils.ownerShadyRootForNode(node);
						if (root) {
							root.update();
						}
					}
				}

				// NOTE: `query` is used primarily for ShadyDOM's querySelector impl,
				// but it's also generally useful to recurse through the element tree
				// and is used by Polymer's styling system.
				function query(node, matcher, halter) {
					var list = [];
					_queryElements(node.childNodes, matcher, halter, list);
					return list;
				}

				function _queryElements(elements, matcher, halter, list) {
					for (var i = 0, l = elements.length, c; i < l && (c = elements[i]); i++) {
						if (c.nodeType === Node.ELEMENT_NODE && _queryElement(c, matcher, halter, list)) {
							return true;
						}
					}
				}

				function _queryElement(node, matcher, halter, list) {
					var result = matcher(node);
					if (result) {
						list.push(node);
					}
					if (halter && halter(result)) {
						return result;
					}
					_queryElements(node.childNodes, matcher, halter, list);
				}

				function renderRootNode(element) {
					var root = element.getRootNode();
					if (utils.isShadyRoot(root)) {
						root.render();
					}
				}

				var scopingShim = null;

				function setAttribute(node, attr, value) {
					if (!scopingShim) {
						scopingShim = window.ShadyCSS && window.ShadyCSS.ScopingShim;
					}
					// avoid scoping elements in non-main document to avoid template documents
					if (scopingShim && attr === 'class' && node.ownerDocument === document) {
						scopingShim.setElementClass(node, value);
					} else {
						nativeMethods.setAttribute.call(node, attr, value);
						distributeAttributeChange(node, attr);
					}
				}

				function removeAttribute(node, attr) {
					nativeMethods.removeAttribute.call(node, attr);
					distributeAttributeChange(node, attr);
				}

				// cases in which we may not be able to just do standard native call
				// 1. container has a shadyRoot (needsDistribution IFF the shadyRoot
				// has an insertion point)
				// 2. container is a shadyRoot (don't distribute, instead set
				// container to container.host.
				// 3. node is <content> (host of container needs distribution)
				function insertBefore(parent, node, ref_node) {
					if (ref_node) {
						var p = (0, _logicalProperties.getProperty)(ref_node, 'parentNode');
						if (p !== undefined && p !== parent) {
							throw Error('The ref_node to be inserted before is not a child ' + 'of this node');
						}
					}
					// remove node from its current position iff it's in a tree.
					if (node.nodeType !== Node.DOCUMENT_FRAGMENT_NODE) {
						var _parent = (0, _logicalProperties.getProperty)(node, 'parentNode');
						removeNodeFromParent(node, _parent);
					}
					if (!addNode(parent, node, ref_node)) {
						if (ref_node) {
							// if ref_node is an insertion point replace with first distributed node
							var root = utils.ownerShadyRootForNode(ref_node);
							if (root) {
								ref_node = ref_node.localName === root.getInsertionPointTag() ? firstComposedNode(ref_node) : ref_node;
							}
						}
						// if adding to a shadyRoot, add to host instead
						var container = utils.isShadyRoot(parent) ? parent.host : parent;
						if (ref_node) {
							nativeMethods.insertBefore.call(container, node, ref_node);
						} else {
							nativeMethods.appendChild.call(container, node);
						}
					}
					_scheduleObserver(parent, node);
					return node;
				}

				/**
				 Removes the given `node` from the element's `lightChildren`.
				 This method also performs dom composition.
				 */
				function removeChild(parent, node) {
					if (node.parentNode !== parent) {
						throw Error('The node to be removed is not a child of this node: ' + node);
					}
					if (!removeNode(node)) {
						// if removing from a shadyRoot, remove form host instead
						var container = utils.isShadyRoot(parent) ? parent.host : parent;
						// not guaranteed to physically be in container; e.g.
						// undistributed nodes.
						var nativeParent = (0, _nativeTree.parentNode)(node);
						if (container === nativeParent) {
							nativeMethods.removeChild.call(container, node);
						}
					}
					_scheduleObserver(parent, null, node);
					return node;
				}

				function cloneNode(node, deep) {
					if (node.localName == 'template') {
						return nativeMethods.cloneNode.call(node, deep);
					} else {
						var n = nativeMethods.cloneNode.call(node, false);
						if (deep) {
							var c$ = node.childNodes;
							for (var i = 0, nc; i < c$.length; i++) {
								nc = c$[i].cloneNode(true);
								n.appendChild(nc);
							}
						}
						return n;
					}
				}

				// note: Though not technically correct, we fast path `importNode`
				// when called on a node not owned by the main document.
				// This allows, for example, elements that cannot
				// contain custom elements and are therefore not likely to contain shadowRoots
				// to cloned natively. This is a fairly significant performance win.
				function importNode(node, deep) {
					if (node.ownerDocument !== document) {
						return nativeMethods.importNode.call(document, node, deep);
					}
					var n = nativeMethods.importNode.call(document, node, false);
					if (deep) {
						var c$ = node.childNodes;
						for (var i = 0, nc; i < c$.length; i++) {
							nc = importNode(c$[i], true);
							n.appendChild(nc);
						}
					}
					return n;
				}

				/***/ },
			/* 60 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.getProperty = getProperty;
				exports.hasProperty = hasProperty;
				function getProperty(node, prop) {
					return node.__shady && node.__shady[prop];
				}

				function hasProperty(node, prop) {
					return getProperty(node, prop) !== undefined;
				}

				/***/ },
			/* 61 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.recordChildNodes = undefined;
				exports.recordInsertBefore = recordInsertBefore;
				exports.recordRemoveChild = recordRemoveChild;

				var _logicalProperties = __webpack_require__(60);

				var _patchAccessors = __webpack_require__(62);

				var _nativeTree = __webpack_require__(56);

				function recordInsertBefore(node, container, ref_node) {
					(0, _patchAccessors.patchInsideElementAccessors)(container);
					container.__shady = container.__shady || {};
					if ((0, _logicalProperties.hasProperty)(container, 'firstChild')) {
						container.__shady.childNodes = null;
					}
					// handle document fragments
					if (node.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
						var c$ = node.childNodes;
						for (var i = 0; i < c$.length; i++) {
							linkNode(c$[i], container, ref_node);
						}
						// cleanup logical dom in doc fragment.
						node.__shady = node.__shady || {};
						var resetTo = (0, _logicalProperties.hasProperty)(node, 'firstChild') ? null : undefined;
						node.__shady.firstChild = node.__shady.lastChild = resetTo;
						node.__shady.childNodes = resetTo;
					} else {
						linkNode(node, container, ref_node);
					}
				}

				function linkNode(node, container, ref_node) {
					(0, _patchAccessors.patchOutsideElementAccessors)(node);
					ref_node = ref_node || null;
					node.__shady = node.__shady || {};
					container.__shady = container.__shady || {};
					if (ref_node) {
						ref_node.__shady = ref_node.__shady || {};
					}
					// update ref_node.previousSibling <-> node
					node.__shady.previousSibling = ref_node ? ref_node.__shady.previousSibling : container.lastChild;
					var ps = node.__shady.previousSibling;
					if (ps && ps.__shady) {
						ps.__shady.nextSibling = node;
					}
					// update node <-> ref_node
					var ns = node.__shady.nextSibling = ref_node;
					if (ns && ns.__shady) {
						ns.__shady.previousSibling = node;
					}
					// update node <-> container
					node.__shady.parentNode = container;
					if (ref_node) {
						if (ref_node === container.__shady.firstChild) {
							container.__shady.firstChild = node;
						}
					} else {
						container.__shady.lastChild = node;
						if (!container.__shady.firstChild) {
							container.__shady.firstChild = node;
						}
					}
					// remove caching of childNodes
					container.__shady.childNodes = null;
				}

				function recordRemoveChild(node, container) {
					node.__shady = node.__shady || {};
					container.__shady = container.__shady || {};
					if (node === container.__shady.firstChild) {
						container.__shady.firstChild = node.__shady.nextSibling;
					}
					if (node === container.__shady.lastChild) {
						container.__shady.lastChild = node.__shady.previousSibling;
					}
					var p = node.__shady.previousSibling;
					var n = node.__shady.nextSibling;
					if (p) {
						p.__shady = p.__shady || {};
						p.__shady.nextSibling = n;
					}
					if (n) {
						n.__shady = n.__shady || {};
						n.__shady.previousSibling = p;
					}
					// When an element is removed, logical data is no longer tracked.
					// Explicitly set `undefined` here to indicate this. This is disginguished
					// from `null` which is set if info is null.
					node.__shady.parentNode = node.__shady.previousSibling = node.__shady.nextSibling = undefined;
					if ((0, _logicalProperties.hasProperty)(container, 'childNodes')) {
						// remove caching of childNodes
						container.__shady.childNodes = null;
					}
				}

				var recordChildNodes = exports.recordChildNodes = function recordChildNodes(node) {
					if (!(0, _logicalProperties.hasProperty)(node, 'firstChild')) {
						node.__shady = node.__shady || {};
						node.__shady.firstChild = (0, _nativeTree.firstChild)(node);
						node.__shady.lastChild = (0, _nativeTree.lastChild)(node);
						(0, _patchAccessors.patchInsideElementAccessors)(node);
						var c$ = node.__shady.childNodes = (0, _nativeTree.childNodes)(node);
						for (var i = 0, n; i < c$.length && (n = c$[i]); i++) {
							n.__shady = n.__shady || {};
							n.__shady.parentNode = node;
							n.__shady.nextSibling = c$[i + 1] || null;
							n.__shady.previousSibling = c$[i - 1] || null;
							(0, _patchAccessors.patchOutsideElementAccessors)(n);
						}
					}
				};

				/***/ },
			/* 62 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.patchInsideElementAccessors = exports.patchOutsideElementAccessors = exports.ActiveElementAccessor = exports.ShadowRootAccessor = undefined;
				exports.patchAccessors = patchAccessors;
				exports.patchShadowRootAccessors = patchShadowRootAccessors;

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				var _innerHTML = __webpack_require__(57);

				var _logicalProperties = __webpack_require__(60);

				var _nativeTree = __webpack_require__(56);

				var nativeTree = _interopRequireWildcard(_nativeTree);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function generateSimpleDescriptor(prop) {
					return {
						get: function get() {
							var l = (0, _logicalProperties.getProperty)(this, prop);
							return l !== undefined ? l : nativeTree[prop](this);
						},

						configurable: true
					};
				}

				function clearNode(node) {
					while (node.firstChild) {
						node.removeChild(node.firstChild);
					}
				}

				var nativeInnerHTMLDesc = Object.getOwnPropertyDescriptor(Element.prototype, 'innerHTML') || Object.getOwnPropertyDescriptor(HTMLElement.prototype, 'innerHTML');

				var inertDoc = document.implementation.createHTMLDocument('inert');
				var htmlContainer = inertDoc.createElement('div');

				var nativeActiveElementDescriptor = Object.getOwnPropertyDescriptor(Document.prototype, 'activeElement');
				function getDocumentActiveElement() {
					if (nativeActiveElementDescriptor && nativeActiveElementDescriptor.get) {
						return nativeActiveElementDescriptor.get.call(document);
					} else if (!utils.settings.hasDescriptors) {
						return document.activeElement;
					}
				}

				function activeElementForNode(node) {
					var active = getDocumentActiveElement();
					// In IE11, activeElement might be an empty object if the document is
					// contained in an iframe.
					// https://developer.microsoft.com/en-us/microsoft-edge/platform/issues/10998788/
					if (!active || !active.nodeType) {
						return null;
					}
					var isShadyRoot = !!utils.isShadyRoot(node);
					if (node !== document) {
						// If this node isn't a document or shady root, then it doesn't have
						// an active element.
						if (!isShadyRoot) {
							return null;
						}
						// If this shady root's host is the active element or the active
						// element is not a descendant of the host (in the composed tree),
						// then it doesn't have an active element.
						if (node.host === active || !node.host.contains(active)) {
							return null;
						}
					}
					// This node is either the document or a shady root of which the active
					// element is a (composed) descendant of its host; iterate upwards to
					// find the active element's most shallow host within it.
					var activeRoot = utils.ownerShadyRootForNode(active);
					while (activeRoot && activeRoot !== node) {
						active = activeRoot.host;
						activeRoot = utils.ownerShadyRootForNode(active);
					}
					if (node === document) {
						// This node is the document, so activeRoot should be null.
						return activeRoot ? null : active;
					} else {
						// This node is a non-document shady root, and it should be
						// activeRoot.
						return activeRoot === node ? active : null;
					}
				}

				var OutsideAccessors = {
					// node...
					parentElement: generateSimpleDescriptor('parentElement'),

					parentNode: generateSimpleDescriptor('parentNode'),

					nextSibling: generateSimpleDescriptor('nextSibling'),

					previousSibling: generateSimpleDescriptor('previousSibling'),

					className: {
						get: function get() {
							return this.getAttribute('class');
						},
						set: function set(value) {
							this.setAttribute('class', value);
						},

						configurable: true
					},

					// fragment, element, document
					nextElementSibling: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'nextSibling')) {
								var n = this.nextSibling;
								while (n && n.nodeType !== Node.ELEMENT_NODE) {
									n = n.nextSibling;
								}
								return n;
							} else {
								return nativeTree.nextElementSibling(this);
							}
						},

						configurable: true
					},

					previousElementSibling: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'previousSibling')) {
								var n = this.previousSibling;
								while (n && n.nodeType !== Node.ELEMENT_NODE) {
									n = n.previousSibling;
								}
								return n;
							} else {
								return nativeTree.previousElementSibling(this);
							}
						},

						configurable: true
					}

				};

				var InsideAccessors = {

					childNodes: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'firstChild')) {
								if (!this.__shady.childNodes) {
									this.__shady.childNodes = [];
									for (var n = this.firstChild; n; n = n.nextSibling) {
										this.__shady.childNodes.push(n);
									}
								}
								return this.__shady.childNodes;
							} else {
								return nativeTree.childNodes(this);
							}
						},

						configurable: true
					},

					firstChild: generateSimpleDescriptor('firstChild'),

					lastChild: generateSimpleDescriptor('lastChild'),

					textContent: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'firstChild')) {
								var tc = [];
								for (var i = 0, cn = this.childNodes, c; c = cn[i]; i++) {
									if (c.nodeType !== Node.COMMENT_NODE) {
										tc.push(c.textContent);
									}
								}
								return tc.join('');
							} else {
								return nativeTree.textContent(this);
							}
						},
						set: function set(text) {
							if (this.nodeType !== Node.ELEMENT_NODE) {
								// TODO(sorvell): can't do this if patch nodeValue.
								this.nodeValue = text;
							} else {
								clearNode(this);
								if (text) {
									this.appendChild(document.createTextNode(text));
								}
							}
						},

						configurable: true
					},

					// fragment, element, document
					firstElementChild: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'firstChild')) {
								var n = this.firstChild;
								while (n && n.nodeType !== Node.ELEMENT_NODE) {
									n = n.nextSibling;
								}
								return n;
							} else {
								return nativeTree.firstElementChild(this);
							}
						},

						configurable: true
					},

					lastElementChild: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'lastChild')) {
								var n = this.lastChild;
								while (n && n.nodeType !== Node.ELEMENT_NODE) {
									n = n.previousSibling;
								}
								return n;
							} else {
								return nativeTree.lastElementChild(this);
							}
						},

						configurable: true
					},

					children: {
						get: function get() {
							if ((0, _logicalProperties.hasProperty)(this, 'firstChild')) {
								return Array.prototype.filter.call(this.childNodes, function (n) {
									return n.nodeType === Node.ELEMENT_NODE;
								});
							} else {
								return nativeTree.children(this);
							}
						},

						configurable: true
					},

					// element (HTMLElement on IE11)
					innerHTML: {
						get: function get() {
							var content = this.localName === 'template' ? this.content : this;
							if ((0, _logicalProperties.hasProperty)(this, 'firstChild')) {
								return (0, _innerHTML.getInnerHTML)(content);
							} else {
								return nativeTree.innerHTML(content);
							}
						},
						set: function set(text) {
							var content = this.localName === 'template' ? this.content : this;
							clearNode(content);
							if (nativeInnerHTMLDesc && nativeInnerHTMLDesc.set) {
								nativeInnerHTMLDesc.set.call(htmlContainer, text);
							} else {
								htmlContainer.innerHTML = text;
							}
							while (htmlContainer.firstChild) {
								content.appendChild(htmlContainer.firstChild);
							}
						},

						configurable: true
					}

				};

				// Note: Can be patched on element prototype on all browsers.
				// Must be patched on instance on browsers that support native Shadow DOM
				// but do not have builtin accessors (old Chrome).
				var ShadowRootAccessor = exports.ShadowRootAccessor = {
					shadowRoot: {
						get: function get() {
							return this.shadyRoot;
						},
						set: function set(value) {
							this.shadyRoot = value;
						},

						configurable: true
					}
				};

				// Note: Can be patched on document prototype on browsers with builtin accessors.
				// Must be patched separately on simulated ShadowRoot.
				// Must be patched as `_activeElement` on browsers without builtin accessors.
				var ActiveElementAccessor = exports.ActiveElementAccessor = {

					activeElement: {
						get: function get() {
							return activeElementForNode(this);
						},
						set: function set() {},

						configurable: true
					}

				};

				// patch a group of descriptors on an object only if it exists or if the `force`
				// argument is true.
				function patchAccessorGroup(obj, descriptors, force) {
					for (var p in descriptors) {
						var objDesc = Object.getOwnPropertyDescriptor(obj, p);
						if (objDesc && objDesc.configurable || !objDesc && force) {
							Object.defineProperty(obj, p, descriptors[p]);
						} else if (force) {
							console.warn('Could not define', p, 'on', obj);
						}
					}
				}

				// patch dom accessors on proto where they exist
				function patchAccessors(proto) {
					patchAccessorGroup(proto, OutsideAccessors);
					patchAccessorGroup(proto, InsideAccessors);
					patchAccessorGroup(proto, ActiveElementAccessor);
				}

				// ensure element descriptors (IE/Edge don't have em)
				function patchShadowRootAccessors(proto) {
					patchAccessorGroup(proto, InsideAccessors, true);
					patchAccessorGroup(proto, ActiveElementAccessor, true);
				}

				// ensure an element has patched "outside" accessors; no-op when not needed
				var patchOutsideElementAccessors = exports.patchOutsideElementAccessors = utils.settings.hasDescriptors ? function () {} : function (element) {
					if (!(element.__shady && element.__shady.__outsideAccessors)) {
						element.__shady = element.__shady || {};
						element.__shady.__outsideAccessors = true;
						patchAccessorGroup(element, OutsideAccessors, true);
					}
				};

				// ensure an element has patched "inside" accessors; no-op when not needed
				var patchInsideElementAccessors = exports.patchInsideElementAccessors = utils.settings.hasDescriptors ? function () {} : function (element) {
					if (!(element.__shady && element.__shady.__insideAccessors)) {
						element.__shady = element.__shady || {};
						element.__shady.__insideAccessors = true;
						patchAccessorGroup(element, InsideAccessors, true);
						patchAccessorGroup(element, ShadowRootAccessor, true);
					}
				};

				/***/ },
			/* 63 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				exports.addEventListener = addEventListener;
				exports.removeEventListener = removeEventListener;
				exports.patchEvents = patchEvents;

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				var _nativeMethods = __webpack_require__(55);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				// https://github.com/w3c/webcomponents/issues/513#issuecomment-224183937
				var alwaysComposed = {
					blur: true,
					focus: true,
					focusin: true,
					focusout: true,
					click: true,
					dblclick: true,
					mousedown: true,
					mouseenter: true,
					mouseleave: true,
					mousemove: true,
					mouseout: true,
					mouseover: true,
					mouseup: true,
					wheel: true,
					beforeinput: true,
					input: true,
					keydown: true,
					keyup: true,
					compositionstart: true,
					compositionupdate: true,
					compositionend: true,
					touchstart: true,
					touchend: true,
					touchmove: true,
					touchcancel: true,
					pointerover: true,
					pointerenter: true,
					pointerdown: true,
					pointermove: true,
					pointerup: true,
					pointercancel: true,
					pointerout: true,
					pointerleave: true,
					gotpointercapture: true,
					lostpointercapture: true,
					dragstart: true,
					drag: true,
					dragenter: true,
					dragleave: true,
					dragover: true,
					drop: true,
					dragend: true,
					DOMActivate: true,
					DOMFocusIn: true,
					DOMFocusOut: true,
					keypress: true
				};

				function pathComposer(startNode, composed) {
					var composedPath = [];
					var current = startNode;
					var startRoot = startNode === window ? window : startNode.getRootNode();
					while (current) {
						composedPath.push(current);
						if (current.assignedSlot) {
							current = current.assignedSlot;
						} else if (current.nodeType === Node.DOCUMENT_FRAGMENT_NODE && current.host && (composed || current !== startRoot)) {
							current = current.host;
						} else {
							current = current.parentNode;
						}
					}
					// event composedPath includes window when startNode's ownerRoot is document
					if (composedPath[composedPath.length - 1] === document) {
						composedPath.push(window);
					}
					return composedPath;
				}

				function retarget(refNode, path) {
					if (!utils.isShadyRoot) {
						return refNode;
					}
					// If ANCESTOR's root is not a shadow root or ANCESTOR's root is BASE's
					// shadow-including inclusive ancestor, return ANCESTOR.
					var refNodePath = pathComposer(refNode, true);
					var p$ = path;
					for (var i = 0, ancestor, lastRoot, root, rootIdx; i < p$.length; i++) {
						ancestor = p$[i];
						root = ancestor === window ? window : ancestor.getRootNode();
						if (root !== lastRoot) {
							rootIdx = refNodePath.indexOf(root);
							lastRoot = root;
						}
						if (!utils.isShadyRoot(root) || rootIdx > -1) {
							return ancestor;
						}
					}
				}

				var eventMixin = {

					get composed() {
						if (this.isTrusted && this.__composed === undefined) {
							this.__composed = alwaysComposed[this.type];
						}
						return this.__composed || false;
					},

					composedPath: function composedPath() {
						if (!this.__composedPath) {
							this.__composedPath = pathComposer(this.__target, this.composed);
						}
						return this.__composedPath;
					},


					get target() {
						return retarget(this.currentTarget, this.composedPath());
					},

					// http://w3c.github.io/webcomponents/spec/shadow/#event-relatedtarget-retargeting
					get relatedTarget() {
						if (!this.__relatedTarget) {
							return null;
						}
						if (!this.__relatedTargetComposedPath) {
							this.__relatedTargetComposedPath = pathComposer(this.__relatedTarget, true);
						}
						// find the deepest node in relatedTarget composed path that is in the same root with the currentTarget
						return retarget(this.currentTarget, this.__relatedTargetComposedPath);
					},
					stopPropagation: function stopPropagation() {
						Event.prototype.stopPropagation.call(this);
						this.__propagationStopped = true;
					},
					stopImmediatePropagation: function stopImmediatePropagation() {
						Event.prototype.stopImmediatePropagation.call(this);
						this.__immediatePropagationStopped = true;
						this.__propagationStopped = true;
					}
				};

				function mixinComposedFlag(Base) {
					// NOTE: avoiding use of `class` here so that transpiled output does not
					// try to do `Base.call` with a dom construtor.
					var klazz = function klazz(type, options) {
						var event = new Base(type, options);
						event.__composed = options && Boolean(options.composed);
						return event;
					};
					// put constructor properties on subclass
					utils.mixin(klazz, Base);
					klazz.prototype = Base.prototype;
					return klazz;
				}

				var nonBubblingEventsToRetarget = {
					focus: true,
					blur: true
				};

				function fireHandlers(event, node, phase) {
					var hs = node.__handlers && node.__handlers[event.type] && node.__handlers[event.type][phase];
					if (hs) {
						for (var i = 0, fn; fn = hs[i]; i++) {
							fn.call(node, event);
							if (event.__immediatePropagationStopped) {
								return;
							}
						}
					}
				}

				function retargetNonBubblingEvent(e) {
					var path = e.composedPath();
					var node = void 0;
					// override `currentTarget` to let patched `target` calculate correctly
					Object.defineProperty(e, 'currentTarget', {
						get: function get() {
							return node;
						},
						configurable: true
					});
					for (var i = path.length - 1; i >= 0; i--) {
						node = path[i];
						// capture phase fires all capture handlers
						fireHandlers(e, node, 'capture');
						if (e.__propagationStopped) {
							return;
						}
					}

					// set the event phase to `AT_TARGET` as in spec
					Object.defineProperty(e, 'eventPhase', { value: Event.AT_TARGET });

					// the event only needs to be fired when owner roots change when iterating the event path
					// keep track of the last seen owner root
					var lastFiredRoot = void 0;
					for (var _i = 0; _i < path.length; _i++) {
						node = path[_i];
						if (_i === 0 || node.shadowRoot && node.shadowRoot === lastFiredRoot) {
							fireHandlers(e, node, 'bubble');
							// don't bother with window, it doesn't have `getRootNode` and will be last in the path anyway
							if (node !== window) {
								lastFiredRoot = node.getRootNode();
							}
							if (e.__propagationStopped) {
								return;
							}
						}
					}
				}

				function addEventListener(type, fn, optionsOrCapture) {
					if (!fn) {
						return;
					}

					// The callback `fn` might be used for multiple nodes/events. Since we generate
					// a wrapper function, we need to keep track of it when we remove the listener.
					// It's more efficient to store the node/type/options information as Array in
					// `fn` itself rather than the node (we assume that the same callback is used
					// for few nodes at most, whereas a node will likely have many event listeners).
					// NOTE(valdrin) invoking external functions is costly, inline has better perf.
					var capture = void 0,
						once = void 0,
						passive = void 0;
					if ((typeof optionsOrCapture === 'undefined' ? 'undefined' : _typeof(optionsOrCapture)) === 'object') {
						capture = Boolean(optionsOrCapture.capture);
						once = Boolean(optionsOrCapture.once);
						passive = Boolean(optionsOrCapture.passive);
					} else {
						capture = Boolean(optionsOrCapture);
						once = false;
						passive = false;
					}
					if (fn.__eventWrappers) {
						// Stop if the wrapper function has already been created.
						for (var i = 0; i < fn.__eventWrappers.length; i++) {
							if (fn.__eventWrappers[i].node === this && fn.__eventWrappers[i].type === type && fn.__eventWrappers[i].capture === capture && fn.__eventWrappers[i].once === once && fn.__eventWrappers[i].passive === passive) {
								return;
							}
						}
					} else {
						fn.__eventWrappers = [];
					}

					var wrapperFn = function wrapperFn(e) {
						// Support `once` option.
						if (once) {
							this.removeEventListener(type, fn, optionsOrCapture);
						}
						if (!e.__target) {
							patchEvent(e);
						}
						// There are two critera that should stop events from firing on this node
						// 1. the event is not composed and the current node is not in the same root as the target
						// 2. when bubbling, if after retargeting, relatedTarget and target point to the same node
						if (e.composed || e.composedPath().indexOf(this) > -1) {
							if (e.eventPhase === Event.BUBBLING_PHASE) {
								if (e.target === e.relatedTarget) {
									e.stopImmediatePropagation();
									return;
								}
							}
							return fn(e);
						}
					};
					// Store the wrapper information.
					fn.__eventWrappers.push({
						node: this,
						type: type,
						capture: capture,
						once: once,
						passive: passive,
						wrapperFn: wrapperFn
					});

					if (nonBubblingEventsToRetarget[type]) {
						this.__handlers = this.__handlers || {};
						this.__handlers[type] = this.__handlers[type] || { capture: [], bubble: [] };
						this.__handlers[type][capture ? 'capture' : 'bubble'].push(wrapperFn);
					} else {
						_nativeMethods.addEventListener.call(this, type, wrapperFn, optionsOrCapture);
					}
				}

				function removeEventListener(type, fn, optionsOrCapture) {
					if (!fn) {
						return;
					}

					// NOTE(valdrin) invoking external functions is costly, inline has better perf.
					var capture = void 0,
						once = void 0,
						passive = void 0;
					if ((typeof optionsOrCapture === 'undefined' ? 'undefined' : _typeof(optionsOrCapture)) === 'object') {
						capture = Boolean(optionsOrCapture.capture);
						once = Boolean(optionsOrCapture.once);
						passive = Boolean(optionsOrCapture.passive);
					} else {
						capture = Boolean(optionsOrCapture);
						once = false;
						passive = false;
					}
					// Search the wrapped function.
					var wrapperFn = undefined;
					if (fn.__eventWrappers) {
						for (var i = 0; i < fn.__eventWrappers.length; i++) {
							if (fn.__eventWrappers[i].node === this && fn.__eventWrappers[i].type === type && fn.__eventWrappers[i].capture === capture && fn.__eventWrappers[i].once === once && fn.__eventWrappers[i].passive === passive) {
								wrapperFn = fn.__eventWrappers.splice(i, 1)[0].wrapperFn;
								// Cleanup.
								if (!fn.__eventWrappers.length) {
									fn.__eventWrappers = undefined;
								}
								break;
							}
						}
					}

					_nativeMethods.removeEventListener.call(this, type, wrapperFn || fn, optionsOrCapture);
					if (wrapperFn && nonBubblingEventsToRetarget[type] && this.__handlers && this.__handlers[type]) {
						var arr = this.__handlers[type][capture ? 'capture' : 'bubble'];
						var idx = arr.indexOf(wrapperFn);
						if (idx > -1) {
							arr.splice(idx, 1);
						}
					}
				}

				function activateFocusEventOverrides() {
					for (var ev in nonBubblingEventsToRetarget) {
						window.addEventListener(ev, function (e) {
							if (!e.__target) {
								patchEvent(e);
								retargetNonBubblingEvent(e);
								e.stopImmediatePropagation();
							}
						}, true);
					}
				}

				function patchEvent(event) {
					event.__target = event.target;
					event.__relatedTarget = event.relatedTarget;
					// patch event prototype if we can
					if (utils.settings.hasDescriptors) {
						utils.patchPrototype(event, eventMixin);
						// and fallback to patching instance
					} else {
						utils.extend(event, eventMixin);
					}
				}

				var PatchedEvent = mixinComposedFlag(window.Event);
				var PatchedCustomEvent = mixinComposedFlag(window.CustomEvent);
				var PatchedMouseEvent = mixinComposedFlag(window.MouseEvent);

				function patchEvents() {
					window.Event = PatchedEvent;
					window.CustomEvent = PatchedCustomEvent;
					window.MouseEvent = PatchedMouseEvent;
					activateFocusEventOverrides();
				}

				/***/ },
			/* 64 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.ShadyRoot = undefined;
				exports.attachShadow = attachShadow;

				var _arraySplice = __webpack_require__(65);

				var _utils = __webpack_require__(52);

				var utils = _interopRequireWildcard(_utils);

				var _flush = __webpack_require__(53);

				var _logicalTree = __webpack_require__(61);

				var _nativeMethods = __webpack_require__(55);

				var _nativeTree = __webpack_require__(56);

				var _patchAccessors = __webpack_require__(62);

				var _distributor = __webpack_require__(66);

				var _distributor2 = _interopRequireDefault(_distributor);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				// Do not export this object. It must be passed as the first argument to the
				// ShadyRoot constructor in `attachShadow` to prevent the constructor from
				// throwing. This prevents the user from being able to manually construct a
				// ShadyRoot (i.e. `new ShadowRoot()`).
				var ShadyRootConstructionToken = {};

				var ShadyRoot = exports.ShadyRoot = function ShadyRoot(token, host) {
					if (token !== ShadyRootConstructionToken) {
						throw new TypeError('Illegal constructor');
					}
					// NOTE: this strange construction is necessary because
					// DocumentFragment cannot be subclassed on older browsers.
					var shadowRoot = document.createDocumentFragment();
					shadowRoot.__proto__ = ShadyRoot.prototype;
					shadowRoot._init(host);
					return shadowRoot;
				};

				ShadyRoot.prototype = Object.create(DocumentFragment.prototype);
				utils.extendAll(ShadyRoot.prototype, {
					_init: function _init(host) {
						// NOTE: set a fake local name so this element can be
						// distinguished from a DocumentFragment when patching.
						// FF doesn't allow this to be `localName`
						this.__localName = 'ShadyRoot';
						// logical dom setup
						(0, _logicalTree.recordChildNodes)(host);
						(0, _logicalTree.recordChildNodes)(this);
						// root <=> host
						host.shadowRoot = this;
						this.host = host;
						// state flags
						this._renderPending = false;
						this._hasRendered = false;
						this._changePending = false;
						this._distributor = new _distributor2.default(this);
						this.update();
					},


					// async render
					update: function update() {
						var _this = this;

						if (!this._renderPending) {
							this._renderPending = true;
							(0, _flush.enqueue)(function () {
								return _this.render();
							});
						}
					},


					// returns the oldest renderPending ancestor root.
					_getRenderRoot: function _getRenderRoot() {
						var renderRoot = this;
						var root = this;
						while (root) {
							if (root._renderPending) {
								renderRoot = root;
							}
							root = root._rendererForHost();
						}
						return renderRoot;
					},


					// Returns the shadyRoot `this.host` if `this.host`
					// has children that require distribution.
					_rendererForHost: function _rendererForHost() {
						var root = this.host.getRootNode();
						if (utils.isShadyRoot(root)) {
							var c$ = this.host.childNodes;
							for (var i = 0, c; i < c$.length; i++) {
								c = c$[i];
								if (this._distributor.isInsertionPoint(c)) {
									return root;
								}
							}
						}
					},
					render: function render() {
						if (this._renderPending) {
							this._getRenderRoot()._render();
						}
					},
					_render: function _render() {
						this._renderPending = false;
						this._changePending = false;
						if (!this._skipUpdateInsertionPoints) {
							this.updateInsertionPoints();
						} else if (!this._hasRendered) {
							this._insertionPoints = [];
						}
						this._skipUpdateInsertionPoints = false;
						// TODO(sorvell): can add a first render optimization here
						// to use if there are no insertion points
						// 1. clear host node of composed children
						// 2. appendChild the shadowRoot itself or (more robust) its logical children
						// NOTE: this didn't seem worth it in perf testing
						// but not ready to delete this info.
						// logical
						this.distribute();
						// physical
						this.compose();
						this._hasRendered = true;
					},
					forceRender: function forceRender() {
						this._renderPending = true;
						this.render();
					},
					distribute: function distribute() {
						var dirtyRoots = this._distributor.distribute();
						for (var i = 0; i < dirtyRoots.length; i++) {
							dirtyRoots[i]._render();
						}
					},
					updateInsertionPoints: function updateInsertionPoints() {
						var i$ = this.__insertionPoints;
						// if any insertion points have been removed, clear their distribution info
						if (i$) {
							for (var i = 0, c; i < i$.length; i++) {
								c = i$[i];
								if (c.getRootNode() !== this) {
									this._distributor.clearAssignedSlots(c);
								}
							}
						}
						i$ = this._insertionPoints = this._distributor.getInsertionPoints();
						// ensure insertionPoints's and their parents have logical dom info.
						// save logical tree info
						// a. for shadyRoot
						// b. for insertion points (fallback)
						// c. for parents of insertion points
						for (var _i = 0, _c; _i < i$.length; _i++) {
							_c = i$[_i];
							_c.__shady = _c.__shady || {};
							(0, _logicalTree.recordChildNodes)(_c);
							(0, _logicalTree.recordChildNodes)(_c.parentNode);
						}
					},


					get _insertionPoints() {
						if (!this.__insertionPoints) {
							this.updateInsertionPoints();
						}
						return this.__insertionPoints || (this.__insertionPoints = []);
					},

					set _insertionPoints(insertionPoints) {
						this.__insertionPoints = insertionPoints;
					},

					hasInsertionPoint: function hasInsertionPoint() {
						return this._distributor.hasInsertionPoint();
					},
					compose: function compose() {
						// compose self
						// note: it's important to mark this clean before distribution
						// so that attachment that provokes additional distribution (e.g.
						// adding something to your parentNode) works
						this._composeTree();
						// TODO(sorvell): See fast paths here in Polymer v1
						// (these seem unnecessary)
					},


					// Reify dom such that it is at its correct rendering position
					// based on logical distribution.
					_composeTree: function _composeTree() {
						this._updateChildNodes(this.host, this._composeNode(this.host));
						var p$ = this._insertionPoints || [];
						for (var i = 0, l = p$.length, p, parent; i < l && (p = p$[i]); i++) {
							parent = p.parentNode;
							if (parent !== this.host && parent !== this) {
								this._updateChildNodes(parent, this._composeNode(parent));
							}
						}
					},


					// Returns the list of nodes which should be rendered inside `node`.
					_composeNode: function _composeNode(node) {
						var children = [];
						var c$ = (node.shadyRoot || node).childNodes;
						for (var i = 0; i < c$.length; i++) {
							var child = c$[i];
							if (this._distributor.isInsertionPoint(child)) {
								var distributedNodes = child.__shady.distributedNodes || (child.__shady.distributedNodes = []);
								for (var j = 0; j < distributedNodes.length; j++) {
									var distributedNode = distributedNodes[j];
									if (this.isFinalDestination(child, distributedNode)) {
										children.push(distributedNode);
									}
								}
							} else {
								children.push(child);
							}
						}
						return children;
					},
					isFinalDestination: function isFinalDestination(insertionPoint, node) {
						return this._distributor.isFinalDestination(insertionPoint, node);
					},


					// Ensures that the rendered node list inside `container` is `children`.
					_updateChildNodes: function _updateChildNodes(container, children) {
						var composed = (0, _nativeTree.childNodes)(container);
						var splices = (0, _arraySplice.calculateSplices)(children, composed);
						// process removals
						for (var i = 0, d = 0, s; i < splices.length && (s = splices[i]); i++) {
							for (var j = 0, n; j < s.removed.length && (n = s.removed[j]); j++) {
								// check if the node is still where we expect it is before trying
								// to remove it; this can happen if we move a node and
								// then schedule its previous host for distribution resulting in
								// the node being removed here.
								if ((0, _nativeTree.parentNode)(n) === container) {
									_nativeMethods.removeChild.call(container, n);
								}
								composed.splice(s.index + d, 1);
							}
							d -= s.addedCount;
						}
						// process adds
						for (var _i2 = 0, _s, next; _i2 < splices.length && (_s = splices[_i2]); _i2++) {
							//eslint-disable-line no-redeclare
							next = composed[_s.index];
							for (var _j = _s.index, _n; _j < _s.index + _s.addedCount; _j++) {
								_n = children[_j];
								_nativeMethods.insertBefore.call(container, _n, next);
								// TODO(sorvell): is this splice strictly needed?
								composed.splice(_j, 0, _n);
							}
						}
					},
					getInsertionPointTag: function getInsertionPointTag() {
						return this._distributor.insertionPointTag;
					}
				});

				/**
				 Implements a pared down version of ShadowDOM's scoping, which is easy to
				 polyfill across browsers.
				 */
				function attachShadow(host, options) {
					if (!host) {
						throw 'Must provide a host.';
					}
					if (!options) {
						throw 'Not enough arguments.';
					}
					return new ShadyRoot(ShadyRootConstructionToken, host);
				}

				(0, _patchAccessors.patchShadowRootAccessors)(ShadyRoot.prototype);

				/***/ },
			/* 65 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				function newSplice(index, removed, addedCount) {
					return {
						index: index,
						removed: removed,
						addedCount: addedCount
					};
				}

				var EDIT_LEAVE = 0;
				var EDIT_UPDATE = 1;
				var EDIT_ADD = 2;
				var EDIT_DELETE = 3;

				var ArraySplice = {

					// Note: This function is *based* on the computation of the Levenshtein
					// "edit" distance. The one change is that "updates" are treated as two
					// edits - not one. With Array splices, an update is really a delete
					// followed by an add. By retaining this, we optimize for "keeping" the
					// maximum array items in the original array. For example:
					//
					//   'xxxx123' -> '123yyyy'
					//
					// With 1-edit updates, the shortest path would be just to update all seven
					// characters. With 2-edit updates, we delete 4, leave 3, and add 4. This
					// leaves the substring '123' intact.
					calcEditDistances: function calcEditDistances(current, currentStart, currentEnd, old, oldStart, oldEnd) {
						// "Deletion" columns
						var rowCount = oldEnd - oldStart + 1;
						var columnCount = currentEnd - currentStart + 1;
						var distances = new Array(rowCount);

						// "Addition" rows. Initialize null column.
						for (var i = 0; i < rowCount; i++) {
							distances[i] = new Array(columnCount);
							distances[i][0] = i;
						}

						// Initialize null row
						for (var j = 0; j < columnCount; j++) {
							distances[0][j] = j;
						}for (var _i = 1; _i < rowCount; _i++) {
							for (var _j = 1; _j < columnCount; _j++) {
								if (this.equals(current[currentStart + _j - 1], old[oldStart + _i - 1])) distances[_i][_j] = distances[_i - 1][_j - 1];else {
									var north = distances[_i - 1][_j] + 1;
									var west = distances[_i][_j - 1] + 1;
									distances[_i][_j] = north < west ? north : west;
								}
							}
						}

						return distances;
					},


					// This starts at the final weight, and walks "backward" by finding
					// the minimum previous weight recursively until the origin of the weight
					// matrix.
					spliceOperationsFromEditDistances: function spliceOperationsFromEditDistances(distances) {
						var i = distances.length - 1;
						var j = distances[0].length - 1;
						var current = distances[i][j];
						var edits = [];
						while (i > 0 || j > 0) {
							if (i == 0) {
								edits.push(EDIT_ADD);
								j--;
								continue;
							}
							if (j == 0) {
								edits.push(EDIT_DELETE);
								i--;
								continue;
							}
							var northWest = distances[i - 1][j - 1];
							var west = distances[i - 1][j];
							var north = distances[i][j - 1];

							var min = void 0;
							if (west < north) min = west < northWest ? west : northWest;else min = north < northWest ? north : northWest;

							if (min == northWest) {
								if (northWest == current) {
									edits.push(EDIT_LEAVE);
								} else {
									edits.push(EDIT_UPDATE);
									current = northWest;
								}
								i--;
								j--;
							} else if (min == west) {
								edits.push(EDIT_DELETE);
								i--;
								current = west;
							} else {
								edits.push(EDIT_ADD);
								j--;
								current = north;
							}
						}

						edits.reverse();
						return edits;
					},


					/**
					 * Splice Projection functions:
					 *
					 * A splice map is a representation of how a previous array of items
					 * was transformed into a new array of items. Conceptually it is a list of
					 * tuples of
					 *
					 *   <index, removed, addedCount>
					 *
					 * which are kept in ascending index order of. The tuple represents that at
					 * the |index|, |removed| sequence of items were removed, and counting forward
					 * from |index|, |addedCount| items were added.
					 */

					/**
					 * Lacking individual splice mutation information, the minimal set of
					 * splices can be synthesized given the previous state and final state of an
					 * array. The basic approach is to calculate the edit distance matrix and
					 * choose the shortest path through it.
					 *
					 * Complexity: O(l * p)
					 *   l: The length of the current array
					 *   p: The length of the old array
					 */
					calcSplices: function calcSplices(current, currentStart, currentEnd, old, oldStart, oldEnd) {
						var prefixCount = 0;
						var suffixCount = 0;
						var splice = void 0;

						var minLength = Math.min(currentEnd - currentStart, oldEnd - oldStart);
						if (currentStart == 0 && oldStart == 0) prefixCount = this.sharedPrefix(current, old, minLength);

						if (currentEnd == current.length && oldEnd == old.length) suffixCount = this.sharedSuffix(current, old, minLength - prefixCount);

						currentStart += prefixCount;
						oldStart += prefixCount;
						currentEnd -= suffixCount;
						oldEnd -= suffixCount;

						if (currentEnd - currentStart == 0 && oldEnd - oldStart == 0) return [];

						if (currentStart == currentEnd) {
							splice = newSplice(currentStart, [], 0);
							while (oldStart < oldEnd) {
								splice.removed.push(old[oldStart++]);
							}return [splice];
						} else if (oldStart == oldEnd) return [newSplice(currentStart, [], currentEnd - currentStart)];

						var ops = this.spliceOperationsFromEditDistances(this.calcEditDistances(current, currentStart, currentEnd, old, oldStart, oldEnd));

						splice = undefined;
						var splices = [];
						var index = currentStart;
						var oldIndex = oldStart;
						for (var i = 0; i < ops.length; i++) {
							switch (ops[i]) {
								case EDIT_LEAVE:
									if (splice) {
										splices.push(splice);
										splice = undefined;
									}

									index++;
									oldIndex++;
									break;
								case EDIT_UPDATE:
									if (!splice) splice = newSplice(index, [], 0);

									splice.addedCount++;
									index++;

									splice.removed.push(old[oldIndex]);
									oldIndex++;
									break;
								case EDIT_ADD:
									if (!splice) splice = newSplice(index, [], 0);

									splice.addedCount++;
									index++;
									break;
								case EDIT_DELETE:
									if (!splice) splice = newSplice(index, [], 0);

									splice.removed.push(old[oldIndex]);
									oldIndex++;
									break;
							}
						}

						if (splice) {
							splices.push(splice);
						}
						return splices;
					},
					sharedPrefix: function sharedPrefix(current, old, searchLength) {
						for (var i = 0; i < searchLength; i++) {
							if (!this.equals(current[i], old[i])) return i;
						}return searchLength;
					},
					sharedSuffix: function sharedSuffix(current, old, searchLength) {
						var index1 = current.length;
						var index2 = old.length;
						var count = 0;
						while (count < searchLength && this.equals(current[--index1], old[--index2])) {
							count++;
						}return count;
					},
					calculateSplices: function calculateSplices(current, previous) {
						return this.calcSplices(current, 0, current.length, previous, 0, previous.length);
					},
					equals: function equals(currentValue, previousValue) {
						return currentValue === previousValue;
					}
				};

				var calculateSplices = exports.calculateSplices = function calculateSplices(current, previous) {
					return ArraySplice.calculateSplices(current, previous);
				};

				/***/ },
			/* 66 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _nativeMethods = __webpack_require__(55);

				var _nativeTree = __webpack_require__(56);

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				// NOTE: normalize event contruction where necessary (IE11)
				var NormalizedEvent = typeof Event === 'function' ? Event : function (inType, params) {
					params = params || {};
					var e = document.createEvent('Event');
					e.initEvent(inType, Boolean(params.bubbles), Boolean(params.cancelable));
					return e;
				};

				var _class = function () {
					function _class(root) {
						_classCallCheck(this, _class);

						this.root = root;
						this.insertionPointTag = 'slot';
					}

					_createClass(_class, [{
						key: 'getInsertionPoints',
						value: function getInsertionPoints() {
							return this.root.querySelectorAll(this.insertionPointTag);
						}
					}, {
						key: 'hasInsertionPoint',
						value: function hasInsertionPoint() {
							return Boolean(this.root._insertionPoints && this.root._insertionPoints.length);
						}
					}, {
						key: 'isInsertionPoint',
						value: function isInsertionPoint(node) {
							return node.localName && node.localName == this.insertionPointTag;
						}
					}, {
						key: 'distribute',
						value: function distribute() {
							if (this.hasInsertionPoint()) {
								return this.distributePool(this.root, this.collectPool());
							}
							return [];
						}

						// Gather the pool of nodes that should be distributed. We will combine
						// these with the "content root" to arrive at the composed tree.

					}, {
						key: 'collectPool',
						value: function collectPool() {
							var host = this.root.host;
							var pool = [],
								i = 0;
							for (var n = host.firstChild; n; n = n.nextSibling) {
								pool[i++] = n;
							}
							return pool;
						}

						// perform "logical" distribution; note, no actual dom is moved here,
						// instead elements are distributed into storage
						// array where applicable.

					}, {
						key: 'distributePool',
						value: function distributePool(node, pool) {
							var dirtyRoots = [];
							var p$ = this.root._insertionPoints;
							for (var i = 0, l = p$.length, p; i < l && (p = p$[i]); i++) {
								this.distributeInsertionPoint(p, pool);
								// provoke redistribution on insertion point parents
								// must do this on all candidate hosts since distribution in this
								// scope invalidates their distribution.
								// only get logical parent.
								var parent = p.parentNode;
								if (parent && parent.shadyRoot && this.hasInsertionPoint(parent.shadyRoot)) {
									dirtyRoots.push(parent.shadyRoot);
								}
							}
							for (var _i = 0; _i < pool.length; _i++) {
								var _p = pool[_i];
								if (_p) {
									_p.__shady = _p.__shady || {};
									_p.__shady.assignedSlot = undefined;
									// remove undistributed elements from physical dom.
									var _parent = (0, _nativeTree.parentNode)(_p);
									if (_parent) {
										_nativeMethods.removeChild.call(_parent, _p);
									}
								}
							}
							return dirtyRoots;
						}
					}, {
						key: 'distributeInsertionPoint',
						value: function distributeInsertionPoint(insertionPoint, pool) {
							var prevAssignedNodes = insertionPoint.__shady.assignedNodes;
							if (prevAssignedNodes) {
								this.clearAssignedSlots(insertionPoint, true);
							}
							insertionPoint.__shady.assignedNodes = [];
							var needsSlotChange = false;
							// distribute nodes from the pool that this selector matches
							var anyDistributed = false;
							for (var i = 0, l = pool.length, node; i < l; i++) {
								node = pool[i];
								// skip nodes that were already used
								if (!node) {
									continue;
								}
								// distribute this node if it matches
								if (this.matchesInsertionPoint(node, insertionPoint)) {
									if (node.__shady._prevAssignedSlot != insertionPoint) {
										needsSlotChange = true;
									}
									this.distributeNodeInto(node, insertionPoint);
									// remove this node from the pool
									pool[i] = undefined;
									// since at least one node matched, we won't need fallback content
									anyDistributed = true;
								}
							}
							// Fallback content if nothing was distributed here
							if (!anyDistributed) {
								var children = insertionPoint.childNodes;
								for (var j = 0, _node; j < children.length; j++) {
									_node = children[j];
									if (_node.__shady._prevAssignedSlot != insertionPoint) {
										needsSlotChange = true;
									}
									this.distributeNodeInto(_node, insertionPoint);
								}
							}
							// we're already dirty if a node was newly added to the slot
							// and we're also dirty if the assigned count decreased.
							if (prevAssignedNodes) {
								// TODO(sorvell): the tracking of previously assigned slots
								// could instead by done with a Set and then we could
								// avoid needing to iterate here to clear the info.
								for (var _i2 = 0; _i2 < prevAssignedNodes.length; _i2++) {
									prevAssignedNodes[_i2].__shady._prevAssignedSlot = null;
								}
								if (insertionPoint.__shady.assignedNodes.length < prevAssignedNodes.length) {
									needsSlotChange = true;
								}
							}
							this.setDistributedNodesOnInsertionPoint(insertionPoint);
							if (needsSlotChange) {
								this._fireSlotChange(insertionPoint);
							}
						}
					}, {
						key: 'clearAssignedSlots',
						value: function clearAssignedSlots(slot, savePrevious) {
							var n$ = slot.__shady.assignedNodes;
							if (n$) {
								for (var i = 0; i < n$.length; i++) {
									var n = n$[i];
									if (savePrevious) {
										n.__shady._prevAssignedSlot = n.__shady.assignedSlot;
									}
									// only clear if it was previously set to this slot;
									// this helps ensure that if the node has otherwise been distributed
									// ignore it.
									if (n.__shady.assignedSlot === slot) {
										n.__shady.assignedSlot = null;
									}
								}
							}
						}
					}, {
						key: 'matchesInsertionPoint',
						value: function matchesInsertionPoint(node, insertionPoint) {
							var slotName = insertionPoint.getAttribute('name');
							slotName = slotName ? slotName.trim() : '';
							var slot = node.getAttribute && node.getAttribute('slot');
							slot = slot ? slot.trim() : '';
							return slot == slotName;
						}
					}, {
						key: 'distributeNodeInto',
						value: function distributeNodeInto(child, insertionPoint) {
							insertionPoint.__shady.assignedNodes.push(child);
							child.__shady.assignedSlot = insertionPoint;
						}
					}, {
						key: 'setDistributedNodesOnInsertionPoint',
						value: function setDistributedNodesOnInsertionPoint(insertionPoint) {
							var n$ = insertionPoint.__shady.assignedNodes;
							insertionPoint.__shady.distributedNodes = [];
							for (var i = 0, n; i < n$.length && (n = n$[i]); i++) {
								if (this.isInsertionPoint(n)) {
									var d$ = n.__shady.distributedNodes;
									if (d$) {
										for (var j = 0; j < d$.length; j++) {
											insertionPoint.__shady.distributedNodes.push(d$[j]);
										}
									}
								} else {
									insertionPoint.__shady.distributedNodes.push(n$[i]);
								}
							}
						}
					}, {
						key: '_fireSlotChange',
						value: function _fireSlotChange(insertionPoint) {
							// NOTE: cannot bubble correctly here so not setting bubbles: true
							// Safari tech preview does not bubble but chrome does
							// Spec says it bubbles (https://dom.spec.whatwg.org/#mutation-observers)
							insertionPoint.dispatchEvent(new NormalizedEvent('slotchange'));
							if (insertionPoint.__shady.assignedSlot) {
								this._fireSlotChange(insertionPoint.__shady.assignedSlot);
							}
						}
					}, {
						key: 'isFinalDestination',
						value: function isFinalDestination(insertionPoint) {
							return !insertionPoint.__shady.assignedSlot;
						}
					}]);

					return _class;
				}();

				exports.default = _class;

				/***/ },
			/* 67 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */
				'use strict';

				/*
				 Small module to load ShadyCSS and CustomStyle together
				 */

				__webpack_require__(68);

				__webpack_require__(80);

				/***/ },
			/* 68 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				// TODO(dfreedm): consider spliting into separate global


				var _cssParse = __webpack_require__(69);

				var _styleSettings = __webpack_require__(70);

				var _styleTransformer = __webpack_require__(71);

				var _styleTransformer2 = _interopRequireDefault(_styleTransformer);

				var _styleUtil = __webpack_require__(72);

				var StyleUtil = _interopRequireWildcard(_styleUtil);

				var _styleProperties = __webpack_require__(73);

				var _styleProperties2 = _interopRequireDefault(_styleProperties);

				var _templateMap = __webpack_require__(75);

				var _templateMap2 = _interopRequireDefault(_templateMap);

				var _stylePlaceholder = __webpack_require__(76);

				var _stylePlaceholder2 = _interopRequireDefault(_stylePlaceholder);

				var _styleInfo = __webpack_require__(74);

				var _styleInfo2 = _interopRequireDefault(_styleInfo);

				var _styleCache = __webpack_require__(77);

				var _styleCache2 = _interopRequireDefault(_styleCache);

				var _applyShim = __webpack_require__(78);

				var _applyShim2 = _interopRequireDefault(_applyShim);

				var _documentWatcher = __webpack_require__(79);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var styleCache = new _styleCache2.default();

				var ShadyCSS = function () {
					function ShadyCSS() {
						_classCallCheck(this, ShadyCSS);

						this._scopeCounter = {};
						this._documentOwner = document.documentElement;
						this._documentOwnerStyleInfo = _styleInfo2.default.set(document.documentElement, new _styleInfo2.default({ rules: [] }));
						this._elementsHaveApplied = false;
					}

					_createClass(ShadyCSS, [{
						key: 'flush',
						value: function flush() {
							(0, _documentWatcher.flush)();
						}
					}, {
						key: '_generateScopeSelector',
						value: function _generateScopeSelector(name) {
							var id = this._scopeCounter[name] = (this._scopeCounter[name] || 0) + 1;
							return name + '-' + id;
						}
					}, {
						key: 'getStyleAst',
						value: function getStyleAst(style) {
							return StyleUtil.rulesForStyle(style);
						}
					}, {
						key: 'styleAstToString',
						value: function styleAstToString(ast) {
							return StyleUtil.toCssText(ast);
						}
					}, {
						key: '_gatherStyles',
						value: function _gatherStyles(template) {
							var styles = template.content.querySelectorAll('style');
							var cssText = [];
							for (var i = 0; i < styles.length; i++) {
								var s = styles[i];
								cssText.push(s.textContent);
								s.parentNode.removeChild(s);
							}
							return cssText.join('').trim();
						}
					}, {
						key: '_getCssBuild',
						value: function _getCssBuild(template) {
							var style = template.content.querySelector('style');
							if (!style) {
								return '';
							}
							return style.getAttribute('css-build') || '';
						}
					}, {
						key: 'prepareTemplate',
						value: function prepareTemplate(template, elementName, typeExtension) {
							if (template._prepared) {
								return;
							}
							template._prepared = true;
							template.name = elementName;
							template.extends = typeExtension;
							_templateMap2.default[elementName] = template;
							var cssBuild = this._getCssBuild(template);
							var cssText = this._gatherStyles(template);
							var info = {
								is: elementName,
								extends: typeExtension,
								__cssBuild: cssBuild
							};
							if (!this.nativeShadow) {
								_styleTransformer2.default.dom(template.content, elementName);
							}
							// check if the styling has mixin definitions or uses
							var hasMixins = _applyShim2.default.detectMixin(cssText);
							var ast = (0, _cssParse.parse)(cssText);
							// only run the applyshim transforms if there is a mixin involved
							if (hasMixins && this.nativeCss && !this.nativeCssApply) {
								_applyShim2.default.transformRules(ast, elementName);
							}
							template._styleAst = ast;

							var ownPropertyNames = [];
							if (!this.nativeCss) {
								ownPropertyNames = _styleProperties2.default.decorateStyles(template._styleAst, info);
							}
							if (!ownPropertyNames.length || this.nativeCss) {
								var root = this.nativeShadow ? template.content : null;
								var placeholder = _stylePlaceholder2.default[elementName];
								var style = this._generateStaticStyle(info, template._styleAst, root, placeholder);
								template._style = style;
							}
							template._ownPropertyNames = ownPropertyNames;
						}
					}, {
						key: '_generateStaticStyle',
						value: function _generateStaticStyle(info, rules, shadowroot, placeholder) {
							var cssText = _styleTransformer2.default.elementStyles(info, rules);
							if (cssText.length) {
								return StyleUtil.applyCss(cssText, info.is, shadowroot, placeholder);
							}
						}
					}, {
						key: '_prepareHost',
						value: function _prepareHost(host) {
							var is = host.getAttribute('is') || host.localName;
							var typeExtension = void 0;
							if (is !== host.localName) {
								typeExtension = host.localName;
							}
							var placeholder = _stylePlaceholder2.default[is];
							var template = _templateMap2.default[is];
							var ast = void 0;
							var ownStylePropertyNames = void 0;
							var cssBuild = void 0;
							if (template) {
								ast = template._styleAst;
								ownStylePropertyNames = template._ownPropertyNames;
								cssBuild = template._cssBuild;
							}
							return _styleInfo2.default.set(host, new _styleInfo2.default(ast, placeholder, ownStylePropertyNames, is, typeExtension, cssBuild));
						}
					}, {
						key: 'applyStyle',
						value: function applyStyle(host, overrideProps) {
							var is = host.getAttribute('is') || host.localName;
							var styleInfo = _styleInfo2.default.get(host);
							var hasApplied = Boolean(styleInfo);
							if (!styleInfo) {
								styleInfo = this._prepareHost(host);
							}
							// Only trip the `elementsHaveApplied` flag if a node other that the root document has `applyStyle` called
							if (!this._isRootOwner(host)) {
								this._elementsHaveApplied = true;
							}
							if (window.CustomStyle) {
								var CS = window.CustomStyle;
								if (CS._documentDirty) {
									CS.findStyles();
									if (!this.nativeCss) {
										this._updateProperties(this._documentOwner, this._documentOwnerStyleInfo);
									} else if (!this.nativeCssApply) {
										CS._revalidateApplyShim();
									}
									CS.applyStyles();
									// if no elements have booted yet, we can just update the document and be done
									if (!this._elementsHaveApplied) {
										return;
									}
									// if no native css custom properties, we must recalculate the whole tree
									if (!this.nativeCss) {
										this.updateStyles();
										/*
										 When updateStyles() runs, this element may not have a shadowroot yet.
										 If not, we need to make sure that this element runs `applyStyle` on itself at least once to generate a style
										 */
										if (hasApplied) {
											return;
										}
									}
								}
							}
							if (overrideProps) {
								styleInfo.overrideStyleProperties = styleInfo.overrideStyleProperties || {};
								Object.assign(styleInfo.overrideStyleProperties, overrideProps);
							}
							if (this.nativeCss) {
								if (styleInfo.overrideStyleProperties) {
									this._updateNativeProperties(host, styleInfo.overrideStyleProperties);
								}
								var template = _templateMap2.default[is];
								// bail early if there is no shadowroot for this element
								if (!template && !this._isRootOwner(host)) {
									return;
								}
								if (template && template._applyShimInvalid && template._style) {
									// update template
									if (!template._validating) {
										_applyShim2.default.transformRules(template._styleAst, is);
										template._style.textContent = _styleTransformer2.default.elementStyles(host, styleInfo.styleRules);
										_styleInfo2.default.startValidating(is);
									}
									// update instance if native shadowdom
									if (this.nativeShadow) {
										var root = host.shadowRoot;
										if (root) {
											var style = root.querySelector('style');
											style.textContent = _styleTransformer2.default.elementStyles(host, styleInfo.styleRules);
										}
									}
									styleInfo.styleRules = template._styleAst;
								}
							} else {
								this._updateProperties(host, styleInfo);
								if (styleInfo.ownStylePropertyNames && styleInfo.ownStylePropertyNames.length) {
									this._applyStyleProperties(host, styleInfo);
								}
							}
							if (hasApplied) {
								var _root = this._isRootOwner(host) ? host : host.shadowRoot;
								// note: some elements may not have a root!
								if (_root) {
									this._applyToDescendants(_root);
								}
							}
						}
					}, {
						key: '_applyToDescendants',
						value: function _applyToDescendants(root) {
							var c$ = root.children;
							for (var i = 0, c; i < c$.length; i++) {
								c = c$[i];
								if (c.shadowRoot) {
									this.applyStyle(c);
								}
								this._applyToDescendants(c);
							}
						}
					}, {
						key: '_styleOwnerForNode',
						value: function _styleOwnerForNode(node) {
							var root = node.getRootNode();
							var host = root.host;
							if (host) {
								if (_styleInfo2.default.get(host)) {
									return host;
								} else {
									return this._styleOwnerForNode(host);
								}
							}
							return this._documentOwner;
						}
					}, {
						key: '_isRootOwner',
						value: function _isRootOwner(node) {
							return node === this._documentOwner;
						}
					}, {
						key: '_applyStyleProperties',
						value: function _applyStyleProperties(host, styleInfo) {
							var is = host.getAttribute('is') || host.localName;
							var cacheEntry = styleCache.fetch(is, styleInfo.styleProperties, styleInfo.ownStylePropertyNames);
							var cachedScopeSelector = cacheEntry && cacheEntry.scopeSelector;
							var cachedStyle = cacheEntry ? cacheEntry.styleElement : null;
							var oldScopeSelector = styleInfo.scopeSelector;
							// only generate new scope if cached style is not found
							styleInfo.scopeSelector = cachedScopeSelector || this._generateScopeSelector(is);
							var style = _styleProperties2.default.applyElementStyle(host, styleInfo.styleProperties, styleInfo.scopeSelector, cachedStyle);
							if (!this.nativeShadow) {
								_styleProperties2.default.applyElementScopeSelector(host, styleInfo.scopeSelector, oldScopeSelector);
							}
							if (!cacheEntry) {
								styleCache.store(is, styleInfo.styleProperties, style, styleInfo.scopeSelector);
							}
							return style;
						}
					}, {
						key: '_updateProperties',
						value: function _updateProperties(host, styleInfo) {
							var owner = this._styleOwnerForNode(host);
							var ownerStyleInfo = _styleInfo2.default.get(owner);
							var ownerProperties = ownerStyleInfo.styleProperties;
							var props = Object.create(ownerProperties || null);
							var hostAndRootProps = _styleProperties2.default.hostAndRootPropertiesForScope(host, styleInfo.styleRules);
							var propertyData = _styleProperties2.default.propertyDataFromStyles(ownerStyleInfo.styleRules, host);
							var propertiesMatchingHost = propertyData.properties;
							Object.assign(props, hostAndRootProps.hostProps, propertiesMatchingHost, hostAndRootProps.rootProps);
							this._mixinOverrideStyles(props, styleInfo.overrideStyleProperties);
							_styleProperties2.default.reify(props);
							styleInfo.styleProperties = props;
						}
					}, {
						key: '_mixinOverrideStyles',
						value: function _mixinOverrideStyles(props, overrides) {
							for (var p in overrides) {
								var v = overrides[p];
								// skip override props if they are not truthy or 0
								// in order to fall back to inherited values
								if (v || v === 0) {
									props[p] = v;
								}
							}
						}
					}, {
						key: '_updateNativeProperties',
						value: function _updateNativeProperties(element, properties) {
							// remove previous properties
							for (var p in properties) {
								// NOTE: for bc with shim, don't apply null values.
								if (p === null) {
									element.style.removeProperty(p);
								} else {
									element.style.setProperty(p, properties[p]);
								}
							}
						}
					}, {
						key: 'updateStyles',
						value: function updateStyles(properties) {
							this.applyStyle(this._documentOwner, properties);
						}
						/* Custom Style operations */

					}, {
						key: '_transformCustomStyleForDocument',
						value: function _transformCustomStyleForDocument(style) {
							var _this = this;

							var ast = StyleUtil.rulesForStyle(style);
							StyleUtil.forEachRule(ast, function (rule) {
								if (_styleSettings.nativeShadow) {
									_styleTransformer2.default.normalizeRootSelector(rule);
								} else {
									_styleTransformer2.default.documentRule(rule);
								}
								if (_this.nativeCss && !_this.nativeCssApply) {
									_applyShim2.default.transformRule(rule);
								}
							});
							if (this.nativeCss) {
								style.textContent = StyleUtil.toCssText(ast);
							} else {
								this._documentOwnerStyleInfo.styleRules.rules.push(ast);
							}
						}
					}, {
						key: '_revalidateApplyShim',
						value: function _revalidateApplyShim(style) {
							if (this.nativeCss && !this.nativeCssApply) {
								var ast = StyleUtil.rulesForStyle(style);
								_applyShim2.default.transformRules(ast);
								style.textContent = StyleUtil.toCssText(ast);
							}
						}
					}, {
						key: '_applyCustomStyleToDocument',
						value: function _applyCustomStyleToDocument(style) {
							if (!this.nativeCss) {
								_styleProperties2.default.applyCustomStyle(style, this._documentOwnerStyleInfo.styleProperties);
							}
						}
					}, {
						key: 'getComputedStyleValue',
						value: function getComputedStyleValue(element, property) {
							var value = void 0;
							if (!this.nativeCss) {
								// element is either a style host, or an ancestor of a style host
								var styleInfo = _styleInfo2.default.get(element) || _styleInfo2.default.get(this._styleOwnerForNode(element));
								value = styleInfo.styleProperties[property];
							}
							// fall back to the property value from the computed styling
							value = value || window.getComputedStyle(element).getPropertyValue(property);
							// trim whitespace that can come after the `:` in css
							// example: padding: 2px -> " 2px"
							return value.trim();
						}
						// given an element and a classString, replaces
						// the element's class with the provided classString and adds
						// any necessary ShadyCSS static and property based scoping selectors

					}, {
						key: 'setElementClass',
						value: function setElementClass(element, classString) {
							var root = element.getRootNode();
							var classes = classString ? classString.split(/\s/) : [];
							var scopeName = root.host && root.host.localName;
							// If no scope, try to discover scope name from existing class.
							// This can occur if, for example, a template stamped element that
							// has been scoped is manipulated when not in a root.
							if (!scopeName) {
								var classAttr = element.getAttribute('class');
								if (classAttr) {
									var k$ = classAttr.split(/\s/);
									for (var i = 0; i < k$.length; i++) {
										if (k$[i] === _styleTransformer2.default.SCOPE_NAME) {
											scopeName = k$[i + 1];
											break;
										}
									}
								}
							}
							if (scopeName) {
								classes.push(_styleTransformer2.default.SCOPE_NAME, scopeName);
							}
							if (!this.nativeCss) {
								var styleInfo = _styleInfo2.default.get(element);
								if (styleInfo && styleInfo.scopeSelector) {
									classes.push(_styleProperties2.default.XSCOPE_NAME, styleInfo.scopeSelector);
								}
							}
							StyleUtil.setElementClassRaw(element, classes.join(' '));
						}
					}, {
						key: '_styleInfoForNode',
						value: function _styleInfoForNode(node) {
							return _styleInfo2.default.get(node);
						}
					}, {
						key: 'nativeShadow',
						get: function get() {
							return _styleSettings.nativeShadow;
						}
					}, {
						key: 'nativeCss',
						get: function get() {
							return _styleSettings.nativeCssVariables;
						}
					}, {
						key: 'nativeCssApply',
						get: function get() {
							return _styleSettings.nativeCssApply;
						}
					}]);

					return ShadyCSS;
				}();

				window['ShadyCSS'] = new ShadyCSS();

				/***/ },
			/* 69 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				/*
				 Extremely simple css parser. Intended to be not more than what we need
				 and definitely not necessarily correct =).
				 */

				'use strict';

				// given a string of css, return a simple rule tree

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.parse = parse;
				exports.stringify = stringify;
				exports.removeCustomPropAssignment = removeCustomPropAssignment;
				function parse(text) {
					text = clean(text);
					return parseCss(lex(text), text);
				}

				// remove stuff we don't care about that may hinder parsing
				function clean(cssText) {
					return cssText.replace(RX.comments, '').replace(RX.port, '');
				}

				// super simple {...} lexer that returns a node tree
				function lex(text) {
					var root = {
						start: 0,
						end: text.length
					};
					var n = root;
					for (var i = 0, l = text.length; i < l; i++) {
						if (text[i] === OPEN_BRACE) {
							if (!n.rules) {
								n.rules = [];
							}
							var p = n;
							var previous = p.rules[p.rules.length - 1];
							n = {
								start: i + 1,
								parent: p,
								previous: previous
							};
							p.rules.push(n);
						} else if (text[i] === CLOSE_BRACE) {
							n.end = i + 1;
							n = n.parent || root;
						}
					}
					return root;
				}

				// add selectors/cssText to node tree
				function parseCss(node, text) {
					var t = text.substring(node.start, node.end - 1);
					node.parsedCssText = node.cssText = t.trim();
					if (node.parent) {
						var ss = node.previous ? node.previous.end : node.parent.start;
						t = text.substring(ss, node.start - 1);
						t = _expandUnicodeEscapes(t);
						t = t.replace(RX.multipleSpaces, ' ');
						// TODO(sorvell): ad hoc; make selector include only after last ;
						// helps with mixin syntax
						t = t.substring(t.lastIndexOf(';') + 1);
						var s = node.parsedSelector = node.selector = t.trim();
						node.atRule = s.indexOf(AT_START) === 0;
						// note, support a subset of rule types...
						if (node.atRule) {
							if (s.indexOf(MEDIA_START) === 0) {
								node.type = types.MEDIA_RULE;
							} else if (s.match(RX.keyframesRule)) {
								node.type = types.KEYFRAMES_RULE;
								node.keyframesName = node.selector.split(RX.multipleSpaces).pop();
							}
						} else {
							if (s.indexOf(VAR_START) === 0) {
								node.type = types.MIXIN_RULE;
							} else {
								node.type = types.STYLE_RULE;
							}
						}
					}
					var r$ = node.rules;
					if (r$) {
						for (var i = 0, l = r$.length, r; i < l && (r = r$[i]); i++) {
							parseCss(r, text);
						}
					}
					return node;
				}

				// conversion of sort unicode escapes with spaces like `\33 ` (and longer) into
				// expanded form that doesn't require trailing space `\000033`
				function _expandUnicodeEscapes(s) {
					return s.replace(/\\([0-9a-f]{1,6})\s/gi, function () {
						var code = arguments[1],
							repeat = 6 - code.length;
						while (repeat--) {
							code = '0' + code;
						}
						return '\\' + code;
					});
				}

				// stringify parsed css.
				function stringify(node, preserveProperties, text) {
					text = text || '';
					// calc rule cssText
					var cssText = '';
					if (node.cssText || node.rules) {
						var r$ = node.rules;
						if (r$ && !_hasMixinRules(r$)) {
							for (var i = 0, l = r$.length, r; i < l && (r = r$[i]); i++) {
								cssText = stringify(r, preserveProperties, cssText);
							}
						} else {
							cssText = preserveProperties ? node.cssText : removeCustomProps(node.cssText);
							cssText = cssText.trim();
							if (cssText) {
								cssText = '  ' + cssText + '\n';
							}
						}
					}
					// emit rule if there is cssText
					if (cssText) {
						if (node.selector) {
							text += node.selector + ' ' + OPEN_BRACE + '\n';
						}
						text += cssText;
						if (node.selector) {
							text += CLOSE_BRACE + '\n\n';
						}
					}
					return text;
				}

				function _hasMixinRules(rules) {
					return rules[0].selector.indexOf(VAR_START) === 0;
				}

				function removeCustomProps(cssText) {
					cssText = removeCustomPropAssignment(cssText);
					return removeCustomPropApply(cssText);
				}

				function removeCustomPropAssignment(cssText) {
					return cssText.replace(RX.customProp, '').replace(RX.mixinProp, '');
				}

				function removeCustomPropApply(cssText) {
					return cssText.replace(RX.mixinApply, '').replace(RX.varApply, '');
				}

				var types = exports.types = {
					STYLE_RULE: 1,
					KEYFRAMES_RULE: 7,
					MEDIA_RULE: 4,
					MIXIN_RULE: 1000
				};

				var OPEN_BRACE = '{';
				var CLOSE_BRACE = '}';

				// helper regexp's
				var RX = {
					comments: /\/\*[^*]*\*+([^/*][^*]*\*+)*\//gim,
					port: /@import[^;]*;/gim,
					customProp: /(?:^[^;\-\s}]+)?--[^;{}]*?:[^{};]*?(?:[;\n]|$)/gim,
					mixinProp: /(?:^[^;\-\s}]+)?--[^;{}]*?:[^{};]*?{[^}]*?}(?:[;\n]|$)?/gim,
					mixinApply: /@apply\s*\(?[^);]*\)?\s*(?:[;\n]|$)?/gim,
					varApply: /[^;:]*?:[^;]*?var\([^;]*\)(?:[;\n]|$)?/gim,
					keyframesRule: /^@[^\s]*keyframes/,
					multipleSpaces: /\s+/g
				};

				var VAR_START = '--';
				var MEDIA_START = '@media';
				var AT_START = '@';

				/***/ },
			/* 70 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				var nativeShadow = exports.nativeShadow = !(window.ShadyDOM && window.ShadyDOM.inUse);
				// chrome 49 has semi-working css vars, check if box-shadow works
				// safari 9.1 has a recalc bug: https://bugs.webkit.org/show_bug.cgi?id=155782
				var nativeCssVariables = exports.nativeCssVariables = !navigator.userAgent.match('AppleWebKit/601') && window.CSS && CSS.supports && CSS.supports('box-shadow', '0 0 0 var(--foo)');

				// experimental support for native @apply
				function detectNativeApply() {
					var style = document.createElement('style');
					style.textContent = '.foo { @apply --foo }';
					document.head.appendChild(style);
					var nativeCssApply = style.sheet.cssRules[0].cssText.indexOf('apply') >= 0;
					document.head.removeChild(style);
					return nativeCssApply;
				}

				var nativeCssApply = exports.nativeCssApply = false && detectNativeApply();

				function parseSettings(settings) {
					if (settings) {
						exports.nativeCssVariables = nativeCssVariables = nativeCssVariables && !settings.shimcssproperties;
						exports.nativeShadow = nativeShadow = nativeShadow && !settings.shimshadow;
					}
				}

				if (window.ShadyCSS) {
					parseSettings(window.ShadyCSS);
				} else if (window.WebComponents) {
					parseSettings(window.WebComponents.flags);
				}

				/***/ },
			/* 71 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _styleUtil = __webpack_require__(72);

				var StyleUtil = _interopRequireWildcard(_styleUtil);

				var _styleSettings = __webpack_require__(70);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				/* Transforms ShadowDOM styling into ShadyDOM styling

				 * scoping:

				 * elements in scope get scoping selector class="x-foo-scope"
				 * selectors re-written as follows:

				 div button -> div.x-foo-scope button.x-foo-scope

				 * :host -> scopeName

				 * :host(...) -> scopeName...

				 * ::slotted(...) -> scopeName > ...

				 * ...:dir(ltr|rtl) -> [dir="ltr|rtl"] ..., ...[dir="ltr|rtl"]

				 * :host(:dir[rtl]) -> scopeName:dir(rtl) -> [dir="rtl"] scopeName, scopeName[dir="rtl"]

				 */
				var SCOPE_NAME = 'style-scope';

				var StyleTransformer = function () {
					function StyleTransformer() {
						_classCallCheck(this, StyleTransformer);
					}

					_createClass(StyleTransformer, [{
						key: 'dom',

						// Given a node and scope name, add a scoping class to each node
						// in the tree. This facilitates transforming css into scoped rules.
						value: function dom(node, scope, shouldRemoveScope) {
							// one time optimization to skip scoping...
							if (node.__styleScoped) {
								node.__styleScoped = null;
							} else {
								this._transformDom(node, scope || '', shouldRemoveScope);
							}
						}
					}, {
						key: '_transformDom',
						value: function _transformDom(node, selector, shouldRemoveScope) {
							if (node.nodeType === Node.ELEMENT_NODE) {
								this.element(node, selector, shouldRemoveScope);
							}
							var c$ = node.localName === 'template' ? (node.content || node._content).childNodes : node.children || node.childNodes;
							if (c$) {
								for (var i = 0; i < c$.length; i++) {
									this._transformDom(c$[i], selector, shouldRemoveScope);
								}
							}
						}
					}, {
						key: 'element',
						value: function element(_element, scope, shouldRemoveScope) {
							// note: if using classes, we add both the general 'style-scope' class
							// as well as the specific scope. This enables easy filtering of all
							// `style-scope` elements
							if (scope) {
								// note: svg on IE does not have classList so fallback to class
								if (_element.classList) {
									if (shouldRemoveScope) {
										_element.classList.remove(SCOPE_NAME);
										_element.classList.remove(scope);
									} else {
										_element.classList.add(SCOPE_NAME);
										_element.classList.add(scope);
									}
								} else if (_element.getAttribute) {
									var c = _element.getAttribute(CLASS);
									if (shouldRemoveScope) {
										if (c) {
											var newValue = c.replace(SCOPE_NAME, '').replace(scope, '');
											StyleUtil.setElementClassRaw(_element, newValue);
										}
									} else {
										var _newValue = (c ? c + ' ' : '') + SCOPE_NAME + ' ' + scope;
										StyleUtil.setElementClassRaw(_element, _newValue);
									}
								}
							}
						}
					}, {
						key: 'elementStyles',
						value: function elementStyles(element, styleRules, callback) {
							var cssBuildType = element.__cssBuild;
							// no need to shim selectors if settings.useNativeShadow, also
							// a shady css build will already have transformed selectors
							// NOTE: This method may be called as part of static or property shimming.
							// When there is a targeted build it will not be called for static shimming,
							// but when the property shim is used it is called and should opt out of
							// static shimming work when a proper build exists.
							var cssText = _styleSettings.nativeShadow || cssBuildType === 'shady' ? StyleUtil.toCssText(styleRules, callback) : this.css(styleRules, element.is, element.extends, callback) + '\n\n';
							return cssText.trim();
						}

						// Given a string of cssText and a scoping string (scope), returns
						// a string of scoped css where each selector is transformed to include
						// a class created from the scope. ShadowDOM selectors are also transformed
						// (e.g. :host) to use the scoping selector.

					}, {
						key: 'css',
						value: function css(rules, scope, ext, callback) {
							var hostScope = this._calcHostScope(scope, ext);
							scope = this._calcElementScope(scope);
							var self = this;
							return StyleUtil.toCssText(rules, function (rule) {
								if (!rule.isScoped) {
									self.rule(rule, scope, hostScope);
									rule.isScoped = true;
								}
								if (callback) {
									callback(rule, scope, hostScope);
								}
							});
						}
					}, {
						key: '_calcElementScope',
						value: function _calcElementScope(scope) {
							if (scope) {
								return CSS_CLASS_PREFIX + scope;
							} else {
								return '';
							}
						}
					}, {
						key: '_calcHostScope',
						value: function _calcHostScope(scope, ext) {
							return ext ? '[is=' + scope + ']' : scope;
						}
					}, {
						key: 'rule',
						value: function rule(_rule, scope, hostScope) {
							this._transformRule(_rule, this._transformComplexSelector, scope, hostScope);
						}

						// transforms a css rule to a scoped rule.

					}, {
						key: '_transformRule',
						value: function _transformRule(rule, transformer, scope, hostScope) {
							// NOTE: save transformedSelector for subsequent matching of elements
							// against selectors (e.g. when calculating style properties)
							rule.selector = rule.transformedSelector = this._transformRuleCss(rule, transformer, scope, hostScope);
						}
					}, {
						key: '_transformRuleCss',
						value: function _transformRuleCss(rule, transformer, scope, hostScope) {
							var p$ = rule.selector.split(COMPLEX_SELECTOR_SEP);
							// we want to skip transformation of rules that appear in keyframes,
							// because they are keyframe selectors, not element selectors.
							if (!StyleUtil.isKeyframesSelector(rule)) {
								for (var i = 0, l = p$.length, p; i < l && (p = p$[i]); i++) {
									p$[i] = transformer.call(this, p, scope, hostScope);
								}
							}
							return p$.join(COMPLEX_SELECTOR_SEP);
						}
					}, {
						key: '_transformComplexSelector',
						value: function _transformComplexSelector(selector, scope, hostScope) {
							var _this = this;

							var stop = false;
							selector = selector.trim();
							// Remove spaces inside of selectors like `:nth-of-type` because it confuses SIMPLE_SELECTOR_SEP
							selector = selector.replace(NTH, function (m, type, inner) {
								return ':' + type + '(' + inner.replace(/\s/g, '') + ')';
							});
							selector = selector.replace(SLOTTED_START, HOST + ' $1');
							selector = selector.replace(SIMPLE_SELECTOR_SEP, function (m, c, s) {
								if (!stop) {
									var info = _this._transformCompoundSelector(s, c, scope, hostScope);
									stop = stop || info.stop;
									c = info.combinator;
									s = info.value;
								}
								return c + s;
							});
							return selector;
						}
					}, {
						key: '_transformCompoundSelector',
						value: function _transformCompoundSelector(selector, combinator, scope, hostScope) {
							// replace :host with host scoping class
							var slottedIndex = selector.indexOf(SLOTTED);
							if (selector.indexOf(HOST) >= 0) {
								selector = this._transformHostSelector(selector, hostScope);
								// replace other selectors with scoping class
							} else if (slottedIndex !== 0) {
								selector = scope ? this._transformSimpleSelector(selector, scope) : selector;
							}
							// mark ::slotted() scope jump to replace with descendant selector + arg
							// also ignore left-side combinator
							var slotted = false;
							if (slottedIndex >= 0) {
								combinator = '';
								slotted = true;
							}
							// process scope jumping selectors up to the scope jump and then stop
							var stop = void 0;
							if (slotted) {
								stop = true;
								if (slotted) {
									// .zonk ::slotted(.foo) -> .zonk.scope > .foo
									selector = selector.replace(SLOTTED_PAREN, function (m, paren) {
										return ' > ' + paren;
									});
								}
							}
							selector = selector.replace(DIR_PAREN, function (m, before, dir) {
								return '[dir="' + dir + '"] ' + before + ', ' + before + '[dir="' + dir + '"]';
							});
							return { value: selector, combinator: combinator, stop: stop };
						}
					}, {
						key: '_transformSimpleSelector',
						value: function _transformSimpleSelector(selector, scope) {
							var p$ = selector.split(PSEUDO_PREFIX);
							p$[0] += scope;
							return p$.join(PSEUDO_PREFIX);
						}

						// :host(...) -> scopeName...

					}, {
						key: '_transformHostSelector',
						value: function _transformHostSelector(selector, hostScope) {
							var m = selector.match(HOST_PAREN);
							var paren = m && m[2].trim() || '';
							if (paren) {
								if (!paren[0].match(SIMPLE_SELECTOR_PREFIX)) {
									// paren starts with a type selector
									var typeSelector = paren.split(SIMPLE_SELECTOR_PREFIX)[0];
									// if the type selector is our hostScope then avoid pre-pending it
									if (typeSelector === hostScope) {
										return paren;
										// otherwise, this selector should not match in this scope so
										// output a bogus selector.
									} else {
										return SELECTOR_NO_MATCH;
									}
								} else {
									// make sure to do a replace here to catch selectors like:
									// `:host(.foo)::before`
									return selector.replace(HOST_PAREN, function (m, host, paren) {
										return hostScope + paren;
									});
								}
								// if no paren, do a straight :host replacement.
								// TODO(sorvell): this should not strictly be necessary but
								// it's needed to maintain support for `:host[foo]` type selectors
								// which have been improperly used under Shady DOM. This should be
								// deprecated.
							} else {
								return selector.replace(HOST, hostScope);
							}
						}
					}, {
						key: 'documentRule',
						value: function documentRule(rule) {
							// reset selector in case this is redone.
							rule.selector = rule.parsedSelector;
							this.normalizeRootSelector(rule);
							this._transformRule(rule, this._transformDocumentSelector);
						}
					}, {
						key: 'normalizeRootSelector',
						value: function normalizeRootSelector(rule) {
							if (rule.selector === ROOT) {
								rule.selector = 'html';
							}
						}
					}, {
						key: '_transformDocumentSelector',
						value: function _transformDocumentSelector(selector) {
							return selector.match(SLOTTED) ? this._transformComplexSelector(selector, SCOPE_DOC_SELECTOR) : this._transformSimpleSelector(selector.trim(), SCOPE_DOC_SELECTOR);
						}
					}, {
						key: 'SCOPE_NAME',
						get: function get() {
							return SCOPE_NAME;
						}
					}]);

					return StyleTransformer;
				}();

				var NTH = /:(nth[-\w]+)\(([^)]+)\)/;
				var SCOPE_DOC_SELECTOR = ':not(.' + SCOPE_NAME + ')';
				var COMPLEX_SELECTOR_SEP = ',';
				var SIMPLE_SELECTOR_SEP = /(^|[\s>+~]+)((?:\[.+?\]|[^\s>+~=\[])+)/g;
				var SIMPLE_SELECTOR_PREFIX = /[[.:#*]/;
				var HOST = ':host';
				var ROOT = ':root';
				var SLOTTED = '::slotted';
				var SLOTTED_START = new RegExp('^(' + SLOTTED + ')');
				// NOTE: this supports 1 nested () pair for things like
				// :host(:not([selected]), more general support requires
				// parsing which seems like overkill
				var HOST_PAREN = /(:host)(?:\(((?:\([^)(]*\)|[^)(]*)+?)\))/;
				// similar to HOST_PAREN
				var SLOTTED_PAREN = /(?:::slotted)(?:\(((?:\([^)(]*\)|[^)(]*)+?)\))/;
				var DIR_PAREN = /(.*):dir\((?:(ltr|rtl))\)/;
				var CSS_CLASS_PREFIX = '.';
				var PSEUDO_PREFIX = ':';
				var CLASS = 'class';
				var SELECTOR_NO_MATCH = 'should_not_match';

				exports.default = new StyleTransformer();

				/***/ },
			/* 72 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.rx = undefined;
				exports.toCssText = toCssText;
				exports.rulesForStyle = rulesForStyle;
				exports.isKeyframesSelector = isKeyframesSelector;
				exports.forEachRule = forEachRule;
				exports.applyCss = applyCss;
				exports.applyStyle = applyStyle;
				exports.createScopeStyle = createScopeStyle;
				exports.applyStylePlaceHolder = applyStylePlaceHolder;
				exports.isTargetedBuild = isTargetedBuild;
				exports.getCssBuildType = getCssBuildType;
				exports.processVariableAndFallback = processVariableAndFallback;
				exports.setElementClassRaw = setElementClassRaw;

				var _styleSettings = __webpack_require__(70);

				var _cssParse = __webpack_require__(69);

				function toCssText(rules, callback) {
					if (typeof rules === 'string') {
						rules = (0, _cssParse.parse)(rules);
					}
					if (callback) {
						forEachRule(rules, callback);
					}
					return (0, _cssParse.stringify)(rules, _styleSettings.nativeCssVariables);
				}

				function rulesForStyle(style) {
					if (!style.__cssRules && style.textContent) {
						style.__cssRules = (0, _cssParse.parse)(style.textContent);
					}
					return style.__cssRules;
				}

				// Tests if a rule is a keyframes selector, which looks almost exactly
				// like a normal selector but is not (it has nothing to do with scoping
				// for example).
				function isKeyframesSelector(rule) {
					return rule.parent && rule.parent.type === _cssParse.types.KEYFRAMES_RULE;
				}

				function forEachRule(node, styleRuleCallback, keyframesRuleCallback, onlyActiveRules) {
					if (!node) {
						return;
					}
					var skipRules = false;
					if (onlyActiveRules) {
						if (node.type === _cssParse.types.MEDIA_RULE) {
							var matchMedia = node.selector.match(rx.MEDIA_MATCH);
							if (matchMedia) {
								// if rule is a non matching @media rule, skip subrules
								if (!window.matchMedia(matchMedia[1]).matches) {
									skipRules = true;
								}
							}
						}
					}
					if (node.type === _cssParse.types.STYLE_RULE) {
						styleRuleCallback(node);
					} else if (keyframesRuleCallback && node.type === _cssParse.types.KEYFRAMES_RULE) {
						keyframesRuleCallback(node);
					} else if (node.type === _cssParse.types.MIXIN_RULE) {
						skipRules = true;
					}
					var r$ = node.rules;
					if (r$ && !skipRules) {
						for (var i = 0, l = r$.length, r; i < l && (r = r$[i]); i++) {
							forEachRule(r, styleRuleCallback, keyframesRuleCallback, onlyActiveRules);
						}
					}
				}

				// add a string of cssText to the document.
				function applyCss(cssText, moniker, target, contextNode) {
					var style = createScopeStyle(cssText, moniker);
					return applyStyle(style, target, contextNode);
				}

				function applyStyle(style, target, contextNode) {
					target = target || document.head;
					var after = contextNode && contextNode.nextSibling || target.firstChild;
					lastHeadApplyNode = style;
					return target.insertBefore(style, after);
				}

				function createScopeStyle(cssText, moniker) {
					var style = document.createElement('style');
					if (moniker) {
						style.setAttribute('scope', moniker);
					}
					style.textContent = cssText;
					return style;
				}

				var lastHeadApplyNode = null;

				// insert a comment node as a styling position placeholder.
				function applyStylePlaceHolder(moniker) {
					var placeHolder = document.createComment(' Shady DOM styles for ' + moniker + ' ');
					var after = lastHeadApplyNode ? lastHeadApplyNode.nextSibling : null;
					var scope = document.head;
					scope.insertBefore(placeHolder, after || scope.firstChild);
					lastHeadApplyNode = placeHolder;
					return placeHolder;
				}

				function isTargetedBuild(buildType) {
					return _styleSettings.nativeShadow ? buildType === 'shadow' : buildType === 'shady';
				}

				// cssBuildTypeForModule: function (module) {
				//   let dm = Polymer.DomModule.import(module);
				//   if (dm) {
				//     return getCssBuildType(dm);
				//   }
				// },
				//
				function getCssBuildType(element) {
					return element.getAttribute('css-build');
				}

				// Walk from text[start] matching parens
				// returns position of the outer end paren
				function findMatchingParen(text, start) {
					var level = 0;
					for (var i = start, l = text.length; i < l; i++) {
						if (text[i] === '(') {
							level++;
						} else if (text[i] === ')') {
							if (--level === 0) {
								return i;
							}
						}
					}
					return -1;
				}

				function processVariableAndFallback(str, callback) {
					// find 'var('
					var start = str.indexOf('var(');
					if (start === -1) {
						// no var?, everything is prefix
						return callback(str, '', '', '');
					}
					//${prefix}var(${inner})${suffix}
					var end = findMatchingParen(str, start + 3);
					var inner = str.substring(start + 4, end);
					var prefix = str.substring(0, start);
					// suffix may have other variables
					var suffix = processVariableAndFallback(str.substring(end + 1), callback);
					var comma = inner.indexOf(',');
					// value and fallback args should be trimmed to match in property lookup
					if (comma === -1) {
						// variable, no fallback
						return callback(prefix, inner.trim(), '', suffix);
					}
					// var(${value},${fallback})
					var value = inner.substring(0, comma).trim();
					var fallback = inner.substring(comma + 1).trim();
					return callback(prefix, value, fallback, suffix);
				}

				function setElementClassRaw(element, value) {
					// use native setAttribute provided by ShadyDOM when setAttribute is patched
					if (window.ShadyDOM) {
						window.ShadyDOM.nativeMethods.setAttribute.call(element, 'class', value);
					} else {
						element.setAttribute('class', value);
					}
				}

				var rx = exports.rx = {
					VAR_ASSIGN: /(?:^|[;\s{]\s*)(--[\w-]*?)\s*:\s*(?:([^;{]*)|{([^}]*)})(?:(?=[;\s}])|$)/gi,
					MIXIN_MATCH: /(?:^|\W+)@apply\s*\(?([^);\n]*)\)?/gi,
					VAR_CONSUMED: /(--[\w-]+)\s*([:,;)]|$)/gi,
					ANIMATION_MATCH: /(animation\s*:)|(animation-name\s*:)/,
					MEDIA_MATCH: /@media[^(]*(\([^)]*\))/,
					IS_VAR: /^--/,
					BRACKETED: /\{[^}]*\}/g,
					HOST_PREFIX: '(?:^|[^.#[:])',
					HOST_SUFFIX: '($|[.:[\\s>+~])'
				};

				/***/ },
			/* 73 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _cssParse = __webpack_require__(69);

				var _styleSettings = __webpack_require__(70);

				var _styleTransformer = __webpack_require__(71);

				var _styleTransformer2 = _interopRequireDefault(_styleTransformer);

				var _styleUtil = __webpack_require__(72);

				var StyleUtil = _interopRequireWildcard(_styleUtil);

				var _styleInfo = __webpack_require__(74);

				var _styleInfo2 = _interopRequireDefault(_styleInfo);

				function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				// TODO: dedupe with shady
				var p = window.Element.prototype;
				var matchesSelector = p.matches || p.matchesSelector || p.mozMatchesSelector || p.msMatchesSelector || p.oMatchesSelector || p.webkitMatchesSelector;

				var IS_IE = navigator.userAgent.match('Trident');

				var XSCOPE_NAME = 'x-scope';

				var StyleProperties = function () {
					function StyleProperties() {
						_classCallCheck(this, StyleProperties);
					}

					_createClass(StyleProperties, [{
						key: 'decorateStyles',

						// decorates styles with rule info and returns an array of used style
						// property names
						value: function decorateStyles(rules) {
							var self = this,
								props = {},
								keyframes = [],
								ruleIndex = 0;
							StyleUtil.forEachRule(rules, function (rule) {
								self.decorateRule(rule);
								// mark in-order position of ast rule in styles block, used for cache key
								rule.index = ruleIndex++;
								self.collectPropertiesInCssText(rule.propertyInfo.cssText, props);
							}, function onKeyframesRule(rule) {
								keyframes.push(rule);
							});
							// Cache all found keyframes rules for later reference:
							rules._keyframes = keyframes;
							// return this list of property names *consumes* in these styles.
							var names = [];
							for (var i in props) {
								names.push(i);
							}
							return names;
						}

						// decorate a single rule with property info

					}, {
						key: 'decorateRule',
						value: function decorateRule(rule) {
							if (rule.propertyInfo) {
								return rule.propertyInfo;
							}
							var info = {},
								properties = {};
							var hasProperties = this.collectProperties(rule, properties);
							if (hasProperties) {
								info.properties = properties;
								// TODO(sorvell): workaround parser seeing mixins as additional rules
								rule.rules = null;
							}
							info.cssText = this.collectCssText(rule);
							rule.propertyInfo = info;
							return info;
						}

						// collects the custom properties from a rule's cssText

					}, {
						key: 'collectProperties',
						value: function collectProperties(rule, properties) {
							var info = rule.propertyInfo;
							if (info) {
								if (info.properties) {
									Object.assign(properties, info.properties);
									return true;
								}
							} else {
								var m = void 0,
									rx = StyleUtil.rx.VAR_ASSIGN;
								var cssText = rule.parsedCssText;
								var value = void 0;
								var any = void 0;
								while (m = rx.exec(cssText)) {
									// note: group 2 is var, 3 is mixin
									value = (m[2] || m[3]).trim();
									// value of 'inherit' or 'unset' is equivalent to not setting the property here
									if (value !== 'inherit' || value !== 'unset') {
										properties[m[1].trim()] = value;
									}
									any = true;
								}
								return any;
							}
						}

						// returns cssText of properties that consume variables/mixins

					}, {
						key: 'collectCssText',
						value: function collectCssText(rule) {
							return this.collectConsumingCssText(rule.parsedCssText);
						}

						// NOTE: we support consumption inside mixin assignment
						// but not production, so strip out {...}

					}, {
						key: 'collectConsumingCssText',
						value: function collectConsumingCssText(cssText) {
							return cssText.replace(StyleUtil.rx.BRACKETED, '').replace(StyleUtil.rx.VAR_ASSIGN, '');
						}
					}, {
						key: 'collectPropertiesInCssText',
						value: function collectPropertiesInCssText(cssText, props) {
							var m = void 0;
							while (m = StyleUtil.rx.VAR_CONSUMED.exec(cssText)) {
								var name = m[1];
								// This regex catches all variable names, and following non-whitespace char
								// If next char is not ':', then variable is a consumer
								if (m[2] !== ':') {
									props[name] = true;
								}
							}
						}

						// turns custom properties into realized values.

					}, {
						key: 'reify',
						value: function reify(props) {
							// big perf optimization here: reify only *own* properties
							// since this object has __proto__ of the element's scope properties
							var names = Object.getOwnPropertyNames(props);
							for (var i = 0, n; i < names.length; i++) {
								n = names[i];
								props[n] = this.valueForProperty(props[n], props);
							}
						}

						// given a property value, returns the reified value
						// a property value may be:
						// (1) a literal value like: red or 5px;
						// (2) a variable value like: var(--a), var(--a, red), or var(--a, --b) or
						// var(--a, var(--b));
						// (3) a literal mixin value like { properties }. Each of these properties
						// can have values that are: (a) literal, (b) variables, (c) @apply mixins.

					}, {
						key: 'valueForProperty',
						value: function valueForProperty(property, props) {
							var _this = this;

							// case (1) default
							// case (3) defines a mixin and we have to reify the internals
							if (property) {
								if (property.indexOf(';') >= 0) {
									property = this.valueForProperties(property, props);
								} else {
									(function () {
										// case (2) variable
										var self = _this;
										var fn = function fn(prefix, value, fallback, suffix) {
											if (!value) {
												return prefix + suffix;
											}
											var propertyValue = self.valueForProperty(props[value], props);
											// if value is "initial", then the variable should be treated as unset
											if (!propertyValue || propertyValue === 'initial') {
												// fallback may be --a or var(--a) or literal
												propertyValue = self.valueForProperty(props[fallback] || fallback, props) || fallback;
											} else if (propertyValue === 'apply-shim-inherit') {
												// CSS build will replace `inherit` with `apply-shim-inherit`
												// for use with native css variables.
												// Since we have full control, we can use `inherit` directly.
												propertyValue = 'inherit';
											}
											return prefix + (propertyValue || '') + suffix;
										};
										property = StyleUtil.processVariableAndFallback(property, fn);
									})();
								}
							}
							return property && property.trim() || '';
						}

						// note: we do not yet support mixin within mixin

					}, {
						key: 'valueForProperties',
						value: function valueForProperties(property, props) {
							var parts = property.split(';');
							for (var i = 0, _p, m; i < parts.length; i++) {
								if (_p = parts[i]) {
									StyleUtil.rx.MIXIN_MATCH.lastIndex = 0;
									m = StyleUtil.rx.MIXIN_MATCH.exec(_p);
									if (m) {
										_p = this.valueForProperty(props[m[1]], props);
									} else {
										var colon = _p.indexOf(':');
										if (colon !== -1) {
											var pp = _p.substring(colon);
											pp = pp.trim();
											pp = this.valueForProperty(pp, props) || pp;
											_p = _p.substring(0, colon) + pp;
										}
									}
									parts[i] = _p && _p.lastIndexOf(';') === _p.length - 1 ?
										// strip trailing ;
										_p.slice(0, -1) : _p || '';
								}
							}
							return parts.join(';');
						}
					}, {
						key: 'applyProperties',
						value: function applyProperties(rule, props) {
							var output = '';
							// dynamically added sheets may not be decorated so ensure they are.
							if (!rule.propertyInfo) {
								this.decorateRule(rule);
							}
							if (rule.propertyInfo.cssText) {
								output = this.valueForProperties(rule.propertyInfo.cssText, props);
							}
							rule.cssText = output;
						}

						// Apply keyframe transformations to the cssText of a given rule. The
						// keyframeTransforms object is a map of keyframe names to transformer
						// functions which take in cssText and spit out transformed cssText.

					}, {
						key: 'applyKeyframeTransforms',
						value: function applyKeyframeTransforms(rule, keyframeTransforms) {
							var input = rule.cssText;
							var output = rule.cssText;
							if (rule.hasAnimations == null) {
								// Cache whether or not the rule has any animations to begin with:
								rule.hasAnimations = StyleUtil.rx.ANIMATION_MATCH.test(input);
							}
							// If there are no animations referenced, we can skip transforms:
							if (rule.hasAnimations) {
								var transform = void 0;
								// If we haven't transformed this rule before, we iterate over all
								// transforms:
								if (rule.keyframeNamesToTransform == null) {
									rule.keyframeNamesToTransform = [];
									for (var keyframe in keyframeTransforms) {
										transform = keyframeTransforms[keyframe];
										output = transform(input);
										// If the transform actually changed the CSS text, we cache the
										// transform name for future use:
										if (input !== output) {
											input = output;
											rule.keyframeNamesToTransform.push(keyframe);
										}
									}
								} else {
									// If we already have a list of keyframe names that apply to this
									// rule, we apply only those keyframe name transforms:
									for (var i = 0; i < rule.keyframeNamesToTransform.length; ++i) {
										transform = keyframeTransforms[rule.keyframeNamesToTransform[i]];
										input = transform(input);
									}
									output = input;
								}
							}
							rule.cssText = output;
						}

						// Test if the rules in these styles matches the given `element` and if so,
						// collect any custom properties into `props`.

					}, {
						key: 'propertyDataFromStyles',
						value: function propertyDataFromStyles(rules, element) {
							var props = {},
								self = this;
							// generates a unique key for these matches
							var o = [];
							// note: active rules excludes non-matching @media rules
							StyleUtil.forEachRule(rules, function (rule) {
								// TODO(sorvell): we could trim the set of rules at declaration
								// time to only include ones that have properties
								if (!rule.propertyInfo) {
									self.decorateRule(rule);
								}
								// match element against transformedSelector: selector may contain
								// unwanted uniquification and parsedSelector does not directly match
								// for :host selectors.
								var selectorToMatch = rule.transformedSelector || rule.parsedSelector;
								if (element && rule.propertyInfo.properties && selectorToMatch) {
									if (matchesSelector.call(element, selectorToMatch)) {
										self.collectProperties(rule, props);
										// produce numeric key for these matches for lookup
										addToBitMask(rule.index, o);
									}
								}
							}, null, true);
							return { properties: props, key: o };
						}
					}, {
						key: 'whenHostOrRootRule',
						value: function whenHostOrRootRule(scope, rule, cssBuild, callback) {
							if (!rule.propertyInfo) {
								this.decorateRule(rule);
							}
							if (!rule.propertyInfo.properties) {
								return;
							}
							var hostScope = scope.is ? _styleTransformer2.default._calcHostScope(scope.is, scope.extends) : 'html';
							var parsedSelector = rule.parsedSelector;
							var isRoot = parsedSelector === ':host > *' || parsedSelector === 'html';
							var isHost = parsedSelector.indexOf(':host') === 0 && !isRoot;
							// build info is either in scope (when scope is an element) or in the style
							// when scope is the default scope; note: this allows default scope to have
							// mixed mode built and unbuilt styles.
							if (cssBuild === 'shady') {
								// :root -> x-foo > *.x-foo for elements and html for custom-style
								isRoot = parsedSelector === hostScope + ' > *.' + hostScope || parsedSelector.indexOf('html') !== -1;
								// :host -> x-foo for elements, but sub-rules have .x-foo in them
								isHost = !isRoot && parsedSelector.indexOf(hostScope) === 0;
							}
							if (cssBuild === 'shadow') {
								isRoot = parsedSelector === ':host > *' || parsedSelector === 'html';
								isHost = isHost && !isRoot;
							}
							if (!isRoot && !isHost) {
								return;
							}
							var selectorToMatch = hostScope;
							if (isHost) {
								// need to transform :host under ShadowDOM because `:host` does not work with `matches`
								if (_styleSettings.nativeShadow && !rule.transformedSelector) {
									// transform :host into a matchable selector
									rule.transformedSelector = _styleTransformer2.default._transformRuleCss(rule, _styleTransformer2.default._transformComplexSelector, _styleTransformer2.default._calcElementScope(scope.is), hostScope);
								}
								selectorToMatch = rule.transformedSelector || hostScope;
							}
							callback({
								selector: selectorToMatch,
								isHost: isHost,
								isRoot: isRoot
							});
						}
					}, {
						key: 'hostAndRootPropertiesForScope',
						value: function hostAndRootPropertiesForScope(scope, rules) {
							var hostProps = {},
								rootProps = {},
								self = this;
							// note: active rules excludes non-matching @media rules
							var cssBuild = rules && rules.__cssBuild;
							StyleUtil.forEachRule(rules, function (rule) {
								// if scope is StyleDefaults, use _element for matchesSelector
								self.whenHostOrRootRule(scope, rule, cssBuild, function (info) {
									var element = scope._element || scope;
									if (matchesSelector.call(element, info.selector)) {
										if (info.isHost) {
											self.collectProperties(rule, hostProps);
										} else {
											self.collectProperties(rule, rootProps);
										}
									}
								});
							}, null, true);
							return { rootProps: rootProps, hostProps: hostProps };
						}
					}, {
						key: 'transformStyles',
						value: function transformStyles(element, properties, scopeSelector) {
							var self = this;
							var hostSelector = _styleTransformer2.default._calcHostScope(element.is, element.extends);
							var rxHostSelector = element.extends ? '\\' + hostSelector.slice(0, -1) + '\\]' : hostSelector;
							var hostRx = new RegExp(StyleUtil.rx.HOST_PREFIX + rxHostSelector + StyleUtil.rx.HOST_SUFFIX);
							var rules = _styleInfo2.default.get(element).styleRules;
							var keyframeTransforms = this._elementKeyframeTransforms(element, rules, scopeSelector);
							return _styleTransformer2.default.elementStyles(element, rules, function (rule) {
								self.applyProperties(rule, properties);
								if (!_styleSettings.nativeShadow && !StyleUtil.isKeyframesSelector(rule) && rule.cssText) {
									// NOTE: keyframe transforms only scope munge animation names, so it
									// is not necessary to apply them in ShadowDOM.
									self.applyKeyframeTransforms(rule, keyframeTransforms);
									self._scopeSelector(rule, hostRx, hostSelector, scopeSelector);
								}
							});
						}
					}, {
						key: '_elementKeyframeTransforms',
						value: function _elementKeyframeTransforms(element, rules, scopeSelector) {
							var keyframesRules = rules._keyframes;
							var keyframeTransforms = {};
							if (!_styleSettings.nativeShadow && keyframesRules) {
								// For non-ShadowDOM, we transform all known keyframes rules in
								// advance for the current scope. This allows us to catch keyframes
								// rules that appear anywhere in the stylesheet:
								for (var i = 0, keyframesRule = keyframesRules[i]; i < keyframesRules.length; keyframesRule = keyframesRules[++i]) {
									this._scopeKeyframes(keyframesRule, scopeSelector);
									keyframeTransforms[keyframesRule.keyframesName] = this._keyframesRuleTransformer(keyframesRule);
								}
							}
							return keyframeTransforms;
						}

						// Generate a factory for transforming a chunk of CSS text to handle a
						// particular scoped keyframes rule.

					}, {
						key: '_keyframesRuleTransformer',
						value: function _keyframesRuleTransformer(keyframesRule) {
							return function (cssText) {
								return cssText.replace(keyframesRule.keyframesNameRx, keyframesRule.transformedKeyframesName);
							};
						}

						// Transforms `@keyframes` names to be unique for the current host.
						// Example: @keyframes foo-anim -> @keyframes foo-anim-x-foo-0

					}, {
						key: '_scopeKeyframes',
						value: function _scopeKeyframes(rule, scopeId) {
							rule.keyframesNameRx = new RegExp(rule.keyframesName, 'g');
							rule.transformedKeyframesName = rule.keyframesName + '-' + scopeId;
							rule.transformedSelector = rule.transformedSelector || rule.selector;
							rule.selector = rule.transformedSelector.replace(rule.keyframesName, rule.transformedKeyframesName);
						}

						// Strategy: x scope shim a selector e.g. to scope `.x-foo-42` (via classes):
						// non-host selector: .a.x-foo -> .x-foo-42 .a.x-foo
						// host selector: x-foo.wide -> .x-foo-42.wide
						// note: we use only the scope class (.x-foo-42) and not the hostSelector
						// (x-foo) to scope :host rules; this helps make property host rules
						// have low specificity. They are overrideable by class selectors but,
						// unfortunately, not by type selectors (e.g. overriding via
						// `.special` is ok, but not by `x-foo`).

					}, {
						key: '_scopeSelector',
						value: function _scopeSelector(rule, hostRx, hostSelector, scopeId) {
							rule.transformedSelector = rule.transformedSelector || rule.selector;
							var selector = rule.transformedSelector;
							var scope = '.' + scopeId;
							var parts = selector.split(',');
							for (var i = 0, l = parts.length, _p2; i < l && (_p2 = parts[i]); i++) {
								parts[i] = _p2.match(hostRx) ? _p2.replace(hostSelector, scope) : scope + ' ' + _p2;
							}
							rule.selector = parts.join(',');
						}
					}, {
						key: 'applyElementScopeSelector',
						value: function applyElementScopeSelector(element, selector, old) {
							var c = element.getAttribute('class') || '';
							var v = c;
							if (old) {
								v = c.replace(new RegExp('\\s*' + XSCOPE_NAME + '\\s*' + old + '\\s*', 'g'), ' ');
							}
							v += (v ? ' ' : '') + XSCOPE_NAME + ' ' + selector;
							if (c !== v) {
								StyleUtil.setElementClassRaw(element, v);
							}
						}
					}, {
						key: 'applyElementStyle',
						value: function applyElementStyle(element, properties, selector, style) {
							// calculate cssText to apply
							var cssText = style ? style.textContent || '' : this.transformStyles(element, properties, selector);
							// if shady and we have a cached style that is not style, decrement
							var styleInfo = _styleInfo2.default.get(element);
							var s = styleInfo.customStyle;
							if (s && !_styleSettings.nativeShadow && s !== style) {
								s._useCount--;
								if (s._useCount <= 0 && s.parentNode) {
									s.parentNode.removeChild(s);
								}
							}
							// apply styling always under native or if we generated style
							// or the cached style is not in document(!)
							if (_styleSettings.nativeShadow) {
								// update existing style only under native
								if (styleInfo.customStyle) {
									styleInfo.customStyle.textContent = cssText;
									style = styleInfo.customStyle;
									// otherwise, if we have css to apply, do so
								} else if (cssText) {
									// apply css after the scope style of the element to help with
									// style precedence rules.
									style = StyleUtil.applyCss(cssText, selector, element.shadowRoot, styleInfo.placeholder);
								}
							} else {
								// shady and no cache hit
								if (!style) {
									// apply css after the scope style of the element to help with
									// style precedence rules.
									if (cssText) {
										style = StyleUtil.applyCss(cssText, selector, null, styleInfo.placeholder);
									}
									// shady and cache hit but not in document
								} else if (!style.parentNode) {
									StyleUtil.applyStyle(style, null, styleInfo.placeholder);
								}
							}
							// ensure this style is our custom style and increment its use count.
							if (style) {
								style._useCount = style._useCount || 0;
								// increment use count if we changed styles
								if (styleInfo.customStyle != style) {
									style._useCount++;
								}
								styleInfo.customStyle = style;
							}
							// @media rules may be stale in IE 10 and 11
							if (IS_IE) {
								style.textContent = style.textContent;
							}
							return style;
						}
					}, {
						key: 'applyCustomStyle',
						value: function applyCustomStyle(style, properties) {
							var rules = StyleUtil.rulesForStyle(style);
							var self = this;
							style.textContent = StyleUtil.toCssText(rules, function (rule) {
								var css = rule.cssText = rule.parsedCssText;
								if (rule.propertyInfo && rule.propertyInfo.cssText) {
									// remove property assignments
									// so next function isn't confused
									// NOTE: we have 3 categories of css:
									// (1) normal properties,
									// (2) custom property assignments (--foo: red;),
									// (3) custom property usage: border: var(--foo); @apply(--foo);
									// In elements, 1 and 3 are separated for efficiency; here they
									// are not and this makes this case unique.
									css = (0, _cssParse.removeCustomPropAssignment)(css);
									// replace with reified properties, scenario is same as mixin
									rule.cssText = self.valueForProperties(css, properties);
								}
							});
						}
					}, {
						key: 'XSCOPE_NAME',
						get: function get() {
							return XSCOPE_NAME;
						}
					}]);

					return StyleProperties;
				}();

				function addToBitMask(n, bits) {
					var o = parseInt(n / 32);
					var v = 1 << n % 32;
					bits[o] = (bits[o] || 0) | v;
				}

				exports.default = new StyleProperties();

				/***/ },
			/* 74 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _templateMap = __webpack_require__(75);

				var _templateMap2 = _interopRequireDefault(_templateMap);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var promise = Promise.resolve();

				var StyleInfo = function () {
					_createClass(StyleInfo, null, [{
						key: 'get',
						value: function get(node) {
							return node.__styleInfo;
						}
					}, {
						key: 'set',
						value: function set(node, styleInfo) {
							node.__styleInfo = styleInfo;
							return styleInfo;
						}
					}, {
						key: 'invalidate',
						value: function invalidate(elementName) {
							if (_templateMap2.default[elementName]) {
								_templateMap2.default[elementName]._applyShimInvalid = true;
							}
						}
						/*
						 the template is marked as `validating` for one microtask so that all instances
						 found in the tree crawl of `applyStyle` will update themselves,
						 but the template will only be updated once.
						 */

					}, {
						key: 'startValidating',
						value: function startValidating(elementName) {
							var template = _templateMap2.default[elementName];
							if (!template._validating) {
								template._validating = true;
								promise.then(function () {
									template._applyShimInvalid = false;
									template._validating = false;
								});
							}
						}
					}]);

					function StyleInfo(ast, placeholder, ownStylePropertyNames, elementName, typeExtension, cssBuild) {
						_classCallCheck(this, StyleInfo);

						this.styleRules = ast || null;
						this.placeholder = placeholder || null;
						this.ownStylePropertyNames = ownStylePropertyNames || [];
						this.overrideStyleProperties = null;
						this.elementName = elementName || '';
						this.cssBuild = cssBuild || '';
						this.typeExtension = typeExtension || '';
						this.styleProperties = null;
						this.scopeSelector = null;
						this.customStyle = null;
					}

					return StyleInfo;
				}();

				exports.default = StyleInfo;

				/***/ },
			/* 75 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.default = {};

				/***/ },
			/* 76 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _styleUtil = __webpack_require__(72);

				var _styleSettings = __webpack_require__(70);

				var placeholderMap = {};

				var ce = window.customElements;
				if (ce && !_styleSettings.nativeShadow) {
					(function () {
						var origDefine = ce.define;
						ce.define = function (name, clazz, options) {
							placeholderMap[name] = (0, _styleUtil.applyStylePlaceHolder)(name);
							return origDefine.call(ce, name, clazz, options);
						};
					})();
				}

				exports.default = placeholderMap;

				/***/ },
			/* 77 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */
				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var StyleCache = function () {
					function StyleCache() {
						var typeMax = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 100;

						_classCallCheck(this, StyleCache);

						// map element name -> [{properties, styleElement, scopeSelector}]
						this.cache = {};
						this.typeMax = typeMax;
					}

					_createClass(StyleCache, [{
						key: '_validate',
						value: function _validate(cacheEntry, properties, ownPropertyNames) {
							for (var idx = 0; idx < ownPropertyNames.length; idx++) {
								var pn = ownPropertyNames[idx];
								if (cacheEntry.properties[pn] !== properties[pn]) {
									return false;
								}
							}
							return true;
						}
					}, {
						key: 'store',
						value: function store(tagname, properties, styleElement, scopeSelector) {
							var list = this.cache[tagname] || [];
							list.push({ properties: properties, styleElement: styleElement, scopeSelector: scopeSelector });
							if (list.length > this.typeMax) {
								list.shift();
							}
							this.cache[tagname] = list;
						}
					}, {
						key: 'fetch',
						value: function fetch(tagname, properties, ownPropertyNames) {
							var list = this.cache[tagname];
							if (!list) {
								return;
							}
							// reverse list for most-recent lookups
							for (var idx = list.length - 1; idx >= 0; idx--) {
								var entry = list[idx];
								if (this._validate(entry, properties, ownPropertyNames)) {
									return entry;
								}
							}
						}
					}]);

					return StyleCache;
				}();

				exports.default = StyleCache;

				/***/ },
			/* 78 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */
				/**
				 * The apply shim simulates the behavior of `@apply` proposed at
				 * https://tabatkins.github.io/specs/css-apply-rule/.
				 * The approach is to convert a property like this:
				 *
				 *    --foo: {color: red; background: blue;}
				 *
				 * to this:
				 *
				 *    --foo_-_color: red;
				 *    --foo_-_background: blue;
				 *
				 * Then where `@apply --foo` is used, that is converted to:
				 *
				 *    color: var(--foo_-_color);
				 *    background: var(--foo_-_background);
				 *
				 * This approach generally works but there are some issues and limitations.
				 * Consider, for example, that somewhere *between* where `--foo` is set and used,
				 * another element sets it to:
				 *
				 *    --foo: { border: 2px solid red; }
				 *
				 * We must now ensure that the color and background from the previous setting
				 * do not apply. This is accomplished by changing the property set to this:
				 *
				 *    --foo_-_border: 2px solid red;
				 *    --foo_-_color: initial;
				 *    --foo_-_background: initial;
				 *
				 * This works but introduces one new issue.
				 * Consider this setup at the point where the `@apply` is used:
				 *
				 *    background: orange;
				 *    @apply --foo;
				 *
				 * In this case the background will be unset (initial) rather than the desired
				 * `orange`. We address this by altering the property set to use a fallback
				 * value like this:
				 *
				 *    color: var(--foo_-_color);
				 *    background: var(--foo_-_background, orange);
				 *    border: var(--foo_-_border);
				 *
				 * Note that the default is retained in the property set and the `background` is
				 * the desired `orange`. This leads us to a limitation.
				 *
				 * Limitation 1:

				 * Only properties in the rule where the `@apply`
				 * is used are considered as default values.
				 * If another rule matches the element and sets `background` with
				 * less specificity than the rule in which `@apply` appears,
				 * the `background` will not be set.
				 *
				 * Limitation 2:
				 *
				 * When using Polymer's `updateStyles` api, new properties may not be set for
				 * `@apply` properties.

				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				var _styleUtil = __webpack_require__(72);

				var _templateMap = __webpack_require__(75);

				var _templateMap2 = _interopRequireDefault(_templateMap);

				var _styleInfo = __webpack_require__(74);

				var _styleInfo2 = _interopRequireDefault(_styleInfo);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				var MIXIN_MATCH = _styleUtil.rx.MIXIN_MATCH;
				var VAR_ASSIGN = _styleUtil.rx.VAR_ASSIGN;

				var APPLY_NAME_CLEAN = /;\s*/m;
				var INITIAL_INHERIT = /^\s*(initial)|(inherit)\s*$/;

				// separator used between mixin-name and mixin-property-name when producing properties
				// NOTE: plain '-' may cause collisions in user styles
				var MIXIN_VAR_SEP = '_-_';

				// map of mixin to property names
				// --foo: {border: 2px} -> {properties: {(--foo, ['border'])}, dependants: {'element-name': proto}}

				var MixinMap = function () {
					function MixinMap() {
						_classCallCheck(this, MixinMap);

						this._map = {};
					}

					_createClass(MixinMap, [{
						key: 'set',
						value: function set(name, props) {
							name = name.trim();
							this._map[name] = {
								properties: props,
								dependants: {}
							};
						}
					}, {
						key: 'get',
						value: function get(name) {
							name = name.trim();
							return this._map[name];
						}
					}]);

					return MixinMap;
				}();

				var ApplyShim = function () {
					function ApplyShim() {
						var _this = this;

						_classCallCheck(this, ApplyShim);

						this._currentTemplate = null;
						this._measureElement = null;
						this._map = new MixinMap();
						this._separator = MIXIN_VAR_SEP;
						this._boundProduceCssProperties = function (matchText, propertyName, valueProperty, valueMixin) {
							return _this._produceCssProperties(matchText, propertyName, valueProperty, valueMixin);
						};
					}
					// return true if `cssText` contains a mixin definition or consumption


					_createClass(ApplyShim, [{
						key: 'detectMixin',
						value: function detectMixin(cssText) {
							var has = MIXIN_MATCH.test(cssText) || VAR_ASSIGN.test(cssText);
							// reset state of the regexes
							MIXIN_MATCH.lastIndex = 0;
							VAR_ASSIGN.lastIndex = 0;
							return has;
						}
					}, {
						key: 'transformStyle',
						value: function transformStyle(style, elementName) {
							var ast = (0, _styleUtil.rulesForStyle)(style);
							this.transformRules(ast, elementName);
							return ast;
						}
					}, {
						key: 'transformRules',
						value: function transformRules(rules, elementName) {
							var _this2 = this;

							this._currentTemplate = _templateMap2.default[elementName];
							(0, _styleUtil.forEachRule)(rules, function (r) {
								_this2.transformRule(r);
							});
							this._currentTemplate = null;
						}
					}, {
						key: 'transformRule',
						value: function transformRule(rule) {
							rule.cssText = this.transformCssText(rule.parsedCssText);
							// :root was only used for variable assignment in property shim,
							// but generates invalid selectors with real properties.
							// replace with `:host > *`, which serves the same effect
							if (rule.selector === ':root') {
								rule.selector = ':host > *';
							}
						}
					}, {
						key: 'transformCssText',
						value: function transformCssText(cssText) {
							// produce variables
							cssText = cssText.replace(VAR_ASSIGN, this._boundProduceCssProperties);
							// consume mixins
							return this._consumeCssProperties(cssText);
						}
					}, {
						key: '_getInitialValueForProperty',
						value: function _getInitialValueForProperty(property) {
							if (!this._measureElement) {
								this._measureElement = document.createElement('meta');
								this._measureElement.style.all = 'initial';
								document.head.appendChild(this._measureElement);
							}
							return window.getComputedStyle(this._measureElement).getPropertyValue(property);
						}
						// replace mixin consumption with variable consumption

					}, {
						key: '_consumeCssProperties',
						value: function _consumeCssProperties(text) {
							var m = void 0;
							// loop over text until all mixins with defintions have been applied
							while (m = MIXIN_MATCH.exec(text)) {
								var matchText = m[0];
								var mixinName = m[1];
								var idx = m.index;
								// collect properties before apply to be "defaults" if mixin might override them
								// match includes a "prefix", so find the start and end positions of @apply
								var applyPos = idx + matchText.indexOf('@apply');
								var afterApplyPos = idx + matchText.length;
								// find props defined before this @apply
								var textBeforeApply = text.slice(0, applyPos);
								var textAfterApply = text.slice(afterApplyPos);
								var defaults = this._cssTextToMap(textBeforeApply);
								var replacement = this._atApplyToCssProperties(mixinName, defaults);
								// use regex match position to replace mixin, keep linear processing time
								text = [textBeforeApply, replacement, textAfterApply].join('');
								// move regex search to _after_ replacement
								MIXIN_MATCH.lastIndex = idx + replacement.length;
							}
							return text;
						}
						// produce variable consumption at the site of mixin consumption
						// @apply --foo; -> for all props (${propname}: var(--foo_-_${propname}, ${fallback[propname]}}))
						// Example:
						// border: var(--foo_-_border); padding: var(--foo_-_padding, 2px)

					}, {
						key: '_atApplyToCssProperties',
						value: function _atApplyToCssProperties(mixinName, fallbacks) {
							mixinName = mixinName.replace(APPLY_NAME_CLEAN, '');
							var vars = [];
							var mixinEntry = this._map.get(mixinName);
							// if we depend on a mixin before it is created
							// make a sentinel entry in the map to add this element as a dependency for when it is defined.
							if (!mixinEntry) {
								this._map.set(mixinName, {});
								mixinEntry = this._map.get(mixinName);
							}
							if (mixinEntry) {
								if (this._currentTemplate) {
									mixinEntry.dependants[this._currentTemplate.name] = this._currentTemplate;
								}
								var p = void 0,
									parts = void 0,
									f = void 0;
								for (p in mixinEntry.properties) {
									f = fallbacks && fallbacks[p];
									parts = [p, ': var(', mixinName, MIXIN_VAR_SEP, p];
									if (f) {
										parts.push(',', f);
									}
									parts.push(')');
									vars.push(parts.join(''));
								}
							}
							return vars.join('; ');
						}
					}, {
						key: '_replaceInitialOrInherit',
						value: function _replaceInitialOrInherit(property, value) {
							var match = INITIAL_INHERIT.exec(value);
							if (match) {
								if (match[1]) {
									// initial
									// replace `initial` with the concrete initial value for this property
									value = ApplyShim._getInitialValueForProperty(property);
								} else {
									// inherit
									// with this purposfully illegal value, the variable will be invalid at
									// compute time (https://www.w3.org/TR/css-variables/#invalid-at-computed-value-time)
									// and for inheriting values, will behave similarly
									// we cannot support the same behavior for non inheriting values like 'border'
									value = 'apply-shim-inherit';
								}
							}
							return value;
						}

						// "parse" a mixin definition into a map of properties and values
						// cssTextToMap('border: 2px solid black') -> ('border', '2px solid black')

					}, {
						key: '_cssTextToMap',
						value: function _cssTextToMap(text) {
							var props = text.split(';');
							var property = void 0,
								value = void 0;
							var out = {};
							for (var i = 0, p, sp; i < props.length; i++) {
								p = props[i];
								if (p) {
									sp = p.split(':');
									// ignore lines that aren't definitions like @media
									if (sp.length > 1) {
										property = sp[0].trim();
										// some properties may have ':' in the value, like data urls
										value = this._replaceInitialOrInherit(property, sp.slice(1).join(':'));
										out[property] = value;
									}
								}
							}
							return out;
						}
					}, {
						key: '_invalidateMixinEntry',
						value: function _invalidateMixinEntry(mixinEntry) {
							for (var elementName in mixinEntry.dependants) {
								if (!this._currentTemplate || elementName !== this._currentTemplate.name) {
									_styleInfo2.default.invalidate(elementName);
								}
							}
						}
					}, {
						key: '_produceCssProperties',
						value: function _produceCssProperties(matchText, propertyName, valueProperty, valueMixin) {
							var _this3 = this;

							// handle case where property value is a mixin
							if (valueProperty) {
								// form: --mixin2: var(--mixin1), where --mixin1 is in the map
								(0, _styleUtil.processVariableAndFallback)(valueProperty, function (prefix, value) {
									if (value && _this3._map.get(value)) {
										valueMixin = '@apply ' + value + ';';
									}
								});
							}
							if (!valueMixin) {
								return matchText;
							}
							var mixinAsProperties = this._consumeCssProperties(valueMixin);
							var prefix = matchText.slice(0, matchText.indexOf('--'));
							var mixinValues = this._cssTextToMap(mixinAsProperties);
							var combinedProps = mixinValues;
							var mixinEntry = this._map.get(propertyName);
							var oldProps = mixinEntry && mixinEntry.properties;
							if (oldProps) {
								// NOTE: since we use mixin, the map of properties is updated here
								// and this is what we want.
								combinedProps = Object.assign(Object.create(oldProps), mixinValues);
							} else {
								this._map.set(propertyName, combinedProps);
							}
							var out = [];
							var p = void 0,
								v = void 0;
							// set variables defined by current mixin
							var needToInvalidate = false;
							for (p in combinedProps) {
								v = mixinValues[p];
								// if property not defined by current mixin, set initial
								if (v === undefined) {
									v = 'initial';
								}
								if (oldProps && !(p in oldProps)) {
									needToInvalidate = true;
								}
								out.push(propertyName + MIXIN_VAR_SEP + p + ': ' + v);
							}
							if (needToInvalidate) {
								this._invalidateMixinEntry(mixinEntry);
							}
							if (mixinEntry) {
								mixinEntry.properties = combinedProps;
							}
							// because the mixinMap is global, the mixin might conflict with
							// a different scope's simple variable definition:
							// Example:
							// some style somewhere:
							// --mixin1:{ ... }
							// --mixin2: var(--mixin1);
							// some other element:
							// --mixin1: 10px solid red;
							// --foo: var(--mixin1);
							// In this case, we leave the original variable definition in place.
							if (valueProperty) {
								prefix = matchText + ';' + prefix;
							}
							return prefix + out.join('; ') + ';';
						}
					}]);

					return ApplyShim;
				}();

				var applyShim = new ApplyShim();
				window['ApplyShim'] = applyShim;
				exports.default = applyShim;

				/***/ },
			/* 79 */
			/***/ function(module, exports, __webpack_require__) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				'use strict';

				Object.defineProperty(exports, "__esModule", {
					value: true
				});
				exports.flush = undefined;

				var _styleSettings = __webpack_require__(70);

				var _styleTransformer = __webpack_require__(71);

				var _styleTransformer2 = _interopRequireDefault(_styleTransformer);

				function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

				var flush = exports.flush = function flush() {};

				if (!_styleSettings.nativeShadow) {
					(function () {
						var elementNeedsScoping = function elementNeedsScoping(element) {
							return element.classList && !element.classList.contains(_styleTransformer2.default.SCOPE_NAME) ||
								// note: necessary for IE11
								element instanceof SVGElement && (!element.hasAttribute('class') || element.getAttribute('class').indexOf(_styleTransformer2.default.SCOPE_NAME) < 0);
						};

						var handler = function handler(mxns) {
							for (var x = 0; x < mxns.length; x++) {
								var mxn = mxns[x];
								if (mxn.target === document.documentElement || mxn.target === document.head) {
									continue;
								}
								for (var i = 0; i < mxn.addedNodes.length; i++) {
									var n = mxn.addedNodes[i];
									if (elementNeedsScoping(n)) {
										var root = n.getRootNode();
										if (root.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
											// may no longer be in a shadowroot
											var host = root.host;
											if (host) {
												var scope = host.is || host.localName;
												_styleTransformer2.default.dom(n, scope);
											}
										}
									}
								}
								for (var _i = 0; _i < mxn.removedNodes.length; _i++) {
									var _n = mxn.removedNodes[_i];
									if (_n.nodeType === Node.ELEMENT_NODE) {
										var classes = undefined;
										if (_n.classList) {
											classes = Array.from(_n.classList);
										} else if (_n.hasAttribute('class')) {
											classes = _n.getAttribute('class').split(/\s+/);
										}
										if (classes !== undefined) {
											// NOTE: relies on the scoping class always being adjacent to the
											// SCOPE_NAME class.
											var classIdx = classes.indexOf(_styleTransformer2.default.SCOPE_NAME);
											if (classIdx >= 0) {
												var _scope = classes[classIdx + 1];
												if (_scope) {
													_styleTransformer2.default.dom(_n, _scope, true);
												}
											}
										}
									}
								}
							}
						};

						var observer = new MutationObserver(handler);
						var start = function start(node) {
							observer.observe(node, { childList: true, subtree: true });
						};
						var nativeCustomElements = window.customElements && !window.customElements.flush;
						// need to start immediately with native custom elements
						// TODO(dfreedm): with polyfilled HTMLImports and native custom elements
						// excessive mutations may be observed; this can be optimized via cooperation
						// with the HTMLImports polyfill.
						if (nativeCustomElements) {
							start(document);
						} else {
							(function () {
								var delayedStart = function delayedStart() {
									start(document.body);
								};
								// use polyfill timing if it's available
								if (window.HTMLImports) {
									window.HTMLImports.whenReady(delayedStart);
									// otherwise push beyond native imports being ready
									// which requires RAF + readystate interactive.
								} else {
									requestAnimationFrame(function () {
										if (document.readyState === 'loading') {
											(function () {
												var listener = function listener() {
													delayedStart();
													document.removeEventListener('readystatechange', listener);
												};
												document.addEventListener('readystatechange', listener);
											})();
										} else {
											delayedStart();
										}
									});
								}
							})();
						}

						exports.flush = flush = function flush() {
							handler(observer.takeRecords());
						};
					})();
				}

				/***/ },
			/* 80 */
			/***/ function(module, exports) {

				/**
				 @license
				 Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
				 This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
				 The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
				 The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
				 Code distributed by Google as part of the polymer project is also
				 subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
				 */

				/*
				 Wrapper over <style> elements to co-operate with ShadyCSS

				 Example:
				 <custom-style>
				 <style>
				 ...
				 </style>
				 </custom-style>
				 */

				'use strict';

				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

				function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

				function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

				var ShadyCSS = window.ShadyCSS;

				var enqueued = false;

				var customStyles = [];

				var hookFn = null;

				/*
				 If a page only has <custom-style> elements, it will flash unstyled content,
				 as all the instances will boot asynchronously after page load.

				 Calling ShadyCSS.updateStyles() will force the work to happen synchronously
				 */
				function enqueueDocumentValidation() {
					if (enqueued) {
						return;
					}
					enqueued = true;
					if (window.HTMLImports) {
						window.HTMLImports.whenReady(validateDocument);
					} else if (document.readyState === 'complete') {
						validateDocument();
					} else {
						document.addEventListener('readystatechange', function () {
							if (document.readyState === 'complete') {
								validateDocument();
							}
						});
					}
				}

				function validateDocument() {
					requestAnimationFrame(function () {
						if (enqueued || ShadyCSS._elementsHaveApplied) {
							ShadyCSS.updateStyles();
						}
						enqueued = false;
					});
				}

				var CustomStyle = function (_HTMLElement) {
					_inherits(CustomStyle, _HTMLElement);

					_createClass(CustomStyle, null, [{
						key: 'findStyles',
						value: function findStyles() {
							for (var i = 0; i < customStyles.length; i++) {
								var c = customStyles[i];
								if (!c._style) {
									var style = c.querySelector('style');
									if (!style) {
										continue;
									}
									// HTMLImports polyfill may have cloned the style into the main document,
									// which is referenced with __appliedElement.
									// Also, we must copy over the attributes.
									if (style.__appliedElement) {
										for (var _i = 0; _i < style.attributes.length; _i++) {
											var attr = style.attributes[_i];
											style.__appliedElement.setAttribute(attr.name, attr.value);
										}
									}
									c._style = style.__appliedElement || style;
									if (hookFn) {
										hookFn(c._style);
									}
									ShadyCSS._transformCustomStyleForDocument(c._style);
								}
							}
						}
					}, {
						key: '_revalidateApplyShim',
						value: function _revalidateApplyShim() {
							for (var i = 0; i < customStyles.length; i++) {
								var c = customStyles[i];
								if (c._style) {
									ShadyCSS._revalidateApplyShim(c._style);
								}
							}
						}
					}, {
						key: 'applyStyles',
						value: function applyStyles() {
							for (var i = 0; i < customStyles.length; i++) {
								var c = customStyles[i];
								if (c._style) {
									ShadyCSS._applyCustomStyleToDocument(c._style);
								}
							}
							enqueued = false;
						}
					}, {
						key: '_customStyles',
						get: function get() {
							return customStyles;
						}
					}, {
						key: 'processHook',
						get: function get() {
							return hookFn;
						},
						set: function set(fn) {
							hookFn = fn;
						}
					}, {
						key: '_documentDirty',
						get: function get() {
							return enqueued;
						}
					}]);

					function CustomStyle() {
						_classCallCheck(this, CustomStyle);

						var _this = _possibleConstructorReturn(this, (CustomStyle.__proto__ || Object.getPrototypeOf(CustomStyle)).call(this));

						customStyles.push(_this);
						enqueueDocumentValidation();
						return _this;
					}

					return CustomStyle;
				}(HTMLElement);

				window['CustomStyle'] = CustomStyle;
				window.customElements.define('custom-style', CustomStyle);

				/***/ }
			/******/ ])
	});
	;

},{}],2:[function(require,module,exports){
	(function webpackUniversalModuleDefinition(root, factory) {
		if(typeof exports === 'object' && typeof module === 'object')
			module.exports = factory(require("incremental-dom"));
		else if(typeof define === 'function' && define.amd)
			define(["incremental-dom"], factory);
		else if(typeof exports === 'object')
			exports["skate"] = factory(require("incremental-dom"));
		else
			root["skate"] = factory(root["IncrementalDOM"]);
	})(this, function(__WEBPACK_EXTERNAL_MODULE_14__) {
		return /******/ (function(modules) { // webpackBootstrap
			/******/ 	// The module cache
			/******/ 	var installedModules = {};

			/******/ 	// The require function
			/******/ 	function __webpack_require__(moduleId) {

				/******/ 		// Check if module is in cache
				/******/ 		if(installedModules[moduleId])
				/******/ 			return installedModules[moduleId].exports;

				/******/ 		// Create a new module (and put it into the cache)
				/******/ 		var module = installedModules[moduleId] = {
					/******/ 			i: moduleId,
					/******/ 			l: false,
					/******/ 			exports: {}
					/******/ 		};

				/******/ 		// Execute the module function
				/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

				/******/ 		// Flag the module as loaded
				/******/ 		module.l = true;

				/******/ 		// Return the exports of the module
				/******/ 		return module.exports;
				/******/ 	}


			/******/ 	// expose the modules object (__webpack_modules__)
			/******/ 	__webpack_require__.m = modules;

			/******/ 	// expose the module cache
			/******/ 	__webpack_require__.c = installedModules;

			/******/ 	// identity function for calling harmony imports with the correct context
			/******/ 	__webpack_require__.i = function(value) { return value; };

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

			/******/ 	// getDefaultExport function for compatibility with non-harmony modules
			/******/ 	__webpack_require__.n = function(module) {
				/******/ 		var getter = module && module.__esModule ?
					/******/ 			function getDefault() { return module['default']; } :
					/******/ 			function getModuleExports() { return module; };
				/******/ 		__webpack_require__.d(getter, 'a', getter);
				/******/ 		return getter;
				/******/ 	};

			/******/ 	// Object.prototype.hasOwnProperty.call
			/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

			/******/ 	// __webpack_public_path__
			/******/ 	__webpack_require__.p = "";

			/******/ 	// Load entry module and return exports
			/******/ 	return __webpack_require__(__webpack_require__.s = 38);
			/******/ })
		/************************************************************************/
		/******/ ([
			/* 0 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return connected; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return created; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return name; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return ctorCreateInitProps; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return ctorObservedAttributes; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return ctorProps; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return ctorPropsMap; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return props; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ref; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return renderer; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return rendering; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return rendererDebounced; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return updated; });
				var connected = '____skate_connected';
				var created = '____skate_created';

// DEPRECATED
//
// This is the only "symbol" that must stay a string. This is because it is
// relied upon across several versions. We should remove it, but ensure that
// it's considered a breaking change that whatever version removes it cannot
// be passed to vdom functions as tag names.
				var name = '____skate_name';

// Used on the Constructor
				var ctorCreateInitProps = '____skate_ctor_createInitProps';
				var ctorObservedAttributes = '____skate_ctor_observedAttributes';
				var ctorProps = '____skate_ctor_props';
				var ctorPropsMap = '____skate_ctor_propsMap';

// Used on the Element
				var props = '____skate_props';
				var ref = '____skate_ref';
				var renderer = '____skate_renderer';
				var rendering = '____skate_rendering';
				var rendererDebounced = '____skate_rendererDebounced';
				var updated = '____skate_updated';

				/***/ }),
			/* 1 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__is_type__ = __webpack_require__(2);
				/* harmony export (immutable) */ __webpack_exports__["a"] = getPropNamesAndSymbols;

				/**
				 * Returns array of owned property names and symbols for the given object
				 */
				function getPropNamesAndSymbols() {
					var obj = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

					var listOfKeys = Object.getOwnPropertyNames(obj);
					return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__is_type__["a" /* isFunction */])(Object.getOwnPropertySymbols) ? listOfKeys.concat(Object.getOwnPropertySymbols(obj)) : listOfKeys;
				}

				/***/ }),
			/* 2 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return isFunction; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return isObject; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return isString; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return isSymbol; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return isUndefined; });
				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				var isFunction = function isFunction(val) {
					return typeof val === 'function';
				};
				var isObject = function isObject(val) {
					return (typeof val === 'undefined' ? 'undefined' : _typeof(val)) === 'object' && val !== null;
				};
				var isString = function isString(val) {
					return typeof val === 'string';
				};
				var isSymbol = function isSymbol(val) {
					return (typeof val === 'undefined' ? 'undefined' : _typeof(val)) === 'symbol';
				};
				var isUndefined = function isUndefined(val) {
					return typeof val === 'undefined';
				};

				/***/ }),
			/* 3 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* WEBPACK VAR INJECTION */(function(global) {/* harmony default export */ __webpack_exports__["a"] = typeof window === 'undefined' ? global : window;
					/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(37)))

				/***/ }),
			/* 4 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__get_prop_names_and_symbols__ = __webpack_require__(1);


// We are not using Object.assign if it is defined since it will cause problems when Symbol is polyfilled.
// Apparently Object.assign (or any polyfill for this method) does not copy non-native Symbols.
				/* harmony default export */ __webpack_exports__["a"] = function (obj) {
					for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
						args[_key - 1] = arguments[_key];
					}

					args.forEach(function (arg) {
						return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__get_prop_names_and_symbols__["a" /* default */])(arg).forEach(function (nameOrSymbol) {
							return obj[nameOrSymbol] = arg[nameOrSymbol];
						});
					}); // eslint-disable-line no-return-assign
					return obj;
				};

				/***/ }),
			/* 5 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony default export */ __webpack_exports__["a"] = function (element) {
					var namespace = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

					var data = element.__SKATE_DATA || (element.__SKATE_DATA = {});
					return namespace && (data[namespace] || (data[namespace] = {})) || data; // eslint-disable-line no-mixed-operators
				};

				/***/ }),
			/* 6 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony default export */ __webpack_exports__["a"] = function (val) {
					return typeof val === 'undefined' || val === null;
				};

				/***/ }),
			/* 7 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util_symbols__ = __webpack_require__(0);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_assign__ = __webpack_require__(4);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util_get_prop_names_and_symbols__ = __webpack_require__(1);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__util_get_props_map__ = __webpack_require__(10);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__util_is_type__ = __webpack_require__(2);






				function get(elem) {
					var props = {};

					__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_get_prop_names_and_symbols__["a" /* default */])(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__util_get_props_map__["a" /* default */])(elem.constructor)).forEach(function (nameOrSymbol) {
						props[nameOrSymbol] = elem[nameOrSymbol];
					});

					return props;
				}

				function set(elem, newProps) {
					__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_assign__["a" /* default */])(elem, newProps);
					if (elem[__WEBPACK_IMPORTED_MODULE_0__util_symbols__["d" /* renderer */]]) {
						elem[__WEBPACK_IMPORTED_MODULE_0__util_symbols__["d" /* renderer */]]();
					}
				}

				/* harmony default export */ __webpack_exports__["a"] = function (elem, newProps) {
					return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4__util_is_type__["b" /* isUndefined */])(newProps) ? get(elem) : set(elem, newProps);
				};

				/***/ }),
			/* 8 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* WEBPACK VAR INJECTION */(function(process) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_incremental_dom__ = __webpack_require__(14);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_incremental_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_symbols__ = __webpack_require__(0);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util_assign__ = __webpack_require__(4);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__util_create_symbol__ = __webpack_require__(25);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__util_data__ = __webpack_require__(5);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__util_debounce__ = __webpack_require__(27);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__util_attributes_manager__ = __webpack_require__(9);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__util_get_own_property_descriptors__ = __webpack_require__(31);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__util_get_prop_names_and_symbols__ = __webpack_require__(1);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__util_get_props_map__ = __webpack_require__(10);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__props__ = __webpack_require__(7);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__lifecycle_props_init__ = __webpack_require__(23);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__util_is_type__ = __webpack_require__(2);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__polyfills_object_is__ = __webpack_require__(24);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__util_set_ctor_native_property__ = __webpack_require__(11);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__util_root__ = __webpack_require__(3);
					var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

					var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

					function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

					function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

					function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


















					var HTMLElement = __WEBPACK_IMPORTED_MODULE_15__util_root__["a" /* default */].HTMLElement || function () {
							function _class() {
								_classCallCheck(this, _class);
							}

							return _class;
						}();
					var _prevName = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__util_create_symbol__["a" /* default */])('prevName');
					var _prevOldValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__util_create_symbol__["a" /* default */])('prevOldValue');
					var _prevNewValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__util_create_symbol__["a" /* default */])('prevNewValue');

// TEMPORARY: Once deprecations in this file are removed, this can be removed.
					function deprecated(elem, oldUsage, newUsage) {
						if (process.env.NODE_ENV !== 'production') {
							var ownerName = elem.localName ? elem.localName : String(elem);
							console.warn(ownerName + ' ' + oldUsage + ' is deprecated. Use ' + newUsage + '.');
						}
					}

					function preventDoubleCalling(elem, name, oldValue, newValue) {
						return name === elem[_prevName] && oldValue === elem[_prevOldValue] && newValue === elem[_prevNewValue];
					}

// TODO remove when not catering to Safari < 10.
					function createNativePropertyDescriptors(Ctor) {
						var propDefs = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_9__util_get_props_map__["a" /* default */])(Ctor);
						return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_8__util_get_prop_names_and_symbols__["a" /* default */])(propDefs).reduce(function (propDescriptors, nameOrSymbol) {
							propDescriptors[nameOrSymbol] = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_11__lifecycle_props_init__["a" /* createNativePropertyDescriptor */])(propDefs[nameOrSymbol]);
							return propDescriptors;
						}, {});
					}

// TODO refactor when not catering to Safari < 10.
//
// We should be able to simplify this where all we do is Object.defineProperty().
					function createInitProps(Ctor) {
						var propDescriptors = createNativePropertyDescriptors(Ctor);

						return function (elem) {
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_8__util_get_prop_names_and_symbols__["a" /* default */])(propDescriptors).forEach(function (nameOrSymbol) {
								var propDescriptor = propDescriptors[nameOrSymbol];
								propDescriptor.beforeDefineProperty(elem);

								// We check here before defining to see if the prop was specified prior
								// to upgrading.
								var hasPropBeforeUpgrading = nameOrSymbol in elem;

								// This is saved prior to defining so that we can set it after it it was
								// defined prior to upgrading. We don't want to invoke the getter if we
								// don't need to, so we only get the value if we need to re-sync.
								var valueBeforeUpgrading = hasPropBeforeUpgrading && elem[nameOrSymbol];

								// https://bugs.webkit.org/show_bug.cgi?id=49739
								//
								// When Webkit fixes that bug so that native property accessors can be
								// retrieved, we can move defining the property to the prototype and away
								// from having to do if for every instance as all other browsers support
								// this.
								Object.defineProperty(elem, nameOrSymbol, propDescriptor);

								// DEPRECATED
								//
								// We'll be removing get / set callbacks on properties. Use the
								// updatedCallback() instead.
								//
								// We re-set the prop if it was specified prior to upgrading because we
								// need to ensure set() is triggered both in polyfilled environments and
								// in native where the definition may be registerd after elements it
								// represents have already been created.
								if (hasPropBeforeUpgrading) {
									elem[nameOrSymbol] = valueBeforeUpgrading;
								}
							});
						};
					}

					var _class2 = function (_HTMLElement) {
						_inherits(_class2, _HTMLElement);

						_createClass(_class2, null, [{
							key: 'observedAttributes',


							/**
							 * Returns unique attribute names configured with props and
							 * those set on the Component constructor if any
							 */
							get: function get() {
								var attrsOnCtor = this.hasOwnProperty(__WEBPACK_IMPORTED_MODULE_1__util_symbols__["f" /* ctorObservedAttributes */]) ? this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["f" /* ctorObservedAttributes */]] : [];
								var propDefs = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_9__util_get_props_map__["a" /* default */])(this);

								// Use Object.keys to skips symbol props since they have no linked attributes
								var attrsFromLinkedProps = Object.keys(propDefs).map(function (propName) {
									return propDefs[propName].attrSource;
								}).filter(Boolean);

								var all = attrsFromLinkedProps.concat(attrsOnCtor).concat(_get(_class2.__proto__ || Object.getPrototypeOf(_class2), 'observedAttributes', this));
								return all.filter(function (item, index) {
									return all.indexOf(item) === index;
								});
							},
							set: function set(value) {
								value = Array.isArray(value) ? value : [];
								__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_14__util_set_ctor_native_property__["a" /* default */])(this, 'observedAttributes', value);
							}

							// Returns superclass props overwritten with this Component props

						}, {
							key: 'props',
							get: function get() {
								return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_assign__["a" /* default */])({}, _get(_class2.__proto__ || Object.getPrototypeOf(_class2), 'props', this), this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["g" /* ctorProps */]]);
							},
							set: function set(value) {
								__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_14__util_set_ctor_native_property__["a" /* default */])(this, __WEBPACK_IMPORTED_MODULE_1__util_symbols__["g" /* ctorProps */], value);
							}

							// Passing args is designed to work with document-register-element. It's not
							// necessary for the webcomponents/custom-element polyfill.

						}]);

						function _class2() {
							var _ref;

							_classCallCheck(this, _class2);

							for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
								args[_key] = arguments[_key];
							}

							var _this = _possibleConstructorReturn(this, (_ref = _class2.__proto__ || Object.getPrototypeOf(_class2)).call.apply(_ref, [this].concat(args)));

							var constructor = _this.constructor;

							// Used for the ready() function so it knows when it can call its callback.

							_this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["c" /* created */]] = true;

							// TODO refactor to not cater to Safari < 10. This means we can depend on
							// built-in property descriptors.
							// Must be defined on constructor and not from a superclass
							if (!constructor.hasOwnProperty(__WEBPACK_IMPORTED_MODULE_1__util_symbols__["h" /* ctorCreateInitProps */])) {
								__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_14__util_set_ctor_native_property__["a" /* default */])(constructor, __WEBPACK_IMPORTED_MODULE_1__util_symbols__["h" /* ctorCreateInitProps */], createInitProps(constructor));
							}

							// Set up a renderer that is debounced for property sets to call directly.
							_this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["i" /* rendererDebounced */]] = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_5__util_debounce__["a" /* default */])(_this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["d" /* renderer */]].bind(_this));

							// Set up property lifecycle.
							var propDefsCount = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_8__util_get_prop_names_and_symbols__["a" /* default */])(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_9__util_get_props_map__["a" /* default */])(constructor)).length;
							if (propDefsCount && constructor[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["h" /* ctorCreateInitProps */]]) {
								constructor[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["h" /* ctorCreateInitProps */]](_this);
							}

							// DEPRECATED
							//
							// static render()
							// Note that renderCallback is an optional method!
							if (!_this.renderCallback && constructor.render) {
								deprecated(_this, 'static render', 'renderCallback');
								_this.renderCallback = constructor.render.bind(constructor, _this);
							}

							// DEPRECATED
							//
							// static created()
							//
							// Props should be set up before calling this.
							var created = constructor.created;

							if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(created)) {
								deprecated(_this, 'static created', 'constructor');
								created(_this);
							}

							// DEPRECATED
							//
							// Feature has rarely been used.
							//
							// Created should be set before invoking the ready listeners.
							var elemData = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4__util_data__["a" /* default */])(_this);
							var readyCallbacks = elemData.readyCallbacks;
							if (readyCallbacks) {
								readyCallbacks.forEach(function (cb) {
									return cb(_this);
								});
								delete elemData.readyCallbacks;
							}
							return _this;
						}

						// Custom Elements v1


						_createClass(_class2, [{
							key: 'connectedCallback',
							value: function connectedCallback() {
								// Reflect attributes pending values
								__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__util_attributes_manager__["a" /* default */])(this).resumeAttributesUpdates();

								// Used to check whether or not the component can render.
								this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["j" /* connected */]] = true;

								// Render!
								this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["i" /* rendererDebounced */]]();

								// DEPRECATED
								//
								// static attached()
								var attached = this.constructor.attached;

								if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(attached)) {
									deprecated(this, 'static attached', 'connectedCallback');
									attached(this);
								}

								// DEPRECATED
								//
								// We can remove this once all browsers support :defined.
								this.setAttribute('defined', '');
							}

							// Custom Elements v1

						}, {
							key: 'disconnectedCallback',
							value: function disconnectedCallback() {
								// Suspend updating attributes until re-connected
								__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__util_attributes_manager__["a" /* default */])(this).suspendAttributesUpdates();

								// Ensures the component can't be rendered while disconnected.
								this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["j" /* connected */]] = false;

								// DEPRECATED
								//
								// static detached()
								var detached = this.constructor.detached;

								if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(detached)) {
									deprecated(this, 'static detached', 'disconnectedCallback');
									detached(this);
								}
							}

							// Custom Elements v1

						}, {
							key: 'attributeChangedCallback',
							value: function attributeChangedCallback(name, oldValue, newValue) {
								// Polyfill calls this twice.
								if (preventDoubleCalling(this, name, oldValue, newValue)) {
									return;
								}

								// Set data so we can prevent double calling if the polyfill.
								this[_prevName] = name;
								this[_prevOldValue] = oldValue;
								this[_prevNewValue] = newValue;

								var propNameOrSymbol = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4__util_data__["a" /* default */])(this, 'attrSourceLinks')[name];
								if (propNameOrSymbol) {
									var changedExternally = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__util_attributes_manager__["a" /* default */])(this).onAttributeChanged(name, newValue);
									if (changedExternally) {
										// Sync up the property.
										var propDef = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_9__util_get_props_map__["a" /* default */])(this.constructor)[propNameOrSymbol];
										var newPropVal = newValue !== null && propDef.deserialize ? propDef.deserialize(newValue) : newValue;

										var propData = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4__util_data__["a" /* default */])(this, 'props')[propNameOrSymbol];
										propData.settingPropFromAttrSource = true;
										this[propNameOrSymbol] = newPropVal;
										propData.settingPropFromAttrSource = false;
									}
								}

								// DEPRECATED
								//
								// static attributeChanged()
								var attributeChanged = this.constructor.attributeChanged;

								if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(attributeChanged)) {
									deprecated(this, 'static attributeChanged', 'attributeChangedCallback');
									attributeChanged(this, { name: name, newValue: newValue, oldValue: oldValue });
								}
							}

							// Skate

						}, {
							key: 'updatedCallback',
							value: function updatedCallback(prevProps) {
								if (this.constructor.hasOwnProperty('updated')) {
									deprecated(this, 'static updated', 'updatedCallback');
								}
								return this.constructor.updated(this, prevProps);
							}

							// Skate

						}, {
							key: 'renderedCallback',
							value: function renderedCallback() {
								if (this.constructor.hasOwnProperty('rendered')) {
									deprecated(this, 'static rendered', 'renderedCallback');
								}
								return this.constructor.rendered(this);
							}

							// Skate
							//
							// Maps to the static renderer() callback. That logic should be moved here
							// when that is finally removed.
							// TODO: finalize how to support different rendering strategies.

						}, {
							key: 'rendererCallback',
							value: function rendererCallback() {
								// TODO: cannot move code here because tests expects renderer function to still exist on constructor!
								return this.constructor.renderer(this);
							}

							// Skate
							// @internal
							// Invokes the complete render lifecycle.

						}, {
							key: __WEBPACK_IMPORTED_MODULE_1__util_symbols__["d" /* renderer */],
							value: function value() {
								if (this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["k" /* rendering */]] || !this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["j" /* connected */]]) {
									return;
								}

								// Flag as rendering. This prevents anything from trying to render - or
								// queueing a render - while there is a pending render.
								this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["k" /* rendering */]] = true;
								if (this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["l" /* updated */]]() && __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(this.renderCallback)) {
									this.rendererCallback();
									this.renderedCallback();
								}

								this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["k" /* rendering */]] = false;
							}

							// Skate
							// @internal
							// Calls the updatedCallback() with previous props.

						}, {
							key: __WEBPACK_IMPORTED_MODULE_1__util_symbols__["l" /* updated */],
							value: function value() {
								var prevProps = this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["m" /* props */]];
								this[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["m" /* props */]] = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_10__props__["a" /* default */])(this);
								return this.updatedCallback(prevProps);
							}

							// Skate

						}], [{
							key: 'extend',
							value: function extend() {
								var definition = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
								var Base = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this;

								// Create class for the user.
								var Ctor = function (_Base) {
									_inherits(Ctor, _Base);

									function Ctor() {
										_classCallCheck(this, Ctor);

										return _possibleConstructorReturn(this, (Ctor.__proto__ || Object.getPrototypeOf(Ctor)).apply(this, arguments));
									}

									return Ctor;
								}(Base);

								// For inheriting from the object literal.


								var opts = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_7__util_get_own_property_descriptors__["a" /* default */])(definition);
								var prot = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_7__util_get_own_property_descriptors__["a" /* default */])(definition.prototype);

								// Prototype is non configurable (but is writable).
								delete opts.prototype;

								// Pass on static and instance members from the definition.
								Object.defineProperties(Ctor, opts);
								Object.defineProperties(Ctor.prototype, prot);

								return Ctor;
							}

							// Skate
							//
							// DEPRECATED
							//
							// Stubbed in case any subclasses are calling it.

						}, {
							key: 'rendered',
							value: function rendered() {}

							// Skate
							//
							// DEPRECATED
							//
							// Move this to rendererCallback() before removing.

						}, {
							key: 'renderer',
							value: function renderer(elem) {
								if (!elem.shadowRoot) {
									elem.attachShadow({ mode: 'open' });
								}
								__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["patchInner"])(elem.shadowRoot, function () {
									var possibleFn = elem.renderCallback(elem);
									if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(possibleFn)) {
										possibleFn();
									} else if (Array.isArray(possibleFn)) {
										possibleFn.forEach(function (fn) {
											if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_12__util_is_type__["a" /* isFunction */])(fn)) {
												fn();
											}
										});
									}
								});
							}

							// Skate
							//
							// DEPRECATED
							//
							// Move this to updatedCallback() before removing.

						}, {
							key: 'updated',
							value: function updated(elem, previousProps) {
								// The 'previousProps' will be undefined if it is the initial render.
								if (!previousProps) {
									return true;
								}

								// The 'previousProps' will always contain all of the keys.
								//
								// Use classic loop because:
								// 'for ... in' skips symbols and 'for ... of' is not working yet with IE!?
								// for (let nameOrSymbol of getPropNamesAndSymbols(previousProps)) {
								var namesAndSymbols = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_8__util_get_prop_names_and_symbols__["a" /* default */])(previousProps);
								for (var i = 0; i < namesAndSymbols.length; i++) {
									var nameOrSymbol = namesAndSymbols[i];

									// With Object.is NaN is equal to NaN
									if (!__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_13__polyfills_object_is__["a" /* default */])(previousProps[nameOrSymbol], elem[nameOrSymbol])) {
										return true;
									}
								}

								return false;
							}
						}]);

						return _class2;
					}(HTMLElement);

					_class2.is = '';
					/* harmony default export */ __webpack_exports__["a"] = _class2;
					/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(13)))

				/***/ }),
			/* 9 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__to_null_or_string__ = __webpack_require__(12);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__is_type__ = __webpack_require__(2);
				/* harmony export (immutable) */ __webpack_exports__["a"] = getAttrMgr;
				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }




				/**
				 * @internal
				 * Attributes Manager
				 *
				 * Postpones attributes updates until when connected.
				 */

				var AttributesManager = function () {
					function AttributesManager(elem) {
						_classCallCheck(this, AttributesManager);

						this.elem = elem;
						this.connected = false;
						this.pendingValues = {};
						this.lastSetValues = {};
					}

					/**
					 * Called from disconnectedCallback
					 */


					_createClass(AttributesManager, [{
						key: 'suspendAttributesUpdates',
						value: function suspendAttributesUpdates() {
							this.connected = false;
						}

						/**
						 * Called from connectedCallback
						 */

					}, {
						key: 'resumeAttributesUpdates',
						value: function resumeAttributesUpdates() {
							var _this = this;

							this.connected = true;
							var names = Object.keys(this.pendingValues);
							names.forEach(function (name) {
								var value = _this.pendingValues[name];
								// Skip if already cleared
								if (!__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__is_type__["b" /* isUndefined */])(value)) {
									delete _this.pendingValues[name];
									_this._syncAttrValue(name, value);
								}
							});
						}

						/**
						 * Returns true if the value is different from the one set internally
						 * using setAttrValue()
						 */

					}, {
						key: 'onAttributeChanged',
						value: function onAttributeChanged(name, value) {
							value = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__to_null_or_string__["a" /* default */])(value);

							// A new attribute value voids the pending one
							this._clearPendingValue(name);

							var changed = this.lastSetValues[name] !== value;
							this.lastSetValues[name] = value;
							return changed;
						}

						/**
						 * Updates or removes the attribute if value === null.
						 *
						 * When the component is not connected the value is saved and
						 * the attribute is only updated when the component is re-connected.
						 */

					}, {
						key: 'setAttrValue',
						value: function setAttrValue(name, value) {
							value = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__to_null_or_string__["a" /* default */])(value);

							this.lastSetValues[name] = value;

							if (this.connected) {
								this._clearPendingValue(name);
								this._syncAttrValue(name, value);
							} else {
								this.pendingValues[name] = value;
							}
						}
					}, {
						key: '_syncAttrValue',
						value: function _syncAttrValue(name, value) {
							var currAttrValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__to_null_or_string__["a" /* default */])(this.elem.getAttribute(name));
							if (value !== currAttrValue) {
								if (value === null) {
									this.elem.removeAttribute(name);
								} else {
									this.elem.setAttribute(name, value);
								}
							}
						}
					}, {
						key: '_clearPendingValue',
						value: function _clearPendingValue(name) {
							if (name in this.pendingValues) {
								delete this.pendingValues[name];
							}
						}
					}]);

					return AttributesManager;
				}();

// Only used by getAttrMgr


				var $attributesMgr = '____skate_attributesMgr';

				/**
				 * @internal
				 * Returns attribute manager instance for the given Component
				 */
				function getAttrMgr(elem) {
					var mgr = elem[$attributesMgr];
					if (!mgr) {
						mgr = new AttributesManager(elem);
						elem[$attributesMgr] = mgr;
					}
					return mgr;
				}

				/***/ }),
			/* 10 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__symbols__ = __webpack_require__(0);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__get_prop_names_and_symbols__ = __webpack_require__(1);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__prop_definition__ = __webpack_require__(35);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__set_ctor_native_property__ = __webpack_require__(11);
				/* harmony export (immutable) */ __webpack_exports__["a"] = getPropsMap;





				/**
				 * Memoizes a map of PropDefinition for the given component class.
				 * Keys in the map are the properties name which can a string or a symbol.
				 *
				 * The map is created from the result of: static get props
				 */
				function getPropsMap(Ctor) {
					// Must be defined on constructor and not from a superclass
					if (!Ctor.hasOwnProperty(__WEBPACK_IMPORTED_MODULE_0__symbols__["e" /* ctorPropsMap */])) {
						(function () {
							var props = Ctor.props || {};

							var propsMap = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__get_prop_names_and_symbols__["a" /* default */])(props).reduce(function (result, nameOrSymbol) {
								result[nameOrSymbol] = new __WEBPACK_IMPORTED_MODULE_2__prop_definition__["a" /* default */](nameOrSymbol, props[nameOrSymbol]);
								return result;
							}, {});
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__set_ctor_native_property__["a" /* default */])(Ctor, __WEBPACK_IMPORTED_MODULE_0__symbols__["e" /* ctorPropsMap */], propsMap);
						})();
					}

					return Ctor[__WEBPACK_IMPORTED_MODULE_0__symbols__["e" /* ctorPropsMap */]];
				}

				/***/ }),
			/* 11 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (immutable) */ __webpack_exports__["a"] = setCtorNativeProperty;
				/**
				 * This is needed to avoid IE11 "stack size errors" when creating
				 * a new property on the constructor of an HTMLElement
				 */
				function setCtorNativeProperty(Ctor, propName, value) {
					Object.defineProperty(Ctor, propName, { configurable: true, value: value });
				}

				/***/ }),
			/* 12 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__empty__ = __webpack_require__(6);

				/**
				 * Attributes value can only be null or string;
				 */
				var toNullOrString = function toNullOrString(val) {
					return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__empty__["a" /* default */])(val) ? null : String(val);
				};

				/* harmony default export */ __webpack_exports__["a"] = toNullOrString;

				/***/ }),
			/* 13 */
			/***/ (function(module, exports) {

// shim for using process in browser
				var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

				var cachedSetTimeout;
				var cachedClearTimeout;

				function defaultSetTimout() {
					throw new Error('setTimeout has not been defined');
				}
				function defaultClearTimeout () {
					throw new Error('clearTimeout has not been defined');
				}
				(function () {
					try {
						if (typeof setTimeout === 'function') {
							cachedSetTimeout = setTimeout;
						} else {
							cachedSetTimeout = defaultSetTimout;
						}
					} catch (e) {
						cachedSetTimeout = defaultSetTimout;
					}
					try {
						if (typeof clearTimeout === 'function') {
							cachedClearTimeout = clearTimeout;
						} else {
							cachedClearTimeout = defaultClearTimeout;
						}
					} catch (e) {
						cachedClearTimeout = defaultClearTimeout;
					}
				} ())
				function runTimeout(fun) {
					if (cachedSetTimeout === setTimeout) {
						//normal enviroments in sane situations
						return setTimeout(fun, 0);
					}
					// if setTimeout wasn't available but was latter defined
					if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
						cachedSetTimeout = setTimeout;
						return setTimeout(fun, 0);
					}
					try {
						// when when somebody has screwed with setTimeout but no I.E. maddness
						return cachedSetTimeout(fun, 0);
					} catch(e){
						try {
							// When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
							return cachedSetTimeout.call(null, fun, 0);
						} catch(e){
							// same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
							return cachedSetTimeout.call(this, fun, 0);
						}
					}


				}
				function runClearTimeout(marker) {
					if (cachedClearTimeout === clearTimeout) {
						//normal enviroments in sane situations
						return clearTimeout(marker);
					}
					// if clearTimeout wasn't available but was latter defined
					if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
						cachedClearTimeout = clearTimeout;
						return clearTimeout(marker);
					}
					try {
						// when when somebody has screwed with setTimeout but no I.E. maddness
						return cachedClearTimeout(marker);
					} catch (e){
						try {
							// When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
							return cachedClearTimeout.call(null, marker);
						} catch (e){
							// same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
							// Some versions of I.E. have different rules for clearTimeout vs setTimeout
							return cachedClearTimeout.call(this, marker);
						}
					}



				}
				var queue = [];
				var draining = false;
				var currentQueue;
				var queueIndex = -1;

				function cleanUpNextTick() {
					if (!draining || !currentQueue) {
						return;
					}
					draining = false;
					if (currentQueue.length) {
						queue = currentQueue.concat(queue);
					} else {
						queueIndex = -1;
					}
					if (queue.length) {
						drainQueue();
					}
				}

				function drainQueue() {
					if (draining) {
						return;
					}
					var timeout = runTimeout(cleanUpNextTick);
					draining = true;

					var len = queue.length;
					while(len) {
						currentQueue = queue;
						queue = [];
						while (++queueIndex < len) {
							if (currentQueue) {
								currentQueue[queueIndex].run();
							}
						}
						queueIndex = -1;
						len = queue.length;
					}
					currentQueue = null;
					draining = false;
					runClearTimeout(timeout);
				}

				process.nextTick = function (fun) {
					var args = new Array(arguments.length - 1);
					if (arguments.length > 1) {
						for (var i = 1; i < arguments.length; i++) {
							args[i - 1] = arguments[i];
						}
					}
					queue.push(new Item(fun, args));
					if (queue.length === 1 && !draining) {
						runTimeout(drainQueue);
					}
				};

// v8 likes predictible objects
				function Item(fun, array) {
					this.fun = fun;
					this.array = array;
				}
				Item.prototype.run = function () {
					this.fun.apply(null, this.array);
				};
				process.title = 'browser';
				process.browser = true;
				process.env = {};
				process.argv = [];
				process.version = ''; // empty string to avoid regexp issues
				process.versions = {};

				function noop() {}

				process.on = noop;
				process.addListener = noop;
				process.once = noop;
				process.off = noop;
				process.removeListener = noop;
				process.removeAllListeners = noop;
				process.emit = noop;

				process.binding = function (name) {
					throw new Error('process.binding is not supported');
				};

				process.cwd = function () { return '/' };
				process.chdir = function (dir) {
					throw new Error('process.chdir is not supported');
				};
				process.umask = function() { return 0; };


				/***/ }),
			/* 14 */
			/***/ (function(module, exports) {

				module.exports = __WEBPACK_EXTERNAL_MODULE_14__;

				/***/ }),
			/* 15 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__api_prop__ = __webpack_require__(19);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__api_symbols__ = __webpack_require__(21);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__api_vdom__ = __webpack_require__(22);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__api_component__ = __webpack_require__(8);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__api_define__ = __webpack_require__(16);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__api_emit__ = __webpack_require__(17);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__api_link__ = __webpack_require__(18);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__api_props__ = __webpack_require__(7);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__api_ready__ = __webpack_require__(20);
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "Component", function() { return __WEBPACK_IMPORTED_MODULE_3__api_component__["a"]; });
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "define", function() { return __WEBPACK_IMPORTED_MODULE_4__api_define__["a"]; });
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "emit", function() { return __WEBPACK_IMPORTED_MODULE_5__api_emit__["a"]; });
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "link", function() { return __WEBPACK_IMPORTED_MODULE_6__api_link__["a"]; });
				/* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "prop", function() { return __WEBPACK_IMPORTED_MODULE_0__api_prop__; });
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "props", function() { return __WEBPACK_IMPORTED_MODULE_7__api_props__["a"]; });
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "ready", function() { return __WEBPACK_IMPORTED_MODULE_8__api_ready__["a"]; });
				/* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "symbols", function() { return __WEBPACK_IMPORTED_MODULE_1__api_symbols__; });
				/* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "vdom", function() { return __WEBPACK_IMPORTED_MODULE_2__api_vdom__; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return h; });










				var h = __WEBPACK_IMPORTED_MODULE_2__api_vdom__["builder"]();



				/***/ }),
			/* 16 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* WEBPACK VAR INJECTION */(function(process) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(8);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_unique_id__ = __webpack_require__(36);
					/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util_root__ = __webpack_require__(3);
					var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };





					/* harmony default export */ __webpack_exports__["a"] = function () {
						var customElements = __WEBPACK_IMPORTED_MODULE_2__util_root__["a" /* default */].customElements,
							HTMLElement = __WEBPACK_IMPORTED_MODULE_2__util_root__["a" /* default */].HTMLElement;

						for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
							args[_key] = arguments[_key];
						}

						var name = args[0],
							Ctor = args[1];


						if (!customElements) {
							throw new Error('Skate requires native custom element support or a polyfill.');
						}

						// DEPRECATED remove when removing the "name" argument.
						if (process.env.NODE_ENV !== 'production' && args.length === 2) {
							console.warn('The "name" argument to define() is deprecated. Please define a `static is` property on the constructor instead.');
						}

						// DEPRECATED remove when removing the "name" argument.
						if (args.length === 1) {
							Ctor = name;
							name = null;
						}

						// DEPRECATED Object literals.
						if ((typeof Ctor === 'undefined' ? 'undefined' : _typeof(Ctor)) === 'object') {
							Ctor = __WEBPACK_IMPORTED_MODULE_0__component__["a" /* default */].extend(Ctor);
						}

						// Ensure a custom element is passed.
						if (!(Ctor.prototype instanceof HTMLElement)) {
							throw new Error('You must provide a constructor that extends HTMLElement to define().');
						}

						// DEPRECATED two arguments
						if (args.length === 2) {
							customElements.define(customElements.get(name) ? __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_unique_id__["a" /* default */])(name) : name, Ctor);
						} else {
							// We must use hasOwnProperty() because we want to know if it was specified
							// directly on this class, not subclasses, as we don't want to inherit tag
							// names from subclasses.
							if (!Ctor.hasOwnProperty('is')) {
								// If we used defineProperty() then the consumer must also use it and
								// cannot use property initialisers. Instead we just set it so they can
								// use whatever method of overridding that they want.
								Ctor.is = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_unique_id__["a" /* default */])();
							}
							customElements.define(Ctor.is, Ctor);
						}

						// The spec doesn't return but this allows for a simpler, more concise API.
						return Ctor;
					};
					/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(13)))

				/***/ }),
			/* 17 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util_root__ = __webpack_require__(3);


				var Event = function (TheEvent) {
					if (TheEvent) {
						try {
							new TheEvent('emit-init'); // eslint-disable-line no-new
						} catch (e) {
							return undefined;
						}
					}
					return TheEvent;
				}(__WEBPACK_IMPORTED_MODULE_0__util_root__["a" /* default */].Event);

				function createCustomEvent(name) {
					var opts = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
					var detail = opts.detail;

					delete opts.detail;

					var e = void 0;
					if (Event) {
						e = new Event(name, opts);
						Object.defineProperty(e, 'detail', { value: detail });
					} else {
						e = document.createEvent('CustomEvent');
						Object.defineProperty(e, 'composed', { value: opts.composed });
						e.initCustomEvent(name, opts.bubbles, opts.cancelable, detail);
					}
					return e;
				}

				/* harmony default export */ __webpack_exports__["a"] = function (elem, name) {
					var opts = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

					if (opts.bubbles === undefined) {
						opts.bubbles = true;
					}
					if (opts.cancelable === undefined) {
						opts.cancelable = true;
					}
					if (opts.composed === undefined) {
						opts.composed = true;
					}
					return elem.dispatchEvent(createCustomEvent(name, opts));
				};

				/***/ }),
			/* 18 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__props__ = __webpack_require__(7);
				function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



				function getValue(elem) {
					var type = elem.type;
					if (type === 'checkbox' || type === 'radio') {
						return elem.checked ? elem.value || true : false;
					}
					return elem.value;
				}

				/* harmony default export */ __webpack_exports__["a"] = function (elem, target) {
					return function (e) {
						// We fallback to checking the composed path. Unfortunately this behaviour
						// is difficult to impossible to reproduce as it seems to be a possible
						// quirk in the shadydom polyfill that incorrectly returns null for the
						// target but has the target as the first point in the path.
						// TODO revisit once all browsers have native support.
						var localTarget = e.target || e.composedPath()[0];
						var value = getValue(localTarget);
						var localTargetName = target || localTarget.name || 'value';

						if (localTargetName.indexOf('.') > -1) {
							var parts = localTargetName.split('.');
							var firstPart = parts[0];
							var propName = parts.pop();
							var obj = parts.reduce(function (prev, curr) {
								return prev && prev[curr];
							}, elem);

							obj[propName || e.target.name] = value;
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__props__["a" /* default */])(elem, _defineProperty({}, firstPart, elem[firstPart]));
						} else {
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__props__["a" /* default */])(elem, _defineProperty({}, localTargetName, value));
						}
					};
				};

				/***/ }),
			/* 19 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util_assign__ = __webpack_require__(4);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_empty__ = __webpack_require__(6);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util_to_null_or_string__ = __webpack_require__(12);
				/* harmony export (immutable) */ __webpack_exports__["create"] = create;
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "array", function() { return array; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "boolean", function() { return boolean; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "number", function() { return number; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "string", function() { return string; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "object", function() { return object; });




				function create(def) {
					return function () {
						for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
							args[_key] = arguments[_key];
						}

						args.unshift({}, def);
						return __WEBPACK_IMPORTED_MODULE_0__util_assign__["a" /* default */].apply(undefined, args);
					};
				}

				var parseIfNotEmpty = function parseIfNotEmpty(val) {
					return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_empty__["a" /* default */])(val) ? null : JSON.parse(val);
				};

				var array = create({
					coerce: function coerce(val) {
						return Array.isArray(val) ? val : __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_empty__["a" /* default */])(val) ? null : [val];
					},
					default: function _default() {
						return [];
					},
					deserialize: parseIfNotEmpty,
					serialize: JSON.stringify
				});

				var boolean = create({
					coerce: function coerce(val) {
						return !!val;
					},
					default: false,
					// TODO: 'false' string must deserialize to false for angular 1.x to work
					// This breaks one existing test.
					// deserialize: val => !(val === null || val === 'false'),
					deserialize: function deserialize(val) {
						return !(val === null);
					},
					serialize: function serialize(val) {
						return val ? '' : null;
					}
				});

// defaults empty to 0 and allows NaN
				var zeroIfEmptyOrNumberIncludesNaN = function zeroIfEmptyOrNumberIncludesNaN(val) {
					return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_empty__["a" /* default */])(val) ? 0 : Number(val);
				};

				var number = create({
					default: 0,
					coerce: zeroIfEmptyOrNumberIncludesNaN,
					deserialize: zeroIfEmptyOrNumberIncludesNaN,
					serialize: __WEBPACK_IMPORTED_MODULE_2__util_to_null_or_string__["a" /* default */]
				});

				var string = create({
					default: '',
					coerce: __WEBPACK_IMPORTED_MODULE_2__util_to_null_or_string__["a" /* default */],
					deserialize: __WEBPACK_IMPORTED_MODULE_2__util_to_null_or_string__["a" /* default */],
					serialize: __WEBPACK_IMPORTED_MODULE_2__util_to_null_or_string__["a" /* default */]
				});

				var object = create({
					default: function _default() {
						return {};
					},
					deserialize: parseIfNotEmpty,
					serialize: JSON.stringify
				});

				/***/ }),
			/* 20 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util_symbols__ = __webpack_require__(0);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_data__ = __webpack_require__(5);



				/* harmony default export */ __webpack_exports__["a"] = function (elem, done) {
					var info = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_data__["a" /* default */])(elem);
					if (elem[__WEBPACK_IMPORTED_MODULE_0__util_symbols__["c" /* created */]]) {
						done(elem);
					} else if (info.readyCallbacks) {
						info.readyCallbacks.push(done);
					} else {
						info.readyCallbacks = [done];
					}
				};

				/***/ }),
			/* 21 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util_symbols__ = __webpack_require__(0);
				/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "name", function() { return __WEBPACK_IMPORTED_MODULE_0__util_symbols__["b"]; });
// DEPRECTAED
//
// We should not be relying on internals for symbols as this creates version
// coupling. We will move forward with platform agnostic ways of doing this.


				/***/ }),
			/* 22 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_incremental_dom__ = __webpack_require__(14);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_incremental_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_symbols__ = __webpack_require__(0);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util_prop_context__ = __webpack_require__(34);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__util_root__ = __webpack_require__(3);
				/* harmony export (immutable) */ __webpack_exports__["element"] = element;
				/* harmony export (immutable) */ __webpack_exports__["builder"] = builder;
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "attr", function() { return newAttr; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "elementClose", function() { return newElementClose; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "elementOpen", function() { return newElementOpen; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "elementOpenEnd", function() { return newElementOpenEnd; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "elementOpenStart", function() { return newElementOpenStart; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "elementVoid", function() { return newElementVoid; });
				/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "text", function() { return newText; });
				var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

				function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

				function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

				/* eslint no-plusplus: 0 */






				var customElements = __WEBPACK_IMPORTED_MODULE_3__util_root__["a" /* default */].customElements,
					HTMLElement = __WEBPACK_IMPORTED_MODULE_3__util_root__["a" /* default */].HTMLElement;

				var applyDefault = __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["attributes"][__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["symbols"].default];

// A stack of children that corresponds to the current function helper being
// executed.
				var stackChren = [];

				var $skip = '__skip';
				var $currentEventHandlers = '__events';
				var $stackCurrentHelperProps = '__props';

// The current function helper in the stack.
				var stackCurrentHelper = void 0;

// This is used for the Incremental DOM overrides to keep track of what args
// to pass the main elementOpen() function.
				var overrideArgs = void 0;

// The number of levels deep after skipping a tree.
				var skips = 0;

				var noop = function noop() {};

// Adds or removes an event listener for an element.
				function applyEvent(elem, ename, newFunc) {
					var events = elem[$currentEventHandlers];

					if (!events) {
						events = elem[$currentEventHandlers] = {};
					}

					// Undefined indicates that there is no listener yet.
					if (typeof events[ename] === 'undefined') {
						// We only add a single listener once. Originally this was a workaround for
						// the Webcomponents ShadyDOM polyfill not removing listeners, but it's
						// also a simpler model for binding / unbinding events because you only
						// have a single handler you need to worry about and a single place where
						// you only store one event handler
						elem.addEventListener(ename, function (e) {
							if (events[ename]) {
								events[ename].call(this, e);
							}
						});
					}

					// Not undefined indicates that we have set a listener, so default to null.
					events[ename] = typeof newFunc === 'function' ? newFunc : null;
				}

				var attributesContext = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_prop_context__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["attributes"], _defineProperty({
					// Attributes that shouldn't be applied to the DOM.
					key: noop,
					statics: noop,

					// Attributes that *must* be set via a property on all elements.
					checked: __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["applyProp"],
					className: __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["applyProp"],
					disabled: __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["applyProp"],
					value: __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["applyProp"],

					// Ref handler.
					ref: function ref(elem, name, value) {
						elem[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["a" /* ref */]] = value;
					},


					// Skip handler.
					skip: function skip(elem, name, value) {
						if (value) {
							elem[$skip] = true;
						} else {
							delete elem[$skip];
						}
					}
				}, __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["symbols"].default, function (elem, name, value) {
					var ce = customElements.get(elem.localName);
					var props = ce && ce.props || {};
					var prototype = ce && ce.prototype || {};

					// TODO when refactoring properties to not have to workaround the old
					// WebKit bug we can remove the "name in props" check below.
					//
					// NOTE: That the "name in elem" check won't work for polyfilled custom
					// elements that set a property that isn't explicitly specified in "props"
					// or "prototype" unless it is added to the element explicitly as a
					// property prior to passing the prop to the vdom function. For example, if
					// it were added in a lifecycle callback because it wouldn't have been
					// upgraded yet.
					//
					// We prefer setting props, so we do this if there's a property matching
					// name that was passed. However, certain props on SVG elements are
					// readonly and error when you try to set them.
					if ((name in props || name in elem || name in prototype) && !('ownerSVGElement' in elem)) {
						__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["applyProp"])(elem, name, value);
						return;
					}

					// Explicit false removes the attribute.
					if (value === false) {
						applyDefault(elem, name);
						return;
					}

					// Handle built-in and custom events.
					if (name.indexOf('on') === 0) {
						var firstChar = name[2];
						var eventName = void 0;

						if (firstChar === '-') {
							eventName = name.substring(3);
						} else if (firstChar === firstChar.toUpperCase()) {
							eventName = firstChar.toLowerCase() + name.substring(3);
						}

						if (eventName) {
							applyEvent(elem, eventName, value);
							return;
						}
					}

					applyDefault(elem, name, value);
				}));

				function resolveTagName(name) {
					// We return falsy values as some wrapped IDOM functions allow empty values.
					if (!name) {
						return name;
					}

					// We try and return the cached tag name, if one exists. This will work with
					// *any* web component of any version that defines a `static is` property.
					if (name.is) {
						return name.is;
					}

					// Get the name for the custom element by constructing it and using the
					// localName property. Cache it and lookup the cached value for future calls.
					if (name.prototype instanceof HTMLElement) {
						if (name[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["b" /* name */]]) {
							return name[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["b" /* name */]];
						}

						// eslint-disable-next-line
						var elem = new name();
						return elem[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["b" /* name */]] = elem.localName;
					}

					// Pass all other values through so IDOM gets what it's expecting.
					return name;
				}

// Incremental DOM's elementOpen is where the hooks in `attributes` are applied,
// so it's the only function we need to execute in the context of our attributes.
				var elementOpen = attributesContext(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["elementOpen"]);

				function elementOpenStart(tag) {
					var key = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
					var statics = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

					overrideArgs = [tag, key, statics];
				}

				function elementOpenEnd() {
					var node = newElementOpen.apply(undefined, _toConsumableArray(overrideArgs)); // eslint-disable-line no-use-before-define
					overrideArgs = null;
					return node;
				}

				function wrapIdomFunc(func) {
					var tnameFuncHandler = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : noop;

					return function wrap() {
						for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
							args[_key] = arguments[_key];
						}

						args[0] = resolveTagName(args[0]);
						stackCurrentHelper = null;
						if (typeof args[0] === 'function') {
							// If we've encountered a function, handle it according to the type of
							// function that is being wrapped.
							stackCurrentHelper = args[0];
							return tnameFuncHandler.apply(undefined, args);
						} else if (stackChren.length) {
							// We pass the wrap() function in here so that when it's called as
							// children, it will queue up for the next stack, if there is one.
							stackChren[stackChren.length - 1].push([wrap, args]);
						} else {
							if (func === elementOpen) {
								if (skips) {
									return ++skips;
								}

								var elem = func.apply(undefined, args);

								if (elem[$skip]) {
									++skips;
								}

								return elem;
							}

							if (func === __WEBPACK_IMPORTED_MODULE_0_incremental_dom__["elementClose"]) {
								if (skips === 1) {
									__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["skip"])();
								}

								// We only want to skip closing if it's not the last closing tag in the
								// skipped tree because we keep the element that initiated the skpping.
								if (skips && --skips) {
									return;
								}

								var _elem = func.apply(undefined, args);
								var ref = _elem[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["a" /* ref */]];

								// We delete so that it isn't called again for the same element. If the
								// ref changes, or the element changes, this will be defined again.
								delete _elem[__WEBPACK_IMPORTED_MODULE_1__util_symbols__["a" /* ref */]];

								// Execute the saved ref after esuring we've cleand up after it.
								if (typeof ref === 'function') {
									ref(_elem);
								}

								return _elem;
							}

							// We must call elementOpenStart and elementOpenEnd even if we are
							// skipping because they queue up attributes and then call elementClose.
							if (!skips || func === elementOpenStart || func === elementOpenEnd) {
								return func.apply(undefined, args);
							}
						}
					};
				}

				function newAttr() {
					for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
						args[_key2] = arguments[_key2];
					}

					if (stackCurrentHelper) {
						stackCurrentHelper[$stackCurrentHelperProps][args[0]] = args[1];
					} else if (stackChren.length) {
						stackChren[stackChren.length - 1].push([newAttr, args]);
					} else {
						overrideArgs.push(args[0]);
						overrideArgs.push(args[1]);
					}
				}

				function stackOpen(tname, key, statics) {
					var props = { key: key, statics: statics };

					for (var _len3 = arguments.length, attrs = Array(_len3 > 3 ? _len3 - 3 : 0), _key3 = 3; _key3 < _len3; _key3++) {
						attrs[_key3 - 3] = arguments[_key3];
					}

					for (var a = 0; a < attrs.length; a += 2) {
						props[attrs[a]] = attrs[a + 1];
					}
					tname[$stackCurrentHelperProps] = props;
					stackChren.push([]);
				}

				function stackClose(tname) {
					var chren = stackChren.pop();
					var props = tname[$stackCurrentHelperProps];
					delete tname[$stackCurrentHelperProps];
					var elemOrFn = tname(props, function () {
						return chren.forEach(function (args) {
							return args[0].apply(args, _toConsumableArray(args[1]));
						});
					});
					return typeof elemOrFn === 'function' ? elemOrFn() : elemOrFn;
				}

// Incremental DOM overrides
// -------------------------

// We must override internal functions that call internal Incremental DOM
// functions because we can't override the internal references. This means
// we must roughly re-implement their behaviour. Luckily, they're fairly
// simple.
				var newElementOpenStart = wrapIdomFunc(elementOpenStart, stackOpen);
				var newElementOpenEnd = wrapIdomFunc(elementOpenEnd);

// Standard open / closed overrides don't need to reproduce internal behaviour
// because they are the ones referenced from *End and *Start.
				var newElementOpen = wrapIdomFunc(elementOpen, stackOpen);
				var newElementClose = wrapIdomFunc(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["elementClose"], stackClose);

// Ensure we call our overridden functions instead of the internal ones.
				function newElementVoid(tag) {
					for (var _len4 = arguments.length, args = Array(_len4 > 1 ? _len4 - 1 : 0), _key4 = 1; _key4 < _len4; _key4++) {
						args[_key4 - 1] = arguments[_key4];
					}

					newElementOpen.apply(undefined, [tag].concat(args));
					return newElementClose(tag);
				}

// Text override ensures their calls can queue if using function helpers.
				var newText = wrapIdomFunc(__WEBPACK_IMPORTED_MODULE_0_incremental_dom__["text"]);

// Convenience function for declaring an Incremental DOM element using
// hyperscript-style syntax.
				function element(tname, attrs) {
					var atype = typeof attrs === 'undefined' ? 'undefined' : _typeof(attrs);

					// If attributes are a function, then they should be treated as children.

					for (var _len5 = arguments.length, chren = Array(_len5 > 2 ? _len5 - 2 : 0), _key5 = 2; _key5 < _len5; _key5++) {
						chren[_key5 - 2] = arguments[_key5];
					}

					if (atype === 'function' || atype === 'string' || atype === 'number') {
						chren.unshift(attrs);
					}

					// Ensure the attributes are an object. Null is considered an object so we
					// have to test for this explicitly.
					if (attrs === null || atype !== 'object') {
						attrs = {};
					}

					// We open the element so we can set attrs after.
					newElementOpenStart(tname, attrs.key, attrs.statics);

					// Delete so special attrs don't actually get set.
					delete attrs.key;
					delete attrs.statics;

					// Set attributes.
					Object.keys(attrs).forEach(function (name) {
						return newAttr(name, attrs[name]);
					});

					// Close before we render the descendant tree.
					newElementOpenEnd(tname);

					chren.forEach(function (ch) {
						var ctype = typeof ch === 'undefined' ? 'undefined' : _typeof(ch);
						if (ctype === 'function') {
							ch();
						} else if (ctype === 'string' || ctype === 'number') {
							newText(ch);
						} else if (Array.isArray(ch)) {
							ch.forEach(function (sch) {
								return sch();
							});
						}
					});

					return newElementClose(tname);
				}

// Even further convenience for building a DSL out of JavaScript functions or hooking into standard
// transpiles for JSX (React.createElement() / h).
				function builder() {
					for (var _len6 = arguments.length, tags = Array(_len6), _key6 = 0; _key6 < _len6; _key6++) {
						tags[_key6] = arguments[_key6];
					}

					if (tags.length === 0) {
						return function () {
							for (var _len7 = arguments.length, args = Array(_len7), _key7 = 0; _key7 < _len7; _key7++) {
								args[_key7] = arguments[_key7];
							}

							return element.bind.apply(element, [null].concat(args));
						};
					}
					return tags.map(function (tag) {
						return function () {
							for (var _len8 = arguments.length, args = Array(_len8), _key8 = 0; _key8 < _len8; _key8++) {
								args[_key8] = arguments[_key8];
							}

							return element.bind.apply(element, [null, tag].concat(args));
						};
					});
				}

// We don't have to do anything special for the text function; it's just a
// straight export from Incremental DOM.


				/***/ }),
			/* 23 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util_symbols__ = __webpack_require__(0);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util_data__ = __webpack_require__(5);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util_empty__ = __webpack_require__(6);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__util_attributes_manager__ = __webpack_require__(9);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__util_get_default_value__ = __webpack_require__(29);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__util_get_initial_value__ = __webpack_require__(30);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__util_get_prop_data__ = __webpack_require__(32);
				/* harmony export (immutable) */ __webpack_exports__["a"] = createNativePropertyDescriptor;








				function createNativePropertyDescriptor(propDef) {
					var nameOrSymbol = propDef.nameOrSymbol;


					var prop = {
						configurable: true,
						enumerable: true
					};

					prop.beforeDefineProperty = function (elem) {
						var propData = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__util_get_prop_data__["a" /* default */])(elem, nameOrSymbol);
						var attrSource = propDef.attrSource;

						// Store attrSource name to property link.
						if (attrSource) {
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__util_data__["a" /* default */])(elem, 'attrSourceLinks')[attrSource] = nameOrSymbol;
						}

						// prop value before upgrading
						var initialValue = elem[nameOrSymbol];

						// Set up initial value if it wasn't specified.
						var valueFromAttrSource = false;
						if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_empty__["a" /* default */])(initialValue)) {
							if (attrSource && elem.hasAttribute(attrSource)) {
								valueFromAttrSource = true;
								initialValue = propDef.deserialize(elem.getAttribute(attrSource));
							} else if ('initial' in propDef) {
								initialValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_5__util_get_initial_value__["a" /* default */])(elem, propDef);
							} else {
								initialValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4__util_get_default_value__["a" /* default */])(elem, propDef);
							}
						}

						initialValue = propDef.coerce(initialValue);

						propData.internalValue = initialValue;

						// Reflect to Target Attribute
						var mustReflect = propDef.attrTarget && !__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_empty__["a" /* default */])(initialValue) && (!valueFromAttrSource || propDef.attrTargetIsNotSource);

						if (mustReflect) {
							var serializedValue = propDef.serialize(initialValue);
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__util_attributes_manager__["a" /* default */])(elem).setAttrValue(propDef.attrTarget, serializedValue);
						}
					};

					prop.get = function get() {
						var propData = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__util_get_prop_data__["a" /* default */])(this, nameOrSymbol);
						var internalValue = propData.internalValue;

						return propDef.get ? propDef.get(this, { name: nameOrSymbol, internalValue: internalValue }) : internalValue;
					};

					prop.set = function set(newValue) {
						var propData = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6__util_get_prop_data__["a" /* default */])(this, nameOrSymbol);

						var useDefaultValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_empty__["a" /* default */])(newValue);
						if (useDefaultValue) {
							newValue = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4__util_get_default_value__["a" /* default */])(this, propDef);
						}

						newValue = propDef.coerce(newValue);

						if (propDef.set) {
							var oldValue = propData.oldValue;


							if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__util_empty__["a" /* default */])(oldValue)) {
								oldValue = null;
							}
							var changeData = { name: nameOrSymbol, newValue: newValue, oldValue: oldValue };
							propDef.set(this, changeData);
						}

						// Queue a re-render.
						this[__WEBPACK_IMPORTED_MODULE_0__util_symbols__["i" /* rendererDebounced */]](this);

						// Update prop data so we can use it next time.
						propData.internalValue = propData.oldValue = newValue;

						// Reflect to Target attribute.
						var mustReflect = propDef.attrTarget && (propDef.attrTargetIsNotSource || !propData.settingPropFromAttrSource);
						if (mustReflect) {
							// Note: setting the prop to empty implies the default value
							// and therefore no attribute should be present!
							var serializedValue = useDefaultValue ? null : propDef.serialize(newValue);
							__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__util_attributes_manager__["a" /* default */])(this).setAttrValue(propDef.attrTarget, serializedValue);
						}
					};

					return prop;
				}

				/***/ }),
			/* 24 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/**
				 * Polyfill Object.is for IE
				 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is
				 */
				if (!Object.is) {
					Object.is = function (x, y) {
						// SameValue algorithm
						if (x === y) {
							// Steps 1-5, 7-10
							// Steps 6.b-6.e: +0 != -0
							return x !== 0 || 1 / x === 1 / y;
						} else {
							// Step 6.a: NaN == NaN
							return x !== x && y !== y;
						}
					};
				}
				/* harmony default export */ __webpack_exports__["a"] = Object.is;

				/***/ }),
			/* 25 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (immutable) */ __webpack_exports__["a"] = createSymbol;
				function createSymbol(description) {
					return typeof Symbol === 'function' ? Symbol(description) : description;
				}

				/***/ }),
			/* 26 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony default export */ __webpack_exports__["a"] = function (str) {
					return str.split(/([A-Z])/).reduce(function (one, two, idx) {
						var dash = !one || idx % 2 === 0 ? '' : '-';
						return '' + one + dash + two.toLowerCase();
					});
				};

				/***/ }),
			/* 27 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__native__ = __webpack_require__(33);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__root__ = __webpack_require__(3);
				function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }




				var MutationObserver = __WEBPACK_IMPORTED_MODULE_1__root__["a" /* default */].MutationObserver;


				function microtaskDebounce(cbFunc) {
					var scheduled = false;
					var i = 0;
					var cbArgs = [];
					var elem = document.createElement('span');
					var observer = new MutationObserver(function () {
						cbFunc.apply(undefined, _toConsumableArray(cbArgs));
						scheduled = false;
						cbArgs = null;
					});

					observer.observe(elem, { childList: true });

					return function () {
						for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
							args[_key] = arguments[_key];
						}

						cbArgs = args;
						if (!scheduled) {
							scheduled = true;
							elem.textContent = '' + i;
							i += 1;
						}
					};
				}

// We have to use setTimeout() for IE9 and 10 because the Mutation Observer
// polyfill requires that the element be in the document to trigger Mutation
// Events. Mutation Events are also synchronous and thus wouldn't debounce.
//
// The soonest we can set the timeout for in IE is 1 as they have issues when
// setting to 0.
				function taskDebounce(cbFunc) {
					var scheduled = false;
					var cbArgs = [];
					return function () {
						for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
							args[_key2] = arguments[_key2];
						}

						cbArgs = args;
						if (!scheduled) {
							scheduled = true;
							setTimeout(function () {
								scheduled = false;
								cbFunc.apply(undefined, _toConsumableArray(cbArgs));
							}, 1);
						}
					};
				}
				/* harmony default export */ __webpack_exports__["a"] = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__native__["a" /* default */])(MutationObserver) ? microtaskDebounce : taskDebounce;

				/***/ }),
			/* 28 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (immutable) */ __webpack_exports__["a"] = error;
				function error(message) {
					throw new Error(message);
				}

				/***/ }),
			/* 29 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (immutable) */ __webpack_exports__["a"] = getDefaultValue;
				function getDefaultValue(elem, propDef) {
					return typeof propDef.default === 'function' ? propDef.default(elem, { name: propDef.nameOrSymbol }) : propDef.default;
				}

				/***/ }),
			/* 30 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (immutable) */ __webpack_exports__["a"] = getInitialValue;
				function getInitialValue(elem, propDef) {
					return typeof propDef.initial === 'function' ? propDef.initial(elem, { name: propDef.nameOrSymbol }) : propDef.initial;
				}

				/***/ }),
			/* 31 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__get_prop_names_and_symbols__ = __webpack_require__(1);


				/* harmony default export */ __webpack_exports__["a"] = function () {
					var obj = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

					return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__get_prop_names_and_symbols__["a" /* default */])(obj).reduce(function (prev, nameOrSymbol) {
						prev[nameOrSymbol] = Object.getOwnPropertyDescriptor(obj, nameOrSymbol);
						return prev;
					}, {});
				};

				/***/ }),
			/* 32 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__data__ = __webpack_require__(5);
				/* harmony export (immutable) */ __webpack_exports__["a"] = getPropData;


				function getPropData(elem, name) {
					var elemData = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__data__["a" /* default */])(elem, 'props');
					return elemData[name] || (elemData[name] = {});
				}

				/***/ }),
			/* 33 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				var nativeHints = ['native code', '[object MutationObserverConstructor]' // for mobile safari iOS 9.0
				];
				/* harmony default export */ __webpack_exports__["a"] = function (fn) {
					return nativeHints.map(function (hint) {
						return (fn || '').toString().indexOf([hint]) > -1;
					}).reduce(function (a, b) {
						return a || b;
					});
				};

				/***/ }),
			/* 34 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assign__ = __webpack_require__(4);


				function enter(object, props) {
					var saved = {};
					Object.keys(props).forEach(function (key) {
						saved[key] = object[key];
						object[key] = props[key];
					});
					return saved;
				}

				function exit(object, saved) {
					__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__assign__["a" /* default */])(object, saved);
				}

// Decorates a function with a side effect that changes the properties of an
// object during its execution, and restores them after. There is no error
// handling here, if the wrapped function throws an error, properties are not
// restored and all bets are off.
				/* harmony default export */ __webpack_exports__["a"] = function (object, props) {
					return function (func) {
						return function () {
							var saved = enter(object, props);
							var result = func.apply(undefined, arguments);
							exit(object, saved);
							return result;
						};
					};
				};

				/***/ }),
			/* 35 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__dash_case__ = __webpack_require__(26);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__empty__ = __webpack_require__(6);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__error__ = __webpack_require__(28);
				/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__is_type__ = __webpack_require__(2);
				var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

				function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }






				/**
				 * @internal
				 * Property Definition
				 *
				 * Internal meta data and strategies for a property.
				 * Created from the options of a PropOptions config object.
				 *
				 * Once created a PropDefinition should be treated as immutable and final.
				 * 'getPropsMap' function memoizes PropDefinitions by Component's Class.
				 *
				 * The 'attribute' option is normalized to 'attrSource' and 'attrTarget' properties.
				 */

				var PropDefinition = function () {
					function PropDefinition(nameOrSymbol, propOptions) {
						var _this = this;

						_classCallCheck(this, PropDefinition);

						this._nameOrSymbol = nameOrSymbol;

						propOptions = propOptions || {};

						// default 'attrSource': no observed source attribute (name)
						this.attrSource = null;

						// default 'attrTarget': no reflected target attribute (name)
						this.attrTarget = null;

						// default 'attrTargetIsNotSource'
						this.attrTargetIsNotSource = false;

						// default 'coerce': identity function
						this.coerce = function (value) {
							return value;
						};

						// default 'default': set prop to 'null'
						this.default = null;

						// default 'deserialize': return attribute's value (string or null)
						this.deserialize = function (value) {
							return value;
						};

						// default 'get': no function
						this.get = null;

						// 'initial' default: unspecified
						// 'initial' option is truly optional and it cannot be initialized.
						// Its presence is tested using: ('initial' in propDef)

						// 'serialize' default: return string value or null
						this.serialize = function (value) {
							return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__empty__["a" /* default */])(value) ? null : String(value);
						};

						// default 'set': no function
						this.set = null;

						// Note: option key is always a string (no symbols here)
						Object.keys(propOptions).forEach(function (option) {
							var optVal = propOptions[option];

							// Only accept documented options and perform minimal input validation.
							switch (option) {
								case 'attribute':
									if (!__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__is_type__["c" /* isObject */])(optVal)) {
										_this.attrSource = _this.attrTarget = resolveAttrName(optVal, nameOrSymbol);
									} else {
										var source = optVal.source,
											target = optVal.target;

										if (!source && !target) {
											__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__error__["a" /* default */])(option + ' \'source\' or \'target\' is missing.');
										}
										_this.attrSource = resolveAttrName(source, nameOrSymbol);
										_this.attrTarget = resolveAttrName(target, nameOrSymbol);
										_this.attrTargetIsNotSource = _this.attrTarget !== _this.attrSource;
									}
									break;
								case 'coerce':
								case 'deserialize':
								case 'get':
								case 'serialize':
								case 'set':
									if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__is_type__["a" /* isFunction */])(optVal)) {
										_this[option] = optVal;
									} else {
										__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__error__["a" /* default */])(option + ' must be a function.');
									}
									break;
								case 'default':
								case 'initial':
									_this[option] = optVal;
									break;
								default:
									// TODO: undocumented options?
									_this[option] = optVal;
									break;
							}
						});
					}

					_createClass(PropDefinition, [{
						key: 'nameOrSymbol',
						get: function get() {
							return this._nameOrSymbol;
						}
					}]);

					return PropDefinition;
				}();

				/* harmony default export */ __webpack_exports__["a"] = PropDefinition;


				function resolveAttrName(attrOption, nameOrSymbol) {
					if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__is_type__["d" /* isSymbol */])(nameOrSymbol)) {
						__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__error__["a" /* default */])(nameOrSymbol.toString() + ' symbol property cannot have an attribute.');
					} else {
						if (attrOption === true) {
							return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__dash_case__["a" /* default */])(String(nameOrSymbol));
						}
						if (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3__is_type__["e" /* isString */])(attrOption)) {
							return attrOption;
						}
					}
					return null;
				}

				/***/ }),
			/* 36 */
			/***/ (function(module, __webpack_exports__, __webpack_require__) {

				"use strict";
				/* harmony export (immutable) */ __webpack_exports__["a"] = uniqueId;
// DEPRECATED prefix when we deprecated the name argument to define()
				function uniqueId(prefix) {
					// http://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript/2117523#2117523
					var rand = 'xxxxxxxx'.replace(/[xy]/g, function (c) {
						var r = Math.random() * 16 | 0;
						// eslint-disable-next-line no-mixed-operators
						var v = c === 'x' ? r : r & 0x3 | 0x8;
						return v.toString(16);
					});
					return (prefix || 'x') + '-' + rand;
				}

				/***/ }),
			/* 37 */
			/***/ (function(module, exports) {

				var g;

// This works in non-strict mode
				g = (function() {
					return this;
				})();

				try {
					// This works if eval is allowed (see CSP)
					g = g || Function("return this")() || (1,eval)("this");
				} catch(e) {
					// This works if the window reference is available
					if(typeof window === "object")
						g = window;
				}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

				module.exports = g;


				/***/ }),
			/* 38 */
			/***/ (function(module, exports, __webpack_require__) {

				module.exports = __webpack_require__(15);


				/***/ })
			/******/ ]);
	});

},{"incremental-dom":3}],3:[function(require,module,exports){

	/**
	 * @license
	 * Copyright 2015 The Incremental DOM Authors. All Rights Reserved.
	 *
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 *
	 *      http://www.apache.org/licenses/LICENSE-2.0
	 *
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS-IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */

	'use strict';

	/**
	 * Copyright 2015 The Incremental DOM Authors. All Rights Reserved.
	 *
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 *
	 *      http://www.apache.org/licenses/LICENSE-2.0
	 *
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS-IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */

	/**
	 * A cached reference to the hasOwnProperty function.
	 */
	var hasOwnProperty = Object.prototype.hasOwnProperty;

	/**
	 * A cached reference to the create function.
	 */
	var create = Object.create;

	/**
	 * Used to prevent property collisions between our "map" and its prototype.
	 * @param {!Object<string, *>} map The map to check.
	 * @param {string} property The property to check.
	 * @return {boolean} Whether map has property.
	 */
	var has = function (map, property) {
		return hasOwnProperty.call(map, property);
	};

	/**
	 * Creates an map object without a prototype.
	 * @return {!Object}
	 */
	var createMap = function () {
		return create(null);
	};

	/**
	 * Keeps track of information needed to perform diffs for a given DOM node.
	 * @param {!string} nodeName
	 * @param {?string=} key
	 * @constructor
	 */
	function NodeData(nodeName, key) {
		/**
		 * The attributes and their values.
		 * @const {!Object<string, *>}
		 */
		this.attrs = createMap();

		/**
		 * An array of attribute name/value pairs, used for quickly diffing the
		 * incomming attributes to see if the DOM node's attributes need to be
		 * updated.
		 * @const {Array<*>}
		 */
		this.attrsArr = [];

		/**
		 * The incoming attributes for this Node, before they are updated.
		 * @const {!Object<string, *>}
		 */
		this.newAttrs = createMap();

		/**
		 * The key used to identify this node, used to preserve DOM nodes when they
		 * move within their parent.
		 * @const
		 */
		this.key = key;

		/**
		 * Keeps track of children within this node by their key.
		 * {?Object<string, !Element>}
		 */
		this.keyMap = null;

		/**
		 * Whether or not the keyMap is currently valid.
		 * {boolean}
		 */
		this.keyMapValid = true;

		/**
		 * The node name for this node.
		 * @const {string}
		 */
		this.nodeName = nodeName;

		/**
		 * @type {?string}
		 */
		this.text = null;
	}

	/**
	 * Initializes a NodeData object for a Node.
	 *
	 * @param {Node} node The node to initialize data for.
	 * @param {string} nodeName The node name of node.
	 * @param {?string=} key The key that identifies the node.
	 * @return {!NodeData} The newly initialized data object
	 */
	var initData = function (node, nodeName, key) {
		var data = new NodeData(nodeName, key);
		node['__incrementalDOMData'] = data;
		return data;
	};

	/**
	 * Retrieves the NodeData object for a Node, creating it if necessary.
	 *
	 * @param {Node} node The node to retrieve the data for.
	 * @return {!NodeData} The NodeData for this Node.
	 */
	var getData = function (node) {
		var data = node['__incrementalDOMData'];

		if (!data) {
			var nodeName = node.nodeName.toLowerCase();
			var key = null;

			if (node instanceof Element) {
				key = node.getAttribute('key');
			}

			data = initData(node, nodeName, key);
		}

		return data;
	};

	/**
	 * Copyright 2015 The Incremental DOM Authors. All Rights Reserved.
	 *
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 *
	 *      http://www.apache.org/licenses/LICENSE-2.0
	 *
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS-IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */

	/** @const */
	var symbols = {
		default: '__default',

		placeholder: '__placeholder'
	};

	/**
	 * @param {string} name
	 * @return {string|undefined} The namespace to use for the attribute.
	 */
	var getNamespace = function (name) {
		if (name.lastIndexOf('xml:', 0) === 0) {
			return 'http://www.w3.org/XML/1998/namespace';
		}

		if (name.lastIndexOf('xlink:', 0) === 0) {
			return 'http://www.w3.org/1999/xlink';
		}
	};

	/**
	 * Applies an attribute or property to a given Element. If the value is null
	 * or undefined, it is removed from the Element. Otherwise, the value is set
	 * as an attribute.
	 * @param {!Element} el
	 * @param {string} name The attribute's name.
	 * @param {?(boolean|number|string)=} value The attribute's value.
	 */
	var applyAttr = function (el, name, value) {
		if (value == null) {
			el.removeAttribute(name);
		} else {
			var attrNS = getNamespace(name);
			if (attrNS) {
				el.setAttributeNS(attrNS, name, value);
			} else {
				el.setAttribute(name, value);
			}
		}
	};

	/**
	 * Applies a property to a given Element.
	 * @param {!Element} el
	 * @param {string} name The property's name.
	 * @param {*} value The property's value.
	 */
	var applyProp = function (el, name, value) {
		el[name] = value;
	};

	/**
	 * Applies a style to an Element. No vendor prefix expansion is done for
	 * property names/values.
	 * @param {!Element} el
	 * @param {string} name The attribute's name.
	 * @param {*} style The style to set. Either a string of css or an object
	 *     containing property-value pairs.
	 */
	var applyStyle = function (el, name, style) {
		if (typeof style === 'string') {
			el.style.cssText = style;
		} else {
			el.style.cssText = '';
			var elStyle = el.style;
			var obj = /** @type {!Object<string,string>} */style;

			for (var prop in obj) {
				if (has(obj, prop)) {
					elStyle[prop] = obj[prop];
				}
			}
		}
	};

	/**
	 * Updates a single attribute on an Element.
	 * @param {!Element} el
	 * @param {string} name The attribute's name.
	 * @param {*} value The attribute's value. If the value is an object or
	 *     function it is set on the Element, otherwise, it is set as an HTML
	 *     attribute.
	 */
	var applyAttributeTyped = function (el, name, value) {
		var type = typeof value;

		if (type === 'object' || type === 'function') {
			applyProp(el, name, value);
		} else {
			applyAttr(el, name, /** @type {?(boolean|number|string)} */value);
		}
	};

	/**
	 * Calls the appropriate attribute mutator for this attribute.
	 * @param {!Element} el
	 * @param {string} name The attribute's name.
	 * @param {*} value The attribute's value.
	 */
	var updateAttribute = function (el, name, value) {
		var data = getData(el);
		var attrs = data.attrs;

		if (attrs[name] === value) {
			return;
		}

		var mutator = attributes[name] || attributes[symbols.default];
		mutator(el, name, value);

		attrs[name] = value;
	};

	/**
	 * A publicly mutable object to provide custom mutators for attributes.
	 * @const {!Object<string, function(!Element, string, *)>}
	 */
	var attributes = createMap();

// Special generic mutator that's called for any attribute that does not
// have a specific mutator.
	attributes[symbols.default] = applyAttributeTyped;

	attributes[symbols.placeholder] = function () {};

	attributes['style'] = applyStyle;

	/**
	 * Gets the namespace to create an element (of a given tag) in.
	 * @param {string} tag The tag to get the namespace for.
	 * @param {?Node} parent
	 * @return {?string} The namespace to create the tag in.
	 */
	var getNamespaceForTag = function (tag, parent) {
		if (tag === 'svg') {
			return 'http://www.w3.org/2000/svg';
		}

		if (getData(parent).nodeName === 'foreignObject') {
			return null;
		}

		return parent.namespaceURI;
	};

	/**
	 * Creates an Element.
	 * @param {Document} doc The document with which to create the Element.
	 * @param {?Node} parent
	 * @param {string} tag The tag for the Element.
	 * @param {?string=} key A key to identify the Element.
	 * @param {?Array<*>=} statics An array of attribute name/value pairs of the
	 *     static attributes for the Element.
	 * @return {!Element}
	 */
	var createElement = function (doc, parent, tag, key, statics) {
		var namespace = getNamespaceForTag(tag, parent);
		var el = undefined;

		if (namespace) {
			el = doc.createElementNS(namespace, tag);
		} else {
			el = doc.createElement(tag);
		}

		initData(el, tag, key);

		if (statics) {
			for (var i = 0; i < statics.length; i += 2) {
				updateAttribute(el, /** @type {!string}*/statics[i], statics[i + 1]);
			}
		}

		return el;
	};

	/**
	 * Creates a Text Node.
	 * @param {Document} doc The document with which to create the Element.
	 * @return {!Text}
	 */
	var createText = function (doc) {
		var node = doc.createTextNode('');
		initData(node, '#text', null);
		return node;
	};

	/**
	 * Creates a mapping that can be used to look up children using a key.
	 * @param {?Node} el
	 * @return {!Object<string, !Element>} A mapping of keys to the children of the
	 *     Element.
	 */
	var createKeyMap = function (el) {
		var map = createMap();
		var child = el.firstElementChild;

		while (child) {
			var key = getData(child).key;

			if (key) {
				map[key] = child;
			}

			child = child.nextElementSibling;
		}

		return map;
	};

	/**
	 * Retrieves the mapping of key to child node for a given Element, creating it
	 * if necessary.
	 * @param {?Node} el
	 * @return {!Object<string, !Node>} A mapping of keys to child Elements
	 */
	var getKeyMap = function (el) {
		var data = getData(el);

		if (!data.keyMap) {
			data.keyMap = createKeyMap(el);
		}

		return data.keyMap;
	};

	/**
	 * Retrieves a child from the parent with the given key.
	 * @param {?Node} parent
	 * @param {?string=} key
	 * @return {?Node} The child corresponding to the key.
	 */
	var getChild = function (parent, key) {
		return key ? getKeyMap(parent)[key] : null;
	};

	/**
	 * Registers an element as being a child. The parent will keep track of the
	 * child using the key. The child can be retrieved using the same key using
	 * getKeyMap. The provided key should be unique within the parent Element.
	 * @param {?Node} parent The parent of child.
	 * @param {string} key A key to identify the child with.
	 * @param {!Node} child The child to register.
	 */
	var registerChild = function (parent, key, child) {
		getKeyMap(parent)[key] = child;
	};

	/**
	 * Copyright 2015 The Incremental DOM Authors. All Rights Reserved.
	 *
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 *
	 *      http://www.apache.org/licenses/LICENSE-2.0
	 *
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS-IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */

	/** @const */
	var notifications = {
		/**
		 * Called after patch has compleated with any Nodes that have been created
		 * and added to the DOM.
		 * @type {?function(Array<!Node>)}
		 */
		nodesCreated: null,

		/**
		 * Called after patch has compleated with any Nodes that have been removed
		 * from the DOM.
		 * Note it's an applications responsibility to handle any childNodes.
		 * @type {?function(Array<!Node>)}
		 */
		nodesDeleted: null
	};

	/**
	 * Keeps track of the state of a patch.
	 * @constructor
	 */
	function Context() {
		/**
		 * @type {(Array<!Node>|undefined)}
		 */
		this.created = notifications.nodesCreated && [];

		/**
		 * @type {(Array<!Node>|undefined)}
		 */
		this.deleted = notifications.nodesDeleted && [];
	}

	/**
	 * @param {!Node} node
	 */
	Context.prototype.markCreated = function (node) {
		if (this.created) {
			this.created.push(node);
		}
	};

	/**
	 * @param {!Node} node
	 */
	Context.prototype.markDeleted = function (node) {
		if (this.deleted) {
			this.deleted.push(node);
		}
	};

	/**
	 * Notifies about nodes that were created during the patch opearation.
	 */
	Context.prototype.notifyChanges = function () {
		if (this.created && this.created.length > 0) {
			notifications.nodesCreated(this.created);
		}

		if (this.deleted && this.deleted.length > 0) {
			notifications.nodesDeleted(this.deleted);
		}
	};

	/**
	 * Makes sure that keyed Element matches the tag name provided.
	 * @param {!string} nodeName The nodeName of the node that is being matched.
	 * @param {string=} tag The tag name of the Element.
	 * @param {?string=} key The key of the Element.
	 */
	var assertKeyedTagMatches = function (nodeName, tag, key) {
		if (nodeName !== tag) {
			throw new Error('Was expecting node with key "' + key + '" to be a ' + tag + ', not a ' + nodeName + '.');
		}
	};

	/** @type {?Context} */
	var context = null;

	/** @type {?Node} */
	var currentNode = null;

	/** @type {?Node} */
	var currentParent = null;

	/** @type {?Element|?DocumentFragment} */
	var root = null;

	/** @type {?Document} */
	var doc = null;

	/**
	 * Returns a patcher function that sets up and restores a patch context,
	 * running the run function with the provided data.
	 * @param {function((!Element|!DocumentFragment),!function(T),T=)} run
	 * @return {function((!Element|!DocumentFragment),!function(T),T=)}
	 * @template T
	 */
	var patchFactory = function (run) {
		/**
		 * TODO(moz): These annotations won't be necessary once we switch to Closure
		 * Compiler's new type inference. Remove these once the switch is done.
		 *
		 * @param {(!Element|!DocumentFragment)} node
		 * @param {!function(T)} fn
		 * @param {T=} data
		 * @template T
		 */
		var f = function (node, fn, data) {
			var prevContext = context;
			var prevRoot = root;
			var prevDoc = doc;
			var prevCurrentNode = currentNode;
			var prevCurrentParent = currentParent;
			var previousInAttributes = false;
			var previousInSkip = false;

			context = new Context();
			root = node;
			doc = node.ownerDocument;
			currentParent = node.parentNode;

			if ('production' !== 'production') {}

			run(node, fn, data);

			if ('production' !== 'production') {}

			context.notifyChanges();

			context = prevContext;
			root = prevRoot;
			doc = prevDoc;
			currentNode = prevCurrentNode;
			currentParent = prevCurrentParent;
		};
		return f;
	};

	/**
	 * Patches the document starting at node with the provided function. This
	 * function may be called during an existing patch operation.
	 * @param {!Element|!DocumentFragment} node The Element or Document
	 *     to patch.
	 * @param {!function(T)} fn A function containing elementOpen/elementClose/etc.
	 *     calls that describe the DOM.
	 * @param {T=} data An argument passed to fn to represent DOM state.
	 * @template T
	 */
	var patchInner = patchFactory(function (node, fn, data) {
		currentNode = node;

		enterNode();
		fn(data);
		exitNode();

		if ('production' !== 'production') {}
	});

	/**
	 * Patches an Element with the the provided function. Exactly one top level
	 * element call should be made corresponding to `node`.
	 * @param {!Element} node The Element where the patch should start.
	 * @param {!function(T)} fn A function containing elementOpen/elementClose/etc.
	 *     calls that describe the DOM. This should have at most one top level
	 *     element call.
	 * @param {T=} data An argument passed to fn to represent DOM state.
	 * @template T
	 */
	var patchOuter = patchFactory(function (node, fn, data) {
		currentNode = /** @type {!Element} */{ nextSibling: node };

		fn(data);

		if ('production' !== 'production') {}
	});

	/**
	 * Checks whether or not the current node matches the specified nodeName and
	 * key.
	 *
	 * @param {?string} nodeName The nodeName for this node.
	 * @param {?string=} key An optional key that identifies a node.
	 * @return {boolean} True if the node matches, false otherwise.
	 */
	var matches = function (nodeName, key) {
		var data = getData(currentNode);

		// Key check is done using double equals as we want to treat a null key the
		// same as undefined. This should be okay as the only values allowed are
		// strings, null and undefined so the == semantics are not too weird.
		return nodeName === data.nodeName && key == data.key;
	};

	/**
	 * Aligns the virtual Element definition with the actual DOM, moving the
	 * corresponding DOM node to the correct location or creating it if necessary.
	 * @param {string} nodeName For an Element, this should be a valid tag string.
	 *     For a Text, this should be #text.
	 * @param {?string=} key The key used to identify this element.
	 * @param {?Array<*>=} statics For an Element, this should be an array of
	 *     name-value pairs.
	 */
	var alignWithDOM = function (nodeName, key, statics) {
		if (currentNode && matches(nodeName, key)) {
			return;
		}

		var node = undefined;

		// Check to see if the node has moved within the parent.
		if (key) {
			node = getChild(currentParent, key);
			if (node && 'production' !== 'production') {
				assertKeyedTagMatches(getData(node).nodeName, nodeName, key);
			}
		}

		// Create the node if it doesn't exist.
		if (!node) {
			if (nodeName === '#text') {
				node = createText(doc);
			} else {
				node = createElement(doc, currentParent, nodeName, key, statics);
			}

			if (key) {
				registerChild(currentParent, key, node);
			}

			context.markCreated(node);
		}

		// If the node has a key, remove it from the DOM to prevent a large number
		// of re-orders in the case that it moved far or was completely removed.
		// Since we hold on to a reference through the keyMap, we can always add it
		// back.
		if (currentNode && getData(currentNode).key) {
			currentParent.replaceChild(node, currentNode);
			getData(currentParent).keyMapValid = false;
		} else {
			currentParent.insertBefore(node, currentNode);
		}

		currentNode = node;
	};

	/**
	 * Clears out any unvisited Nodes, as the corresponding virtual element
	 * functions were never called for them.
	 */
	var clearUnvisitedDOM = function () {
		var node = currentParent;
		var data = getData(node);
		var keyMap = data.keyMap;
		var keyMapValid = data.keyMapValid;
		var child = node.lastChild;
		var key = undefined;

		if (child === currentNode && keyMapValid) {
			return;
		}

		if (data.attrs[symbols.placeholder] && node !== root) {
			if ('production' !== 'production') {}
			return;
		}

		while (child !== currentNode) {
			node.removeChild(child);
			context.markDeleted( /** @type {!Node}*/child);

			key = getData(child).key;
			if (key) {
				delete keyMap[key];
			}
			child = node.lastChild;
		}

		// Clean the keyMap, removing any unusued keys.
		if (!keyMapValid) {
			for (key in keyMap) {
				child = keyMap[key];
				if (child.parentNode !== node) {
					context.markDeleted(child);
					delete keyMap[key];
				}
			}

			data.keyMapValid = true;
		}
	};

	/**
	 * Changes to the first child of the current node.
	 */
	var enterNode = function () {
		currentParent = currentNode;
		currentNode = null;
	};

	/**
	 * Changes to the next sibling of the current node.
	 */
	var nextNode = function () {
		if (currentNode) {
			currentNode = currentNode.nextSibling;
		} else {
			currentNode = currentParent.firstChild;
		}
	};

	/**
	 * Changes to the parent of the current node, removing any unvisited children.
	 */
	var exitNode = function () {
		clearUnvisitedDOM();

		currentNode = currentParent;
		currentParent = currentParent.parentNode;
	};

	/**
	 * Makes sure that the current node is an Element with a matching tagName and
	 * key.
	 *
	 * @param {string} tag The element's tag.
	 * @param {?string=} key The key used to identify this element. This can be an
	 *     empty string, but performance may be better if a unique value is used
	 *     when iterating over an array of items.
	 * @param {?Array<*>=} statics An array of attribute name/value pairs of the
	 *     static attributes for the Element. These will only be set once when the
	 *     Element is created.
	 * @return {!Element} The corresponding Element.
	 */
	var coreElementOpen = function (tag, key, statics) {
		nextNode();
		alignWithDOM(tag, key, statics);
		enterNode();
		return (/** @type {!Element} */currentParent
		);
	};

	/**
	 * Closes the currently open Element, removing any unvisited children if
	 * necessary.
	 *
	 * @return {!Element} The corresponding Element.
	 */
	var coreElementClose = function () {
		if ('production' !== 'production') {}

		exitNode();
		return (/** @type {!Element} */currentNode
		);
	};

	/**
	 * Makes sure the current node is a Text node and creates a Text node if it is
	 * not.
	 *
	 * @return {!Text} The corresponding Text Node.
	 */
	var coreText = function () {
		nextNode();
		alignWithDOM('#text', null, null);
		return (/** @type {!Text} */currentNode
		);
	};

	/**
	 * Gets the current Element being patched.
	 * @return {!Element}
	 */
	var currentElement = function () {
		if ('production' !== 'production') {}
		return (/** @type {!Element} */currentParent
		);
	};

	/**
	 * Skips the children in a subtree, allowing an Element to be closed without
	 * clearing out the children.
	 */
	var skip = function () {
		if ('production' !== 'production') {}
		currentNode = currentParent.lastChild;
	};

	/**
	 * The offset in the virtual element declaration where the attributes are
	 * specified.
	 * @const
	 */
	var ATTRIBUTES_OFFSET = 3;

	/**
	 * Builds an array of arguments for use with elementOpenStart, attr and
	 * elementOpenEnd.
	 * @const {Array<*>}
	 */
	var argsBuilder = [];

	/**
	 * @param {string} tag The element's tag.
	 * @param {?string=} key The key used to identify this element. This can be an
	 *     empty string, but performance may be better if a unique value is used
	 *     when iterating over an array of items.
	 * @param {?Array<*>=} statics An array of attribute name/value pairs of the
	 *     static attributes for the Element. These will only be set once when the
	 *     Element is created.
	 * @param {...*} const_args Attribute name/value pairs of the dynamic attributes
	 *     for the Element.
	 * @return {!Element} The corresponding Element.
	 */
	var elementOpen = function (tag, key, statics, const_args) {
		if ('production' !== 'production') {}

		var node = coreElementOpen(tag, key, statics);
		var data = getData(node);

		/*
		 * Checks to see if one or more attributes have changed for a given Element.
		 * When no attributes have changed, this is much faster than checking each
		 * individual argument. When attributes have changed, the overhead of this is
		 * minimal.
		 */
		var attrsArr = data.attrsArr;
		var newAttrs = data.newAttrs;
		var attrsChanged = false;
		var i = ATTRIBUTES_OFFSET;
		var j = 0;

		for (; i < arguments.length; i += 1, j += 1) {
			if (attrsArr[j] !== arguments[i]) {
				attrsChanged = true;
				break;
			}
		}

		for (; i < arguments.length; i += 1, j += 1) {
			attrsArr[j] = arguments[i];
		}

		if (j < attrsArr.length) {
			attrsChanged = true;
			attrsArr.length = j;
		}

		/*
		 * Actually perform the attribute update.
		 */
		if (attrsChanged) {
			for (i = ATTRIBUTES_OFFSET; i < arguments.length; i += 2) {
				newAttrs[arguments[i]] = arguments[i + 1];
			}

			for (var _attr in newAttrs) {
				updateAttribute(node, _attr, newAttrs[_attr]);
				newAttrs[_attr] = undefined;
			}
		}

		return node;
	};

	/**
	 * Declares a virtual Element at the current location in the document. This
	 * corresponds to an opening tag and a elementClose tag is required. This is
	 * like elementOpen, but the attributes are defined using the attr function
	 * rather than being passed as arguments. Must be folllowed by 0 or more calls
	 * to attr, then a call to elementOpenEnd.
	 * @param {string} tag The element's tag.
	 * @param {?string=} key The key used to identify this element. This can be an
	 *     empty string, but performance may be better if a unique value is used
	 *     when iterating over an array of items.
	 * @param {?Array<*>=} statics An array of attribute name/value pairs of the
	 *     static attributes for the Element. These will only be set once when the
	 *     Element is created.
	 */
	var elementOpenStart = function (tag, key, statics) {
		if ('production' !== 'production') {}

		argsBuilder[0] = tag;
		argsBuilder[1] = key;
		argsBuilder[2] = statics;
	};

	/***
	 * Defines a virtual attribute at this point of the DOM. This is only valid
	 * when called between elementOpenStart and elementOpenEnd.
	 *
	 * @param {string} name
	 * @param {*} value
	 */
	var attr = function (name, value) {
		if ('production' !== 'production') {}

		argsBuilder.push(name, value);
	};

	/**
	 * Closes an open tag started with elementOpenStart.
	 * @return {!Element} The corresponding Element.
	 */
	var elementOpenEnd = function () {
		if ('production' !== 'production') {}

		var node = elementOpen.apply(null, argsBuilder);
		argsBuilder.length = 0;
		return node;
	};

	/**
	 * Closes an open virtual Element.
	 *
	 * @param {string} tag The element's tag.
	 * @return {!Element} The corresponding Element.
	 */
	var elementClose = function (tag) {
		if ('production' !== 'production') {}

		var node = coreElementClose();

		if ('production' !== 'production') {}

		return node;
	};

	/**
	 * Declares a virtual Element at the current location in the document that has
	 * no children.
	 * @param {string} tag The element's tag.
	 * @param {?string=} key The key used to identify this element. This can be an
	 *     empty string, but performance may be better if a unique value is used
	 *     when iterating over an array of items.
	 * @param {?Array<*>=} statics An array of attribute name/value pairs of the
	 *     static attributes for the Element. These will only be set once when the
	 *     Element is created.
	 * @param {...*} const_args Attribute name/value pairs of the dynamic attributes
	 *     for the Element.
	 * @return {!Element} The corresponding Element.
	 */
	var elementVoid = function (tag, key, statics, const_args) {
		elementOpen.apply(null, arguments);
		return elementClose(tag);
	};

	/**
	 * Declares a virtual Element at the current location in the document that is a
	 * placeholder element. Children of this Element can be manually managed and
	 * will not be cleared by the library.
	 *
	 * A key must be specified to make sure that this node is correctly preserved
	 * across all conditionals.
	 *
	 * @param {string} tag The element's tag.
	 * @param {string} key The key used to identify this element.
	 * @param {?Array<*>=} statics An array of attribute name/value pairs of the
	 *     static attributes for the Element. These will only be set once when the
	 *     Element is created.
	 * @param {...*} const_args Attribute name/value pairs of the dynamic attributes
	 *     for the Element.
	 * @return {!Element} The corresponding Element.
	 */
	var elementPlaceholder = function (tag, key, statics, const_args) {
		if ('production' !== 'production') {}

		elementOpen.apply(null, arguments);
		skip();
		return elementClose(tag);
	};

	/**
	 * Declares a virtual Text at this point in the document.
	 *
	 * @param {string|number|boolean} value The value of the Text.
	 * @param {...(function((string|number|boolean)):string)} const_args
	 *     Functions to format the value which are called only when the value has
	 *     changed.
	 * @return {!Text} The corresponding text node.
	 */
	var text = function (value, const_args) {
		if ('production' !== 'production') {}

		var node = coreText();
		var data = getData(node);

		if (data.text !== value) {
			data.text = /** @type {string} */value;

			var formatted = value;
			for (var i = 1; i < arguments.length; i += 1) {
				/*
				 * Call the formatter function directly to prevent leaking arguments.
				 * https://github.com/google/incremental-dom/pull/204#issuecomment-178223574
				 */
				var fn = arguments[i];
				formatted = fn(formatted);
			}

			node.data = formatted;
		}

		return node;
	};

	exports.patch = patchInner;
	exports.patchInner = patchInner;
	exports.patchOuter = patchOuter;
	exports.currentElement = currentElement;
	exports.skip = skip;
	exports.elementVoid = elementVoid;
	exports.elementOpenStart = elementOpenStart;
	exports.elementOpenEnd = elementOpenEnd;
	exports.elementOpen = elementOpen;
	exports.elementClose = elementClose;
	exports.elementPlaceholder = elementPlaceholder;
	exports.text = text;
	exports.attr = attr;
	exports.symbols = symbols;
	exports.attributes = attributes;
	exports.applyAttr = applyAttr;
	exports.applyProp = applyProp;
	exports.notifications = notifications;


},{}],4:[function(require,module,exports){
	'use strict';

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	require('skatejs-web-components');

	var _skatejs = require('skatejs');

	var skate = _interopRequireWildcard(_skatejs);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	customElements.define('global-navigation', function (_skate$Component) {
		_inherits(_class, _skate$Component);

		function _class() {
			_classCallCheck(this, _class);

			return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
		}

		_createClass(_class, [{
			key: 'i18n',
			value: function i18n(key) {
				// FIXME: lol
				return key.split('-').slice(-1).pop();
			}
		}, {
			key: 'style',
			value: function style() {
				return skate.h(
					'style',
					null,
					'@import \'http://wikiadesignsystem.com/assets/design-system.css\';',
					'.wds-global-navigation {\n\t\t\t\tz-index: 5000102;\n\t\t\t}'
				);
			}
		}, {
			key: 'logo',
			value: function logo() {
				if (!this.model.logo.header) {
					return;
				}

				// FIXME svgs should be rendered based on model data
				return skate.h(
					'a',
					{ 'class': 'wds-global-navigation__logo', href: this.model.logo.module.main.href },
					skate.h(
						'svg',
						{ 'class': 'wds-global-navigation__logo-image wds-is-wds-company-logo-fandom', xmlns: 'http://www.w3.org/2000/svg', width: '117', height: '23', viewBox: '0 0 117 23' },
						skate.h(
							'defs',
							null,
							skate.h(
								'linearGradient',
								{ id: 'logo-fandom-gradient', x1: '0%', x2: '63.848%', y1: '100%', y2: '32.54%' },
								skate.h('stop', { 'stop-color': '#94D11F', offset: '0%' }),
								skate.h('stop', { 'stop-color': '#09D3BF', offset: '100%' })
							)
						),
						skate.h(
							'g',
							{ 'fill-rule': 'evenodd' },
							skate.h('path', { d: 'M114.543 8.924c-1.028-1.086-2.48-1.66-4.197-1.66-1.748 0-3.18.79-4.062 2.23-.882-1.44-2.315-2.23-4.063-2.23-1.71 0-3.16.574-4.19 1.66-.96 1.013-1.48 2.432-1.48 3.997v6.48h3.24v-6.48c0-1.75.89-2.75 2.445-2.75s2.444 1.01 2.444 2.76v6.48h3.24v-6.48c0-1.75.89-2.75 2.44-2.75 1.554 0 2.444 1.005 2.444 2.756v6.48h3.24v-6.48c0-1.564-.53-2.983-1.487-3.996M37.3 1.467c-.26-.038-.53-.078-.81-.078-3.886 0-6.496 2.47-6.496 6.15V19.4h3.24v-8.717h3.397V7.78h-3.39v-.263c0-2.077 1.15-3.13 3.41-3.13.22 0 .43.035.657.073.085.014.17.03.26.042l.163.024v-3l-.13-.016-.29-.05m10.31 11.923c0 2.11-1.083 3.224-3.133 3.224-2.81 0-3.23-2.02-3.23-3.224 0-2.05 1.18-3.223 3.23-3.223 2.007 0 3.03 1.058 3.135 3.226m3.254.602c-.004-.226-.007-.43-.014-.61-.153-3.774-2.594-6.12-6.373-6.12-1.95 0-3.6.62-4.77 1.792-1.1 1.096-1.7 2.627-1.7 4.31 0 3.507 2.63 6.152 6.12 6.152 1.66 0 3.01-.6 3.92-1.736.134.534.32 1.05.56 1.54l.04.08h3.264l-.09-.19c-.91-1.938-.94-3.91-.96-5.217m8.774-6.73c-1.86 0-3.436.62-4.553 1.79-1.046 1.09-1.622 2.63-1.622 4.34v6.01h3.24v-6.01c0-2.05 1.07-3.23 2.935-3.23s2.938 1.174 2.938 3.223v6.01h3.237v-6.01c0-1.7-.576-3.24-1.622-4.336-1.115-1.17-2.69-1.79-4.552-1.79m17.61 6.125c0 2.11-1.085 3.224-3.135 3.224-2.812 0-3.232-2.02-3.232-3.224 0-2.05 1.18-3.22 3.235-3.22 2.006 0 3.03 1.055 3.134 3.223m2.786 0V3.095h-3.13v4.85c-.994-.423-1.724-.68-2.962-.68-3.82 0-6.385 2.453-6.385 6.103 0 3.5 2.655 6.15 6.17 6.15 1.79 0 3.085-.51 3.94-1.56.14.55.34 1.15.58 1.71l.033.082h3.27l-.088-.19c-1.048-2.27-1.428-4.937-1.428-6.174m11.655-.003c0 2.05-1.16 3.225-3.183 3.225-2.024 0-3.184-1.175-3.184-3.224 0-2.05 1.16-3.22 3.185-3.22 2.024 0 3.184 1.175 3.184 3.225M88.52 7.26c-3.78 0-6.42 2.52-6.42 6.13s2.64 6.13 6.42 6.13 6.42-2.52 6.42-6.127c0-3.607-2.64-6.126-6.42-6.126' }),
							skate.h('path', { fill: 'url(#logo-fandom-gradient)', d: 'M10.175 16.803c0 .19-.046.46-.26.666l-.81.69-7.362-6.94V8.51l8.094 7.627c.126.12.338.367.338.666zm11.21-8.096v2.525l-9.158 8.86a.673.673 0 0 1-.493.21.73.73 0 0 1-.514-.21l-.838-.76L21.384 8.707zm-6.976 4.498l-2.54 2.422-8.04-7.672a1.997 1.997 0 0 1-.01-2.9l2.54-2.423 8.04 7.672c.84.8.84 2.1 0 2.9zm-1.5-6.682L15.55 4c.406-.387.945-.6 1.52-.6.575 0 1.114.213 1.52.6l2.73 2.605-4.164 3.973-1.52-1.45-2.73-2.605zm10.17-.403L17.09.317l-.125-.12-.124.12-5.22 5.03L6.96.867 6.953.864 6.948.858l-.583-.47-.12-.098-.115.106L.052 6.11 0 6.16v5.76l.05.05 11.396 10.867.123.117.12-.117L23.07 11.97l.05-.05V6.17l-.05-.05z' })
						)
					),
					skate.h(
						'svg',
						{ 'class': 'wds-global-navigation__logo-image wds-is-wds-company-logo-powered-by-wikia', width: '128', height: '13', viewBox: '0 0 128 13', xmlns: 'http://www.w3.org/2000/svg' },
						skate.h(
							'g',
							{ fill: 'none', 'fill-rule': 'evenodd' },
							skate.h('path', { d: 'M3.233 8.427c.208 0 .409-.015.602-.046.194-.032.363-.091.51-.18a.986.986 0 0 0 .353-.376c.089-.163.134-.374.134-.637 0-.262-.045-.475-.134-.637a.99.99 0 0 0-.353-.377 1.395 1.395 0 0 0-.51-.178 3.69 3.69 0 0 0-.602-.046H1.819v2.477h1.414zm.497-3.89c.518 0 .958.075 1.32.226.364.15.66.349.887.596.228.247.394.528.499.845a3.158 3.158 0 0 1 0 1.963c-.105.319-.27.603-.5.85a2.458 2.458 0 0 1-.885.596c-.363.15-.803.226-1.321.226H1.819v2.964H0V4.536h3.73zm5.696 5.181c.08.328.21.623.388.885.177.262.41.472.695.63.286.16.633.238 1.043.238.409 0 .757-.079 1.043-.237.286-.159.517-.369.695-.631a2.71 2.71 0 0 0 .388-.885c.08-.328.122-.666.122-1.013a4.53 4.53 0 0 0-.122-1.054 2.799 2.799 0 0 0-.388-.908 1.968 1.968 0 0 0-.695-.637c-.286-.158-.634-.238-1.043-.238-.41 0-.757.08-1.043.238-.286.158-.518.37-.695.637a2.749 2.749 0 0 0-.388.908 4.471 4.471 0 0 0 0 2.067M7.763 6.985c.186-.528.452-.989.8-1.384a3.665 3.665 0 0 1 1.28-.925c.507-.224 1.077-.336 1.71-.336.64 0 1.213.112 1.715.336.502.223.927.533 1.275.925.347.395.614.856.8 1.384a5.19 5.19 0 0 1 .277 1.72 5.01 5.01 0 0 1-.278 1.684 4.017 4.017 0 0 1-.8 1.36 3.664 3.664 0 0 1-1.274.909c-.502.22-1.074.33-1.715.33-.633 0-1.203-.11-1.708-.33a3.654 3.654 0 0 1-1.281-.909 4.017 4.017 0 0 1-.8-1.36 4.981 4.981 0 0 1-.278-1.684c0-.617.092-1.19.278-1.72m15.282 5.818l-1.402-5.627h-.023l-1.38 5.627H18.4l-2.19-8.266h1.818l1.31 5.627h.023L20.8 4.537h1.7l1.414 5.695h.023l1.356-5.695h1.785l-2.225 8.266zm11.169-8.266v1.528h-4.368v1.771h4.01V9.25h-4.01v2.025h4.46v1.528h-6.28V4.537zm5.249 3.739c.417 0 .73-.092.939-.278.208-.185.312-.485.312-.903 0-.4-.104-.692-.312-.874-.21-.181-.522-.272-.94-.272h-1.992v2.327h1.993zm.649-3.74c.37 0 .705.061 1.002.18.297.12.552.284.764.492.213.21.375.45.487.723.111.274.168.57.168.887 0 .485-.103.906-.306 1.262-.206.354-.54.625-1.003.81v.023c.223.061.41.156.556.284a1.6 1.6 0 0 1 .36.451c.092.174.16.364.202.573.042.208.07.416.087.625.007.132.016.285.023.464.008.177.02.358.041.543.019.186.05.36.092.527.043.166.107.307.19.422H40.96a3.17 3.17 0 0 1-.186-.937c-.024-.363-.058-.71-.104-1.042-.062-.433-.193-.748-.394-.95-.201-.2-.53-.3-.985-.3h-1.82v3.23h-1.819V4.536h4.462zm10.207.001v1.528h-4.368v1.771h4.01V9.25h-4.01v2.025h4.46v1.528h-6.28V4.537zm4.878 6.738c.263 0 .517-.043.764-.128a1.7 1.7 0 0 0 .662-.422c.192-.197.347-.453.463-.77.116-.317.173-.702.173-1.157 0-.417-.04-.794-.12-1.13a2.278 2.278 0 0 0-.4-.863 1.776 1.776 0 0 0-.736-.548c-.305-.129-.683-.192-1.13-.192h-1.298v5.21h1.622zm.128-6.738c.532 0 1.03.085 1.49.254.458.17.856.425 1.192.765.335.34.598.764.789 1.273.188.51.282 1.108.282 1.795 0 .602-.077 1.157-.23 1.666-.155.51-.39.95-.702 1.32-.313.37-.704.662-1.17.875-.468.212-1.018.318-1.65.318h-3.57V4.537h3.57zm12.235 6.853c.178 0 .348-.016.51-.052.162-.034.305-.092.43-.174a.875.875 0 0 0 .294-.33c.073-.138.11-.316.11-.532 0-.423-.12-.727-.358-.908-.24-.182-.556-.273-.95-.273h-1.983v2.27h1.947zm-.104-3.508c.324 0 .59-.076.8-.231.208-.155.312-.404.312-.753a.954.954 0 0 0-.104-.474.761.761 0 0 0-.278-.29 1.165 1.165 0 0 0-.4-.144 2.63 2.63 0 0 0-.47-.041h-1.703v1.933h1.843zm.233-3.345c.394 0 .754.035 1.078.104.324.07.602.183.834.341.231.159.411.369.539.631.126.263.19.588.19.973 0 .417-.094.765-.284 1.041-.189.28-.468.506-.84.684.51.147.891.403 1.142.77.25.366.376.808.376 1.326 0 .416-.08.776-.242 1.082a2.12 2.12 0 0 1-.656.746 2.897 2.897 0 0 1-.938.43 4.255 4.255 0 0 1-1.083.137h-4.01V4.537h3.894zm3.486 0h2.04l1.934 3.265 1.923-3.265h2.028L76.03 9.63v3.172h-1.819V9.584z', fill: '#656E78' }),
							skate.h('path', { d: 'M102.992.404V12.81h2.79v-2.233l.96-.913 1.9 3.146h3.617l-3.487-5.004 3.346-3.268h-3.989l-1.604 1.89-.744.929V.404zM92.934 4.536l-1.05 5.649-1.375-5.65H87.3l-1.353 5.65-1.056-5.65H81.98l2.15 8.272h3.737l1.047-4.292 1.047 4.292H93.7l2.155-8.271zm32.036 5.173c-.355.463-.912.772-1.64.772-.834 0-1.5-.54-1.5-1.824 0-1.283.666-1.824 1.5-1.824.728 0 1.285.31 1.64.773V9.71zm2.784-2.767l.155-2.406h-2.546l-.192.906c-.587-.617-1.316-1.128-2.598-1.128-2.322 0-3.59 1.5-3.59 4.343 0 2.844 1.268 4.343 3.59 4.343 1.282 0 2.011-.51 2.598-1.128l.2.936h2.538l-.155-2.435V6.942zM98.83.45a1.594 1.594 0 1 0-.001 3.187A1.594 1.594 0 0 0 98.83.45m2.402 5.83V4.536h-3.996v8.272h3.996v-1.735h-1.253V6.28zM114.4 2.043a1.595 1.595 0 0 0 3.19 0 1.595 1.595 0 1 0-3.19 0m.445 4.237v4.793h-1.252v1.735h3.997V4.536h-3.997V6.28z', fill: '#092344' })
						)
					)
				);
			}
		}, {
			key: 'fandomOverviewLinks',
			value: function fandomOverviewLinks() {
				var _this2 = this;

				if (!this.model.fandom_overview.links) {
					return;
				}

				return this.model.fandom_overview.links.map(function (link) {
					return _this2.linkBranded(link);
				});
			}
		}, {
			key: 'linkBranded',
			value: function linkBranded(model) {
				var classes = ['wds-global-navigation__link'];

				classes.push('wds-is-' + model.brand);

				return skate.h(
					'a',
					{ 'class': classes.join(' ') },
					this.i18n(model.title.key)
				);
			}
		}, {
			key: 'globalNavOnclick',
			value: function globalNavOnclick(event) {
				var $eventTarget = $(event.target),
					$clickedToggle = $eventTarget.closest('.wds-dropdown__toggle'),
					$clickedDropdown = $eventTarget.closest('.wds-dropdown');

				if ($clickedToggle.length) {
					$clickedDropdown.toggleClass('wds-is-active');

					if ($clickedDropdown.hasClass('wds-is-active')) {
						$clickedDropdown.trigger('wds-dropdown-open');
					}
				}

				$(this).find('.wds-dropdown.wds-is-active').not($clickedDropdown).removeClass('wds-is-active').trigger('wds-dropdown-close');

				$(this).find('.wds-global-navigation').toggleClass('wds-dropdown-is-open', Boolean($clickedDropdown.hasClass('wds-is-active')));
			}
		}, {
			key: 'renderCallback',
			value: function renderCallback() {
				return skate.h(
					'div',
					{ 'class': 'wds-global-navigation', onClick: this.globalNavOnclick },
					this.style(),
					skate.h(
						'div',
						{ 'class': 'wds-global-navigation__content-bar' },
						this.logo(),
						skate.h(
							'div',
							{ 'class': 'wds-global-navigation__links-and-search' },
							this.fandomOverviewLinks(),
							skate.h(
								'div',
								{ 'class': 'wds-global-navigation__wikis-menu wds-dropdown' },
								skate.h(
									'div',
									{ 'class': 'wds-global-navigation__dropdown-toggle wds-dropdown__toggle' },
									skate.h(
										'span',
										null,
										'Wikis'
									),
									skate.h(
										'svg',
										{ 'class': 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron', width: '12', height: '12', viewBox: '0 0 12 12', xmlns: 'http://www.w3.org/2000/svg' },
										skate.h('path', { d: 'M1 3h10L6 9z' })
									)
								),
								skate.h(
									'div',
									{ 'class': 'wds-global-navigation__dropdown-content wds-dropdown__content' },
									skate.h(
										'ul',
										{ 'class': 'wds-is-linked wds-list' },
										skate.h(
											'li',
											null,
											skate.h(
												'a',
												{ 'class': 'wds-global-navigation__dropdown-link' },
												'Explore Wikis'
											)
										),
										skate.h(
											'li',
											null,
											skate.h(
												'a',
												{ 'class': 'wds-global-navigation__dropdown-link' },
												'Community Central'
											)
										),
										skate.h(
											'li',
											null,
											skate.h(
												'a',
												{ 'class': 'wds-global-navigation__dropdown-link' },
												'Fandom University'
											)
										)
									)
								)
							),
							skate.h(
								'form',
								{ 'class': 'wds-global-navigation__search' },
								skate.h(
									'div',
									{ 'class': 'wds-global-navigation__search-input-wrapper wds-dropdown ' },
									skate.h(
										'label',
										{ 'class': 'wds-dropdown__toggle wds-global-navigation__search-label' },
										skate.h(
											'svg',
											{ 'class': 'wds-icon wds-icon-small wds-global-navigation__search-label-icon', width: '24', height: '24', viewBox: '0 0 24 24', xmlns: 'http://www.w3.org/2000/svg' },
											skate.h(
												'g',
												{ 'fill-rule': 'evenodd' },
												skate.h('path', { d: 'M21.747 20.524l-4.872-4.871a.864.864 0 1 0-1.222 1.222l4.871 4.872a.864.864 0 1 0 1.223-1.223z' }),
												skate.h('path', { d: 'M3.848 10.763a6.915 6.915 0 0 1 6.915-6.915 6.915 6.915 0 0 1 6.915 6.915 6.915 6.915 0 0 1-6.915 6.915 6.915 6.915 0 0 1-6.915-6.915zm-1.729 0a8.643 8.643 0 0 0 8.644 8.644 8.643 8.643 0 0 0 8.644-8.644 8.643 8.643 0 0 0-8.644-8.644 8.643 8.643 0 0 0-8.644 8.644z' })
											)
										),
										skate.h('input', { type: 'search', name: 'query', placeholder: 'Search', autocomplete: 'off', 'class': 'wds-global-navigation__search-input' })
									),
									skate.h(
										'button',
										{ 'class': 'wds-button wds-is-text wds-global-navigation__search-close', type: 'reset', 'data-ember-action': '690' },
										skate.h(
											'svg',
											{ 'class': 'wds-icon wds-icon-small wds-global-navigation__search-close-icon', width: '24', height: '24', viewBox: '0 0 24 24', xmlns: 'http://www.w3.org/2000/svg' },
											skate.h('path', { d: 'M19.707 4.293a.999.999 0 0 0-1.414 0L12 10.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L10.586 12l-6.293 6.293a.999.999 0 1 0 1.414 1.414L12 13.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L13.414 12l6.293-6.293a.999.999 0 0 0 0-1.414', 'fill-rule': 'evenodd' })
										)
									),
									skate.h(
										'div',
										{ 'class': 'wds-dropdown__content wds-global-navigation__search-suggestions' },
										skate.h('ul', { 'class': 'wds-has-ellipsis wds-is-linked wds-list' })
									),
									skate.h(
										'button',
										{ 'class': 'wds-button wds-global-navigation__search-submit', type: 'button', disabled: true },
										skate.h(
											'svg',
											{ 'class': 'wds-icon wds-icon-small wds-global-navigation__search-submit-icon', width: '24', height: '24', viewBox: '0 0 24 24', xmlns: 'http://www.w3.org/2000/svg' },
											skate.h('path', { d: 'M22.999 12a1 1 0 0 0-1-1H4.413l5.293-5.293a.999.999 0 1 0-1.414-1.414l-7 7a1 1 0 0 0 0 1.415l7 7a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.415L4.413 13h17.586a1 1 0 0 0 1-1', 'fill-rule': 'evenodd' })
										)
									)
								)
							)
						),
						skate.h(
							'div',
							{ 'class': 'wds-global-navigation__account-menu wds-dropdown' },
							skate.h(
								'div',
								{ 'class': 'wds-global-navigation__dropdown-toggle wds-dropdown__toggle' },
								skate.h(
									'svg',
									{ 'class': 'wds-icon wds-icon-small', width: '24', height: '24', viewBox: '0 0 24 24', xmlns: 'http://www.w3.org/2000/svg' },
									skate.h('path', { d: 'M12 14c3.309 0 6-2.691 6-6V6c0-3.309-2.691-6-6-6S6 2.691 6 6v2c0 3.309 2.691 6 6 6zm5 2H7c-3.86 0-7 3.14-7 7a1 1 0 0 0 1 1h22a1 1 0 0 0 1-1c0-3.86-3.14-7-7-7z', 'fill-rule': 'evenodd' })
								),
								skate.h(
									'span',
									{ 'class': 'wds-global-navigation__account-menu-caption' },
									'My Account'
								),
								skate.h(
									'svg',
									{ 'class': 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron', width: '12', height: '12', viewBox: '0 0 12 12', xmlns: 'http://www.w3.org/2000/svg' },
									skate.h('path', { d: 'M1 3h10L6 9z' })
								)
							),
							skate.h(
								'div',
								{ 'class': 'wds-global-navigation__dropdown-content wds-dropdown__content wds-is-right-aligned' },
								skate.h(
									'ul',
									{ 'class': 'wds-has-lines-between wds-list' },
									skate.h(
										'li',
										null,
										skate.h(
											'a',
											{ rel: 'nofollow', href: '', 'class': 'wds-button wds-is-full-width' },
											'Sign In'
										)
									),
									skate.h(
										'li',
										null,
										skate.h(
											'div',
											{ 'class': 'wds-global-navigation__account-menu-dropdown-caption' },
											'Don\'t have an account?'
										),
										skate.h(
											'a',
											{ rel: 'nofollow', href: '', 'class': 'wds-button wds-is-full-width wds-is-secondary' },
											'Register'
										)
									)
								)
							)
						),
						skate.h(
							'div',
							{ 'class': 'wds-global-navigation__start-a-wiki' },
							skate.h(
								'a',
								{ 'class': 'wds-global-navigation__start-a-wiki-button wds-button wds-is-squished wds-is-secondary', href: 'http://www.wikia.com/Special:CreateNewWiki' },
								skate.h(
									'span',
									{ 'class': 'wds-global-navigation__start-a-wiki-caption' },
									'Start a Wiki'
								),
								skate.h(
									'svg',
									{ 'class': 'wds-global-navigation__start-a-wiki-icon wds-icon', width: '24', height: '24', viewBox: '0 0 24 24', xmlns: 'http://www.w3.org/2000/svg' },
									skate.h('path', { d: 'M11 13v9a1 1 0 1 0 2 0v-9h9a1 1 0 1 0 0-2h-9V2a1 1 0 1 0-2 0v9H2a1 1 0 1 0 0 2h9z', 'fill-rule': 'evenodd' })
								)
							)
						)
					)
				);
			}
		}], [{
			key: 'props',
			get: function get() {
				return {
					model: {
						attribute: true,
						deserialize: function deserialize(value) {
							return JSON.parse(value);
						},
						serialize: function serialize(value) {
							return JSON.stringify(value);
						}
					}
				};
			}
		}]);

		return _class;
	}(skate.Component));

},{"skatejs":2,"skatejs-web-components":1}]},{},[4]);
