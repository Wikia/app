/**
 * Geo-location utility used mainly for advertisement (e.g. Meebo, AdConfig)
 */

/*global define*/
(function (context) {
	'use strict';

	/**
	 * @private
	 */
	function geo(cookies) {
		var cookieName = 'Geo',
			geoData = false;

		/**
		 * @public
		 *
		 * @return {Object}
		 */
		function getGeoData() {
			if (geoData === false) {
				var jsonData = decodeURIComponent(cookies.get(cookieName));
				geoData = JSON.parse(jsonData) || {};
			}

			return geoData;
		}

		function getCountryCode() {
			var data = getGeoData();
			return data.country;
		}

		return {
			getGeoData: getGeoData,
			getCountryCode: getCountryCode
		};
	}

	//namespace, window.Geo is legacy support for Meebo, see /extensions/wikia/Geo/geo.js
	//this depends on cookies.js and will fail if window.Wikia.Cookies is not defined
	context.Geo = context.Wikia.geo = geo(context.Wikia.Cookies);

	if (typeof define !== 'undefined' && define.amd) {
		//AMD
		define('geo', function () {
			return context.Wikia.geo;
		});
	}
}(this));
