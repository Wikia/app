/*global define*/
define('ext.wikia.recirculation.utils', [
	'wikia.loader',
	'wikia.cache'
], function (loader, cache) {
	'use strict';

	/**
	 * Checks if template is cached in LocalStorage and if not loads it by using loader
	 * @returns {$.Deferred}
	 */
	function loadTemplate(templateLocation) {
		var dfd = new $.Deferred(),
			cacheKey = 'RecirculationAssets_' + templateLocation,
			template = cache.getVersioned(cacheKey);

		if (template) {
			dfd.resolve(template);
		} else {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: templateLocation
				}
			}).done(function (data) {
				template = data.mustache[0];

				dfd.resolve(template);

				cache.setVersioned(cacheKey, template, 86400); //1 days
			});
		}

		return dfd.promise();
	}

	return {
		loadTemplate: loadTemplate
	};
});
