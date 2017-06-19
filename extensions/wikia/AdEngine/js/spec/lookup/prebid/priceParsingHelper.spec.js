/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.priceParsingHelper', function () {
	'use strict';

	var adId = '1',
		result,
		noop = function () {},
		mocks = {
			sampler: {},
			geo: {
				isProperGeo: function () {
					return false;
				}
			},
			instantGlobals: {
				wgAdDriverVelesBidderConfig: {}
			},
			log: noop
		};

	mocks.log.levels = {
		debug: 1
	};

	var DEFAULT_PRICE = 0,
		DEFAULT_POS = 'IC',
		testCases = [
		{
			configPrice: 've3150xx',
			expectedPrice: 31.50,
			expectedPosition: 'XX',
			isValid: true
		},
		{
			configPrice: 've3150ic',
			expectedPrice: 31.50,
			expectedPosition: 'IC',
			isValid: true
		},
		{
			configPrice: 've3150IC',
			expectedPrice: 31.50,
			expectedPosition: 'IC',
			isValid: true
		},
		{
			configPrice: 've3150LB',
			expectedPrice: 31.50,
			expectedPosition: 'LB',
			isValid: true
		},
		{
			configPrice: 've0315LB',
			expectedPrice: 3.15,
			expectedPosition: 'LB',
			isValid: true
		},
		{
			configPrice: 've0031LB',
			expectedPrice: 0.31,
			expectedPosition: 'LB',
			isValid: true
		},
		{
			configPrice: 've0031LB+100%',
			expectedPrice: 0.31,
			expectedPosition: 'LB',
			expectedMoatTracking: 100,
			isValid: true
		},
		{
			configPrice: 've0000xx',
			expectedPrice: DEFAULT_PRICE,
			expectedPosition: DEFAULT_POS,
			isValid: false
		},
		{
			configPrice: 've0001xx',
			expectedPrice: 0.01,
			expectedPosition: 'XX',
			isValid: true
		},
		{
			configPrice: 've0001xx+100%',
			expectedPrice: 0.01,
			expectedPosition: 'XX',
			expectedMoatTracking: 100,
			isValid: true
		},
		{
			configPrice: 've3150',
			expectedPrice: DEFAULT_PRICE,
			expectedPosition: DEFAULT_POS,
			isValid: false
		},
		{
			configPrice: 've3150x',
			expectedPrice: DEFAULT_PRICE,
			expectedPosition: DEFAULT_POS,
			isValid: false
		},
		{
			configPrice: 've315x',
			expectedPrice: DEFAULT_PRICE,
			expectedPosition: DEFAULT_POS,
			isValid: false
		},
		{
			configPrice: 've31509xx',
			expectedPrice: DEFAULT_PRICE,
			expectedPosition: DEFAULT_POS,
			isValid: false
		}
	];

	function getParsingHelper() {
		return modules['ext.wikia.adEngine.lookup.prebid.priceParsingHelper'](
			mocks.sampler,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	function getResponseObject(ad) {
		return {
			readyState: 4,
			status: 200,
			responseXML: {
				documentElement: {
					querySelector: function () {
						return ad;
					}
				}
			}
		};
	}

	function mockAdXVastResponse(adId) {
		var ad = document.createElement('Ad');
		ad.setAttribute('id', adId);
		ad.appendChild(document.createElement('AdSystem'))
			.appendChild(document.createTextNode('AdSense/AdX'));

		return getResponseObject(ad);
	}

	function mockVastResponse(adId) {
		var ad = document.createElement('Ad');
		ad.setAttribute('id', adId);
		ad.appendChild(document.createElement('AdParameters'));
		ad.appendChild(document.createElement('AdSystem'))
			.appendChild(document.createTextNode('DFP'));

		return getResponseObject(ad);
	}

	beforeEach(function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {};
	}) ;

	it('Should parse price from wgVariables config', function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {'1234567': 've3150XX'};

		expect(getParsingHelper().analyze(mockVastResponse('1234567')).price)
			.toEqual(31.50);
	});

	it('Should return 0 for non-existing price in config', function () {
		expect(getParsingHelper().analyze(mockVastResponse('not_exisiting_price')).price)
			.toEqual(0);
	});

	testCases.forEach(function (testCase) {
		it('Should parse price ' + testCase.expectedPrice + ' from wgVariables config: ' + testCase.configPrice, function () {
			mocks.instantGlobals.wgAdDriverVelesBidderConfig[adId] = testCase.configPrice;

			result = getParsingHelper().analyze(mockVastResponse(adId));
			expect(result.price).toEqual(testCase.expectedPrice);
			expect(result.position).toEqual(testCase.expectedPosition);
			expect(result.valid).toEqual(testCase.isValid);
			expect(result.vastId).toEqual('DFP:' + adId);
			if (testCase.expectedMoatTracking) {
				expect(result.moatTracking).toEqual(testCase.expectedMoatTracking);
			} else {
				expect(result.moatTracking).toEqual(1);
			}
		});
	});

	it('Should parse price form AdX config', function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig['AdSense/AdX'] = 've1123LB';

		result = getParsingHelper().analyze(mockAdXVastResponse('123'));
		expect(result.price).toEqual(11.23);
		expect(result.position).toEqual('LB');
		expect(result.valid).toEqual(true);
		expect(result.vastId).toEqual('AdSense/AdX:123');
	});

	it('Should get price from id if exists, before AdX', function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig['AdSense/AdX'] = 've1123XX';
		mocks.instantGlobals.wgAdDriverVelesBidderConfig['666'] = 've6677LB';

		result = getParsingHelper().analyze(mockAdXVastResponse('666'));
		expect(result.price).toEqual(66.77);
		expect(result.position).toEqual('LB');
		expect(result.valid).toEqual(true);
		expect(result.vastId).toEqual('AdSense/AdX:666');
	});

});
