$(
	$.nirvana.sendRequest({
		controller: 'RailController',
		method: 'lazy',
		data: {
			'title': wgTitle
		},
		type: 'get',
		format: 'json',
		callback: function(data) {
			require(['wikia.loader'], function(loader) {
				loader({
					type: loader.CSS,
					resources: data.css
				});
			});
			$('#WikiaRail').find('.loading').remove().end().append(data.railLazyContent + data.js);
			AIC2.init();
		}
	})
);
