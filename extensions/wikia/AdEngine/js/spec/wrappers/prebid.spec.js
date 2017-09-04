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
					getBidResponsesForAdUnitCode: function () {
						return {
							bids: [
								{
									bidderCode: 'bidder1',
									cpm: 15.00,
									vastUrl: 'http://...'
								},
								{
									cpm: 20.00,
									bidderCode: 'bidder4'
								},
								{
									bidderCode: 'bidder2',
									cpm: 17.50,
									vastUrl: 'http://...'
								},
								{
									bidderCode: 'bidder3',
									cpm: 19.50,
									vastUrl: 'http://...'
								}
							]
						};
					}
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

	it('Get winning video bid for slot', function () {
		var bid = prebid.getWinningVideoBidBySlotName('foo');

		expect(bid.cpm).toBe(19.50);
	});

	it('Get winning video bid for slot from allowed bidders only', function () {
		var bid = prebid.getWinningVideoBidBySlotName('foo', ['bidder1', 'bidder2']);

		expect(bid.cpm).toBe(17.50);
	});
});
