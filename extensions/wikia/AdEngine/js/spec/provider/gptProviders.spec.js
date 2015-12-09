/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.*', function () {
	'use strict';

	function noop() {}

	var mocks = {
			log: noop,
			context: {
				opts: {}
			},
			countryCode: 'CURRENT',
			adContext: {
				getContext: function () {
					return mocks.context;
				}
			},
			adLogicPageParams: {
				getPageLevelParams: function () {
					return {
						s0: 'ent',
						s1: '_muppet',
						s2: 'home'
					};
				}
			},
			gptHelper: {
				pushAd: function (slotName, slotElement, slotPath, slotTargeting, extra) {
					extra.success();
					extra.error();
				}
			},
			lookups: {
				extendSlotTargeting: noop
			},
			geo: {
				getCountryCode: function () {
					return mocks.countryCode;
				}
			},
			slotTweaker: {
				removeDefaultHeight: noop,
				removeTopButtonIfNeeded: noop,
				adjustLeaderboardSize: noop
			},
			lazyQueue: {},
			window: {},
			beforeSuccess: noop,
			beforeHop: noop
		};

	function getFactory() {
		return modules['ext.wikia.adEngine.provider.factory.wikiaGpt'](
			mocks.adLogicPageParams,
			mocks.gptHelper,
			mocks.geo,
			mocks.log,
			mocks.lookups
		);
	}

	function getProvider(providerName) {
		switch (providerName) {
			case 'directGpt':
				return modules['ext.wikia.adEngine.provider.directGpt'](
					mocks.adContext,
					getFactory(),
					mocks.slotTweaker,
					mocks.lazyQueue,
					mocks.log,
					mocks.window
				);
			case 'remnantGpt':
				return modules['ext.wikia.adEngine.provider.remnantGpt'](
					getFactory(),
					mocks.slotTweaker
				);
			case 'directGptMobile':
			case 'remnantGptMobile':
				return modules['ext.wikia.adEngine.provider.' + providerName](
					getFactory()
				);
		}
	}

	function assertSlotSizes(provider, slotName, expectedSizes) {
		provider.fillInSlot(slotName, {}, noop, noop);
		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3].size)
			.toBe(expectedSizes, provider.name + '.' + slotName + ' sizes');
	}

	function assertIfSlotIsSupported(provider, slotName) {
		expect(provider.canHandleSlot(slotName)).toBeTruthy('Can handle ' + provider.name + '.' + slotName);
	}

	function assertIfSlotIsNotSupported(provider, slotName) {
		expect(provider.canHandleSlot(slotName)).toBeFalsy('Cannot handle ' + provider.name + '.' + slotName);
	}

	function assertProviderSlotMap(provider, expectedSizes) {
		spyOn(mocks.gptHelper, 'pushAd');
		Object.keys(expectedSizes).forEach(function (slotName) {
			if (expectedSizes[slotName]) {
				assertIfSlotIsSupported(provider, slotName);
				assertSlotSizes(provider, slotName, expectedSizes[slotName]);
			} else {
				assertIfSlotIsNotSupported(provider, slotName);
			}
		});
	}

	beforeEach(function () {
		mocks.countryCode = 'CURRENT';
	});

	it('directGpt: Push ad with specific slot sizes', function () {
		var expectedSizes = {
				CORP_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				CORP_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
				HOME_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				HOME_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
				HUB_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				INCONTENT_BOXAD_1: '300x250',
				INCONTENT_PLAYER: '1x1',
				INVISIBLE_SKIN: '1000x1000,1x1',
				LEFT_SKYSCRAPER_2: '160x600,300x600',
				LEFT_SKYSCRAPER_3: '160x600,300x600',
				PREFOOTER_LEFT_BOXAD: '300x250',
				PREFOOTER_RIGHT_BOXAD: '300x250',
				TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
			};

		assertProviderSlotMap(getProvider('directGpt'), expectedSizes);
	});

	it('directGpt: Push ad with overridden slot sizes', function () {
		mocks.countryCode = 'JP';
		var expectedSizes = {
				CORP_TOP_LEADERBOARD: '728x90',
				CORP_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
				HOME_TOP_LEADERBOARD: '728x90',
				HOME_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
				HUB_TOP_LEADERBOARD: '728x90',
				INCONTENT_BOXAD_1: '300x250',
				INCONTENT_PLAYER: '1x1',
				INVISIBLE_SKIN: '1000x1000,1x1',
				LEFT_SKYSCRAPER_2: '160x600,300x600',
				LEFT_SKYSCRAPER_3: '160x600,300x600',
				PREFOOTER_LEFT_BOXAD: '300x250',
				PREFOOTER_RIGHT_BOXAD: '300x250',
				TOP_LEADERBOARD: '728x90',
				TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
			};

		assertProviderSlotMap(getProvider('directGpt'), expectedSizes);
	});

	it('remnantGpt: Push ad with specific slot sizes', function () {
		var expectedSizes = {
				CORP_TOP_LEADERBOARD: null,
				CORP_TOP_RIGHT_BOXAD: null,
				HOME_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				HOME_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
				HUB_TOP_LEADERBOARD: null,
				INCONTENT_BOXAD_1: '300x250',
				INCONTENT_PLAYER: null,
				INVISIBLE_SKIN: '1000x1000,1x1',
				LEFT_SKYSCRAPER_2: '160x600,300x600',
				LEFT_SKYSCRAPER_3: '160x600,300x600',
				PREFOOTER_LEFT_BOXAD: '300x250',
				PREFOOTER_RIGHT_BOXAD: '300x250',
				TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
			};

		assertProviderSlotMap(getProvider('remnantGpt'), expectedSizes);
	});

	it('remnantGpt: Push ad with overridden slot sizes', function () {
		mocks.countryCode = 'JP';
		var expectedSizes = {
				CORP_TOP_LEADERBOARD: null,
				CORP_TOP_RIGHT_BOXAD: null,
				HOME_TOP_LEADERBOARD: '728x90',
				HOME_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
				HUB_TOP_LEADERBOARD: null,
				INCONTENT_BOXAD_1: '300x250',
				INCONTENT_PLAYER: null,
				INVISIBLE_SKIN: '1000x1000,1x1',
				LEFT_SKYSCRAPER_2: '160x600,300x600',
				LEFT_SKYSCRAPER_3: '160x600,300x600',
				PREFOOTER_LEFT_BOXAD: '300x250',
				PREFOOTER_RIGHT_BOXAD: '300x250',
				TOP_LEADERBOARD: '728x90',
				TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
			};

		assertProviderSlotMap(getProvider('remnantGpt'), expectedSizes);
	});

	it('directGptMobile: Push ad with specific slot sizes', function () {
		var expectedSizes = {
				INVISIBLE_HIGH_IMPACT: '1x1',
				MOBILE_TOP_LEADERBOARD: '320x50,320x100,300x250,1x1',
				MOBILE_IN_CONTENT: '300x250,1x1',
				MOBILE_PREFOOTER: '300x250,1x1'
			};

		assertProviderSlotMap(getProvider('directGptMobile'), expectedSizes);
	});

	it('remnantGptMobile: Push ad with specific slot sizes', function () {
		var expectedSizes = {
				INVISIBLE_HIGH_IMPACT: null,
				MOBILE_TOP_LEADERBOARD: '320x50,320x100,300x250,1x1',
				MOBILE_IN_CONTENT: '300x250,1x1',
				MOBILE_PREFOOTER: '300x250,1x1'
			};

		assertProviderSlotMap(getProvider('remnantGptMobile'), expectedSizes);
	});
});
