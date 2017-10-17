define('wikia.articleVideo.featuredVideo.moatTracking', [
	'ext.wikia.adEngine.adContext',
	'wikia.window'
], function (adContext, win) {
	return function(player) {
		player.on('adImpression', function (event) {
			if (win.moatjw) {
				win.moatjw.add({
					adImpressionEvent: event,
					partnerCode: 'wikiajwint101173217941',
					player: this
				});
			}
		});
	};
});
