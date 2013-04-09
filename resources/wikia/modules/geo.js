/**
 * Geo-location utility used mainly for advertisement (e.g. AdConfig)
 */

(function (context) {
	'use strict';

	function geo(cookies) {
		var cookieName = 'Geo',
			geoData = false;

		/**
		 * Gets the whole data as an object representation
		 *
		 * @public
		 *
		 * @return {Object} The geo data stored in the user's cookie
		 */
		function getGeoData() {
			if (geoData === false) {
				var jsonData = decodeURIComponent(cookies.get(cookieName));

				// Fix for broken json in cookie
				try {
					geoData = JSON.parse(jsonData) || {};
				} catch (e) {
					geoData = {};
				}
			}

			return geoData;
		}

		/**
		 * Returns the code for the country
		 *
		 * @public
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
		 * @public
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

	//UMD inclusive
	//this depends on cookies.js and will fail if window.Wikia.Cookies is not defined
	//TODO: Can we remove the double alias in window.Geo and Wikia.geo
	//and just stick to one?
	if (context.Wikia) {
		context.Geo = context.Wikia.geo = geo(context.Wikia.Cookies);
	}

	if (context.define && context.define.amd) {
		//AMD
		context.define('wikia.geo', ['wikia.cookies'], geo);
	}
}(this));
