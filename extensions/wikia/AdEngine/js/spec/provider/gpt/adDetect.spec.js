/*global describe, it, expect, modules, spyOn*/
describe('Method ext.wikia.adEngine.provider.gpt.adDetect.onAdLoad', function () {
	'use strict';

	var noop = function () {},
		returnObj = function () { return {};},
		slotTweaker = {
			onReady: noop
		};

	function createSlot(slotName, success, collapse, hop) {
		return {
			name: slotName,
			success: success,
			collapse: collapse,
			hop: hop,
			pre: noop
		};
	}

	function assertResult(result, mocks) {
		switch (result) {
			case 'success':
				expect(mocks.success.calls.count()).toBe(1, 'Success callback should be called once');
				expect(mocks.collapse.calls.count()).toBe(0, 'Collapse callback should not be called once');
				expect(mocks.hop.calls.count()).toBe(0, 'Hop callback should not be called');
				break;
			case 'collapse':
				expect(mocks.success.calls.count()).toBe(0, 'Success callback should not be called once');
				expect(mocks.collapse.calls.count()).toBe(1, 'Collapse callback should be called once');
				expect(mocks.hop.calls.count()).toBe(0, 'Hop callback should not be called');
				break;
			case 'hop':
				expect(mocks.success.calls.count()).toBe(0, 'Success callback should not be called');
				expect(mocks.collapse.calls.count()).toBe(0, 'Collapse callback should not be called once');
				expect(mocks.hop.calls.count()).toBe(1, 'Hop callback should be called');
				break;
		}
	}

	function getModule(mocks) {
		return modules['ext.wikia.adEngine.provider.gpt.adDetect'](
			mocks.adContext,
			mocks.messageListener,
			slotTweaker,
			mocks.log,
			mocks.window
		);
	}

	function desktop(name, slotName, gptEvent, windowMock, result, forceAdType) {
		it('calls ' + result + ' for ' + name + ' ' + slotName + ' on desktop', function () {
			var gptHop, mocks = {
				log: noop,
				success: noop,
				collapse: noop,
				hop: noop,
				iframe: {},
				window: windowMock,
				adContext: {
					getContext: function () {
						return {
							targeting: {}
						};
					}
				},
				messageListener: {}
			};

			mocks.iframe.contentWindow = {
				'AdEngine_adType': forceAdType,
				document: {
					querySelector: {}
				}
			};

			gptHop = getModule(mocks);

			spyOn(mocks, 'success');
			spyOn(mocks, 'collapse');
			spyOn(mocks, 'hop');

			gptHop.onAdLoad(createSlot(slotName, mocks.success, mocks.collapse, mocks.hop), gptEvent, mocks.iframe);

			assertResult(result, mocks);
		});
	}

	function mobile(name, slotName, gptEvent, iframeContentHeight, specialAd, result, forceAdType) {
		it('calls ' + result + ' for ' + name + ' ' + slotName + ' on mobile', function () {
			var gptHop, mocks = {
				log: noop,
				success: noop,
				collapse: noop,
				hop: noop,
				window: {},
				iframe: {},
				iframeDoc: {},
				adContext: {
					getContext: function () {
						return {
							targeting: {
								skin: 'wikiamobile'
							}
						};
					}
				},
				messageListener: {}
			};

			mocks.iframe.contentWindow = {
				'AdEngine_adType': forceAdType
			};
			mocks.iframe.contentWindow.document = mocks.iframeDoc;

			// Just call the 'load' callback straight away for the test
			mocks.iframe.contentWindow.addEventListener = function (event, callback) {
				if (event === 'load') {
					callback();
				}
			};

			mocks.iframeDoc.body = {};
			mocks.iframeDoc.body.offsetHeight = iframeContentHeight;
			mocks.iframeDoc.querySelector = specialAd ? returnObj : noop;
			mocks.iframeDoc.querySelectorAll = function () { return []; };

			gptHop = getModule(mocks);

			spyOn(mocks, 'success');
			spyOn(mocks, 'collapse');
			spyOn(mocks, 'hop');

			gptHop.onAdLoad(createSlot(slotName, mocks.success, mocks.collapse, mocks.hop), gptEvent, mocks.iframe);

			assertResult(result, mocks);
		});
	}

	// Desktop:
	desktop('regular ad', 'SLOT_NAME', { isEmpty: false, size: [728, 90] }, {}, 'success');
	desktop('regular ad', 'TOP_LEADERBOARD', { isEmpty: false, size: [728, 90] }, {}, 'success');
	desktop('regular ad', 'INVISIBLE_SKIN', { isEmpty: false, size: [1000, 1000] }, {}, 'success');
	desktop('regular ad', 'ANYTHING', { isEmpty: false, size: [100, 100] }, {}, 'success');

	desktop('empty ad', 'SLOT_NAME', { isEmpty: true }, {}, 'hop');
	// If isEmpty, then shouldn't really check the size:
	desktop('empty ad', 'SLOT_NAME', { isEmpty: true, size: null }, {}, 'hop');
	desktop('empty ad', 'SLOT_NAME', { isEmpty: true, size: [1, 1] }, {}, 'hop');
	desktop('empty ad', 'SLOT_NAME', { isEmpty: true, size: [100, 100] }, {}, 'hop');

	desktop('1x1 ad', 'SLOT_NAME', { isEmpty: false, size: [1, 1] }, {}, 'hop');
	desktop('1x1 ad', 'INVISIBLE_SKIN', { isEmpty: false, size: [1, 1] }, {}, 'hop');

	desktop('collapsed ad', 'INCONTENT_PLAYER', { isEmpty: false, size: [640, 400] }, {}, 'collapse', 'collapse');

	// adDriver2ForcedStatus:
	desktop('proper collapse slot ad', 'FORCED_SLOT_NAME', { isEmpty: false, size: [1, 1] }, {
		adDriver2ForcedStatus: { FORCED_SLOT_NAME: 'success' }
	}, 'success');

	desktop('wrong collapse slot ad', 'FORCED_SLOT_NAME', { isEmpty: false, size: [1, 1] }, {
		adDriver2ForcedStatus: { OTHER_SLOT_NAME: 'success' }
	}, 'hop');
	desktop('wrong collapse slot ad i', 'FORCED_SLOT_NAME', { isEmpty: false, size: [1, 1] }, {
		adDriver2ForcedStatus: { FORCED_SLOT_NAME: true }
	}, 'hop');
	desktop('wrong collapse slot ad ii', 'FORCED_SLOT_NAME', { isEmpty: false, size: [1, 1] }, {
		adDriver2ForcedStatus: { FORCED_SLOT_NAME: 'hop' }
	}, 'hop');

	desktop('unsupported status=hop', 'FORCED_SLOT_NAME', { isEmpty: false, size: [100, 100] }, {
		adDriver2ForcedStatus: { FORCED_SLOT_NAME: 'hop' }
	}, 'success');

	desktop('out of page ad', 'SLOT_NAME', {
		isEmpty: false,
		slot: {
			getOutOfPage: function () {
				return true;
			}
		}
	}, {}, 'success');

	// Mobile
	mobile('regular ad', 'SLOT_NAME', { isEmpty: false, size: [320, 50] }, 50, false, 'success');
	mobile('regular ad', 'MOBILE_TOP_LEADERBOARD', { isEmpty: false, size: [320, 50] }, 50, false, 'success');
	mobile('regular ad', 'MOBILE_IN_CONTENT', { isEmpty: false, size: [300, 250] }, 250, false, 'success');
	mobile('regular ad', 'MOBILE_PREFOOTER', { isEmpty: false, size: [300, 250] }, 250, false, 'success');
	mobile('regular ad', 'ANYTHING', { isEmpty: false, size: [10, 100] }, 100, false, 'success');

	mobile('non-1x1 ad with empty contents', 'SLOT_NAME', { isEmpty: false, size: [320, 50] }, 0, false, 'hop');

	mobile('empty ad', 'SLOT_NAME', { isEmpty: true }, 0, false, 'hop');
	// If isEmpty, then shouldn't really check the size:
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true }, 100, false, 'hop');
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true, size: null }, 0, false, 'hop');
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true, size: null }, 100, false, 'hop');
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true, size: [1, 1] }, 0, false, 'hop');
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true, size: [1, 1] }, 100, false, 'hop');
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true, size: [100, 100] }, 0, false, 'hop');
	mobile('empty ad', 'SLOT_NAME', { isEmpty: true, size: [100, 100] }, 100, false, 'hop');

	mobile('1x1 ad', 'SLOT_NAME', { isEmpty: false, size: [1, 1] }, 0, false, 'hop');
	// If isEmpty, then shouldn't really check the size:
	mobile('1x1 ad', 'SLOT_NAME', { isEmpty: false, size: [1, 1] }, 1, false, 'hop');
	mobile('1x1 ad', 'SLOT_NAME', { isEmpty: false, size: [1, 1] }, 100, false, 'hop');

	mobile('collapsed mobile ad', 'SLOT_NAME', { isEmpty: false, size: [320, 50] }, 50, false, 'collapse', 'collapse');

	// Special ads
	mobile('Special ad (Celtra, etc)', 'SLOT_NAME', { isEmpty: false, size: [300, 250] }, 0, true, 'success');
	mobile('Special ad (Celtra, etc) 1x1', 'SLOT_NAME', { isEmpty: false, size: [1, 1] }, 0, true, 'hop');
	mobile('Special ad (Celtra, etc) empty', 'SLOT_NAME', { isEmpty: true, size: [300, 250] }, 0, true, 'hop');

	// TODO: test for absolute positioned images
	// (like the AdSense ads in desktop browser pretending to be a mobile browser)
});
