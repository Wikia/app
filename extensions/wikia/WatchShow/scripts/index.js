require(['wikia.geo', 'wikia.tracker'], function (geo, tracker) {

	var track = tracker.buildTrackingFunction({
		category: 'article',
		label: 'watch-show',
		trackingMethod: 'analytics'
	});

	var isEnabled = watchShowEnabledDate && (Date.parse(watchShowEnabledDate) < Date.now()); 
	var isProperGeo = Array.isArray(watchShowGeos) && (watchShowGeos.indexOf(geo.getCountryCode()) > -1);

	if (isEnabled && isProperGeo) {
		var watchShowElement = document.getElementById('watch-show-rail-module');

		if (watchShowElement) {
			watchShowElement.classList.remove('wds-is-hidden');

			track({
				action: 'impression'
			});

			if (watchShowElement.dataset.trackingPixel) {
				var img = document.createElement('img');

				img.width = 0;
				img.height = 0;
				img.src = watchShowElement.dataset.trackingPixel;

				document.body.appendChild(img);
			}

			watchShowElement.querySelector('.wds-button').addEventListener('click', function () {
				track({
					action: 'click'
				});
			});
		}

	}
});
