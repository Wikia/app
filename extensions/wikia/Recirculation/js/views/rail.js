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

		data.items[0].flag = 'Featured';
		data.items[0].classes = 'featured';

		data.items[1].flag = 'Trending';
		data.items[1].classes = 'trending';

		data.items = utils.addUtmTracking(data.items, 'rail');

		return utils.renderTemplate(options.template, data).then(function($html) {
			if (options.before) {
				$html = options.before($html);
			}

			$('#RECIRCULATION_RAIL').html($html).find('.timeago').timeago();

			return $html;
		});
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'rail');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'rail'));
			});
		}
	}

	// Add a line break after the first word in the title
	function formatTitle(title) {
		return title.replace(' ', '<br>');
	}

	return function(config) {
		$.extend(options, config);

		return {
			render: render,
			setupTracking: setupTracking
		}
	}
});
