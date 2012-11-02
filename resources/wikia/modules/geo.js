/**
 * Geo-location utility used mainly for advertisement (e.g. AdConfig)
 */

/*global define*/
(function (context) {
	'use strict';

	function geo(cookies) {
		/** @private **/

		var cookieName = 'Geo',
			geoData = false;

		/**
		 * Gets the whole data as an object representation
		 *
		 * @return {Object} The geo data stored in the user's cookie
		 */
		function getGeoData() {
			if (geoData === false) {
				var jsonData = decodeURIComponent(cookies.get(cookieName));
				geoData = JSON.parse(jsonData) || {};
			}

			return geoData;
		}

		/**
		 * Returns the code for the country
		 *
		 * @return {String} The country code
		 */
		function getCountryCode() {
			var data = getGeoData();
			return data.country;
		}

		/**
		 * Returns the code for the continent
		 *
		 * @return {String} The contintent code
		 */
		function getContinentCode() {
			var data = getGeoData();
			return data.continent;
		}

		/** @public **/

		return {
			getGeoData: getGeoData,
			getCountryCode: getCountryCode,
			getContinentCode: getContinentCode
		};
	}

	//this depends on cookies.js and will fail if window.Wikia.Cookies is not defined
	//TODO: Can we remove the double alias in window.Geo and Wikia.geo
	//and just stick to one?
	context.Geo = context.Wikia.geo = geo(context.Wikia.Cookies);

	if (context.define && context.define.amd) {
		//AMD
		context.define('geo', function () {
			return context.Wikia.geo;
		});
	}
}(this));
