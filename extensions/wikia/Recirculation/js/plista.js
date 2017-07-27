define('ext.wikia.recirculation.plista', ['jquery'], function ($) {
	function shouldFetchPlista(items) {
		var index = items.findIndex(function (item) {
			return item.presented_by;
		});

		return true;//index === -1 && ['AU', 'NZ'].indexOf(Geo.getCountryCode()) > -1;
	}

	function fetchPlista() {
		return $.getJSON('http://farm.plista.com/recommendation/?publickey=845c651d11cf72a0f766713f&widgetname=api' +
			'&count=1&adcount=1&image[width]=320&image[height]=180'
		)
			.then(function (data) {

				return {
					"brand": "Life Insurance Comparison",
					"img": "http://static.plista.com/image/resized/244310/a9q1eFGqTxGvhcD_356x200_8365.jpg (32kB)",
					"status": 34,
					"text": "New Life Insurance Comparison Site Helps Aussies Save Big Money Quickly!",
					"title": "Over 40 with Life Insurance? You need to read this",
					"type": "pet",
					"url": "http://click.plista.com/pets/?friendid=0&frienddomainid=243030&widgetid=45044&itemid=371828933&campaignid=257204&bucketid=0&rh=59770fddc9cc34.78975602&lh=59770fde620b32.28763435&bv=_0_bVMLruQgDLvOqxShOB9C5mx7-DW0o5ldPVq1BdvBIamIoBPgQ7DUsWxJeLqZWCLgLXp5RCbE5moVDohzQJAL0A6BTnWTaN06ElK1K3W2MIxNXSRDVLyj0BPkWLg6w6GcUhEdyPCJ_qMjls3wMZRXnifG-Lkw0K1YnPBztI5uvpUYLhsggprjLOWY-mDX6y0sxkZ7qT8s908IhjedvPMXjNGXV7Y9WHxhL7sN25dzbAp0J6X5EP16-U2I7ePj1u1_alwvymtVQjd3Ganr3hvnehyzYtl1A5EfxA6CeA7jS-PDzAr2zuSDyKntCmuWRjA1e9WUSI0gErtX1CacE67RFKvIiV2WbJ-jhi_Tkl1Xq8w5qXPz5qwslHIPk516IPZmXlECPyGouUN1kcblncFcchtr1nAvdobV2hZuuxrMRwwKD3YYlDFto7Y3DlNf7KoKbTmK87JVOnd77s777ldqqhryDLAhNHTtr52R7sxm5FLDP31uitLiP9N00HdY3nqOoqtJ9LN6kanFRv8L&tend=1501003870&crc=b64bbdc21f80c3b8860cd862d9980088"
				};

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

	function prepareData(renderData) {
		return function () {
			var length = renderData.items.length;

			if (shouldFetchPlista(renderData.items)) {
				return fetchPlista()
					.then(mapPlista)
					.then(function (data) {
						renderData.items.splice(5, 0, data);

						renderData.items = renderData.items.slice(0, length);
					}, function () {
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
