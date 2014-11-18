define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'wikia.mustache', 'JSMessages', 'wikia.thumbnailer'],
	function(loader, win, mustache, msg, thumbnailer) {
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
					mustache: '/extensions/wikia/Recommendations/templates/Recommendations_index.mustache,/extensions/wikia/Recommendations/templates/Recommendations_image.mustache,/extensions/wikia/Recommendations/templates/Recommendations_video.mustache',
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
				var data, i, slot = {}, slots = [], slotsData, template;

				loader.processStyle(res.styles);
				//loader.processScript(res.scripts);

				if (typeof(callback) === 'function') {
					slotsData = JSON.parse(res.templates[controllerName + '_' + methodName]).items;
					// TODO shuffle

					for (i=0; i < slotsData.length; i++) { // TODO length
						slot = {
							title: slotsData[i].title,
							url: slotsData[i].url,
							description: slotsData[i].description
						};

						if (i === 0) {
							slot.slotType = 'big';
						} else {
							slot.slotType = 'small';
						}

						if (slotsData[i].media) {
							slot.thumbUrl = thumbnailer.getThumbURL(
								slotsData[i].media.thumbUrl,
								'image',
								178, // TODO image size
								100
							);

							if (slotsData[i].type === 'video') {
								slot.videoKey = slotsData[i].media.videoKey;
								slot.duration = '1:32'; // TODO
								template = res.mustache[2];
							} else {
								template = res.mustache[1];
							}
							slot.media = mustache.render(template, slot);
						}
						slots.push(slot);
					}

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
