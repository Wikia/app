define('ext.wikia.recirculation.helpers.sponsoredContent', [
	'jquery',
	'wikia.window',
	'wikia.geo',
	'wikia.log'
], function ($, w, geo, log) {
	'use strict';

	var userGeo = geo.getCountryCode();
	var deferred = $.Deferred();

	function fetch() {
		$.ajax({
			url: w.wgServicesExternalDomain + 'wiki-recommendations/sponsored-articles/article',
			data: {
				geo: userGeo,
				wikiId: w.wgCityId,
				vertical: w.wgWikiVertical
			}
		}).done(function (result) {
			deferred.resolve(result);
		}).fail(function (err) {
			log('Failed to fetch Sponsored content data' + err, log.levels.error);
			// don't block rendering of rail/MCF
			deferred.resolve(null);
		});

		return deferred.promise();
	}

	return {
		fetch: fetch
	};
});
