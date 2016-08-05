/*global define*/
define('ext.wikia.recirculation.views.incontent', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, log, tracker, utils) {

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
		width = $container.outerWidth(false);
		firstSuitableSection = sections.filter(function(index, element) {
			return element.offsetWidth === width;
		}).first();

		if (firstSuitableSection.length === 0) {
			return false;
		}

		return firstSuitableSection;
	}

	function waitForToc() {
		var $toc = $('#toc'),
			deferred = $.Deferred(),
			args = Array.prototype.slice.call(arguments);

		if ($toc.length === 0 || $toc.data('loaded') === true || !$toc.hasClass( 'show' )) {
			deferred.resolve.apply(null, args);
		} else {
			$toc.one('afterLoad.toc', function() {
				deferred.resolve.apply(null, args);
			});
		}

		return deferred.promise();
	}

	function render(data) {
		var deferred = $.Deferred();

		data.items = utils.addUtmTracking(data.items, 'incontent');

		utils.renderTemplate('incontent.mustache', data)
			.then(waitForToc)
			.then(function($html) {
				var section = findSuitableSection();

				if (!section) {
					return deferred.reject('Recirculation in-content widget not shown - Not enough sections in article');
				}

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

	return function() {

		return {
			render: render,
			setupTracking: setupTracking,
			findSuitableSection: findSuitableSection
		}
	}
});
