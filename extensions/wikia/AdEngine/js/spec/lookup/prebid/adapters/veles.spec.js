/*global document, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.veles', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		adContext: {
			getContext: function () {
				return {
					targeting: {
						skin: 'oasis'
					}
				};
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
		instantGlobals: {
			wgAdDriverVelesBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: noop
		},
		win: {
			XMLHttpRequest: noop
		}
	};

	function getVeles() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.veles'](
			mocks.adContext,
			mocks.prebid,
			mocks.vastUrlBuilder,
			mocks.geo,
			mocks.instantGlobals,
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

	function mockSuccessfulResponse() {
		var adParameters = document.createElement('AdParameters'),
			textNode = document.createTextNode('velesPrice=1554'),
			vast = document.createElement('VAST');

		adParameters.appendChild(textNode);
		vast.appendChild(adParameters);

		mocks.win.XMLHttpRequest.prototype.open = noop;
		mocks.win.XMLHttpRequest.prototype.send = function () {
			this.readyState = 4;
			this.status = 200;
			this.response = '<VAST><AdParameters><![CDATA[velesPrice=1554]]></AdParameters></VAST>';
			this.responseXML = {
				documentElement: vast
			};
			this.onreadystatechange();
		};
	}

	it('Is disabled when geo does not match', function () {
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(false);
		var veles = getVeles();

		expect(veles.isEnabled()).toBeFalsy();
	});

	it('Is enabled when geo matches', function () {
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(true);
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

		expect(Object.keys(slots)).toEqual(['INCONTENT_PLAYER', 'INCONTENT_LEADERBOARD']);
	});

	it('Returns mercury slots', function () {
		var veles = getVeles(),
			slots = veles.getSlots('mercury');

		expect(Object.keys(slots)).toEqual(['MOBILE_IN_CONTENT']);
	});

	it('Returns prepared ad unit object', function () {
		var veles = getVeles(),
			adUnit = veles.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]});

		expect(adUnit).toEqual({
			code: 'INCONTENT_PLAYER',
			sizes: [
				[ 640, 480 ]
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
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]}),
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

	it('Adds bids with proper values on successful response', function () {
		var bid,
			bidder = getVeles(),
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]}),
			velesAdapter = bidder.create();

		mockSuccessfulResponse();
		bidderRequest.placementCode = 'foo123';
		spyOn(mocks.prebidBid, 'addBidResponse').and.callThrough();

		velesAdapter.callBids({
			bidderCode: 'bar',
			bids: [
				bidderRequest
			]
		});

		bid = mocks.prebidBid.addBidResponse.calls.mostRecent().args[1];
		expect(bid.ad).toBe('<VAST><AdParameters><![CDATA[velesPrice=1554]]></AdParameters></VAST>');
		expect(bid.code).toBe(1);
		expect(bid.cpm).toBe(15.54);
	});
});
