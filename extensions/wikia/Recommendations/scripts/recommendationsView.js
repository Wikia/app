define(
	'wikia.recommendations.view',
	['wikia.mustache', 'JSMessages', 'wikia.thumbnailer', 'wikia.arrayHelper', 'venus.layout'],
	function(mustache, msg, thumbnailer, arrayHelper, layout) {
		'use strict';

		/**
		 * @desc Image slot columns definition
		 * @type object {slot_name: number of columns, small: number}
		 */
		var slotColumnCounts = {
			big: 6,
			small: 3
		};

		/**
		 * @desc Get image width in px
		 * @param string size - slot size big/small
		 * @return int
		 */
		function getSlotWidth(size) {
			var columnCount;
			if (size === 'big') {
				columnCount = slotColumnCounts[size];
			} else {
				columnCount = slotColumnCounts[size];
			}
			return layout.getGridColumnWidth(
				layout.getBreakpoint(),
				columnCount
			);
		}

		/**
		 * @desc get image slot sizes
		 * @return object
		 */
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
		 * Get video duration in human format (hh:)mm:ss
		 * @param duration in seconds
		 * @returns string
		 */
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
		 * @desc Render recommendations module
		 * @param object slotsData
		 * @param array mustacheTemplates
		 * @return string HTML
		 */
		function render(slotsData, mustacheTemplates) {
			var data,
				i,
				slot = {},
				slots = [],
				slotsDataLength = slotsData.length,
				slotSizes,
				template;

			slotSizes = getSlotSizes();
			for (i = 0; i < slotsDataLength; i++) {
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
					// TODO empty image
					slot.thumbUrl = thumbnailer.getThumbURL(
						slotsData[i].media.thumbUrl,
						'image',
						slotSizes[slot.slotType].width,
						slotSizes[slot.slotType].height
					);

					if (slotsData[i].type === 'video') {
						slot.videoKey = slotsData[i].media.videoKey;
						slot.duration = formatDuration(slotsData[i].media.duration);
						template = mustacheTemplates[2];
					} else {
						template = mustacheTemplates[1];
					}
					slot.media = mustache.render(template, slot);
				}
				slots.push(slot);
			}

			data = {
				header: msg('recommendations-header'),
				slots: slots
			};
			return mustache.render(mustacheTemplates[0], data);
		}

		return {
			render: render
		};
	});
