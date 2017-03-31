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

	function prepareXML(adId) {
		var ad = document.createElement('Ad');
		var adParameters = document.createElement('AdParameters');
		var vast = document.createElement('VAST');

		ad.setAttribute('id', adId);
		adParameters.appendChild(document.createTextNode('veles=1554'));
		ad.appendChild(adParameters);
		vast.appendChild(ad);

		return ad;
	}

	function mockVastResponse(adId) {
		return {
			readyState: 4,
			status: 200,
			responseXML: {
				documentElement: {
					querySelector: function () {
						return prepareXML(adId);
					}
				}
			}
		};
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

});
