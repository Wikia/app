/**
 * DartUrl - a module to help generating DART URLs
 *
 * @example
 *
 * The best way to build an URL is using urlBuilder:
 *
 * var url = DartUrl().urlBuilder('aa.doubleclick.net', 'adi/bb/cc');
 *
 * url.addParam('artid', '9');
 * url.addParam('cat', ['movie', 'tv', 'action']);
 * url.addString('genre=action;mom=mom;age=yadult;age=adult;');
 * url.toString();
 *
 * // The above gives you this:
 * // http://aa.doubleclick.net/adi/bb/cc;artid=9;cat=movie;cat=tv;cat=action;genre=action;mom=mom;age=yadult;age=adult;
 *
 * @return {Object}
 * @constructor
 *
 * TODO: This file is only used by JWPlayer. Remove it when JWPlayer is removed
 */
/*global define*/
define('ext.wikia.adEngine.dartUrl', function () {
	'use strict';

	var logGroup = 'DartUrlUtils';

	/**
	 * Trim DART parameter, so that it doesn't exceed given limit (by default 500 characters).
	 * If the parameter has multiple values, the trimming removes the whole values from the end
	 * instead of trimming them.
	 *
	 * @param kvs (if not empty MUST end with semicolon)
	 * @param limit (can be omitted or set to true, to apply the default limit)
	 * @return {String} (unless empty will end with ;)
	 */
	function trimParam(kvs, limit) {
		// default limit is 500:
		if (!limit || limit === true) {
			limit = 500;
		}
		kvs = kvs || '';
		kvs = kvs.substr(0, limit).replace(/;[^;]*$/, ';');
		if (!kvs.match(/;$/)) {
			kvs = '';
		}
		return kvs;
	}

	/**
	 * Decorate DART parameter, given key and value(s) produces the key=value1;key=value2;... string
	 * There happens additional encoding of values: spaces are converted to underscores and
	 * the whole value is then url-encoded (so DART can accept them)
	 *
	 * @param key
	 * @param value
	 * @return {String}
	 */
	function decorateParam(key, value) {
		var ret = '', i;

		if (value) {
			if (!(value instanceof Array)) {
				value = [value];
			}
			for (i = 0; i < value.length; i += 1) {
				if (value[i]) {
					ret += key + '=' + encodeURIComponent(value[i] + '') + ';';
				}
			}
		}

		return ret;
	}

	/**
	 * DART URL builder
	 *
	 * @param domain
	 * @param path
	 * @return {Object}
	 */
	function urlBuilder(domain, path) {
		var params = '';

		function toString() {
			return 'http://' + domain + '/' + path + ';' + params;
		}

		function addString(str, limit) {
			if (limit) {
				str = trimParam(str, limit);
			}
			params += str;
		}

		function addParam(key, value, limit) {
			addString(decorateParam(key, value), limit);
		}

		return {
			addParam: addParam,
			addString: addString,
			toString: toString
		};
	}

	return {
		decorateParam: decorateParam,
		trimParam: trimParam,
		urlBuilder: urlBuilder
	};
});
