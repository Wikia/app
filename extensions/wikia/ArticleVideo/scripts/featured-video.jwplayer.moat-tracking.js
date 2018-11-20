define('wikia.articleVideo.featuredVideo.moatTracking', [
	'ext.wikia.adEngine.adContext',
	'wikia.window'
], function (adContext, win) {

	var jwplayerPluginUrl = 'https://z.moatads.com/jwplayerplugin0938452/moatplugin.js',
		partnerCode = 'wikiajwint101173217941';

	function track(player) {
		if (adContext.get('opts.isMoatTrackingForFeaturedVideoEnabled')) {
			player.on('adImpression', function (event) {
				if (win.moatjw) {
					win.moatjw.add({
						adImpressionEvent: event,
						partnerCode: partnerCode,
						player: this
					});
				}
			});
		}
	}

	function loadTrackingPlugin() {
		if (!win.moatjw) {
			var scriptElement = win.document.createElement('script');
			scriptElement.async = true;
			scriptElement.src = jwplayerPluginUrl;
			win.document.head.appendChild(scriptElement);
		}
	}

	return {
		track: track,
		loadTrackingPlugin: loadTrackingPlugin
	};
});
