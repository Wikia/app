var Aperture = {
	eligibleGeos : {'US':1},	// key is important, value is not
	geoData : [],
	liveconClientId : 4651450754457,
	nonsecureScriptHost : 'http://edge.aperture',
	secureScriptHost : 'https://xedge.aperture',
	scriptUrl : '.displaymarketplace.com/displayscript.js',
	
	init : function() {
		if (typeof wgEnableAperture != undefined && wgEnableAperture) {
			Aperture.geoData = Geo.getGeoData();
			var key = 'country';
			if ($(Aperture.geoData).exists()) {
				if (Aperture.geoData[key] in Aperture.eligibleGeos) {
					// get script
					var scriptHost = window.location.protocol == 'https' ? Aperture.secureScriptHost : Aperture.nonsecureScriptHost;
					var fullUrl = scriptHost + Aperture.scriptUrl + '?liveconclientID=' + Aperture.liveconClientId + '&PageID=' + window.aperturePageId;
					$.getScript(fullUrl);
				}
			}
		}
	}
};

Aperture.init();