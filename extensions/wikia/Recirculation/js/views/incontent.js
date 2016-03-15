/*global define*/
define('ext.wikia.recirculation.views.incontent', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'wikia.mustache',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, log, Mustache, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.views.incontent',
		$container = $('#mw-content-text'),
		minimumSectionsNumber = 3;

	function findSuitableSection() {
		var sections = $container.find('h2'),
			firstSuitableSection,
			width;

		// If this page doesn't have enough content (either links or sections) we
		// don't want to show this widget
		if (sections.length < minimumSectionsNumber) {
			log('Recirculation in-content widget not shown - Not enough sections in article', 'debug', logGroup);
			return false;
		}

		// The idea is to show links above the first section under an infobox
		width = $container.outerWidth();
		firstSuitableSection = sections.filter(function(index, element) {
			return element.offsetWidth === width;
		}).first();

		return firstSuitableSection;
	}

	function render(data) {
		var deferred = $.Deferred(),
			section = findSuitableSection();

		if (!section) {
			return deferred.reject();
		}

		utils.renderTemplate('incontent.mustache', data).then(function($html) {
			section.before($html);
			deferred.resolve($html);
		});

		return deferred.promise();
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'in-content');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'in-content'));
			});
		}
	}

	return {
		render: render,
		setupTracking: setupTracking
	}
});
