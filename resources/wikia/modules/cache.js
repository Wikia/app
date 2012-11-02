/**
 * Memcache-like API based on localStorage using JS global namespace as a fallback
 *
 * @author Federico "Lox" Lucignano
 * @author Piotr "Rychu" Gabryjeluk
 */

(function (context) {
	'use strict';

	var CACHE_VALUE_PREFIX = 'wkch_val_',
		CACHE_TTL_PREFIX = 'wkch_ttl_',
		undef;

	function cache() {
		var moduleStorage = {};

		function uniGet(key) {
			if (moduleStorage[key] !== undef) {
				return moduleStorage[key];
			}

			try {
				return context.localStorage.getItem(key);
			} catch (err) {
				return null;
			}
		}

		function uniSet(key, value) {
			moduleStorage[key] = value;
			try {
				context.localStorage.setItem(key, value);
			} catch (err) {}
		}

		function uniDel(key) {
			delete moduleStorage[key];
			try {
				context.localStorage.removeItem(key);
			} catch (err) {}
		}

		/**
		 * Save a value under given key
		 *
		 * @param key       key to save the value at
		 * @param value     any serializable object to store under the key
		 * @param ttl       (optional) TTL in seconds. If falsy: live forever
		 * @param customNow (optional) custom now (date object) for computing TTL
		 */
		function set(key, value, ttl, customNow) {
			var now = customNow || new Date();

			ttl = parseInt(ttl, 10);
			if (ttl) {
				uniSet(CACHE_TTL_PREFIX + key, now.getTime() + ttl * 1000);
			} else {
				uniDel(CACHE_TTL_PREFIX + key);
			}
			uniSet(CACHE_VALUE_PREFIX + key, JSON.stringify(value));
		}

		/**
		 * Delete the value under given key
		 *
		 * @param key       key to delete the value at
		 */
		function del(key) {
			uniDel(CACHE_TTL_PREFIX + key);
			uniDel(CACHE_VALUE_PREFIX + key);
		}

		/**
		 * Get previously saved value. If value is not available or expired, return null
		 *
		 * @param key       key to get
		 * @param customNow (optional) custom now (date object) for computing TTL
		 */
		function get(key, customNow) {
			var ttl = uniGet(CACHE_TTL_PREFIX + key),
				value,
				now = customNow || new Date();

			if (!ttl || ttl > now.getTime()) {
				value = uniGet(CACHE_VALUE_PREFIX + key);
				if (value) {
					return JSON.parse(value);
				}
			}

			del(key);
			return null;
		}

		/** public **/

		return {
			get: get,
			set: set,
			del: del
		};
	}

	// Register the module
	if (context.define && context.define.amd) {
		context.define('cache', cache);
	} else {
		context.Wikia = context.Wikia || {};
		context.Wikia.Cache = cache();
	}
}(this));
