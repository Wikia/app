/*global define*/
define('ext.wikia.recirculation.helpers.fandom', [
	'jquery',
	'wikia.abTest',
	'wikia.nirvana',
	'wikia.mustache'
], function ($, abTest, nirvana, Mustache) {

	function loadData() {
		var deferred = $.Deferred();

		nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getFandomPosts',
			format: 'json',
			type: 'get',
			data: {
				type: 'recent_popular'
			},
			callback: function(data) {
				deferred.resolve(formatData(data));
			}
		});

		return deferred.promise();
	}

	function formatData(data) {
		var items = [];

		$.each(data.posts, function(index, item) {
			if (items.length < 3) {
				item.thumbnail = item.image_url;
				items.push(item);	
			}
		});

		return {
			title: data.title,
			items: items
		};
	}

	function injectHtml(type, element) {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'index',
			data: {
				type: type
			},
			format: 'html',
			type: 'get',
			callback: function (response) {
				$(element).append(response);
			}
		});
	}

	return {
		loadData: loadData,
		injectHtml: injectHtml
	}
});
