/**
 * URL String handler
 *
 * @author Jakub "Student" Olek <jakubolek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

(function (context) {
	'use strict';

	function querystring(location, win) {
		var l = location,
			p,
			u,
			a = document.createElement('a');

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
			if(!(this instanceof Querystring)) {
				return new Querystring(url);
			}

			var srh,
				tmp,
				cache = {},
				tmpQuery,
				i,
				loc = url ? a : l;

			if (url) {
				a.href = url;
			}

			srh = loc.search.substr(1);

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
			this.protocol = loc.protocol;
			this.link = loc.host;
			// found in DAR-744: IE returns bad pathname (no initial '/')
			// when <a> element is created in javascript
			this.path = (loc.pathname.charAt(0) != '/' ? '/' : '') + loc.pathname;

			this.hash = loc.hash.substr(1);
		}

		p = Querystring.prototype;

		/**
		 * Return a string representation of a QueryString instance
		 *
		 * @public
		 *
		 * @example new Querystring().toString()
		 * @example new Querystring() + 'some string'
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
					tmpArr.push(encodeURIComponent(attr) + (val === u ? '' : '=' + val));
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
		 * Get object with all parameters
		 *
		 * @public
		 *
		 * @return {Object}
		 */
		p.getVals = function () {
			var cacheCopy = {};
			for( var param in this.cache ) {
				cacheCopy[param] = this.cache[param];
			}
			return cacheCopy;
		};


		/**
		 * Sets a parameter by name
		 *
		 * @public
		 *
		 * to remove key=value use removeVal(key)
		 *
		 * @param {String} name The parameter's name
		 * @param {Mixed} val The parameter's value
		 * @param {Boolean} safe Val has already been uri encoded
		 */
		p.setVal = function (name, val, safe) {
			if (name) {
				if(typeof name === 'object') {
					val = val || '';

					for(var key in name) {
						if(name.hasOwnProperty(key)) {
							this.cache[val + key] = safe ? name[key] : encodeURIComponent(name[key]);
						}
					}
				} else if(val){
					this.cache[name] = safe ? val : encodeURIComponent(val);
				}
			}
			return this;
		};

		/**
		 * It can be called with a string as list then it'll remove one param
		 * if array of keys will be passed it'll remove all of them
		 *
		 * @param list string or array of keys to be removed from URL GET parametes
		 * @return {Querystring}
		 */
		p.removeVal = function(list){
			if (list instanceof Array){
				for(var i = 0, l = list.length; i < l; i++){
					delete this.cache[list[i]];
				}
			} else {
				delete this.cache[list];
			}
			return this;
		};

		/**
		 * Remove all parameters
		 *
		 * @public
		 * @return {Querystring}
		 */
		p.clearVals = function() {
			this.cache = {};
			return this;
		};

		/**
		 * @return {String} a hash from URL
		 */
		p.getHash = function () {
			return this.hash;
		};

		/**
		 * Sets the text after the hash (#)
		 *
		 * @public
		 *
		 * @param h String a hash to set
		 * @return {Querystring}
		 */
		p.setHash = function (h) {
			this.hash = h;
			return this;
		};

		/**
		 *
		 * Function that let's you remove hash from URL
		 * without any parameters will remove any hash
		 * or you can give a black list of hashes as array or a single black listed hash as string
		 *
		 * @param list a string or array
		 * @return {Querystring}
		 */
		p.removeHash = function(list){
			if (list === u || (list instanceof Array && list.indexOf(this.hash) > -1) || list === this.hash) {
				this.hash = '';
			}
			return this;
		};

		/**
		 * Gets the path of the URL
		 *
		 * @public
		 *
		 * @return {String} a path part of URL
		 */
		p.getPath = function () {
			return this.path;
		};

		/**
		 * Sets the path of the URL
		 *
		 * @public
		 *
		 * @param p String a path to set
		 *
		 * @return {Querystring}
		 */
		p.setPath = function (p) {
			this.path = p;
			return this;
		};

		/**
		 * Adds a cachebuster to the querystring
		 *
		 * @public
		 *
		 * @return {Querystring}
		 */
		p.addCb = function () {
			this.setVal('cb', Math.ceil(Math.random() * 10001));
			return this;
		};

		/**
		 * Loads the URL represented by the QueryString instance in the browser
		 *
		 * @public
		 */
		p.goTo = function () {
			l.href = this.toString();
		};

		/**
		 * @desc Sanitize HREF - checks if it's in valid format, i.e. it starts with a hash sign
		 * and is not empty; cuts hash sign from it if it's valid or returns empty string otherwise
		 *
		 * @public
		 *
		 * @param {String} href to sanitize
		 * @return {String}
		 */
		p.sanitizeHref = function(href) {
			href = href.trim();
			return (href.indexOf("#") === 0 && href.length > 1) ? href.slice(1) : '';
		};

		return Querystring;
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	//namespace
	context.Wikia.Querystring = querystring(window.location, context);

	if (context.define && context.define.amd) {
		context.define('wikia.querystring', ['wikia.location', 'wikia.window'], querystring);
	}
}(this));
