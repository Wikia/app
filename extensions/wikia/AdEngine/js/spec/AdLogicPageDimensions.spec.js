/*global describe, expect, it*/
describe('AdLogicPageDimensions', function(){

	'use strict';

	var adHelperMock = {
		throttle: function (fn) {
			return fn;
		}
	};

	function adShown(slotName, pageLength, layoutName, matchingMediaQuery, railExists) {

		if (typeof railExists === 'undefined') {
			railExists = true;
		}
		var matchingMediaQueryDict = {},
			i,
			len,
			windowMock = {
				wgOasisResponsive: (layoutName === 'responsive'),
				wgOasisBreakpoints: (layoutName === 'breakpoints'),
				addEventListener: function() {},
				styleMedia: {
					matchMedium: function (mediaQuery) {
						return !!matchingMediaQueryDict[mediaQuery];
					}
				}
			},
			logMock = function() {},
			documentMock = {documentElement: {scrollHeight: pageLength, scrollWidth: 1280}, getElementById: function() { return railExists ? {} : null; }},
			slotTweakerMock = {hide: function() {}, show: function() {}, hackChromeRefresh: function() {}},
			abTestMock = {getGroup: function () {}},
			adLogicPageDimensions = modules['ext.wikia.adEngine.adLogicPageDimensions'](windowMock, documentMock, logMock, slotTweakerMock, adHelperMock),
			fillInSlotCalled = false,
			fillInSlotMock = function () { fillInSlotCalled = true; };

		if (matchingMediaQuery) {
			for (i = 0, len = matchingMediaQuery.length; i < len; i += 1) {
				matchingMediaQueryDict[matchingMediaQuery[i]] = true;
			}
		}

		if (!adLogicPageDimensions.isApplicable(slotName)) {
			// The proxy would not be used, so ad would be always shown
			return true;
		}

		adLogicPageDimensions.addSlot(slotName, fillInSlotMock);

		if (fillInSlotCalled) {
			// The ad would be shown
			return true;
		}

		// The ad is delayed, so the ad would not be shown yet
		return false;
	}

	var oneColumnResponsive = 'screen and (max-width: 1023px)',
		oneColumnBreakpoints = 'screen and (max-width: 1063px)',
		noTopButton = 'screen and (max-width: 1030px)',
		width800Responsive = [oneColumnResponsive, noTopButton],
		width800Breakpoints = [oneColumnBreakpoints, noTopButton],
		width1024 = [noTopButton],
		width2000 = [];

	it('checks if page is too short for a slot on a static oasis skin', function() {

		expect(adShown('foo', 1000)).toBeTruthy('height=1000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 1000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 1000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 1000)).toBeFalsy('height=1000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 1000)).toBeFalsy('height=1000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 2000)).toBeTruthy('height=2000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 2000)).toBeTruthy('height=2000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 2000)).toBeTruthy('height=2000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 3000)).toBeTruthy('height=3000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 3000)).toBeTruthy('height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 3000)).toBeFalsy('height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 3000)).toBeTruthy('height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 3000)).toBeTruthy('height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 5000)).toBeTruthy('height=5000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, undefined, undefined, false)).toBeFalsy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS noRail');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 5000)).toBeTruthy('height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 5000)).toBeTruthy('height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});

	it('checks if page is too short for a slot on responsive / breakpoints skin for wide screen', function() {
		expect(adShown('foo', 1000, 'responsive', width2000)).toBeTruthy('height=1000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 2000, 'responsive', width2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 2000, 'responsive', width2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 3000, 'responsive', width2000)).toBeFalsy('height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width2000, false)).toBeFalsy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS noRail');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});

	it('checks if screen is too narrow for a slot', function() {

		expect(adShown('foo', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=foo -> ADS');
		expect(adShown('TOP_BUTTON_WIDE', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=TOP_BUTTON_WIDE -> ADS');
		expect(adShown('TOP_BUTTON_WIDE.force', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=TOP_BUTTON_WIDE.force -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=HOME_TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width2000, false)).toBeFalsy('width=2000 slot=LEFT_SKYSCRAPER_3 -> ADS noRail');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=INCONTENT_BOXAD_1 -> ADS');

		expect(adShown('foo', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=foo -> ADS');
		expect(adShown('TOP_BUTTON_WIDE', 5000, 'responsive', width1024)).toBeFalsy('width=1024 slot=TOP_BUTTON_WIDE -> ADS');
		expect(adShown('TOP_BUTTON_WIDE.force', 5000, 'responsive', width1024)).toBeFalsy('width=1024 slot=TOP_BUTTON_WIDE.force -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=HOME_TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width1024, false)).toBeFalsy('width=1024 slot=LEFT_SKYSCRAPER_3 -> ADS noRail');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=INCONTENT_BOXAD_1 -> ADS');

		expect(adShown('foo', 5000, 'responsive', width800Responsive)).toBeTruthy('width=800Responsive slot=foo -> ADS');
		expect(adShown('TOP_BUTTON_WIDE', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('TOP_BUTTON_WIDE.force', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=PREFOOTER_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=PREFOOTER_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=PREFOOTER_RIGHT_BOXAD -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'responsive', width800Responsive)).toBeFalsy('width=800Responsive slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 5000, 'breakpoints', width800Breakpoints)).toBeTruthy('width=800Breakpoints slot=foo -> ADS');
		expect(adShown('TOP_BUTTON_WIDE', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('TOP_BUTTON_WIDE.force', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=PREFOOTER_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=PREFOOTER_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=PREFOOTER_RIGHT_BOXAD -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'breakpoints', width800Breakpoints)).toBeFalsy('width=800Breakpoints slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});

	it('updates the logic when resize event is fired', function() {
		var slotName = 'LEFT_SKYSCRAPER_3',
			resizeListener = function () {},
			isNarrow,
			windowMock = {
				wgOasisResponsive: true,
				addEventListener: function (eventName, listener) {
					if (eventName === 'resize') {
						resizeListener = listener;
					}
				},
				styleMedia: {
					matchMedium: function () {
						return isNarrow;
					}
				}
			},
			logMock = function() {},
			documentMock = {documentElement: {scrollWidth: 1280}, getElementById: function() { return {}; }},
			adShown,
			adLoadCounter = 0,
			slotTweakerMock = {
				hide: function () {adShown = false;},
				show: function () {adShown = true;},
				hackChromeRefresh: function() {}
			},
			abTestMock = {getGroup: function () {}},
			adLogicPageDimensions = modules['ext.wikia.adEngine.adLogicPageDimensions'](windowMock, documentMock, logMock, slotTweakerMock, adHelperMock),
			fillInSlotMock = function () { adLoadCounter += 1; };

		documentMock.documentElement.scrollHeight = 1000;
		adLogicPageDimensions.addSlot(slotName, fillInSlotMock);

		// Page is short and wide
		documentMock.documentElement.scrollHeight = 1000;
		isNarrow = false;
		expect(adLoadCounter).toBe(0, '1) Ad is not loaded at first');
		expect(adShown).toBeFalsy('1) Ad is hidden at first');

		// Page is long and wide
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '2) Ad is loaded once');
		expect(adShown).toBeTruthy('2) Ad is shown');

		// Page is short and wide
		documentMock.documentElement.scrollHeight = 1000;
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '3) Ad is loaded once');
		expect(adShown).toBeFalsy('3) Ad is hidden');

		// Page is short and narrow
		documentMock.documentElement.scrollHeight = 1000;
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '4) Ad is loaded once');
		expect(adShown).toBeFalsy('4) Ad is hidden');

		// Page is long and narrow
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '5) Ad is loaded once');
		expect(adShown).toBeFalsy('5) Ad is hidden');

		// Page is long and wide
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '6) Ad is loaded once');
		expect(adShown).toBeTruthy('6) Ad is shown');

		// Page is long and narrow
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '7) Ad is loaded once');
		expect(adShown).toBeFalsy('7) Ad is hidden');
	});
});
