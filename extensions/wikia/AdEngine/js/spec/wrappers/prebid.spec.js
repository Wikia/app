/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.wrappers.prebid', function () {
	'use strict';

	function noop() {}

	var mocks = {
			adContext: {
				get: noop
			},
			bidsReceived: [
				{
					ad: 'foo',
					adId: 'uniqueFooAd'
				},
				{
					ad: 'bar',
					adId: 'uniqueBarAd'
				}
			],
			win: {
				loadPrebid: noop,
				pbjs: {
					que: {
						push: noop
					},
					setConfig: noop,
					getAllPrebidWinningBids: function () {
						return [];
					},
					getBidResponses: function () {
						return {
							"TOP_RIGHT_BOXAD": {
								bids: mocks.bidsReceived
							}
						}
					},
					getBidResponsesForAdUnitCode: function () {
						return {
							bids: [
								{
									bidderCode: 'bidder1',
									cpm: 15.00,
									vastUrl: 'http://...'
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
								},
								{
									bidderCode: 'bidder4',
									cpm: 20.00
								}
							]
						};
					}
				}
			},
			loc: {
				href: '//bar'
			}
		},
		prebid;

	function getModule() {
		return modules['ext.wikia.adEngine.wrappers.prebid'](
			mocks.adContext,
			undefined,
			mocks.loc,
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
		expect(prebid.getBidByAdId('uniqueBarAd')).toBe(mocks.bidsReceived[1]);
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
