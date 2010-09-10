var QuantcastSegments = {
	geoData : [],
	apiUrl : 'http://pixel.quantserve.com/api/segments.json',
	pId : 'p-8bG6eLqkH6Avk',
	segCookieName : 'qcseg',
	segCookieExpires : 3650,	// in days
	updatedCookieName : 'qcsegupdate'
};

QuantcastSegments.setQcseg = function (qcResult) {
	$.cookies.set(QuantcastSegments.segCookieName, JSON.stringify(qcResult), { hoursToLive: 24*QuantcastSegments.segCookieExpires, path: wgCookiePath, domain: wgCookieDomain})
	$.cookies.set(QuantcastSegments.updatedCookieName, wgNow.getTime(), { hoursToLive: 24*365*10, path: wgCookiePath, domain: wgCookieDomain})
};

QuantcastSegments.setQuantcastData = function () {
	QuantcastSegments.geoData = Geo.getGeoData();
	var key = 'country';
	if ($(QuantcastSegments.geoData).exists()) {
		if (QuantcastSegments.geoData[key] == 'US') {
			if (wgNow.getTime() - $.cookies.get(QuantcastSegments.updatedCookieName) > 86400000) {
				$.getScript(QuantcastSegments.apiUrl+'?a='+QuantcastSegments.pId+'&callback=QuantcastSegments.setQcseg&ttl='+86400);
			}
		}
	}
};

if (typeof(wgCollectQuantcastSegments) !== 'undefined' && wgCollectQuantcastSegments) {
	QuantcastSegments.setQuantcastData();
}
