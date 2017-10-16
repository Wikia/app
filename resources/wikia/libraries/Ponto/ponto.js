/**
 * Ponto JavaScript implementation for WebViews
 *
 * @see  http://github.com/wikia-apps/Ponto
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 */

/*global define, require, PontoUriProtocol*/
(function (context) {
	'use strict';

	/**
	 * AMD support
	 *
	 * @private
	 *
	 * @type {Boolean}
	 */
	var amd = false;

	/**
	 * module constructor
	 *
	 * @private
	 *
	 * @return {Object} The module reference
	 */
	function ponto() {
		var
			/**
			 * [Constant] Name of the URI protocol optionally
			 * registered by the native layer
			 *
			 * @private
			 *
			 * @type {String}
			 *
			 * @see  protocol.request
			 * @see  protocol.response
			 */
				PROTOCOL_NAME = 'ponto',

			/**
			 * [Constant] Represents a completed request
			 *
			 * @private
			 *
			 * @type {Number}
			 *
			 * @see  Ponto.acceptResponse
			 */
				RESPONSE_COMPLETE = 0,

			/**
			 * [Constant] Represents a failed request with errors
			 *
			 * @private
			 *
			 * @type {Number}
			 *
			 * @see  Ponto.acceptResponse
			 */
				RESPONSE_ERROR = 1,

			/**
			 * [Constant] Indicates that the target is a native platform
			 *
			 * @type {Number}
			 */
				TARGET_NATIVE = 0,

			/**
			 * [Constant] Indicates that the target is an iframe
			 *
			 * @type {Number}
			 */
				TARGET_IFRAME = 1,

			/**
			 * [Constant] Indicates that the target is an iframe parent window
			 *
			 * @type {Number}
			 */
				TARGET_IFRAME_PARENT = 2,

			/**
			 * Window to communicate with (if iframe transport is overriden)
			 *
			 * @type {Window}
			 */
				targetWindow,

			/**
			 * Origin url of the targeted window
			 *
			 * @type {String}
			 */
				targetOrigin,

			/**
			 * Request / Response dispatcher
			 *
			 * @type {PontoDispatcher}
			 */
				dispatcher  = new PontoDispatcher(context),

			/**
			 * Registry for complete/error callbacks
			 *
			 * @private
			 *
			 * @type {Object}
			 */
				callbacks = {},

			/**
			 * Protocol helper
			 * registered by native platforms that
			 * have the capability to do so (e.g. Android) or
			 * implemented directly for those that don't (e.g iOS)
			 *
			 * @type {Object}
			 */
				protocol = nativeProtocol(),

			targets = {},

			exports;

		/**
		 * Returns a valid communication protocol for native platform
		 * @returns {*|{request: request, response: response}}
		 * Communication protocol methods for the native layer in an object
		 */
		function nativeProtocol () {
			return context.PontoProtocol || {
				//the only other chance is for the native layer to register
				//a custom protocol for communicating with the webview (e.g. iOS)
				request: function (execContext, target, method, params, callbackId) {
					if (execContext.location && execContext.location.href) {
						execContext.location.href = PROTOCOL_NAME + ':///request?target=' + encodeURIComponent(target) +
							'&method=' + encodeURIComponent(method) +
							((params) ? '&params=' + encodeURIComponent(params) : '') +
							((callbackId) ? '&callbackId=' + encodeURIComponent(callbackId) : '');
					} else {
						throw new LocationException();
					}
				},
				response: function (execContext, callbackId, params) {
					if (execContext.location && execContext.location.href) {
						execContext.location.href = PROTOCOL_NAME + ':///response?callbackId=' + encodeURIComponent(callbackId) +
							((params) ? '&params=' + encodeURIComponent(JSON.stringify(params)) : '');
					} else {
						throw new LocationException();
					}
				}
			};
		}

		/**
		 * Returns a valid communication protocol for the iframe
		 * @returns {{request: request, response: response}}
		 * Communication protocol methods for the iframe
		 */
		function iframeProtocol () {
			return {
				request: function (execContext, target, method, params, callbackId, async) {
					if (targetWindow.postMessage) {
						targetWindow.postMessage({
							protocol: PROTOCOL_NAME,
							action: 'request',
							target: target,
							method: method,
							params: params,
							async: async,
							callbackId: callbackId
						}, targetOrigin);
					} else {
						throw new PostMessageException();
					}
				},
				response: function (execContext, callbackId, result) {
					if (targetWindow.postMessage) {
						targetWindow.postMessage({
							protocol: PROTOCOL_NAME,
							action: 'response',
							type: (result && result.type) ? result.type : RESPONSE_COMPLETE,
							params: result,
							callbackId: callbackId
						}, targetOrigin);
					} else {
						throw new PostMessageException();
					}
				}
			};
		}

		/**
		 * Throws a post message error
		 */
		function PostMessageException() {
			this.message = 'Target context does not support postMessage';
		}

		/**
		 * Throws a user agent location error
		 */
		function LocationException() {
			this.message = 'Context doesn\'t support User Agent location API';
		}

		/**
		 * 'message' Event handler
		 * @param {Event} event
		 */
		function onMessage(event) {
			var data = event.data;
			if (data && data.protocol === PROTOCOL_NAME) {
				dispatcher[data.action](data);
			}
		}


		/**
		 * Request handler base class constructor
		 *
		 * @public
		 */
		function PontoBaseHandler() {}

		/**
		 * Request handler factory method, each subclass of
		 * PontoBaseHandler needs to implement this static method
		 */
		PontoBaseHandler.getInstance = function () {
			throw new Error('The getInstance method needs to be overridden in PontoBaseHandler subclasses');
		};

		/**
		 * PontoBaseHandler extension pattern
		 *
		 * @param {PontoBaseHandler} constructor The reference to a constructor
		 * of a type to be converted in a PontoBaseHandler subtype
		 *
		 * @example
		 * function MyHandler(){...}
		 * Ponto.PontoBaseHandler.derive(MyHandler);
		 * MyHandler.getInstance = function() {...};
		 */
		PontoBaseHandler.derive = function (constructor) {
			constructor.handlerSuper = PontoBaseHandler;
			constructor.getInstance = PontoBaseHandler.getInstance;
			constructor.prototype = new PontoBaseHandler();
		};

		/**
		 * Dispatches a request sent by the native layer
		 *
		 * @private
		 *
		 * @param {Object} scope The execution scope
		 * @param {Mixed} target A reference to a constructor or a static instance
		 * @param {RequestParams} data An hash containing the parameters associated to the request
		 */
		function dispatchRequest(scope, target, data) {
			var instance,
				result;

			if (target && target.handlerSuper === PontoBaseHandler && target.getInstance) {
				instance = target.getInstance();

				//unfortunately we need to instantiate before being able to
				if (instance[data.method]) {
					if (data.async) {
						instance[data.method](data.params, data.callbackId);
					} else {
						result = instance[data.method](data.params);

						if (data.callbackId && protocol && protocol.response) {
							protocol.response(scope, data.callbackId, result);
						}
					}
				}
			}
		}

		/**
		 * Function called by the native layer when answering a request
		 *
		 * @public
		 *
		 * @param {Object} scope The execution scope
		 * @param {ResponseParams} data An hash containing the parameters associated to the response
		 */
		function dispatchResponse(data) {
			var
				callbackId = data.callbackId,
				cbGroup = callbacks[callbackId],
				callback,
				responseType;

			if (cbGroup) {
				responseType = data.type;

				switch (responseType) {
					case RESPONSE_COMPLETE:
						callback = cbGroup.complete;
						break;
					case RESPONSE_ERROR:
					default:
						callback = cbGroup.error;
						break;
				}

				if (callback) {
					callback(data.params);
				}

				delete callbacks[callbackId];
			}
		}

		/**
		 * Initialized iframe protocol to work
		 */
		function setIframeProtocol () {
			protocol = iframeProtocol();
			context.addEventListener('message', onMessage, false);

			/**
			 * Enables manual trigger of the response when async operation needed
			 * this can be explicitly called after the async operation is done
			 * @param {Object} result response params, optionally with 'type' field
			 * @param {Number} callbackId
			 */
			PontoDispatcher.prototype.respond = function (result, callbackId) {
				protocol.response(this.context, callbackId, result);
			};
		}

		/**
		 * Sets iframe's content window as the protocol's target
		 * @param {String} _targetOrigin - origin URL of the iframe's document
		 * @param {Window} _targetWindow
		 */
		targets[TARGET_IFRAME] = function (_targetOrigin, _targetWindow) {
			if (_targetWindow.top && _targetWindow !== _targetWindow.top) {
				targetWindow = _targetWindow;
				targetOrigin = _targetOrigin;
			} else {
				throw new Error('Bad iframe content window provided.');
			}
			setIframeProtocol();
		};

		/**
		 * @param {String} _targetOrigin - origin URL of the parent's document
		 * Sets iframe's parent window as the protocol's target
		 */
		targets[TARGET_IFRAME_PARENT] = function (_targetOrigin) {
			if (context.top && context.top !== context) {
				targetWindow = context.top;
				targetOrigin = _targetOrigin;
			} else {
				throw new Error('No possible communication in this context.');
			}
			setIframeProtocol();
		};

		/**
		 * Sets the native layer as the protocol's target
		 */
		targets[TARGET_NATIVE] = function () {
			protocol = nativeProtocol();
			if (PontoDispatcher.prototype.respond) {
				delete PontoDispatcher.prototype.respond;
				context.removeEventListener('message', onMessage);
			}
		};

		/**
		 * Overrides the protocol target (default: native)
		 * @param {Number} _target
		 * @param {String | undefined} _targetOrigin - origin url of the targeted window
		 * @param {Number | undefined}_targetWindow
		 * provide if target is an iframe
		 */
		function setTarget(_target, _targetOrigin, _targetWindow) {
			if (targets[_target]) {
				targets[_target](_targetOrigin, _targetWindow);
			}
		}

		/**
		 * Deserializes JSON string if needed
		 * @param {Object | String} data
		 * @returns {Object}
		 */
		function parse(data) {
			return typeof data === 'string' ? JSON.parse(data) : data;
		}

		/**
		 * RequestParams constructor
		 *
		 * Extracts and normalizes the parameters out of a JSON-encoded string
		 * passed in by a request from the native context
		 *
		 * @private
		 *
		 * @param {String} data JSON-encoded string describing parameters
		 * for a request to Ponto
		 */
		function RequestParams(data) {
			var hash = parse(data);

			this.target = hash.target;
			this.method = hash.method;
			this.params = parse(hash.params);
			this.callbackId = hash.callbackId;
			this.async = hash.async;
		}

		/**
		 * ResponseParams constructor
		 *
		 * Extracts and normalizes the parameters out of a JSON-encoded string
		 * passed in by a response from the native context
		 *
		 * @private
		 *
		 * @param {String} data JSON-encoded string describing parameters
		 * for a response from Ponto
		 */
		function ResponseParams(data) {
			var hash = parse(data);

			this.type = parseInt(hash.type, 10);
			this.callbackId = hash.callbackId;
			this.params = hash.params;
		}

		/**
		 * Ponto dispatcher constructor
		 *
		 * @public
		 *
		 * @param {Object} dispatchContext The execution scope to bind to this instance
		 */
		function PontoDispatcher(dispatchContext) {
			this.context = dispatchContext;
		}

		/**
		 * Sets the context/scope to bind to the PontoDispatcher instance
		 *
		 * @public
		 *
		 * @param {Object} scope The context/scope to bind to the instance
		 */
		PontoDispatcher.prototype.setContext = function (scope) {
			this.context = scope;
		};

		/**
		 * Handle a request from the native layer,
		 * this is supposed to be called directly from native code
		 *
		 * @public
		 *
		 * @param {String} data A JSON-encoded string containing the parameters
		 * associated to the request
		 */
		PontoDispatcher.prototype.request = function (data) {
			var params = new RequestParams(data),
				scope = this.context,
				target = scope[params.target];

			if (target) {
				dispatchRequest(scope, target, params);
			} else if (amd && params.target) {
				require([params.target], function (target) {
					dispatchRequest(scope, target, params);
				});
			}
		};

		/**
		 * Handle a response from the native layer,
		 * this is supposed to be called directly from native code
		 *
		 * @public
		 *
		 * @param {String} data A JSON-encoded string containing the parameters
		 * associated to the response
		 */
		PontoDispatcher.prototype.response = function (data) {
			var params = new ResponseParams(data);
			dispatchResponse(params);
		};

		/**
		 * Makes a request to the native layer
		 *
		 * @public
		 *
		 * @param {String} target The target native class
		 * @param {String} method The method to call
		 * @param {Object} params [OPTIONAL] An hash contaning the parameters to pass to the method
		 * @param {Function} completeCallback [OPTIONAL] The callback to invoke on completion
		 * @param {Function} errorCallback [OPTIONAL] The callback to invoke in case of error
		 * @param {Bool} async Indicates of the other side will make async operation and respond
		 * manually
		 */
			//ToDo -> Make the method take object with params (too many params now)
		PontoDispatcher.prototype.invoke = function (target, method, params, completeCallback, errorCallback, async) {
			var callbackId;

			if (typeof (completeCallback || errorCallback) === 'function') {
				callbackId = Math.random().toString().substr(2);
				callbacks[callbackId] = {
					complete: completeCallback,
					error: errorCallback
				};
			}

			protocol.request(this.context, target, method, JSON.stringify(params), callbackId, async);
		};

		exports = dispatcher;
		exports.RESPONSE_COMPLETE = RESPONSE_COMPLETE;
		exports.RESPONSE_ERROR = RESPONSE_ERROR;
		exports.TARGET_NATIVE = TARGET_NATIVE;
		exports.TARGET_IFRAME = TARGET_IFRAME;
		exports.TARGET_IFRAME_PARENT = TARGET_IFRAME_PARENT;
		exports.PontoDispatcher = PontoDispatcher;
		exports.PontoBaseHandler = PontoBaseHandler;
		exports.setTarget = setTarget;

		return exports;
	}

	//check for AMD availability
	if (typeof define !== 'undefined' && define.amd) {
		amd = true;
	}

	//make module available in the global scope
	context.Ponto = ponto();

	//if AMD available then register also as a module
	//to allow easy usage in other AMD modules
	if (amd) {
		amd = true;
		define('ponto', context.Ponto);
	}
}(this));
