function getDomainSuffix(domain) {
	var SIGNIFICANT_PIECE_LENGTH = 4;
	var pieces = domain.split('.');
	var n_pieces = pieces.length;
	var lastSignificantPieceIdx = -1;
	// loop through pieces in reverse. assume the meaningful part of suffix is greater than three letters (e.g. wikia, wowwiki)
	for (i = n_pieces-1; i>=0; i--) {
		if (pieces[i].length >= SIGNIFICANT_PIECE_LENGTH) {
			lastSignificantPieceIdx = i;
			break;
		}
	}

	if (lastSignificantPieceIdx >= 0) {
		var suffix = pieces.slice(lastSignificantPieceIdx).join('.');
		return suffix;
	}

	return domain;
}

var QuantcastSegments = {
	geoData : [],
	apiUrl : 'http://pixel.quantserve.com/api/segments.json',
	pId : 'p-8bG6eLqkH6Avk',
	segCookieName : 'qcseg',
	segCookieExpires : 1,	// in days
	updatedCookieName : 'qcsegupdate'
};

QuantcastSegments.setQcseg = function (qcResult) {
	var domain_suffix = getDomainSuffix(document.domain);
	var today = new Date();
	$.cookies.set(QuantcastSegments.segCookieName, JSON.stringify(qcResult), { hoursToLive: 24*QuantcastSegments.segCookieExpires, path: '/', domain: domain_suffix })
	$.cookies.set(QuantcastSegments.updatedCookieName, today.getTime(), { hoursToLive: 24*365*10, path: '/', domain: domain_suffix })
};

QuantcastSegments.setQuantcastData = function () {
	QuantcastSegments.geoData = Geo.getGeoData();
	var key = 'country';
	if ($(QuantcastSegments.geoData).exists()) {
		if (QuantcastSegments.geoData[key] == 'US') {
			var today = new Date();
			if (today.getTime() - $.cookies.get(QuantcastSegments.updatedCookieName) > 86400000) {
				document.write('<script type="text/javascript" src="' + QuantcastSegments.apiUrl + '?a=' + QuantcastSegments.pId + '&callback=QuantcastSegments.setQcseg&ttl=' + 86400*QuantcastSegments.segCookieExpires + '"></scr' + 'ipt>');
			}
		}
	}
};

QuantcastSegments.setQuantcastData();
