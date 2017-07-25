define('ext.wikia.recirculation.plista', ['jquery'], function ($) {
	function shouldFetchPlista(items) {
		var index = items.findIndex(function (item) {
			return item.presented_by;
		});

		return index === -1 && ['AU', 'NZ'].indexOf(Geo.getCountryCode()) > -1;
	}

	function fetchPlista() {
		return $.getJSON('http://farm.plista.com/recommendation/?publickey=845c651d11cf72a0f766713f&widgetname=api' +
			'&count=1&adcount=1&image[width]=583&image[height]=328'
		)
			.then(function (data) {
				if (data[0]) {
					return data[0];
				} else {
					return $.Deferred().reject('Plista returned no content');
				}

			});
	}

	function mapPlista(plistaData) {
		return {
			meta: 'wikia-impactfooter',
			source: 'plista',
			thumbnail: plistaData.img,
			title: plistaData.title,
			url: plistaData.url,
			presented_by: 'Plista',
			isPlista: true
		}
	}

	function getPlista() {
		return fetchPlista().then(mapPlista);
	}

	function prepareData(renderData) {
		return function() {
			var length = renderData.items.length;

			if (shouldFetchPlista(renderData.items)) {
				return getPlista().then(function (data) {
					renderData.items.splice(5, 0, data);

					renderData.items = renderData.items.slice(0, length);
				}, function() {
					// If Plista did not return anything, just don't add it to renderData

					return $.Deferred().resolve();
				});
			}
		}

	}

	return {
		prepareData: prepareData
	}
});
