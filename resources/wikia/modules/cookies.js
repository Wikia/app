/**
 * Pure JS implementation of a cookie setter/getter to use in generic components
 * that shouldn't rely on jQuery's cookie plugin (e.g. AdEngine, A)
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

/*global define*/
(function (context) {
	'use strict';

	/**
	 * @private
	 */
	function cookies() {
		/** @private **/

		var cookieReplaceRegEx1 = /^\s*/,
			cookieReplaceRegEx2 = /\s*$/,
			lastCookieContent,
			data;

		/**
		 * @private
		 *
		 * @return {Object}
		 */
		function fetchCookies() {
			var cookieString = context.document.cookie,
				pair,
				name,
				value,
				separated,
				i,
				m;

			if (lastCookieContent !== cookieString) {
				data = {};
				lastCookieContent = cookieString;
				separated = cookieString.split(';');

				for (i = 0, m = separated.length; i < m; i += 1) {
					pair = separated[i].split('=');
					name = pair[0].replace(cookieReplaceRegEx1, '').replace(cookieReplaceRegEx2, '');
					value = decodeURIComponent(pair[1]);
					data[name] = value;
				}
			}

			return data;
		}

		/**
		 * @public
		 *
		 * @param {String} name
		 *
		 * @return {Mixed}
		 */
		function get(name) {
			var val = fetchCookies()[name];

			return (typeof val !== 'undefined') ? val : null;
		}

		/**
		 * @public
		 *
		 * @param {String} name
		 * @param {Mixed} value
		 * @param {Object} options
		 */
		function set(name, value, options) {
			var expDate,
				cookieString = '',
				data = [],
				x,
				y;

			options = options || {};

			if (typeof value === 'undefined' || value === null) {
				value = '';
				options.expires = -1;
			}

			if (options.expires) {
				if (typeof options.expires === 'number') {
					expDate = new Date();
					expDate.setTime(expDate.getTime() + (options.expires));
				} else if (options.expires instanceof Date) {
					expDate = options.expires;
				}

				//use expires attribute, max-age is not supported by IE
				data.push('; expires=' + expDate.toUTCString());
			}

			if (options.path) {
				data.push('; path=' + options.path);
			}

			if (options.domain) {
				data.push('; path=' + options.domain);
			}

			if (options.secure) {
				data.push('; secure');
			}

			cookieString = name + '=' + encodeURIComponent(value);

			for (x = 0, y = data.length; x < y; x += 1) {
				cookieString += data[x];
			}

			context.document.cookie = cookieString;
			return cookieString;
		}

		return {
			get: get,
			set: set
		};
	}

	// this module needs to be also available via a namespace for access early in the process
	if (!context.Wikia) {
		context.Wikia = {};
	}

	//namespace
	context.Wikia.Cookies = cookies();

	if (typeof define != 'undefined' && define.amd) {
		//AMD
		define('cookies', function () {
			return context.Wikia.Cookies;
		});
	}
}(this));