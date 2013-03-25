/**
 * Memcache-like API based on localStorage using JS global namespace as a fallback
 *
 * @author Federico "Lox" Lucignano
 * @author Piotr "Rychu" Gabryjeluk
 * @author Jakub "Gordon" Olek
 */

(function (context) {
	'use strict';

	var CACHE_PREFIX = 'wkch_',
		CACHE_VALUE_PREFIX = CACHE_PREFIX + 'val_',
		CACHE_TTL_PREFIX = CACHE_PREFIX + 'ttl_',
		CACHE_VARY_PREFIX = CACHE_PREFIX + 'vary_',
		storage,
		undef;

	function cache(localStorage, window) {
		var moduleStorage = {};

		/**
		 * Gets a value from the storage
		 *
		 * @private
		 *
		 * @param {String} key Storage key
		 *
		 * @return {Mixed} Sored value or null
		 */
		function uniGet(key) {
			if (moduleStorage[key] !== undef) {
				return moduleStorage[key];
			}

			try {
				return localStorage.getItem(key);
			} catch (err) {
				return null;
			}
		}

		/**
		 * Sets a value in the storage
		 *
		 * @private
		 *
		 * @param {String} key   Storage key
		 * @param {Mixed}  value Value to store
		 */
		function uniSet(key, value) {
			moduleStorage[key] = value;
			try {
				localStorage.setItem(key, value);
			} catch (err) {}
		}

		/**
		 * Removes a value from the storage
		 *
		 * @private
		 *
		 * @param {String} key Storage key
		 */
		function uniDel(key) {
			delete moduleStorage[key];
			try {
				localStorage.removeItem(key);
			} catch (err) {}
		}

		/**
		 * Save a value under given key
		 *
		 * @public
		 *
		 * @param {String}  key       Key to save the value at
		 * @param {Mixed}   value     Any serializable object to store under the key
		 * @param {Integer} ttl       [OPTIONAL] TTL in seconds. If falsy: live forever
		 * @param {Date}    customNow [OPTIONAL] Custom now (date object) for computing TTL
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
		 * Delete the value under given key along with a cachebuster value associated with it
		 *
		 * @public
		 *
		 * @param {String} key Key to delete the value at
		 */
		function del(key) {
			uniDel(CACHE_TTL_PREFIX + key);
			uniDel(CACHE_VALUE_PREFIX + key);
			uniDel(CACHE_VARY_PREFIX + key);
		}

		/**
		 * Get previously saved value. If value is not available or expired, return null
		 *
		 * @public
		 *
		 * @param {String} key       Key to get
		 * @param {Date}   customNow [OPTIONAL] Custom now (date object) for computing TTL
		 *
		 * @return {Mixed} The value stored in the key or null
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

		/**
		 * Set a value under given name that will be vaild as long cachebuster don't get changed
		 *
		 * @public
		 *
		 * @param {String}  key       Key to save the value at
		 * @param {Mixed}   value     Any serializable object to store under the key
		 * @param {Integer} ttl       [OPTIONAL] TTL in seconds.
		 * @param {Date}    customNow [OPTIONAL] Custom now (date object) for computing TTL
		 */
		function setVersioned(key, value, ttl, customNow){
			set(key, value, ttl, customNow);
			uniSet(CACHE_VARY_PREFIX + key, window.wgStyleVersion);
		}

		/**
		 * Get previously saved value. If value is not available or expired, return null
		 *
		 * @public
		 *
		 * @param {String} key       Key to get
		 * @param {Date}   customNow [OPTIONAL] Custom now (date object) for computing TTL
		 *
		 * @return {Mixed} The value stored in the key or null
		 */
		function getVersioned(key, customNow){
			var vary = uniGet(CACHE_VARY_PREFIX + key);

			if(!vary || vary == window.wgStyleVersion) {
				return get(key, customNow);
			}

			del(key);
			return null;
		}

		return {
			get: get,
			set: set,
			del: del,
			setVersioned: setVersioned,
			getVersioned: getVersioned,
			delVersioned: del
		};
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	// Trying to access storage with cookies disabled can throw
	// security exceptions in some browsers like Firefox (BugId:94924)
	try {
		storage = context.localStorage;
	} catch( e ) {}

	//namespace
	context.Wikia.Cache = cache(storage, context);

	if (context.define && context.define.amd) {
		context.define('wikia.cache', ['wikia.localStorage', 'wikia.window'], cache);
	}
}(this));
