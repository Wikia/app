/* depends on jquery */
VisualDNAAAT = {
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
	VisualDNAAAT.init();
}