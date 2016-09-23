/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'wikia.log',
	'wikia.mustache',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, abTest, nirvana, log, Mustache, tracker, utils) {
	// Currently only showing for English communities
	if (w.wgContentLanguage !== 'en') { return; }

	var experimentName = 'RECIRCULATION_INCONTENT',
		logGroup = 'ext.wikia.recirculation.incontent',
		$container = $('#mw-content-text'),
		minimumLinksNumber = 8,
		minimumSectionsNumber = 3,
		template;

	function injectInContentWidget($container) {
		var $links = $container.find('a'),
			sections = buildSections($container.find('h2')),
			width,
			firstSuitableSection,
			topTitles;

		// If this page doesn't have enough content (either links or sections) we
		// don't want to show this widget
		if ($links.length < minimumLinksNumber || sections.length < minimumSectionsNumber) {
			log('Recirculation in-content widget not shown - Not enough links or sections in article', 'debug', logGroup);
			return;
		}

		// The idea is to show links above the first section under an infobox
		width = $container.outerWidth();
		firstSuitableSection = sections.find(function(item, index) {
			return item.width === width;
		});

		if (!firstSuitableSection) {
			log('Recirculation in-content widget not shown - No section is wide enough', 'debug', logGroup);
			return;
		}

		topTitles = findTopTitles($links);
		if (topTitles.length < 3) {
			log('Recirculation in-content widget not shown - No enough top links', 'debug', logGroup);
			return;
		}

		nirvana.sendRequest({
			controller: 'ArticlesApi',
			method: 'getDetails',
			format: 'json',
			type: 'get',
			data: {
				titles: topTitles.join(','),
				abstract: 0,
				width: 50,
				height: 50
			},
			callback: renderArticles(firstSuitableSection)
		});
	}

	function renderArticles(section) {
		var placeholderImage = w.wgExtensionsPath + '/wikia/Recirculation/images/placeholder.png';
		tracker.trackVerboseImpression(experimentName, 'in-content');

		return function (response) {
			var items = [],
				html;

			$.each(response.items, function(index, item) {
				item.thumbnail = item.thumbnail || placeholderImage;
				items.push(item);
			});

			$html = $(Mustache.render(template, {
				title: $.msg('recirculation-incontent-title'),
				items: items
			}));

			section.$start.before($html);

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

	function findTopTitles($links) {
		var links = buildLinks($links),
			titles = getSortedKeys(links),
			topTitles = [],
			i = 0;

		while (topTitles.length < 3) {
			if (titles[i]) {
				topTitles.push(titles[i]);
			}
			i ++;
		}

		return topTitles;
	}

	function validLink(element) {
		// Not a link to current article
		if (element.title === w.wgTitle) {
			return false;
		}

		// This is a pretty heavy handed Regex, and it may only work for EN communities
		// but the idea is to not display links to special pages
		if (element.title.match(/\S:\S/)) {
			return false;
		}

		return true;
	}

	function buildLinks($links) {
		var links = [];

		$links.each(function(index, element) {
			if (validLink(element)) {
				links[element.title] = links[element.title] || 0;
				links[element.title] ++;
			}
		});

		return links;
	}

	function getSortedKeys(obj) {
		var keys = [];
		for(var key in obj) {
			keys.push(key);
		}

		var sortedKeys = keys.sort(function(a,b){
			return obj[b] - obj[a];
		});

		return sortedKeys;
	}

	if (abTest.inGroup(experimentName, 'YES')) {
		utils.loadTemplate('extensions/wikia/Recirculation/templates/inContent.client.mustache')
			.then(function(loadedTemplate) {
				template = loadedTemplate;
				injectInContentWidget($container);
			});
	}
});
