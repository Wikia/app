/**
 * Pure JS implementation of a cookie setter/getter to use in generic components
 * that shouldn't rely on jQuery's cookie plugin (e.g. AdEngine, A)
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

(function (context) {
	'use strict';

	function cookies(window) {
		var cookieReplaceRegEx1 = /^\s*/,
			cookieReplaceRegEx2 = /\s*$/,
			lastCookieContent,
			data;

		/**
		 * Parses cookies string into an object
		 *
		 * @private
		 *
		 * @return {Object} An object representation of the user's cookies
		 */
		function fetchCookies() {
			var cookieString = window.document.cookie,
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
		 * Gets the value of a cookie by name
		 *
		 * @public
		 *
		 * @param {String} name The name of the cookie
		 *
		 * @return {Mixed} The value of the cookie or null
		 */
		function get(name) {
			var val = fetchCookies()[name];

			return (typeof val !== 'undefined') ? val : null;
		}

		/**
		 * Sets the value of a cookie by name and also return its' string representation
		 *
		 * @public
		 *
		 * @param {String} name The name of the cookie
		 * @param {Mixed} value The value of the cookie
		 * @param {Object} options Options that apply to the cookie:
		 * - {Mixed} expires An integer (relative time from now) or a Date instance
		 * - {String} path The cookie's path
		 * - {String} domain The domain of validity
		 * - {Boolean} secure
		 *
		 * @return {String} The string representation of the cookie
		 */
		function set(name, value, options) {
			var expDate,
				cookieString,
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
				data.push('; domain=' + options.domain);
			}

			if (options.secure) {
				data.push('; secure');
			}

			cookieString = name + '=' + encodeURIComponent(value);

			for (x = 0, y = data.length; x < y; x += 1) {
				cookieString += data[x];
			}

			window.document.cookie = cookieString;
			return cookieString;
		}

		return {
			get: get,
			set: set
		};
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	//namespace
	context.Wikia.Cookies = cookies(context);

	if (context.define && context.define.amd) {
		context.define('wikia.cookies', ['wikia.window'], cookies);
	}
}(this));
