define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'wikia.mustache', 'JSMessages', 'wikia.thumbnailer', 'wikia.arrayHelper'],
	function(loader, win, mustache, msg, thumbnailer, arrayHelper) {
		'use strict';

		var controllerName = 'RecommendationsApi',
			methodName = 'getArticle';

		function formatDuration(duration) {
			var out = '',
				hours   = Math.floor(duration / 3600),
				minutes = Math.floor((duration - (hours * 3600)) / 60),
				seconds = duration - (hours * 3600) - (minutes * 60);

			if (hours > 0){
				if (hours < 10) {
					hours = '0' + hours;
				}
				out += hours + ':';
			}

			if (minutes < 10) {
				minutes = '0' + minutes;
			}
			if (seconds < 10) {
				seconds = '0' + seconds;
			}

			out += minutes + ':' + seconds;
			return out;
		}

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
					slotsData = arrayHelper.shuffle(slotsData);

					for (i=0; i < slotsData.length; i++) { // TODO length
						slot = {
							title: slotsData[i].title,
							url: slotsData[i].url,
							description: slotsData[i].description,
							type: slotsData[i].type
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
								slot.duration = formatDuration(slotsData[i].media.duration);
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
