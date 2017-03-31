/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.priceParsingHelper', function () {
	'use strict';

	var noop = function () {},
		mocks = {
		sampler: {},
		geo: {isProperGeo: function () {return false;}},
		instantGlobals: {
			wgAdDriverVelesBidderConfig: {}
		},
		log: noop
	};

	mocks.log.levels = {
		debug: 1
	};

	var DEFAULT_PRICE = 0,
		testCases = [
		{
			configPrice: 've3150xx',
			expected: 31.50
		},
		{
			configPrice: 've3150ic',
			expected: 31.50
		},
		{
			configPrice: 've3150IC',
			expected: 31.50
		},
		{
			configPrice: 've3150LB',
			expected: 31.50
		},
		{
			configPrice: 've0315LB',
			expected: 3.15
		},
		{
			configPrice: 've0031LB',
			expected: 0.31
		},
		{
			configPrice: 've0000xx',
			expected: 0
		},
		{
			configPrice: 've0001xx',
			expected: 0.01
		},
		{
			configPrice: 've3150',
			expected: DEFAULT_PRICE
		},
		{
			configPrice: 've3150x',
			expected: DEFAULT_PRICE
		},
		{
			configPrice: 've315x',
			expected: DEFAULT_PRICE
		},
		{
			configPrice: 've31509xx',
			expected: DEFAULT_PRICE
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

	function mockAdXVastResponse() {
		var ad = document.createElement('Ad');
		ad.setAttribute('id', '333');
		ad.appendChild(document.createElement('AdSystem'))
			.appendChild(document.createTextNode('AdSense/AdX'));

		return getResponseObject(ad);
	}

	function mockVastResponse(adId) {
		var ad = document.createElement('Ad');
		ad.setAttribute('id', adId);
		ad.appendChild(document.createElement('AdParameters'));

		return getResponseObject(ad);
	}

	beforeEach(function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {};
	}) ;

	it('Should parse price from wgVariables config', function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig = {'1234567': 've3150XX'};

		expect(31.50)
			.toEqual(getParsingHelper().analyze(mockVastResponse('1234567')).price);
	});

	it('Should return 0 for non-existing price in config', function () {
		expect(0)
			.toEqual(getParsingHelper().analyze(mockVastResponse('not_exisiting_price')).price);
	});

	testCases.forEach(function (testCase) {
		var adId = '1';
		it('Should parse price ' + testCase.expected + ' from wgVariables config: ' + testCase.configPrice, function () {
			mocks.instantGlobals.wgAdDriverVelesBidderConfig[adId] = testCase.configPrice;

			expect(testCase.expected)
				.toEqual(getParsingHelper().analyze(mockVastResponse(adId)).price);
		});
	});

	it('Should should parse price form AdX config', function () {
		mocks.instantGlobals.wgAdDriverVelesBidderConfig['AdSense/AdX'] = 've1123LB';
		expect(11.23)
			.toEqual(getParsingHelper().analyze(mockAdXVastResponse()).price);
	});

});
