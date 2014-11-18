define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'wikia.mustache', 'JSMessages', 'wikia.thumbnailer', 'wikia.arrayHelper', 'venus.layout'],
	function(loader, win, mustache, msg, thumbnailer, arrayHelper, layout) {
		'use strict';

		var controllerName = 'RecommendationsApi',
			methodName = 'getArticle',
			slotColumnCounts = {
				big: 6,
				small: 3
			};

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

		function getSlotWidth(size) {
			var columnCount;
			if (size === 'big') {
				columnCount = slotColumnCounts[size];
			} else {
				columnCount = slotColumnCounts[size];
			}
			return layout.getGridColumnWidth(
				layout.getBreakpoint(), // TODO cache
				columnCount
			);
		}

		function getSlotSizes() {
			var slotSize,
				out = {},
				width,
				height;

			for (slotSize in slotColumnCounts) {
				if (slotColumnCounts.hasOwnProperty(slotSize)) {
					width = getSlotWidth(slotSize);
					height = Math.round(width / 16 * 9);
					out[slotSize] = {
						width: width,
						height: height
					};
				}
			}

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
				var data,
					i,
					slot = {},
					slots = [],
					slotsData,
					slotSizes,
					template;

				loader.processStyle(res.styles);
				//loader.processScript(res.scripts);

				if (typeof(callback) === 'function') {
					slotsData = JSON.parse(res.templates[controllerName + '_' + methodName]).items;
					slotsData = arrayHelper.shuffle(slotsData);

					slotSizes = getSlotSizes();
					for (i = 0; i < slotsData.length; i++) { // TODO length
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
								slotSizes[slot.slotType].width,
								slotSizes[slot.slotType].height
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
