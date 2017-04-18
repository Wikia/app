/**
 * A set of AMD modules wrapping local storage API
 */
define('wikia.localStorage', ['wikia.window'], function(window) {
	'use strict';

	return window.localStorage || {
		_data: {},

		/**
		 * @param {string} key
		 * @param {string} value
		 * @returns {string}
		 */
		setItem: function(key, value) {
			var val = String(value);

			this._data[key] = val;
			return val;
		},

		/**
		 * @param {string} key
		 * @returns {string|undefined}
		 */
		getItem: function(key) {
			if (this._data.hasOwnProperty(key)) {
				return this._data[key];
			}

			// non-explict return undefined
		},

		/*
		 * @param {string} key
		 * @returns {string}
		 */
		removeItem: function(key) {
			var val = this._data[key];

			delete this._data[key];
			return val;
		},

		/**
		 * @returns {void}
		 */
		clear: function() {
			this._data = {};
		}
	};
});
