/* depends on jquery */
/* depends on geo.js */
VisualDNAAAT = {
	activeCountries: ['US','UK','GB'],
	apiKey: 'wikia',
	method: 'reportPageView',
	init: function() {
		$.getScript('http://a1.vdna-assets.com/analytics.js', function(data, textStatus) {
			this.VDNA.queue=this.VDNA.queue||[];
			VDNA.queue.push({
			    apiKey : VisualDNAAAT.apiKey,
			    method : VisualDNAAAT.method
			});
		});
	}
}

if (window.wgIntegrateVisualDNAAAT) {
	if (window.Geo) {
		var geoData = Geo.getGeoData();
		if (typeof geoData == "object" && !$.isEmptyObject(geoData) && $.inArray(geoData['country'], VisualDNAAAT.activeCountries) > -1) {
			VisualDNAAAT.init();	
		}
	}
}
