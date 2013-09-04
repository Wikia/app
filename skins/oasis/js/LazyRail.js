$(
	$.nirvana.sendRequest({
		controller: 'RailController',
		method: 'lazy',
		data: {
			'title': wgTitle
		},
		type: 'get',
		format: 'html',
		callback: function(data) {
			$('#WikiaRail').append(data).find('.loading').remove();
		}
	})
);
