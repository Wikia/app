/*global describe, expect, it, modules*/
/*jshint maxlen: 200*/
/*jshint onevar: false*/
/*jslint vars: true*/
describe('AdLogicPageDimensions', function () {

	'use strict';

	var adHelperMock = {
		throttle: function (fn) {
			return fn;
		}
	};

	function noop() {
		return;
	}

	function adShown(slotName, pageLength, layoutName, matchingMediaQuery) {

		var matchingMediaQueryDict = {},
			i,
			len,
			windowMock = {
				wgOasisResponsive: (layoutName === 'responsive'),
				wgOasisBreakpoints: (layoutName === 'breakpoints'),
				addEventListener: noop,
				styleMedia: {
					matchMedium: function (mediaQuery) {
						return !!matchingMediaQueryDict[mediaQuery];
					}
				}
			},
			logMock = noop,
			documentMock = {documentElement: {scrollHeight: pageLength, scrollWidth: 1280}},
			slotTweakerMock = {hide: noop, show: noop, hackChromeRefresh: noop},
			adLogicPageDimensions = modules['ext.wikia.adEngine.adLogicPageDimensions'](
				windowMock,
				documentMock,
				logMock,
				slotTweakerMock,
				adHelperMock
			),
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
		noTopButton = 'screen and (max-width: 1063px)',
		noMiddlePrefooter = 'screen and (max-width: 1083px)',
		width800 = [oneColumnResponsive, noTopButton, noMiddlePrefooter],
		width1024 = [noTopButton, noTopButton, noMiddlePrefooter],
		width2000 = [];

	it('checks if page is too short for a slot on a static oasis skin', function () {

		expect(adShown('foo', 1000)).toBeTruthy('height=1000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 1000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 1000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 1000)).toBeFalsy('height=1000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 1000)).toBeFalsy('height=1000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 1000)).toBeFalsy('height=1000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 2000)).toBeTruthy('height=2000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 2000)).toBeTruthy('height=2000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 2000)).toBeTruthy('height=2000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 2000)).toBeTruthy('height=2000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 3000)).toBeTruthy('height=3000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 3000)).toBeTruthy('height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 3000)).toBeFalsy('height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 3000)).toBeTruthy('height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 3000)).toBeTruthy('height=3000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 3000)).toBeTruthy('height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 5000)).toBeTruthy('height=5000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 5000)).toBeTruthy('height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 5000)).toBeTruthy('height=5000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 5000)).toBeTruthy('height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});

	it('checks if page is too short for a slot on responsive / breakpoints skin for wide screen', function () {
		expect(adShown('foo', 1000, 'responsive', width2000)).toBeTruthy('height=1000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 1000, 'responsive', width2000)).toBeFalsy('height=1000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 2000, 'responsive', width2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 2000, 'responsive', width2000)).toBeFalsy('height=2000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 2000, 'responsive', width2000)).toBeTruthy('height=2000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 3000, 'responsive', width2000)).toBeFalsy('height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 3000, 'responsive', width2000)).toBeTruthy('height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adShown('foo', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=foo -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('PREFOOTER_LEFT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
		expect(adShown('PREFOOTER_RIGHT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});

	it('checks if screen is too narrow for a slot', function () {

		expect(adShown('foo', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=foo -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=HOME_TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=INCONTENT_BOXAD_1 -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 5000, 'responsive', width2000)).toBeTruthy('width=2000 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');

		expect(adShown('foo', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=foo -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=HOME_TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'responsive', width1024)).toBeTruthy('width=1024 slot=INCONTENT_BOXAD_1 -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 5000, 'responsive', width1024)).toBeFalsy('width=1024 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');

		expect(adShown('foo', 5000, 'responsive', width800)).toBeTruthy('width=800 slot=foo -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 5000, 'responsive', width800)).toBeFalsy('width=800 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('HOME_TOP_RIGHT_BOXAD', 5000, 'responsive', width800)).toBeFalsy('width=800 slot=HOME_TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_2', 5000, 'responsive', width800)).toBeFalsy('width=800 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adShown('LEFT_SKYSCRAPER_3', 5000, 'responsive', width800)).toBeFalsy('width=800 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 5000, 'responsive', width800)).toBeFalsy('width=800 slot=INCONTENT_BOXAD_1 -> ADS');
		expect(adShown('PREFOOTER_MIDDLE_BOXAD', 5000, 'responsive', width800)).toBeFalsy('width=800 slot=PREFOOTER_MIDDLE_BOXAD -> ADS');
	});

	it('updates the logic when resize event is fired', function () {
		var slotName = 'LEFT_SKYSCRAPER_3',
			resizeListener = function () { return; },
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
			logMock = noop,
			documentMock = {documentElement: {scrollWidth: 1280}, getElementById: function () { return {}; }},
			adWasShown,
			adLoadCounter = 0,
			slotTweakerMock = {
				hide: function () { adWasShown = false; },
				show: function () { adWasShown = true; },
				hackChromeRefresh: noop
			},
			adLogicPageDimensions = modules['ext.wikia.adEngine.adLogicPageDimensions'](
				windowMock,
				documentMock,
				logMock,
				slotTweakerMock,
				adHelperMock
			),
			fillInSlotMock = function () { adLoadCounter += 1; };

		documentMock.documentElement.scrollHeight = 1000;
		adLogicPageDimensions.addSlot(slotName, fillInSlotMock);

		// Page is short and wide
		documentMock.documentElement.scrollHeight = 1000;
		isNarrow = false;
		expect(adLoadCounter).toBe(0, '1) Ad is not loaded at first');
		expect(adWasShown).toBeFalsy('1) Ad is hidden at first');

		// Page is long and wide
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '2) Ad is loaded once');
		expect(adWasShown).toBeTruthy('2) Ad is shown');

		// Page is short and wide
		documentMock.documentElement.scrollHeight = 1000;
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '3) Ad is loaded once');
		expect(adWasShown).toBeFalsy('3) Ad is hidden');

		// Page is short and narrow
		documentMock.documentElement.scrollHeight = 1000;
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '4) Ad is loaded once');
		expect(adWasShown).toBeFalsy('4) Ad is hidden');

		// Page is long and narrow
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '5) Ad is loaded once');
		expect(adWasShown).toBeFalsy('5) Ad is hidden');

		// Page is long and wide
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '6) Ad is loaded once');
		expect(adWasShown).toBeTruthy('6) Ad is shown');

		// Page is long and narrow
		documentMock.documentElement.scrollHeight = 5000;
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '7) Ad is loaded once');
		expect(adWasShown).toBeFalsy('7) Ad is hidden');
	});
});
