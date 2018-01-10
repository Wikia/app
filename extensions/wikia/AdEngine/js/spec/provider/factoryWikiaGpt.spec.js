/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.factory.wikiaGpt', function () {
	'use strict';

	function noop() {}

	var mocks = {
		log: noop,
		adUnitBuilder: {
			build: function(slotName, src) {
				return '/5441/wka.ent/_muppet//home/' + src + '/' + slotName;
			}
		},
		extraUnitBuilder: {
			build: function(slotName, src) {
				return 'extra/' + src + '/' + slotName;
			}
		},
		gptHelper: {
			pushAd: function (slot) {
				slot.success();
				slot.hop();
			}
		},
		lookups: {
			extendSlotTargeting: noop,
			storeRealSlotPrices: noop
		},
		slotRegistry: {
			getRefreshCount: function () {
				return 2;
			},
			storeScrollY: noop
		},
		afterSuccess: noop,
		afterCollapse: noop,
		window: {},
		afterHop: noop,
		btfBlocker: {
			decorate: noop
		}
	};

	function createSlot(slotName) {
		return {
			name: slotName,
			success: noop,
			hop: noop,
			post: function (name, callback) {
				callback();
			}
		};
	}

	function getModule() {
		return modules['ext.wikia.adEngine.provider.factory.wikiaGpt'](
			mocks.btfBlocker,
			mocks.gptHelper,
			mocks.adUnitBuilder,
			mocks.slotRegistry,
			mocks.log,
			mocks.lookups
		);
	}

	function getProvider(extra) {
		return getModule().createProvider(
			'logGroup',
			'testProvider',
			'testSource',
			{
				TOP_LEADERBOARD:         {size: '728x90,970x250,970x90', pos: 'top'},
				TOP_RIGHT_BOXAD:         {size: '300x250,300x600', pos: 'top'},
				GPT_FLUSH:               {skipCall: true}
			},
			extra
		);
	}

	it('Created provider with given name', function () {
		expect(getProvider().name).toEqual('testProvider');
	});

	it('Can handle the slot if it is defined in slot map', function () {
		expect(getProvider().canHandleSlot('TOP_LEADERBOARD')).toEqual(true);
	});

	it('Can not handle the slot if it is not defined in slot map', function () {
		expect(getProvider().canHandleSlot('NOT_SUPPORTED_SLOT')).toEqual(false);
	});

	it('Build slot path based on page params', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getProvider().fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[1]).toEqual(
			'/5441/wka.ent/_muppet//home/testSource/TOP_LEADERBOARD'
		);
	});

	it('Build slot path based on page params width extra ad unit builder', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		var extra = {
			getAdUnitBuilder: function () {
				return mocks.extraUnitBuilder;
			}
		};

		getProvider(extra).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[1]).toEqual(
			'extra/testSource/TOP_LEADERBOARD'
		);
	});

	it('Build slot path based on page params width extra ad unit builder in function', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		var extra = {
			getAdUnitBuilder: function () {
				return mocks.extraUnitBuilder;
			}
		};

		getProvider(extra).fillInSlot(createSlot('TOP_RIGHT_BOXAD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[1]).toEqual(
			'extra/testSource/TOP_RIGHT_BOXAD'
		);
	});

	it('Call afterSuccess on pushAd if is defined', function () {
		spyOn(mocks, 'afterSuccess');

		getProvider({
			afterSuccess: mocks.afterSuccess
		}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.afterSuccess).toHaveBeenCalled();
	});

	it('Call afterCollapse on pushAd if is defined', function () {
		spyOn(mocks, 'afterCollapse');

		getProvider({
			afterCollapse: mocks.afterCollapse
		}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.afterCollapse).toHaveBeenCalled();
	});

	it('Call afterHop on pushAd if is defined', function () {
		spyOn(mocks, 'afterHop');

		getProvider({
			afterHop: mocks.afterHop
		}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.afterHop).toHaveBeenCalled();
	});

	it('Push slot with refresh count key val', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getProvider().fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].rv).toEqual('2');
	});

	it('Pass correct testSrc as a param', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getProvider({testSrc: 'abc'}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3].testSrc).toEqual('abc');
	});

	it('Pass empty testSrc value for undefined', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getProvider().fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3].testSrc).toBeUndefined();
	});
});
