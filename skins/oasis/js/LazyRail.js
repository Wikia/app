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
		format: 'html',
		callback: function(data) {
			$('#WikiaRail').find('.loading').remove().end().append(data);
			AIC2.init();
		}
	})
);
