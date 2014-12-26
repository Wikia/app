define(
	'wikia.recommendations.view',
	['wikia.mustache', 'JSMessages', 'wikia.imageServing', 'wikia.thumbnailer', 'wikia.arrayHelper', 'venus.layout', 'wikia.window'],
	function(mustache, msg, imageServing, thumbnailer, arrayHelper, layout, w) {
		'use strict';

		/**
		 * @desc Image slot columns definition
		 * @type object {slot_name: number of columns, small: number}
		 */
		var slotColumnCounts = {
			big: 6,
			small: 3
		},
			slotSizes;

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
				seconds = Math.round(duration - (hours * 3600) - (minutes * 60));

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
		 * @desc Get numer of slots that should be shown
		 * @param number availableSlotsCount
		 * @returns {number}
		 */
		function getSlotsToShowCount(availableSlotsCount) {
			var out = 0;
			if (availableSlotsCount >= 9) {
				out = 9;
			} else if (availableSlotsCount >= 5) {
				out = 5;
			} else if (availableSlotsCount >= 4) {
				out = 4;
			}
			return out;
		}

		/**
		 * @desc Check whether current slot should be displayed as big one
		 * @param number index slot index
		 * @param number slotsToShowCount number of slots that should be shown
		 * @returns {boolean}
		 */
		function shouldDisplayBigSlot(index, slotsToShowCount) {
			var out = false;
			if (index === 0 && slotsToShowCount !== 4) {
				out = true;
			}
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
				slotsToShowCount = getSlotsToShowCount(slotsData.length);

			slotSizes = getSlotSizes();

			for (i = 0; i < slotsToShowCount; i++) {
				slot = {
					title: slotsData[i].title,
					url: slotsData[i].url,
					description: slotsData[i].description,
					type: slotsData[i].type
				};

				if (shouldDisplayBigSlot(i, slotsToShowCount)) {
					slot.slotType = 'big';
				} else {
					slot.slotType = 'small';
				}

				if (slotsData[i].media) {
					slot.media = renderMedia(slot, slotsData[i], mustacheTemplates);
				}
				slots.push(slot);
			}

			data = {
				header: msg('recommendations-header'),
				slots: slots
			};
			return mustache.render(mustacheTemplates[0], data);
		}

		/**
		 * @desc Render recommendation media
		 * @param object slot
		 * @param object slotsData
		 * @param array mustacheTemplates
		 * @returns {string}
		 */
		function renderMedia(slot, slotsData, mustacheTemplates) {
			var template;

			if (slot.type === 'video') {
				slot.videoKey = slotsData.media.videoKey;
				slot.duration = formatDuration(slotsData.media.duration);
				template = mustacheTemplates[2];

				slot.thumbUrl = thumbnailer.getThumbURL(
					slotsData.media.thumbUrl,
					'image',
					slotSizes[slot.slotType].width,
					slotSizes[slot.slotType].height
				);
			} else {
				template = mustacheTemplates[1];

				if (slotsData.media.thumbUrl) {
					slot.thumbUrl = imageServing.getThumbUrl(
						slotsData.media.thumbUrl,
						slotsData.media.originalWidth,
						slotsData.media.originalHeight,
						slotSizes[slot.slotType].width,
						slotSizes[slot.slotType].height
					);
				} else {
					slot.thumbUrl = w.wgCdnApiUrl + '/extensions/wikia/Recommendations/images/image_placeholder.svg';
				}
			}
			return mustache.render(template, slot);
		}

		return {
			render: render
		};
	});
