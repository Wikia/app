/*global define*/
define('ext.wikia.recirculation.helpers.contentLinks', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'wikia.log',
	'wikia.mustache',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, abTest, nirvana, log, Mustache, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.helpers.contentLinks',
		placeholderImage = w.wgExtensionsPath + '/wikia/Recirculation/images/placeholder.png',
		$container = $('#mw-content-text'),
		minimumLinksNumber = 8,
		minimumSectionsNumber = 3;


	function loadData() {
		var deferred = $.Deferred(),
			$links = $container.find('a'),
			topTitles;

		// If this page does not have enough links we don't want to show this widget
		if ($links.length < minimumLinksNumber) {
			log('Recirculation in-content widget not shown - Not enough links in article', 'debug', logGroup);
			return deferred.reject('HELPER 1').promise();
		}

		topTitles = findTopTitles($links);
		if (topTitles.length < 3) {
			log('Recirculation in-content widget not shown - No enough top links', 'debug', logGroup);
			return deferred.reject('HELPER 2').promise();
		}

		nirvana.sendRequest({
			controller: 'ArticlesApi',
			method: 'getDetails',
			format: 'json',
			type: 'get',
			data: {
				titles: topTitles.join(','),
				abstract: 0,
				width: 270,
				height: 150
			},
			callback: function(data) {
				deferred.resolve(formatData(data));
			}
		});

		return deferred.promise();
	}

	function formatData(data) {
		var items = [];

		$.each(data.items, function(index, item) {
			item.thumbnail = item.thumbnail || placeholderImage;
			items.push(item);
		});

		return {
			title: $.msg('recirculation-incontent-title'),
			items: items
		}
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
		// Link doesn't have a title
		if (!element.title) {
			return false;
		}

		// Not a link to current article
		if (element.title === w.wgTitle) {
			return false;
		}

		// The API can't handle articles with commas in the title
		if (element.title.indexOf(',') !== -1) {
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

	return {
		loadData: loadData
	}
});
