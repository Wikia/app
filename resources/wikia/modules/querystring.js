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

	function querystring(){
		var l = context.location,
			p = Querystring.prototype,
			u;//late binding

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

		p.getVal = function (name, defVal) {
			return this.cache[name] || defVal;
		};

		p.setVal = function (name, val) {
			if(val === u){
				delete this.cache[name];
			}else{
				this.cache[name] = encodeURIComponent(val);
			}
			return this;
		};

		p.getHash = function () {
			return this.hash;
		};

		p.setHash = function (h) {
			this.hash = h;
			return this;
		};

		p.excludeHash = function(list){
			if ((list instanceof Array && list.indexOf(this.hash) > -1) || list === this.hash) {
				this.hash = '';
			}
			return this;
		};

		p.getPath = function () {
			return this.path;
		};

		p.setPath = function (p) {
			this.path = p;
			return this;
		};

		p.addCb = function () {
			this.setVal('cb', Math.ceil(Math.random() * 10001));
			return this;
		};

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