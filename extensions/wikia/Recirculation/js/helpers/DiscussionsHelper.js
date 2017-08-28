define('ext.wikia.recirculation.helpers.discussions', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana'
], function ($, w, abTest, nirvana) {
	'use strict';

	var deferred = $.Deferred();

	function prepare() {
		return deferred.promise();
	}

	function fetch() {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'discussions',
			format: 'html',
			type: 'get',
			data: {
				cityId: w.wgCityId,
				latest: true,
				limit: 10,
				ignoreWgEnableRecirculationDiscussions: true
			},
			callback: function (response) {
				deferred.resolve(response);
			}
		});
	}

	return {
		prepare: prepare,
		fetch: fetch
	};
});
