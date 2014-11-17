define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'wikia.mustache', 'JSMessages'],
	function(loader, win, mustache, msg) {
		'use strict';

		var controllerName = 'RecommendationsApi',
			methodName = 'getArticle';

		/**
		 * Load recommendations template
		 *
		 * @param {Function} callback function passed to process recieved template
		 */
		function loadTemplate(callback) {
			// TODO rethink loading template & recommendation data in one request
			loader({
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/Recommendations/templates/Recommendations_index.mustache',
					styles: 'extensions/wikia/Recommendations/styles/recommendations.scss',
					messages: 'Recommendations',
					templates: [{
						controller: controllerName,
						method: methodName,
						params: {
							id: win.wgArticleId
						}
					}]
				}
			}).done(function (res) {
				var data, i, slot = {}, slots = [], slotsData;

				loader.processStyle(res.styles);
				//loader.processScript(res.scripts);
				console.log(res);

				if (typeof(callback) === 'function') {
					slotsData = JSON.parse(res.templates[controllerName + '_' + methodName]).items;
					// TODO shuffle

					for (i=0; i < slotsData.length; i++) { // TODO length
						slot = {
							'title': slotsData[i].title,
							'url': slotsData[i].url,
							'description': slotsData[i].description
							// TODO image
						};

						if (i === 0) {
							slot.slotType = 'big';
						} else {
							slot.slotType = 'small';
						}

						slots.push(slot);
					}
					console.log(slots);

					data = {
						header: msg('recommendations-header'),
						slots: slots
					};
					callback(mustache.render(res.mustache[0], data));
				}
			});
		}

		return {
			loadTemplate: loadTemplate
	};
});
