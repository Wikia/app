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

	function renderTemplate(templateName, data) {
		var templateName = 'extensions/wikia/Recirculation/templates/client/' + templateName;
		
		return loadTemplate(templateName)
			.then(function(template) {
				return $(Mustache.render(template, data));
			});
	}

	function buildLabel(element, label) {
		var slot = $(element).parent().index() + 1;
		
		return label + '=slot-' + slot;
	}

	return {
		buildLabel: buildLabel,
		loadTemplate: loadTemplate,
		renderTemplate: renderTemplate
	};
});
