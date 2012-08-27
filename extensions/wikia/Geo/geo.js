var Geo = {
	cookieName : 'Geo',
	geoData : false
};

Geo.getGeoData = function () {
	if (Geo.geoData === false) {
		var jsonData = decodeURIComponent($.cookies.get(Geo.cookieName));
		Geo.geoData = JSON.parse(jsonData);
	}
	return Geo.geoData;
};
