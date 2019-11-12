require(['wikia.geo', 'wikia.tracker'], function (geo, tracker) {

	var track = tracker.buildTrackingFunction({
		category: 'article',
		label: 'watch-' + wgWatchShowTrackingLabel,
		trackingMethod: 'analytics'
	});

	var isEnabled = wgWatchShowEnabledDate && (Date.parse(wgWatchShowEnabledDate) < Date.now());
	// proper geo is always if the variable is empty
	var isProperGeo = !wgWatchShowGeos
		// proper geo check
		|| (wgWatchShowGeos.split(',').indexOf(geo.getCountryCode()) > -1);

	if (isEnabled && isProperGeo) {
		// special CA-ony version
		var watchShowElement = geo.getCountryCode() === 'CA'
			? document.getElementById('watch-show-rail-module-ca')
			: document.getElementById('watch-show-rail-module');

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
