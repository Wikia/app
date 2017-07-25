define('ext.wikia.recirculation.plista', function () {
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
				return data[0];
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

	return {
		get: getPlista,
		shouldFetch: shouldFetchPlista
	}
});
