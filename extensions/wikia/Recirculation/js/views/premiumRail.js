define('ext.wikia.recirculation.views.premiumRail', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.helpers.curatedContent'
], function ($, w, abTest, tracker, utils, CuratedHelper) {
	'use strict';

	var options = {};

	function render(data, title) {
		var curated = new CuratedHelper();

		return curated.injectContent(data)
			.then(renderTemplate('client/premiumRail.mustache', title))
			.then(utils.waitForRail)
			.then(function ($html) {
				var $recirculationRail = $('#recirculation-rail');
				if (options.before) {
					$html = options.before($html);
				}

				$recirculationRail.html($html);
				curated.setupTracking($html);

				$recirculationRail.trigger('premiumRecirculationRail.ready');

				return $html;
			});
	}

	function renderTemplate(templateName, title) {
		return function (data) {
			data.title = $.msg(title);
			data.items = data.items.slice(0, 5);
			data.fandomHeartSvg = utils.fandomHeartSvg;
			return utils.renderTemplateByName(templateName, data);
		};
	}

	function setupTracking() {
		return function ($html) {
			$html.on('mousedown', 'a', function () {
				tracker.trackClick(utils.buildLabel(this, 'rail'));
			});

			return $html;
		};
	}

	return function (config) {
		$.extend(options, config);

		return {
			render: render,
			setupTracking: setupTracking,
			itemsSelector: '.premium-recirculation-rail .item'
		};
	};
});
