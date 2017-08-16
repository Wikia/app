/*global define*/
define('ext.wikia.recirculation.utils', [
	'jquery',
	'wikia.loader',
	'wikia.cache',
	'wikia.mustache'
], function ($, loader, cache, Mustache) {
	'use strict';

	var footerState = {
		cleared: false,
		loading: false,
		pending: []
	};

	// function prepareFooter() {
	// 	var deferred = $.Deferred();
	//
	// 	if (!footerState.cleared) {
	// 		footerState.pending.push(deferred);
	//
	// 		if (!footerState.loading) {
	// 			footerState.loading = true;
	// 			return renderTemplateByName('footer-index-container.mustache', {})
	// 				.then(function($html) {
	// 					$('#WikiaFooter')
	// 						.find('#BOTTOM_LEADERBOARD')
	// 						.siblings()
	// 						.remove()
	// 						.end()
	// 						.end()
	// 						.append($html);
	// 					footerState.cleared = true;
	// 					footerState.pending.forEach(function(d) {
	// 						d.resolve();
	// 					});
	// 				});
	// 		} else {
	// 			return deferred.promise();
	// 		}
	// 	} else {
	// 		return deferred.resolve();
	// 	}
	// }

	/**
	 * Checks if template is cached in LocalStorage and if not loads it by using loader
	 * @returns {$.Deferred}
	 */
	function loadTemplate(templateName) {
		var dfd = new $.Deferred(),
			templateLocation = 'extensions/wikia/Recirculation/templates/' + templateName,
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
					mustache: templateLocation + ',extensions/wikia/Recirculation/templates/client/Recirculation_topic.mustache'
				}
			}).done(function (data) {
				template = data.mustache[0];

				dfd.resolve(template);

				// 1 day
				cache.setVersioned(cacheKey, template, 86400);
			});
		}

		return dfd.promise();
	}

	/**
	 * Loads mustache templates
	 * @returns {$.Deferred}
	 */
	function loadTemplates(templatesNames) {
		var dfd = new $.Deferred(),
			templatePath = 'extensions/wikia/Recirculation/templates/',
			templateLocations = templatesNames.map(function (templatesName) {
				return templatePath + templatesName;
			});

		loader({
			type: loader.MULTI,
			resources: {
				mustache: templateLocations.join(',')
			}
		}).done(function (data) {
			dfd.resolve(data.mustache);
		});

		return dfd.promise();
	}

	function renderTemplate(template, data) {
		return $(Mustache.render(template, data));
	}

	function renderTemplateByName(templateName, data) {
		return loadTemplate(templateName)
			.then(function(template) {
				return $(Mustache.render(template, data));
			});
	}

	function buildLabel(element, label) {
		var $parent = $(element).parent(),
			slot = $parent.data('index') + 1,
			source = $parent.data('source') || 'undefined',
			isVideo = $parent.hasClass('is-video') ? 'video' : 'not-video',
			parts = [label, 'slot-' + slot, source, isVideo];

		return parts.join('=');
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
		loadTemplates: loadTemplates,
		// prepareFooter: prepareFooter,
		renderTemplate: renderTemplate,
		renderTemplateByName: renderTemplateByName,
		waitForRail: waitForRail
	};
});
