/*global define*/
define('ext.wikia.recirculation.views.rail', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'wikia.mustache',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, log, Mustache, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.views.rail';

	function render(data) {
		var deferred = $.Deferred();

		utils.loadTemplate('extensions/wikia/Recirculation/templates/client/rail.mustache')
			.then(function(template) {
				var $container = $('#RECIRCULATION_RAIL');
				var $html = $(Mustache.render(template, {
					title: data.title,
					items: data.items
				}));

				$container.html($html);

				deferred.resolve($html);
			});

		return deferred.promise();
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'rail');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, 'rail');
			});
		}
	}

	return {
		render: render,
		setupTracking: setupTracking
	}
});
