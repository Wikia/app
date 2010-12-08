var Geo = {
	cookieName : 'Geo',
	geoData : ''
}

Geo.getGeoData = function () {
	if (Geo.geoData == '') {
		var jsonData = $.cookies.get(Geo.cookieName);
		Geo.geoData = jQuery.parseJSON(jsonData);
	}
	return Geo.geoData;
}

