/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('OpenX Provider targeting', function () {
	'use strict';

	var evolve2,
		noop = function () {},
		mocks = {
			evolveHelper: {
				getSect: function () {
					return 'foo_section';
				}
			},
			gptHelper: {
				pushAd: noop
			},
			log: noop,
			slotTweaker: {}
		};

	function getEvolve2Provider() {
		return modules['ext.wikia.adEngine.provider.evolve2'](
			mocks.evolveHelper,
			mocks.gptHelper,
			mocks.slotTweaker,
			mocks.log
		);
	}

	beforeEach(function () {
		evolve2 = getEvolve2Provider();
		spyOn(mocks.gptHelper, 'pushAd');
	});

	it('Cannot handle not defined slot', function () {
		expect(evolve2.canHandleSlot('FOO_SLOT')).toBeFalsy();
	});

	it('Can handle defined slot', function () {
		expect(evolve2.canHandleSlot('TOP_RIGHT_BOXAD')).toBeTruthy();
	});

	it('Should push ad to helper with proper ad unit id', function () {
		var expectedAdUnit = '/4403/ev/wikia_intl/foo_section/TOP_LEADERBOARD';

		evolve2.fillInSlot('TOP_LEADERBOARD');

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[2]).toEqual(expectedAdUnit);
	});

	it('Should push ad to helper with proper targeting', function () {
		var expectedTargeting = {
				size: '728x90,970x250,970x300,970x90',
				pos: 'a',
				sect: 'foo_section',
				site: 'wikia_intl'
			};

		evolve2.fillInSlot('TOP_LEADERBOARD');

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3]).toEqual(expectedTargeting);
	});

	it('Should increment pos tageting value for the same size slots', function () {
		evolve2.fillInSlot('TOP_RIGHT_BOXAD');
		evolve2.fillInSlot('HOME_TOP_RIGHT_BOXAD');

		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3].pos).toEqual('b');
	});

	it('Should start 160x600 with b pos and then increment', function () {
		evolve2.fillInSlot('LEFT_SKYSCRAPER_2');
		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3].pos).toEqual('b');

		evolve2.fillInSlot('LEFT_SKYSCRAPER_2');
		expect(mocks.gptHelper.pushAd.calls.mostRecent().args[3].pos).toEqual('c');
	});
});
