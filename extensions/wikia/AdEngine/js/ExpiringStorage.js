var ExpiringStorage = function(log, JSON) {
	'use strict';

	var logGroup = 'ExpiringStorage'
		, makeStorage
	;

	makeStorage = function(storage) {
		var getItem, setItem;

		/**
		 * Store value at given key for given number of milliseconds
		 *
		 * @param key        what key to store at
		 * @param value      what value to store
		 * @param expireTime in milliseconds
		 * @param customNow  (OPTIONAL) "now" date
		 */
		setItem = function(key, value, expireTime, customNow) {
			var now = customNow || new Date()
				, expires = now.getTime() + expireTime
				, data = JSON.stringify({v: value, e: expires})
			;

			storage.setItem(key, data);
		};

		/**
		 * Get value for given key
		 *
		 * @param key        what key to ask for
		 * @param customNow  (OPTIONAL) "now" date
		 */
		getItem = function(key, customNow) {
			var value = storage.getItem(key)
				, now = customNow || new Date()
				, data
			;

			if (value) {
				data = JSON.parse(value);

				if (data.e >= now.getTime()) {
					return data.v;
				}

				storage.removeItem(key);
			}
		};

		if (typeof(storage) === 'object'
			&& typeof(storage.getItem) === 'function'
			&& typeof(storage.setItem) === 'function'
			&& typeof(storage.removeItem) === 'function'
		) {
			return {
				getItem: getItem,
				setItem: setItem,
				removeItem: storage.removeItem
			};
		}

		log('makeStorage: No proper storage passed, using no-op functions!', 1, logGroup);
		return {
			getItem: function() {},
			setItem: function() {},
			removeItem: function() {}
		};
	};

	return {
		makeStorage: makeStorage
	};
};
