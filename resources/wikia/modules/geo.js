/**
 * Geo-location utility used mainly for advertisement (e.g. AdConfig)
 */

(function (context) {
	'use strict';

	function geo(cookies) {
		var cookieName = 'Geo',
			earth = 'XX',
			geoData = false,
			negativePrefix = 'non-';

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
		 * Set the country code
		 *
		 * @public
		 * @param {String} countryCode
		 */
		function setCountryCode(countryCode) {
			var data = getGeoData();
			data.country = countryCode;
			cookies.set(cookieName, JSON.stringify(data));
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

		/**
		 * Returns the code for the region
		 *
		 * @public
		 *
		 * @return {String} The region code
		 */
		function getRegionCode() {
			var data = getGeoData();
			return data.region;
		}

		/**
		 * Returns true if current country is in countryList
		 * @param {array} countryList
		 * @returns {boolean}
		 */
		function isProperCountry(countryList) {
			return !!(
				countryList &&
				countryList.indexOf &&
				countryList.indexOf(getCountryCode()) > -1
			);
		}

		/**
		 * Returns true if current region is in countryList
		 * @param {array} countryList - list of regions
		 * @returns {boolean}
		 */
		function isProperRegion(countryList) {
			return !!(
				countryList &&
				countryList.indexOf &&
				countryList.indexOf(getCountryCode() + '-' + getRegionCode()) > -1
			);
		}

		/**
		 * Returns true if current continent is in countryList for example: [XX-EU, XX-NA, XX]. 'XX' means: any.
		 * @param {array} countryList
		 * @returns {boolean}
		 */
		function isProperContinent(countryList) {
			if (countryList && countryList.indexOf) {
				return !!(
					countryList.indexOf(earth) > -1 ||
					countryList.indexOf(earth + '-' + getContinentCode()) > -1
				);
			}
			return false;
		}

		/**
		 * Returns true if current region/country/continent is not excluded in countryList
		 * @param {array} countryList
		 * @returns {boolean}
		 */
		function isGeoExcluded(countryList) {
			return !!(
				countryList.indexOf(negativePrefix + getCountryCode()) > -1 ||
				countryList.indexOf(negativePrefix + getCountryCode() + '-' + getRegionCode()) > -1 ||
				countryList.indexOf(negativePrefix + earth + '-' + getContinentCode()) > -1
			);
		}

		/**
		 * Returns true if isProperContinent || isProperCountry || isProperRegion
		 * @param {array} countryList
		 * @returns {boolean}
		 */
		function isProperGeo(countryList) {
			return !!(countryList &&
				countryList.indexOf &&
				!isGeoExcluded(countryList) &&
				(isProperContinent(countryList) || isProperCountry(countryList) || isProperRegion(countryList))
			);
		}

		/** @public **/
		return {
			getGeoData: getGeoData,
			getCountryCode: getCountryCode,
			getContinentCode: getContinentCode,
			getRegionCode: getRegionCode,
			setCountryCode: setCountryCode,
			isProperGeo: isProperGeo
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
