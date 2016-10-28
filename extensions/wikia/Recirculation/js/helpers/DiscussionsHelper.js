define('ext.wikia.recirculation.helpers.discussions', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana'
], function ($, w, abTest, nirvana) {
	'use strict';

	return function(config) {
		var defaults = {
				type: 'all',
				cityId: w.wgCityId
			},
			options = $.extend({}, defaults, config);

		function loadData() {
			var deferred = $.Deferred();

			nirvana.sendRequest({
				controller: 'RecirculationApi',
				method: 'getDiscussions',
				format: 'json',
				type: 'get',
				scriptPath: w.wgCdnApiUrl,
				data: options,
				callback: function(data) {
					data = formatData(data);
					deferred.resolve(data);
				}
			});

			return deferred.promise();
		}

		function formatData(data) {
			var returnData = {};

			if (data.posts) {
				returnData.items = data.posts;
			}

			return returnData;
		}

		return {
			loadData: loadData
		};
	};
});
