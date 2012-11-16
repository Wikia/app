var AdLogicShortPage = function (document) {
	'use strict';

	var logGroup = 'AdLogicShortPage',
		slotsOnlyOnLongPages,
		pageHeight,
		getPageHeight,
		hasPreFootersThreshold,
		hasPreFooters,
		isPageTooShortForSlot;

	// Map of slots present only on long pages
	// key: slot name
	// value: minimal height needed to show the ad (in pixels)
	slotsOnlyOnLongPages = {
		LEFT_SKYSCRAPER_2: 2400,
		LEFT_SKYSCRAPER_3: 4000,
		PREFOOTER_LEFT_BOXAD: 2400,
		PREFOOTER_RIGHT_BOXAD: 2400
	};
	hasPreFootersThreshold = 2400;

	getPageHeight = function () {
		if (!pageHeight) {
			pageHeight = document.documentElement.offsetHeight;
		}
		return pageHeight;
	};

	hasPreFooters = function () {
		return (getPageHeight() > hasPreFootersThreshold);
	};

	isPageTooShortForSlot = function (slotname) {
		return !!(slotsOnlyOnLongPages[slotname] && getPageHeight() < slotsOnlyOnLongPages[slotname]);
	};

	return {
		hasPreFooters: hasPreFooters,
		isPageTooShortForSlot: isPageTooShortForSlot
	};
};
