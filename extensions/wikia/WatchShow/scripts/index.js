require(['wikia.geo', 'wikia.tracker'], function (geo, tracker) {

	var track = tracker.buildTrackingFunction({
		category: 'article',
		label: 'watch-hulu',
		trackingMethod: 'analytics'
	});

	if (geo.getCountryCode() === 'US') {
		var watchShowElement = document.getElementById('watch-show-rail-module');

		if (watchShowElement) {
			watchShowElement.classList.remove('wds-is-hidden');

			track({
				action: 'impression'
			});

			watchShowElement.querySelector('.wds-button').addEventListener('click', function () {
				track({
					action: 'click'
				});
			});
		}

	}
});