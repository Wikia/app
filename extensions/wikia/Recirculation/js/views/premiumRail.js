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

	function render(data) {
		var curated = new CuratedHelper();

		return curated.injectContent(data)
			.then(renderTemplate('client/premiumRail.mustache'))
			.then(utils.waitForRail)
			.then(function ($html) {
				if (options.before) {
					$html = options.before($html);
				}

				$('#recirculation-rail').html($html);
				curated.setupTracking($html);

				return $html;
			});
	}

	function renderTemplate(templateName) {
		return function (data) {
			data.title = data.title || $.msg('recirculation-fandom-title');
			data.items = data.items.slice(0, 5);
			return utils.renderTemplate(templateName, data);
		};
	}

	function setupTracking() {
		return function ($html) {
			tracker.trackImpression('rail');

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
			setupTracking: setupTracking
		};
	};
});
