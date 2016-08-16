/*global define*/
define('ext.wikia.recirculation.views.rail', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'wikia.abTest',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, log, abTest, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.views.rail',
		options = {
			template: 'rail.mustache'
		};

	function render(data) {
		data.titleHtml = options.formatTitle ? formatTitle(data.title) : data.title;
		data.group = abTest.getGroup('RECIRCULATION_PLACEMENT');

		return utils.renderTemplate(options.template, data)
			.then(utils.waitForRail)
			.then(function($html) {
				if (options.before) {
					$html = options.before($html);
				}

				$('#RECIRCULATION_RAIL').html($html);

				return $html;
			});
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'rail');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'rail'));
			});

			return $html;
		}
	}

	// Format title for E3
	function formatTitle(title) {
		return title;
	}

	return function(config) {
		$.extend(options, config);

		return {
			render: render,
			setupTracking: setupTracking
		}
	}
});
