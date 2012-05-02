/**
 * URL String handler
 *
 * @author Jakub "Student" Olek
 */

(function(){
	if(define){
		//AMD
		define('querystring', querystring);//late binding
	}else{
		window.Querystring = querystring();//late binding
	}

	function querystring(){
		var l = window.location;

		return function(url){
			var srh,
				cache = {},
				link,
				tmp,
				protocol,
				path = '',
				hash,
				pos;

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
					cache[tmp[0]] = tmp[1];
				}
			}

			return {
				toString: function(){
					var ret = (protocol ? protocol + '//' : '') + link + path + '?',
						attr;
					for(attr in cache){
						ret += attr + '=' + cache[attr] + '&';
					}
					return ret.slice(0, -1) + (hash ? '#' + hash : '');
				},

				getVal: function(name, defVal){
					return cache[name] || defVal;
				},

				setVal: function(name, val){
					if(val != ''){
						cache[name] = val;
					}else{
						delete cache[name];
					}
				},

				getHash: function(){
					return hash;
				},

				setHash: function(h){
					hash = h;
				},

				getPath: function(){
					return path;
				},

				setPath: function(p){
					path = p;
				},

				goTo: function(){
					//We don't want these to be in url on load
					if(hash == 'pop' || hash == 'Modal'){
						hash = '';
					}
					l.href = this.toString();
				}
			}
		}
	}
})();