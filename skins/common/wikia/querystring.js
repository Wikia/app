/**
 * URL String handler
 *
 * @author Jakub "Student" Olek
 */

(function(){
	if(window.define){
		//AMD
		define('querystring', querystring);//late binding
	}else{
		window.Querystring = querystring();//late binding
	}

	function querystring(){
		var l = window.location,
			p = QueryString.prototype;//late binding

		function QueryString(url){
			var srh,
				link,
				tmp,
				protocol,
				path = '',
				hash,
				pos;

			this.cache = {};

			if(url) {
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
				hash = l.hash.substr(1)
			}

			if(srh){
				var tmpQuery = srh.split('&');

				for(var i = 0; i < tmpQuery.length; i++){
					tmp = tmpQuery[i].split('=');
					this.cache[tmp[0]] = tmp[1];
				}
			}

			this.protocol = protocol;
			this.link = link;
			this.path = path;
			this.srh = srh;
			this.hash = hash;
		}

		p.toString = function(){
			var ret = (this.protocol ? this.protocol + '//' : '') + this.link + this.path + '?',
				attr;

			for(attr in this.cache){
				ret += attr + '=' + this.cache[attr] + '&';
			}
			return ret.slice(0, -1) + (this.hash ? '#' + this.hash : '');
		};

		p.getVal = function(name, defVal){
			return this.cache[name] || defVal;
		};

		p.setVal = function(name, val){
			if(val != ''){
				this.cache[name] = val;
			}else{
				delete this.cache[name];
			}
		};

		p.getHash = function(){
			return this.hash;
		};

		p.setHash = function(h){
			this.hash = h;
		};

		p.getPath = function(){
			return this.path;
		};

		p.setPath = function(p){
			this.path = p;
		};

		p.addCb = function(){
			this.cache.cb = Math.ceil(Math.random() * 10001);
		};

		p.goTo = function(){
			//TODO: We don't want these to be in url on load, this should be refactored as is valid only for WikiaMobile
			if(this.hash == 'topbar' || this.hash == 'Modal'){
				this.hash = '';
			}

			l.href = this.toString();
		};

		return QueryString;
	}
})();