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
		var sections = buildSections($container.find('h2')),
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
		firstSuitableSection = sections.find(function(item, index) {
			return item.width === width;
		});

		return firstSuitableSection;
	}

	function render(data) {
		var deferred = $.Deferred(),
			section = findSuitableSection();

		if (!section) {
			return deferred.reject('view');
		}

		utils.loadTemplate('extensions/wikia/Recirculation/templates/client/incontent.mustache')
			.then(function(template) {
				var $html = $(Mustache.render(template, {
					title: data.title,
					items: data.items
				}));

				section.$start.before($html);

				deferred.resolve($html);
			});

		return deferred.promise();
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'in-content');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, 'in-content');
			});
		}
	}

	/**
	 * Build the sections array
	 *
	 * DOM/layout querying: OK
	 * DOM modification:    forbidden
	 *
	 * @param {jQuery} $headers headers dividing the article to sections
	 * @returns {Section[]}
	 */
	function buildSections($headers) {
		var i,
			len,
			sections = [],
			intro,
			$start,
			$end,
			section;

		for (i = 0, len = $headers.length; i < len + 1; i += 1) {
			intro = (i === 0);
			$start = !intro && $headers.eq(i - 1);
			$end = $headers.eq(i);
			section = {
				intro: intro,
				$start: intro ? undefined : $start,
				$end: $end
			};
			section.width = $start && $start.outerWidth();

			sections.push(section);
		}

		return sections;
	}

	return {
		render: render,
		setupTracking: setupTracking
	}
});
