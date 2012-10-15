/*global define */
/**
 * Memcache-like API based on localStorage using JS global namespace as a fallback
 *
 * @author Federico "Lox" Lucignano
 */

(function(){
	if(window.define){
		//AMD
		define('cache', cache);//late binding
	}else{
		//namespace
		if(!window.Wikia) window.Wikia = {};

		window.Wikia.Cache = cache();//late binding
	}

	function cache(){
		/** @private **/
		
		var CACHE_PREFIX = 'wkch_',
			CACHE_EXP_SUFFIX = '_ttl',
			clean = false,
			ls;
	
		function getKey(token){
			return CACHE_PREFIX + token;
		}
	
		function getTtlKey(token){
			return  CACHE_PREFIX + token + CACHE_EXP_SUFFIX;
		}
	
		function getTimestamp(){
			return (new Date()).getTime();
		}
	
		if(window.localStorage){
			ls = localStorage;
		}else{
			var c = window.__wkCache__ = {};

			ls = {
				getItem: function(key){
					return c[key];
				},
	
				setItem: function(key, value){
					c[key] = value;
				},
	
				removeItem: function(key){
					delete c[key];
				}
			};
		}
	
		/** public **/
	
		return {
			get: function(key){
				var ttl = ls.getItem(getTtlKey(key)),
				value;
	
				if(ttl === null || typeof ttl == 'undefined' || (typeof ttl == 'string' && JSON.parse(ttl) > getTimestamp())){
					value = ls.getItem(getKey(key));
					value = (typeof value == 'undefined' || value === null) ? null : JSON.parse(value);
				}else{
					this.del(key);
					value = null;
				}
	
				return value;
			},
	
			set: function(key, value, ttl/* seconds */){
				ttl = parseInt(ttl);
				ls.setItem(getKey(key), JSON.stringify(value));
	
				if(!isNaN(ttl) && ttl > 0)
					ls.setItem(getTtlKey(key), getTimestamp() + (ttl * 1000));
	
				//attempt at cleaning old ttl's
				if(!clean)
					this.cleanup();
			},
	
			del: function(key){
				ls.removeItem(getKey(key));
				ls.removeItem(getTtlKey(key));
	
				//attempt at cleaning old ttl's
				if(!clean)
					this.cleanup();
			},
	
			cleanup: function(){
				for(var x = 0, y = ls.length, k; x < y; x++){
					k = ls.key(x);
	
					if( k !== null &&
						k.indexOf(CACHE_PREFIX) == 0 &&
						k.indexOf(CACHE_EXP_SUFFIX) > 0 &&
						JSON.parse(ls.getItem(k)) <= getTimestamp()
					){
						ls.removeItem(k);
						ls.removeItem(k.replace(CACHE_EXP_SUFFIX, ''));
					}
				}
	
				clean = true;
			}
		};
	};
})();