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
		priceParsingHelper: {
			getPriceFromString: function() {
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
		sampler: {
			sample: function () {
				return false;
			}
		},
		vastUrlBuilder: {
			build: function () {
				return '//foo.vast';
			}
		},
		instantGlobals: {
			wgAdDriverVelesBidderCountries: ['PL'],
			wgAdDriverVelesBidderConfig: {}
		},
		geo: {
			isProperGeo: noop
		},
		log: noop,
		win: {
			XMLHttpRequest: noop
		}
	};

	mocks.log.levels = {};

	function getVeles() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.veles'](
			mocks.adContext,
			mocks.priceParsingHelper,
			mocks.sampler,
			mocks.prebid,
			mocks.vastUrlBuilder,
			mocks.geo,
			mocks.instantGlobals,
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

	function mockSuccessfulResponse(overrideResponseXMLDocumentElement) {
		var ad,
			adParameters,
			textNode,
			vast;

		if (overrideResponseXMLDocumentElement) {
			vast = overrideResponseXMLDocumentElement;
		} else {
			ad = document.createElement('Ad');
			adParameters = document.createElement('AdParameters');
			vast = document.createElement('VAST');
			textNode = document.createTextNode('veles=1554');

			ad.setAttribute('id', '831');
			adParameters.appendChild(textNode);
			ad.appendChild(adParameters);
			vast.appendChild(ad);
		}

		mocks.win.XMLHttpRequest.prototype.open = noop;
		mocks.win.XMLHttpRequest.prototype.send = function () {
			this.readyState = 4;
			this.status = 200;
			this.response = '<VAST><Ad id="831"><AdParameters><![CDATA[veles=1554]]></AdParameters></Ad></VAST>';
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
		expect(bid.ad).toBe('<VAST><Ad id="831"><AdParameters><![CDATA[veles=1554]]></AdParameters></Ad></VAST>');
		expect(bid.code).toBe(1);
		expect(bid.cpm).toBe(15.54);
	});

	it('Adds bids with price from config on successful response', function () {
		var bid,
			bidder = getVeles(),
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]}),
			velesAdapter = bidder.create();

		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {
			'831': 832
		};
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
		expect(bid.cpm).toBe(8.32);
	});

	it('Get correct price based on ad id (from config)', function () {
		var bid,
			bidder = getVeles(),
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]}),
			velesAdapter = bidder.create();

		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {
			'831': 564,
			'832': 434,
			'AdSense/AdX': 388
		};
		mockSuccessfulResponse();
		spyOn(mocks.prebidBid, 'addBidResponse').and.callThrough();

		velesAdapter.callBids({
			bidderCode: 'bar',
			bids: [
				bidderRequest
			]
		});

		bid = mocks.prebidBid.addBidResponse.calls.mostRecent().args[1];
		expect(bid.cpm).toBe(5.64);
	});

	it('Get correct price based on ad adxAdSystem (from config)', function () {
		var bid,
			bidder = getVeles(),
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]}),
			velesAdapter = bidder.create();

		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {
			'222': 564,
			'AdSense/AdX': 388
		};

		// prepare xml response documentElement to mock
		var ad = document.createElement('Ad'),
			adSystem = document.createElement('AdSystem'),
			vast = document.createElement('VAST'),
			adxAdSystemTextNode = document.createTextNode('AdSense/AdX');

		ad.setAttribute('id', '333');
		adSystem.appendChild(adxAdSystemTextNode);
		ad.appendChild(adSystem);
		vast.appendChild(ad);

		mockSuccessfulResponse(vast);
		spyOn(mocks.prebidBid, 'addBidResponse').and.callThrough();

		velesAdapter.callBids({
			bidderCode: 'bar',
			bids: [
				bidderRequest
			]
		});

		bid = mocks.prebidBid.addBidResponse.calls.mostRecent().args[1];
		expect(bid.cpm).toBe(3.88);
	});

	it('Get correct price based on AdParameters', function () {
		var bid,
			bidder = getVeles(),
			bidderRequest = bidder.prepareAdUnit('INCONTENT_PLAYER', { sizes: [ [ 640, 480 ] ]}),
			velesAdapter = bidder.create();

		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {
			'222': 564
		};

		// prepare xml response documentElement to mock
		var ad = document.createElement('Ad'),
			adParameters = document.createElement('AdParameters'),
			adSystem = document.createElement('AdSystem'),
			vast = document.createElement('VAST'),
			adxAdSystemTextNode = document.createTextNode('AdSense/AdX'),
			adParametersVelesTextNode = document.createTextNode('veles=1665');

		ad.setAttribute('id', '333');
		adSystem.appendChild(adxAdSystemTextNode);
		adParameters.appendChild(adParametersVelesTextNode);
		ad.appendChild(adSystem);
		ad.appendChild(adParameters);
		vast.appendChild(ad);

		mockSuccessfulResponse(vast);
		spyOn(mocks.prebidBid, 'addBidResponse').and.callThrough();

		velesAdapter.callBids({
			bidderCode: 'bar',
			bids: [
				bidderRequest
			]
		});

		bid = mocks.prebidBid.addBidResponse.calls.mostRecent().args[1];
		expect(bid.cpm).toBe(16.65);
	});
});
