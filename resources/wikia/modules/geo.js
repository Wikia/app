/**
 * Geo-location utility
 *
 * Depends on: cookies module
 *
 * TODO: migrate to true AMD
 */
(function(){
	// this module needs to be also available via a namespace for access early in the process
	if(!window.Wikia) window.Wikia = {};//namespace
	window.Wikia.geo = geo();//late binding

	// backward compat with /extensions/wikia/Geo/geo.js (used only by Meebo toolbar)
	// TODO:remove
	window.Geo = window.Wikia.geo;

	function geo() {
		var cookieName = 'Geo',
			geoData = false;

		function getGeoData() {
			if (geoData === false) {
				var jsonData = decodeURIComponent(Wikia.Cookies.get(cookieName));
				geoData = JSON.parse(jsonData) || {};
			}
			return geoData;
		}

		// public module API
		return {
			getGeoData: getGeoData
		}
	}
}());
