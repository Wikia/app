/*global describe, expect, it, modules*/
/*jshint maxlen: 200*/
/*jshint onevar: false*/
/*jslint vars: true*/
describe('AdLogicPageDimensions', function () {

	'use strict';

	var throttleMock = function (fn) {
		return fn;
	};

	function noop() {
		return;
	}

	function adShown(slotName, layoutName, matchingMediaQuery) {

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
			documentMock = {documentElement: {scrollWidth: 1280}},
			slotTweakerMock = {hide: noop, show: noop, hackChromeRefresh: noop},
			adLogicPageDimensions = modules['ext.wikia.adEngine.adLogicPageDimensions'](
				slotTweakerMock,
				documentMock,
				logMock,
				throttleMock,
				windowMock
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
		width800 = [oneColumnResponsive, noTopButton],
		width1024 = [noTopButton, noTopButton],
		width2000 = [];

	it('checks if screen is too narrow for a slot', function () {

		expect(adShown('foo', 'responsive', width2000)).toBeTruthy('width=2000 slot=foo -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 'responsive', width2000)).toBeTruthy('width=2000 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 'responsive', width2000)).toBeTruthy('width=2000 slot=INCONTENT_BOXAD_1 -> ADS');

		expect(adShown('foo', 'responsive', width1024)).toBeTruthy('width=1024 slot=foo -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 'responsive', width1024)).toBeTruthy('width=1024 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 'responsive', width1024)).toBeTruthy('width=1024 slot=INCONTENT_BOXAD_1 -> ADS');

		expect(adShown('foo', 'responsive', width800)).toBeTruthy('width=800 slot=foo -> ADS');
		expect(adShown('TOP_RIGHT_BOXAD', 'responsive', width800)).toBeFalsy('width=800 slot=TOP_RIGHT_BOXAD -> ADS');
		expect(adShown('INCONTENT_BOXAD_1', 'responsive', width800)).toBeFalsy('width=800 slot=INCONTENT_BOXAD_1 -> ADS');
	});

	it('updates the logic when resize event is fired', function () {
		var slotName = 'TOP_RIGHT_BOXAD',
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
				slotTweakerMock,
				documentMock,
				logMock,
				throttleMock,
				windowMock
			),
			fillInSlotMock = function () { adLoadCounter += 1; };

		adLogicPageDimensions.addSlot(slotName, fillInSlotMock);

		// Page is wide
		isNarrow = false;
		resizeListener();
		expect(adLoadCounter).toBe(1, '1) Ad is loaded once');
		expect(adWasShown).toBeTruthy('1) Ad is shown');

		// Page is narrow
		isNarrow = true;
		resizeListener();
		expect(adLoadCounter).toBe(1, '2) Ad is loaded once');
		expect(adWasShown).toBeFalsy('2) Ad is hidden');
	});
});
