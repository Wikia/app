/*global define*/
define('ext.wikia.recirculation.utils', [
	'jquery',
	'wikia.loader',
	'wikia.cache',
	'wikia.mustache'
], function ($, loader, cache, Mustache) {
	'use strict';

	// returns a gaussian random function with the given mean and stdev.
	function gaussian(mean, stdev) {
		var y2,
			use_last = false;
		return function() {
			var y1;
			if (use_last) {
				y1 = y2;
				use_last = false;
			} else {
				var x1, x2, w;

				do {
					x1 = 2.0 * Math.random() - 1.0;
					x2 = 2.0 * Math.random() - 1.0;
					w = x1 * x1 + x2 * x2;
				} while (w >= 1.0);

				w = Math.sqrt((-2.0 * Math.log(w))/w);
				y1 = x1 * w;
				y2 = x2 * w;
				use_last = true;
			}

			var retval = mean + stdev * y1;
			return Math.abs(retval);
	   };
	}

	function Result (item, score) {
		return {
			item: item,
			score: score
		};
	}

	function ditherResults(results, epsilon) {
		var standardDeviation = (epsilon > 1) ? Math.sqrt(Math.log(epsilon)) : Math.exp(1e-10),
			distribution = gaussian(0, standardDeviation);

		return results.map(Result)
			.map(function(result, index) {
				result.score = Math.log(index + 1) + distribution();
				return result;
			}).sort(function(a, b) {
				return a.score - b.score;
			}).map(function(result, index) {
				result.item.index = index;
				return result.item
			});
	}

	/**
	 * Checks if template is cached in LocalStorage and if not loads it by using loader
	 * @returns {$.Deferred}
	 */
	function loadTemplate(templateName) {
		var dfd = new $.Deferred(),
			templateLocation = 'extensions/wikia/Recirculation/templates/client/' + templateName,
			cacheKey = 'RecirculationAssets_' + templateLocation,
			template = cache.getVersioned(cacheKey);

		if (!templateName) {
			return dfd.reject('Invalid template name');
		}

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
		waitForRail: waitForRail,
		ditherResults: ditherResults
	};
});
