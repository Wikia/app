/**
 * URL String handler
 *
 * @author Jakub "Student" Olek <jakubolek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

(function (context) {
	'use strict';

	function isEmpty (o) {
		var k;

		for (k in o) {
			return false;
		}

		return true;
	}

	function querystring() {
		var l = context.location,
			p = Querystring.prototype,//late binding
			u;

		/**
		 * You can pass url to parse to it
		 * if url will be undefined, it'll grab URL from window.location
		 *
		 * @param url an URL to parse
		 * @constructor
		 */
		function Querystring(url){
			var srh,
				link,
				tmp,
				protocol,
				path = '',
				hash,
				pos,
				cache = {};

			if (url) {
				tmp = url.split('//', 2);
				protocol = tmp[1] ? tmp[0] : '';
				tmp = (tmp[1] || tmp[0]).split('#');
				hash = tmp[1] || '';
				tmp = tmp[0].split('?');

				link = tmp[0];

				pos = link.indexOf('/');
				if(pos > -1){
					path = link.slice(pos);
					link = link.slice(0, pos);
				}

				srh = tmp[1];
			}else{
				protocol = l.protocol;
				link = l.host;
				path = l.pathname;
				srh = l.search.substr(1);
				hash = l.hash.substr(1);
			}

			if (srh) {
				var tmpQuery = srh.split('&'),
					i = tmpQuery.length;

				while(i--){
					if(tmpQuery[i]) {
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

		/**
		 * Function that takes all parameters gathered and cast it to string
		 *
		 * @example new Querystring().toString()
		 * @example new Querystring() + 'some string'
		 *
		 * @return {String}
		 */
		p.toString = function () {
			var ret = ((this.protocol) ? this.protocol + '//' : '') + this.link + this.path + (isEmpty(this.cache) ? '' : '?'),
				attr, val,
				tmpArr = [];

			for (attr in this.cache) {
				val = this.cache[attr];
				tmpArr.push(attr + (val === u ? '' : '=' + val));
			}

			return ret + tmpArr.join('&') + ((this.hash) ? '#' + this.hash : '');
		};

		/**
		 * Function that returns value for given key from GET parameters
		 *
		 * @param name key to get value for
		 * @param defVal default value to return if given key does not exist
		 * @return {String}
		 */
		p.getVal = function (name, defVal) {
			return this.cache[name] || defVal;
		};


		/**
		 * Function to set value for a given key
		 *
		 * to remove key=value use removeVal(key)
		 *
		 * @param name key to set value for
		 * @param val value to set
		 * @return {Querystring}
		 */
		p.setVal = function (name, val) {
			if (name && val) {
				this.cache[name] = encodeURIComponent(val);
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
		 * @return {String} a hash from URL
		 */
		p.getHash = function () {
			return this.hash;
		};

		/**
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
		 *
		 * @return {String} a path part of URL
		 */
		p.getPath = function () {
			return this.path;
		};

		/**
		 *
		 * @param p String a path to set
		 * @return {Querystring}
		 */
		p.setPath = function (p) {
			this.path = p;
			return this;
		};

		/**
		 * a helper function to add CB value to URL
		 *
		 * @return {Querystring}
		 */
		p.addCb = function () {
			this.setVal('cb', Math.ceil(Math.random() * 10001));
			return this;
		};

		/**
		 * This will create an URL and reload a page with it
		 */
		p.goTo = function () {
			l.href = this.toString();
		};

		return Querystring;
	}

	//UMD
	if (context.define && context.define.amd) {
		//AMD
		define('querystring', querystring);//late binding
	} else {
		//namespace
		if(!context.Wikia) {
			context.Wikia = {};
		}

		context.Wikia.Querystring = querystring();//late binding
	}
}(this));