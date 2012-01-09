var Geo = {
	cookieName : 'Geo',
	geoData : {}
}

Geo.getGeoData = function () {
	if ($.isEmptyObject(Geo.geoData)) {
		var jsonData = $.cookies.get(Geo.cookieName);
		jsonData = unescape(jsonData);
		Geo.geoData = JSON.parse(jsonData);
	}
	return Geo.geoData;
}

