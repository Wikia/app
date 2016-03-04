/*global define*/
define('ext.wikia.recirculation.helpers.fandom', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'wikia.log',
	'wikia.mustache',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, abTest, nirvana, log, Mustache, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.helpers.fandom';


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
			item.thumbnail = item.image_url;
			items.push(item);
		});

		return {
			title: data.title,
			items: items
		};
	}

	return {
		loadData: loadData
	}
});
