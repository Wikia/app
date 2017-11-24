/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.*', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		log: noop,
		context: {
			slots: {},
			opts: {}
		},
		adContext: {
			get: noop,
			getContext: function () {
				return mocks.context;
			}
		},
		adUnitBuilder: {
			build: function (slotName, src) {
				return '/5441/wka.ent/_muppet//home/' + src + '/' + slotName;
			},
			buildNew: noop
		},
		kiloAdUnitBuilder: {
			build: function () {}
		},
		megaAdUnitBuilder: {
			build: function () {}
		},
		gptHelper: {
			pushAd: function (slotName, slotElement, slotPath, slotTargeting, extra) {
				extra.success();
				extra.error();
			}
		},
		lookups: {
			extendSlotTargeting: noop,
			storeRealSlotPrices: noop
		},
		slotRegistry: {
			getRefreshCount: function () {
				return 3;
			},
			storeScrollY: noop
		},
		slotTweaker: {
			removeDefaultHeight: noop,
			removeTopButtonIfNeeded: noop,
			adjustLeaderboardSize: noop
		},
		uapContext: {
			isUapLoaded: noop
		},
		lazyQueue: {},
		window: {},
		afterSuccess: noop,
		afterHop: noop,
		btfBlocker: {
			decorate: function (fillInSlot) {
				return fillInSlot;
			}
		}
	};

	function createSlot(slotName) {
		return {
			name: slotName,
			pre: noop,
			post: noop
		};
	}

	function getFactory() {
		return modules['ext.wikia.adEngine.provider.factory.wikiaGpt'](
			mocks.btfBlocker,
			mocks.gptHelper,
			mocks.adUnitBuilder,
			mocks.slotRegistry,
			mocks.log,
			mocks.lookups
		);
	}

	function getProvider(providerName) {
		switch (providerName) {
			case 'directGpt':
				return modules['ext.wikia.adEngine.provider.' + providerName](
					mocks.adContext,
					mocks.uapContext,
					getFactory(),
					mocks.kiloAdUnitBuilder,
					mocks.slotTweaker
				);
			case 'remnantGpt':
				return modules['ext.wikia.adEngine.provider.' + providerName](
					mocks.adContext,
					mocks.uapContext,
					getFactory(),
					mocks.adUnitBuilder,
					mocks.slotTweaker
				);
			case 'directGptMobile':
				return modules['ext.wikia.adEngine.provider.' + providerName](
					mocks.adContext,
					mocks.kiloAdUnitBuilder,
					mocks.megaAdUnitBuilder,
					getFactory()
				);
			case 'remnantGptMobile':
				return modules['ext.wikia.adEngine.provider.' + providerName](
					mocks.adContext,
					getFactory(),
					mocks.adUnitBuilder
				);
			default:
				return null;
		}
	}

	function assertSlotSizes(provider, slotName, expectedSizes) {
		provider.fillInSlot(createSlot(slotName));
		if (expectedSizes === 'out-of-page') {
			expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].size).toBe(undefined);
		} else {
			expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].size)
				.toBe(expectedSizes, provider.name + '.' + slotName + ' sizes');
		}
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

	it('directGpt: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			BOTTOM_LEADERBOARD: '728x90,970x250',
			INCONTENT_BOXAD_1: '120x600,160x600,300x250,300x600',
			INCONTENT_PLAYER: '1x1',
			INVISIBLE_HIGH_IMPACT_2: 'out-of-page',
			INVISIBLE_SKIN: '1000x1000,1x1',
			TOP_LEADERBOARD: '3x3,728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
			TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
		};

		assertProviderSlotMap(getProvider('directGpt'), expectedSizes);
	});

	it('remnantGpt: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			BOTTOM_LEADERBOARD: '728x90,970x250',
			INCONTENT_BOXAD_1: '120x600,160x600,300x250,300x600',
			INCONTENT_PLAYER: '1x1',
			INVISIBLE_HIGH_IMPACT_2: 'out-of-page',
			INVISIBLE_SKIN: '1000x1000,1x1',
			TOP_LEADERBOARD: '3x3,728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
			TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
		};

		assertProviderSlotMap(getProvider('remnantGpt'), expectedSizes);
	});

	it('directGptMobile: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			INVISIBLE_HIGH_IMPACT: '1x1',
			INVISIBLE_HIGH_IMPACT_2: 'out-of-page',
			MOBILE_TOP_LEADERBOARD: '300x50,320x50,320x100,320x480,2x2',
			MOBILE_BOTTOM_LEADERBOARD: '320x480,2x2',
			MOBILE_IN_CONTENT: '320x50,300x250,300x50,320x480',
			MOBILE_PREFOOTER: '320x50,300x250,300x50'
		};

		assertProviderSlotMap(getProvider('directGptMobile'), expectedSizes);
	});

	it('remnantGptMobile: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			INVISIBLE_HIGH_IMPACT: null,
			INVISIBLE_HIGH_IMPACT_2: null,
			MOBILE_TOP_LEADERBOARD: '300x50,320x50,320x100,320x480,2x2',
			MOBILE_BOTTOM_LEADERBOARD: '320x480,2x2',
			MOBILE_IN_CONTENT: '320x50,300x250,300x50,320x480',
			MOBILE_PREFOOTER: '320x50,300x250,300x50'
		};

		assertProviderSlotMap(getProvider('remnantGptMobile'), expectedSizes);
	});
});
