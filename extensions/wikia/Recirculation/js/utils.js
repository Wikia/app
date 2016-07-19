/*global define*/
define('ext.wikia.recirculation.utils', [
	'jquery',
	'wikia.loader',
	'wikia.cache',
	'wikia.mustache'
], function ($, loader, cache, Mustache) {
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
		var $parent = $(element).parent(),
			slot = $parent.data('index') + 1,
			source = $parent.data('source');

		label = label + '=slot-' + slot;
		if (source) {
			label = label + '=' + source;
		}

		return label;
	}

	function addUtmTracking(items, placement) {
		var params = {
			utm_source: 'wikia',
			utm_campaign: 'recirc',
			utm_medium: placement
		};

		items = $.map(items, function(item, index) {
			params.utm_content = index + 1;
			item.url = item.url + '?' + $.param(params);
			return item;
		});

		return items;
	}

	function afterRailLoads(callback) {
		var $rail = $('#WikiaRail');

		if ($rail.find('.loading').exists()) {
			$rail.one('afterLoad.rail', callback);
		} else {
			callback();
		}
	}

	function waitForRail() {
		var $rail = $('#WikiaRail'),
			deferred = $.Deferred(),
			args = Array.prototype.slice.call(arguments);

		if ($rail.find('.loading').exists()) {
			$rail.one('afterLoad.rail', function() {
				deferred.resolve.apply(null, args);
			});
		} else {
			deferred.resolve.apply(null, args);
		}

		return deferred.promise();
	}

	return {
		buildLabel: buildLabel,
		loadTemplate: loadTemplate,
		renderTemplate: renderTemplate,
		addUtmTracking: addUtmTracking,
		afterRailLoads: afterRailLoads,
		waitForRail: waitForRail
	};
});
