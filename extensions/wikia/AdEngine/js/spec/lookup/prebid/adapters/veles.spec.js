/*global beforeEach, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.veles', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		adContext: {
			get: noop,
			getContext: function () {
				return mocks.context;
			}
		},
		context: {},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		priceParsingHelper: {
			getPriceFromString: function () {
				return 0;
			}
		},
		prebidBid: {
			createBid: function (code) {
				return {
					code: code
				};
			},
			addBidResponse: noop
		},
		prebid: {
			push: function (callback) {
				callback();
			},
			get: function () {
				return mocks.prebidBid;
			}
		},
		vastUrlBuilder: {
			build: function () {
				return '//foo.vast';
			}
		},
		log: noop,
		win: {
			XMLHttpRequest: noop,
			pbjs: {
				_bidsReceived: [{
					bidderCode: 'veles',
					adId: 123
				}, {
					bidderCode: 'veles',
					adId: 456
				}, {
					bidderCode: 'veles',
					adId: 789
				}, {
					bidderCode: 'wikia',
					adId: 123
				}, {
					bidderCode: 'wikia',
					adId: 456
				}]
			}
		},
		instartLogic: {
			isBlocking: function() {
				return false;
			}
		}
	};

	mocks.log.levels = {};

	beforeEach(function () {
		mocks.context = {
			opts: {},
			targeting: {
				skin: 'oasis'
			},
			bidders: {
				veles: true
			}
		};
	});

	function getVeles() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.veles'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.priceParsingHelper,
			mocks.prebid,
			mocks.vastUrlBuilder,
			mocks.instartLogic,
			mocks.log,
			mocks.win
		);
	}

	function mockFailedResponse() {
		mocks.win.XMLHttpRequest.prototype.open = noop;
		mocks.win.XMLHttpRequest.prototype.send = function () {
			this.readyState = 4;
			this.status = 404;
			this.onreadystatechange();
		};
	}

	it('Is disabled when context is disabled', function () {
		mocks.context.bidders.veles = false;
		var veles = getVeles();

		expect(veles.isEnabled()).toBeFalsy();
	});

	it('Is disabled when context is enabled but is blocking', function () {
		var veles = getVeles();
		spyOn(mocks.instartLogic, 'isBlocking').and.returnValue(true);

		expect(veles.isEnabled()).toBeFalsy();
	});

	it('Is enabled when context is enabled', function () {
		var veles = getVeles();

		expect(veles.isEnabled()).toBeTruthy();
	});

	it('Returns proper adapter name', function () {
		var veles = getVeles();

		expect(veles.getName()).toBe('veles');
	});

	it('Returns oasis slots in proper order', function () {
		var veles = getVeles(),
			slots = veles.getSlots('oasis');

		expect(Object.keys(slots).sort()).toEqual([
			'TOP_LEADERBOARD', 'INCONTENT_PLAYER'
		].sort());
	});

	it('Returns mercury slots', function () {
		var veles = getVeles(),
			slots = veles.getSlots('mercury');

		expect(Object.keys(slots)).toEqual(['MOBILE_IN_CONTENT']);
	});

	it('Returns prepared ad unit object', function () {
		var veles = getVeles(),
			adUnit = veles.prepareAdUnit('INCONTENT_PLAYER', { sizes: [[640,480]]});

		expect(adUnit).toEqual({
			code: 'INCONTENT_PLAYER',
			sizes: [
				[640, 480]
			],
			bids: [
				{
					bidder: 'veles'
				}
			]
		});
	});

	it('Adds empty bids on failed response', function () {
		var bid,
			bidder = getVeles(),
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [[640, 480]]}),
			velesAdapter = bidder.create();

		mockFailedResponse();
		bidderRequest.placementCode = 'foo123';
		spyOn(mocks.prebidBid, 'addBidResponse').and.callThrough();

		velesAdapter.callBids({
			bidderCode: 'bar',
			bids: [
				bidderRequest
			]
		});

		bid = mocks.prebidBid.addBidResponse.calls.mostRecent().args[1];
		expect(bid.code).toBe(2);
	});

	it('Marks Veles bids as used except given ad', function () {
		var bidder = getVeles();

		bidder.markBidsAsUsed(456);

		expect(mocks.win.pbjs._bidsReceived[0].cpm).toBe(0.00);
		expect(mocks.win.pbjs._bidsReceived[0].used).toBe(true);
		expect(mocks.win.pbjs._bidsReceived[2].cpm).toBe(0.00);
		expect(mocks.win.pbjs._bidsReceived[2].used).toBe(true);
	});
});
