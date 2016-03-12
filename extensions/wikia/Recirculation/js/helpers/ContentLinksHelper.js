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
			$links = $container.find('a[title]').filter(validLink),
			topTitles;

		// If this page does not have enough links we don't want to show this widget
		if ($links.length < minimumLinksNumber) {
			log('Recirculation in-content widget not shown - Not enough links in article', 'debug', logGroup);
			return deferred.reject().promise();
		}

		topTitles = findTopTitles($links);
		if (topTitles.length < 3) {
			log('Recirculation in-content widget not shown - Not enough top links', 'debug', logGroup);
			return deferred.reject().promise();
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
				data = formatData(data);
				if (data.items && data.items.length >=3 ) {
					deferred.resolve(data);
				} else {
					log('Recirculation in-content widget not shown - Not enough items returned from API', 'debug', logGroup);
					deferred.reject();
				}
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
		var links = [],
			titles,
			sortedTitles;

		$links.each(function(index, element) {
			links[element.title] = links[element.title] || 0;
			links[element.title] ++;
		});

		titles = Object.keys(links),
		sortedTitles = titles.sort(function(title1, title2){
			return links[title2] - links[title1];
		});

		return sortedTitles.slice(0,3);
	}

	function validLink(index, element) {
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

	return {
		loadData: loadData
	}
});
