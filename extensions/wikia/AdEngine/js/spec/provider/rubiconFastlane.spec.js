/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('Rubicon Fastlane provider', function () {
	'use strict';

	var rubiconFastlane,
		noop = function () {},
		mocks = {
			container: {
				appendChild: noop,
				setAttribute: noop
			},
			slotTweaker: {
				removeDefaultHeight: noop,
				removeTopButtonIfNeeded: noop,
				adjustLeaderboardSize: noop
			},
			iframeWriter: {
				getIframe: function () {
					return {
						contentWindow: {
							document: {
								body: {}
							}
						}
					};
				}
			},
			instantGlobals: {
				wgAdDriverRubiconFastlaneProviderSkipTier: 15
			},
			log: noop,
			win: {
				rubicontag: {
					getSlot: function (slotName) {
						return {
							getAdServerTargetingByKey: function () {
								switch (slotName) {
									case 'TOP_LEADERBOARD':
										return ['2_tier0020', '57_tier0050'];
									case 'TOP_RIGHT_BOXAD':
										return ['15_tierNONE'];
									case 'LEFT_SKYSCRAPER_2':
										return ['10_tier0000'];
									case 'PREFOOTER_LEFT_BOXAD':
										return ['15_tier0014'];
									case 'PREFOOTER_RIGHT_BOXAD':
										return ['15_tier0015', '49_tier0035'];
									case 'INCONTENT_BOXAD_1':
										return ['15_tier0100deals', '10_tier0075'];
									case 'MOBILE_TOP_LEADERBOARD':
										return [];
								}
							}
						};
					},
					renderCreative: noop
				}
			}
		};

	function getRubiconFastlaneProvider() {
		return modules['ext.wikia.adEngine.provider.rubiconFastlane'](
			mocks.slotTweaker,
			mocks.iframeWriter,
			mocks.instantGlobals,
			mocks.log,
			mocks.win
		);
	}

	function getSlot(slotName) {
		return {
			name: slotName,
			container: mocks.container,
			collapse: noop,
			success: noop,
			hop: noop,
			post: noop
		};
	}

	function assertCollapse(slotName) {
		var slot = getSlot(slotName);
		spyOn(slot, 'success');
		spyOn(slot, 'collapse');

		rubiconFastlane.fillInSlot(slot);

		expect(slot.success).not.toHaveBeenCalled();
		expect(slot.collapse).toHaveBeenCalled();
	}

	function assertRenderCreativeWithProperSize(slotName, expectedSize) {
		var slot = getSlot(slotName);

		rubiconFastlane.fillInSlot(slot);

		expect(mocks.win.rubicontag.renderCreative.calls.mostRecent().args[2]).toEqual(expectedSize);
	}

	beforeEach(function () {
		rubiconFastlane = getRubiconFastlaneProvider();
	});

	it('Cannot handle not defined slot', function () {
		expect(rubiconFastlane.canHandleSlot('FOO_SLOT')).toBeFalsy();
		expect(rubiconFastlane.canHandleSlot('BAR_SLOT')).toBeFalsy();
	});

	it('Can handle slot', function () {
		expect(rubiconFastlane.canHandleSlot('MOBILE_TOP_LEADERBOARD')).toBeTruthy();
		expect(rubiconFastlane.canHandleSlot('TOP_RIGHT_BOXAD')).toBeTruthy();
		expect(rubiconFastlane.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy();
	});

	it('Collapse slot when there is no minimum tier', function () {
		assertCollapse('TOP_RIGHT_BOXAD');
		assertCollapse('PREFOOTER_LEFT_BOXAD');
	});

	it('Render creative on success', function () {
		var slot = getSlot('TOP_LEADERBOARD');
		spyOn(slot, 'success');

		rubiconFastlane.fillInSlot(slot);

		expect(slot.success).toHaveBeenCalled();
	});

	it('Render creative on success with best tier', function () {
		spyOn(mocks.win.rubicontag, 'renderCreative');

		assertRenderCreativeWithProperSize('TOP_LEADERBOARD', '57');
		assertRenderCreativeWithProperSize('INCONTENT_BOXAD_1', '15');
		assertRenderCreativeWithProperSize('PREFOOTER_RIGHT_BOXAD', '49');
	});
});
