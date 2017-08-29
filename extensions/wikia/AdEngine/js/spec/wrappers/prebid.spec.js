/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.wrappers.prebid', function () {
	'use strict';

	function noop () {}

	var mocks = {
			win: {
				pbjs: {
					que: {
						push: noop
					},
					_bidsReceived: [
						{
							ad: 'foo',
							adId: 'uniqueFooAd'
						},
						{
							ad: 'bar',
							adId: 'uniqueBarAd'
						}
					],
					getHighestCpmBids: noop
				}
			}
		},
		prebid;


	function getModule() {
		return modules['ext.wikia.adEngine.wrappers.prebid'](
			mocks.win
		);
	}

	beforeEach(function () {
		prebid = getModule();
	});

	it('Returns main pbjs object', function () {
		expect(prebid.get()).toBe(mocks.win.pbjs);
	});

	it('Pushes callbacks to pbjs que', function () {
		spyOn(mocks.win.pbjs.que, 'push');

		prebid.push('foo');

		expect(mocks.win.pbjs.que.push).toHaveBeenCalled();
	});

	it('Finds bid by ad id', function () {
		expect(prebid.getBidByAdId('uniqueBarAd')).toBe(mocks.win.pbjs._bidsReceived[1]);
	});

	it('Returns null when bid does not exist', function () {
		expect(prebid.getBidByAdId('notExistingId')).toEqual(null);
	});

	it('Get highest bid for slot name', function () {
		spyOn(mocks.win.pbjs, 'getHighestCpmBids');

		prebid.getBidBySlotName('foo');

		expect(mocks.win.pbjs.getHighestCpmBids).toHaveBeenCalled();
	});
});
