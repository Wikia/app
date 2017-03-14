define('ext.wikia.design-system.templating', [
	'jquery',
	'wikia.loader',
	'wikia.cache',
	'wikia.mustache'
], function ($, loader, cache, mustache) {
	'use strict';

	/**
	 * Checks if template is cached in LocalStorage and if not loads it by using loader
	 * @returns {$.Deferred}
	 */
	function load(templateLocation) {
		var dfd = new $.Deferred();

		if (!templateLocation) {
			return dfd.reject('Invalid template name');
		}

		var cacheKey = 'DesignSystemAssets_' + templateLocation,
			template = cache.getVersioned(cacheKey);

		if (template) {
			return dfd.resolve(template).promise();
		} else {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: templateLocation
				}
			}).done(function (data) {
				template = data.mustache[0];
				dfd.resolve(template);
				cache.setVersioned(cacheKey, template, /* 1h */ 60 * 60);
			});
			return dfd.promise();
		}
	}

	function render(template, params) {
		return mustache.render(template, params);
	}

	function renderByLocation(location, params) {
		return load(location)
			.then(function (template) {
				return render(template, params);
			});
	}

	return {
		renderByLocation: renderByLocation
	}
});
