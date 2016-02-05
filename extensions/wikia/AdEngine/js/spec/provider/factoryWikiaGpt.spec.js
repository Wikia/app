/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.factory.wikiaGpt', function () {
	'use strict';

	function noop() {}

	var mocks = {
			log: noop,
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
				pushAd: function (slot, slotPath, slotTargeting, extra) {
					slot.success();
					slot.hop();
				}
			},
			lookups: {
				extendSlotTargeting: noop
			},
			geo: {
				getCountryCode: function () {
					return 'CURRENT';
				}
			},
			beforeSuccess: noop,
			beforeHop: noop
		};

	function createSlot(slotName) {
		return {
			name: slotName,
			success: noop,
			hop: noop,
			pre: function (name, callback) {
				callback();
			}
		};
	}

	function getModule() {
		return modules['ext.wikia.adEngine.provider.factory.wikiaGpt'](
			mocks.adLogicPageParams,
			mocks.gptHelper,
			mocks.geo,
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
				LEFT_SKYSCRAPER_2:       {size: '160x600', pos: 'middle'},
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

	it('Call beforeSuccess on pushAd if is defined', function () {
		spyOn(mocks, 'beforeSuccess');

		getProvider({
			beforeSuccess: mocks.beforeSuccess
		}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.beforeSuccess).toHaveBeenCalled();
	});

	it('Call beforeHop on pushAd if is defined', function () {
		spyOn(mocks, 'beforeHop');

		getProvider({
			beforeHop: mocks.beforeHop
		}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.beforeHop).toHaveBeenCalled();
	});

	it('Override slot sizes when country is listed in provider configuration', function () {
		spyOn(mocks.gptHelper, 'pushAd');
		var provider = getProvider({
			overrideSizesPerCountry: {
				CURRENT: {
					TOP_LEADERBOARD: '2x2',
					TOP_RIGHT_BOXAD: '3x3'
				}
			}
		});
		provider.fillInSlot(createSlot('TOP_RIGHT_BOXAD'));
		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].size).toEqual('3x3');
		provider.fillInSlot(createSlot('TOP_LEADERBOARD'));
		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].size).toEqual('2x2');
	});

	it('Do nothing when overriding other slots', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getProvider({
			overrideSizesPerCountry: {
				CURRENT: {
					TOP_LEADERBOARD: '2x2'
				}
			}
		}).fillInSlot(createSlot('TOP_RIGHT_BOXAD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].size).toEqual('300x250,300x600');
	});

	it('Do nothing when overriding in different country', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getProvider({
			overrideSizesPerCountry: {
				US: {
					TOP_LEADERBOARD: '2x2'
				}
			}
		}).fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2].size).toEqual('728x90,970x250,970x90');
	});
});
