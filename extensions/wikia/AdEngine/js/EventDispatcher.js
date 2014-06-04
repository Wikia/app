/*jslint nomen: true*/
/*global define*/
define('ext.wikia.adEngine.eventDispatcher', function () {
	'use strict';

	var Dispatcher = function () {
		this._events = {};
	};

	Dispatcher.prototype = {

		/**
		 * Binds callback function on particular event
		 *
		 * @param {string}   eventName Event name to listen to
		 * @param {Function} callback  Callback function to launch on trigger
		 * @param {boolean}  lazyBind  Runs callback for every trigger call before bind
		 */
		bind: function (eventName, callback, lazyBind) {

			var event = this._get(eventName), i, j;

			event.push(callback);

			if (lazyBind === true) {
				for (i = 0, j = event.calls.length; i < j; i = i + 1) {
					callback.apply(this, event.calls[i]);
				}
			}
		},

		/**
		 * Unbinds callback function on particular event
		 *
		 * @param {string}   eventName Event name to cleanup
		 * @param {Function} callback  A callback function to remove
		 */
		unbind: function (eventName, callback) {
			if (this._events.hasOwnProperty(eventName) && callback) {
				this._events[eventName].splice(this._events[eventName].indexOf(callback), 1);
			}
		},

		/**
		 * Triggers callbacks for event name
		 *
		 * @param eventName
		 */
		trigger: function (eventName /* , args... */) {
			var i, j, result = true, event = this._get(eventName),
				args = Array.prototype.slice.call(arguments, 1);

			event.calls.push(args);

			for (i = 0, j = event.length; result !== false && i < j; i = i + 1) {
				result = event[i].apply(this, args);
			}

			return result !== false;
		},


		/**
		 * Gets the eventName and returns event object
		 *
		 * @param eventName
		 * @returns {Array}
		 * @private
		 */
		_get: function (eventName) {
			if (!this._events.hasOwnProperty(eventName)) {
				this._events[eventName] = [];
			}

			if (!this._events[eventName].hasOwnProperty('calls')) {
				this._events[eventName].calls = [];
			}

			return this._events[eventName];
		}
	};

	return new Dispatcher();
});