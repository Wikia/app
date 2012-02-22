/**
 * Memcache-like API based on localStorage using JS global namespace as a fallback
 *
 * @author Federico "Lox" Lucignano
 */

if(!window.Wikia) window.Wikia = {};

window.Wikia.Cache = (function(){
	/** @private **/
	
	var CACHE_PREFIX = 'wkch_',
		CACHE_EXP_SUFFIX = '_ttl',
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

	if(Modernizr.localstorage)
		ls = localStorage;
	else{
		var c = window.__wkCache__ = {};

		ls = {
			getItem: function(key){
				return c[key];
			},

			setItem: function(key, value){
				c[key] = '' + value;
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
				value = ls.getItem(getKey(key))
				value = (typeof value == 'undefined') ? null : JSON.parse(value);
			}else{
				this.del(key);
				value = null;
			}

			return value;
		},

		set: function(key, value, ttl/* seconds */){
			ttl = parseInt(ttl);
			ls.setItem(getKey(key), (typeof(value) == 'string') ? '"' + value + '"' : JSON.stringify(value));

			if(!isNaN(ttl) && ttl > 0)
				ls.setItem(getTtlKey(key), getTimestamp() + (ttl * 1000));
		},

		del: function(key){
			ls.removeItem(getKey(key));
			ls.removeItem(getTtlKey(key));
		}
	}
})();