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
		slotTweaker: {
			removeDefaultHeight: noop,
			removeTopButtonIfNeeded: noop,
			adjustLeaderboardSize: noop
		},
		lazyQueue: {},
		window: {},
		beforeSuccess: noop,
		beforeHop: noop,
		btfBlocker: {
			decorate: function(atfSlots, fillInSlot) {
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
			mocks.adContext,
			mocks.adLogicPageParams,
			mocks.btfBlocker,
			mocks.gptHelper,
			mocks.log,
			mocks.lookups
		);
	}

	function getProvider(providerName) {
		switch (providerName) {
			case 'directGpt':
			case 'remnantGpt':
				return modules['ext.wikia.adEngine.provider.' + providerName](
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

	beforeEach(function () {
		mocks.context.opts.overridePrefootersSizes = false;
		mocks.context.slots.incontentLeaderboardAsOutOfPage = false;
	});

	it('directGpt: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			CORP_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
			CORP_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
			HOME_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
			HOME_TOP_RIGHT_BOXAD: '300x250,300x600,300x1050',
			HUB_TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
			INCONTENT_BOXAD_1: '120x600,160x600,300x250,300x600',
			INCONTENT_LEADERBOARD: '1x1,728x90,300x250,468x60',
			INCONTENT_PLAYER: '1x1',
			INVISIBLE_HIGH_IMPACT_2: 'out-of-page',
			INVISIBLE_SKIN: '1000x1000,1x1',
			LEFT_SKYSCRAPER_2: '120x600,160x600,300x250,300x600,300x1050',
			LEFT_SKYSCRAPER_3: '120x600,160x600,300x250,300x600,1024x416',
			PREFOOTER_LEFT_BOXAD: '300x250',
			PREFOOTER_RIGHT_BOXAD: '300x250',
			TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
			TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
		};

		assertProviderSlotMap(getProvider('directGpt'), expectedSizes);
	});

	it('directGpt: Push ad with overridden prefooters slot sizes', function () {
		mocks.context.opts.overridePrefootersSizes = true;
		var expectedSizes = {
			PREFOOTER_LEFT_BOXAD: '300x250,468x60,728x90',
			PREFOOTER_RIGHT_BOXAD: null
		};

		assertProviderSlotMap(getProvider('directGpt'), expectedSizes);
	});

	it('directGpt: Push ad with overridden incontent leaderboard', function () {
		mocks.context.slots.incontentLeaderboardAsOutOfPage = true;
		var expectedSizes = {
			INCONTENT_LEADERBOARD: 'out-of-page'
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
			INCONTENT_BOXAD_1: '120x600,160x600,300x250,300x600',
			INCONTENT_LEADERBOARD: '1x1,728x90,300x250,468x60',
			INCONTENT_PLAYER: null,
			INVISIBLE_HIGH_IMPACT_2: 'out-of-page',
			INVISIBLE_SKIN: '1000x1000,1x1',
			LEFT_SKYSCRAPER_2: '120x600,160x600,300x250,300x600,300x1050',
			LEFT_SKYSCRAPER_3: '120x600,160x600,300x250,300x600',
			PREFOOTER_LEFT_BOXAD: '300x250',
			PREFOOTER_RIGHT_BOXAD: '300x250',
			TOP_LEADERBOARD: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
			TOP_RIGHT_BOXAD: '300x250,300x600,300x1050'
		};

		assertProviderSlotMap(getProvider('remnantGpt'), expectedSizes);
	});

	it('remnantGpt: Push ad with overridden prefooters slot sizes', function () {
		mocks.context.opts.overridePrefootersSizes = true;
		var expectedSizes = {
			PREFOOTER_LEFT_BOXAD: '300x250,468x60,728x90',
			PREFOOTER_RIGHT_BOXAD: null
		};

		assertProviderSlotMap(getProvider('remnantGpt'), expectedSizes);
	});

	it('remnantGpt: Push ad with overridden incontent leaderboard', function () {
		mocks.context.slots.incontentLeaderboardAsOutOfPage = true;
		var expectedSizes = {
			INCONTENT_LEADERBOARD: 'out-of-page'
		};

		assertProviderSlotMap(getProvider('remnantGpt'), expectedSizes);
	});

	it('directGptMobile: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			INVISIBLE_HIGH_IMPACT: '1x1',
			INVISIBLE_HIGH_IMPACT_2: null,
			MOBILE_TOP_LEADERBOARD: '320x50,320x100,300x250,300x50,1x1',
			MOBILE_IN_CONTENT: '320x50,300x250,300x50,1x1',
			MOBILE_PREFOOTER: '320x50,300x250,300x50,1x1'
		};

		assertProviderSlotMap(getProvider('directGptMobile'), expectedSizes);
	});

	it('remnantGptMobile: Push ad with specific slot sizes', function () {
		var expectedSizes = {
			INVISIBLE_HIGH_IMPACT: null,
			INVISIBLE_HIGH_IMPACT_2: null,
			MOBILE_TOP_LEADERBOARD: '320x50,320x100,300x250,300x50,1x1',
			MOBILE_IN_CONTENT: '320x50,300x250,300x50,1x1',
			MOBILE_PREFOOTER: '320x50,300x250,300x50,1x1'
		};

		assertProviderSlotMap(getProvider('remnantGptMobile'), expectedSizes);
	});
});
