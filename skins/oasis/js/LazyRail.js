$(
	$.nirvana.sendRequest({
		controller: 'RailController',
		method: 'lazy',
		data: {
			'title': wgTitle,
			'namespace': wgNamespaceNumber
			// TODO fix forum rail
			// TODO fix related videos rail (ugly hack in RelatedVideos.hooks.php)
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
