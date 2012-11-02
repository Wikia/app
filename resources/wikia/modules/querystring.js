/**
 * URL String handler
 *
 * @author Jakub "Student" Olek <jakubolek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

(function (context) {
	'use strict';

	function querystring() {
		var l = context.location,
			p,
			u;

		/**
		 * Checks if an object is empty (no properties)
		 *
		 * @private
		 *
		 * @param {Object} obj The object to check
		 *
		 * @return {Boolean} True if the object has no properties, false otherwise
		 */
		function isEmpty(obj) {
			var key;

			for (key in obj) {
				if (obj.hasOwnProperty(key)) {
					return false;
				}
			}

			return true;
		}

		/**
		 * An object representation of the URL's querystring
		 *
		 * @public
		 *
		 * @param {String} url The URL to parse for parameters
		 */
		function Querystring(url) {
			var srh,
				link,
				tmp,
				protocol,
				path = '',
				hash,
				pos,
				cache = {},
				tmpQuery,
				i;

			if (url) {
				tmp = url.split('//', 2);
				protocol = tmp[1] ? tmp[0] : '';
				tmp = (tmp[1] || tmp[0]).split('#');
				hash = tmp[1] || '';
				tmp = tmp[0].split('?');

				link = tmp[0];

				pos = link.indexOf('/');
				if (pos > -1) {
					path = link.slice(pos);
					link = link.slice(0, pos);
				}

				srh = tmp[1];
			} else {
				protocol = l.protocol;
				link = l.host;
				path = l.pathname;
				srh = l.search.substr(1);
				hash = l.hash.substr(1);
			}

			if (srh) {
				tmpQuery = srh.split('&');
				i = tmpQuery.length;

				while (i--) {
					if (tmpQuery[i]) {
						tmp = tmpQuery[i].split('=');
						cache[tmp[0]] = decodeURIComponent(tmp[1]) || '';
					}
				}
			}

			this.cache = cache;
			this.protocol = protocol;
			this.link = link;
			this.path = path;
			this.hash = hash;
		}

		p = Querystring.prototype;

		/**
		 * Return a string representation of a QueryString instance
		 *
		 * @public
		 *
		 * @return {String} The QueryString instance turned to a String
		 */
		p.toString = function () {
			var ret = ((this.protocol) ? this.protocol + '//' : '') + this.link + this.path + (isEmpty(this.cache) ? '' : '?'),
				attr,
				val,
				tmpArr = [];

			for (attr in this.cache) {
				if (this.cache.hasOwnProperty(attr)) {
					val = this.cache[attr];
					tmpArr.push(attr + (val === u ? '' : '=' + val));
				}
			}

			return ret + tmpArr.join('&') + ((this.hash) ? '#' + this.hash : '');
		};

		/**
		 * Gets a parameter by name
		 *
		 * @public
		 *
		 * @param {String} name The parameter's name
		 * @param {Mixed} defVal The value to return in case the parameter is not found
		 *
		 * @return {String} The parameter's value
		 */
		p.getVal = function (name, defVal) {
			return this.cache[name] || defVal;
		};

		/**
		 * Sets a parameter by name
		 *
		 * @public
		 *
		 * @param {String} name The parameter's name
		 * @param {Mixed} val The parameter's value
		 */
		p.setVal = function (name, val) {
			if (val === u) {
				delete this.cache[name];
			} else {
				this.cache[name] = encodeURIComponent(val);
			}
		};

		/**
		 * Gets the text after the hash (#)
		 *
		 * @public
		 *
		 * @return {String} The text after the hash
		 */
		p.getHash = function () {
			return this.hash;
		};

		/**
		 * Sets the text after the hash (#)
		 *
		 * @public
		 *
		 * @param {String} hash The text to put after the hash
		 */
		p.setHash = function (hash) {
			this.hash = hash;
		};

		/**
		 * Gets the path of the URL
		 *
		 * @public
		 *
		 * @return {String} The path of the URL
		 */
		p.getPath = function () {
			return this.path;
		};

		/**
		 * Sets the path of the URL
		 *
		 * @public
		 *
		 * @param {String} path The path of the URL
		 */
		p.setPath = function (path) {
			this.path = path;
		};

		/**
		 * Adds a cachebuster to the querystring
		 *
		 * @public
		 */
		p.addCb = function () {
			this.setVal('cb', Math.ceil(Math.random() * 10001));
		};

		/**
		 * Loads the URL represented by the QueryString instance in the browser
		 *
		 * @public
		 */
		p.goTo = function () {
			//TODO: We don't want these to be in url on load, this should be refactored as is valid only for WikiaMobile
			if (this.hash === 'topbar' || this.hash === 'Modal') {
				this.hash = '';
			}

			l.href = this.toString();
		};

		return Querystring;
	}

	//UMD exclusive
	if (context.define && context.define.amd) {
		context.define('querystring', querystring);
	} else {
		if (!context.Wikia) {
			context.Wikia = {};
		}

		context.Wikia.Querystring = querystring();
	}
}(this));