/*global define*/
define('ext.wikia.recirculation.views.footer', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'wikia.mustache',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, log, Mustache, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.views.footer';

	function render(data) {
		var deferred = $.Deferred();

		utils.loadTemplate('extensions/wikia/Recirculation/templates/client/footer.mustache')
			.then(function(template) {
				var $html = $(Mustache.render(template, {
					title: data.title,
					items: data.items
				}));

				$('#WikiaArticle').append($html);

				deferred.resolve($html);
			});

		return deferred.promise();
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'footer');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, 'footer');
			});
		}
	}

	return {
		render: render,
		setupTracking: setupTracking
	}
});
