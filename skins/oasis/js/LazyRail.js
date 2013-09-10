$(function() {
	var rail = $('#WikiaRail');

	if (rail.find('.loading').exists()) {
		$.nirvana.sendRequest({
			controller: 'RailController',
			method: 'lazy',
			data: {
				'title': wgTitle,
				'namespace': wgNamespaceNumber
				// TODO fix related videos rail
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
		});
	}
});
