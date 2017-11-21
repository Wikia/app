/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('Evolve2 Provider targeting', function () {
	'use strict';

	var evolve2,
		noop = function () {},
		mocks = {
			adContext: {
				addCallback: noop,
				getContext: function () {
					return {
						targeting: {
							skin: 'oasis'
						}
					};
				}
			},
			btfBlocker: {
				decorate: function (callback) {
					return callback;
				}
			},
			eventDispatcher: {
				dispatch: noop
			},
			gptHelper: {
				pushAd: noop
			},
			log: noop,
			slotTweaker: {},
			vertical: 'foo_vertical',
			mappedVertical: 'bar_vertical',
			zoneParams: {
				getSite: function () {
					return mocks.mappedVertical;
				},
				getVertical: function () {
					return mocks.vertical;
				}
			}
		};

	function getEvolve2Provider() {
		return modules['ext.wikia.adEngine.provider.evolve2'](
			mocks.adContext,
			mocks.btfBlocker,
			mocks.gptHelper,
			mocks.slotTweaker,
			mocks.zoneParams,
			mocks.eventDispatcher,
			mocks.log
		);
	}

	function createSlot(slotName) {
		return {
			name: slotName,
			pre: noop
		};
	}

	beforeEach(function () {
		evolve2 = getEvolve2Provider();

		mocks.vertical = 'foo_vertical';
		mocks.mappedVertical = 'bar_vertical';
		spyOn(mocks.gptHelper, 'pushAd');
	});

	it('Cannot handle not defined slot', function () {
		expect(evolve2.canHandleSlot('FOO_SLOT')).toBeFalsy();
	});

	it('Can handle defined slot', function () {
		expect(evolve2.canHandleSlot('TOP_RIGHT_BOXAD')).toBeTruthy();
	});

	it('Should push ad to helper with proper ad unit id', function () {
		var expectedAdUnit = '/4403/ev/wikia_intl/ros/TOP_LEADERBOARD';

		evolve2.fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[1]).toEqual(expectedAdUnit);
	});

	it('Should push ad to helper with proper targeting', function () {
		var expectedTargeting = {
			size: '728x90,970x250,970x300,970x90',
			pos: 'a',
			wloc: 'top',
			wpos: 'TOP_LEADERBOARD',
			wsrc: 'evolve'
		};

		evolve2.fillInSlot(createSlot('TOP_LEADERBOARD'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2]).toEqual(expectedTargeting);
	});

	it('Should push ad to helper with proper targeting', function () {
		var expectedTargeting = {
			size: '300x250',
			pos: 'a',
			wpos: 'MOBILE_IN_CONTENT',
			wsrc: 'mobile_evolve'
		};

		evolve2.fillInSlot(createSlot('MOBILE_IN_CONTENT'));

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2]).toEqual(expectedTargeting);
	});

	it('Should push ad to helper with proper vertical', function () {
		var adUnitElements,
			expectedSection = 'tv';

		mocks.vertical = 'tv';
		evolve2.fillInSlot(createSlot('TOP_LEADERBOARD'));

		adUnitElements = mocks.gptHelper.pushAd.calls.mostRecent().args[1].split('/');
		expect(adUnitElements[4]).toEqual(expectedSection);
	});

	it('Should push ad to helper with proper vertical', function () {
		var adUnitElements,
			expectedSection = 'movies';

		mocks.vertical = 'movies';
		evolve2.fillInSlot(createSlot('TOP_LEADERBOARD'));

		adUnitElements = mocks.gptHelper.pushAd.calls.mostRecent().args[1].split('/');
		expect(adUnitElements[4]).toEqual(expectedSection);
	});

	it('Should push ad to helper with proper mapped vertical', function () {
		var adUnitElements,
			expectedSection = 'gaming';

		mocks.mappedVertical = 'gaming';
		evolve2.fillInSlot(createSlot('TOP_LEADERBOARD'));

		adUnitElements = mocks.gptHelper.pushAd.calls.mostRecent().args[1].split('/');
		expect(adUnitElements[4]).toEqual(expectedSection);
	});

	it('Should push ad to helper with proper mapped vertical', function () {
		var adUnitElements,
			expectedSection = 'entertainment';

		mocks.mappedVertical = 'ent';
		evolve2.fillInSlot(createSlot('TOP_LEADERBOARD'));

		adUnitElements = mocks.gptHelper.pushAd.calls.mostRecent().args[1].split('/');
		expect(adUnitElements[4]).toEqual(expectedSection);
	});
});
