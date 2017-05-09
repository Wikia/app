/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.rubicon.rubiconTier', function () {
	'use strict';

	var rubiconTier;

	function getRubiconTier() {
		return modules['ext.wikia.adEngine.lookup.rubicon.rubiconTier'](
			modules['ext.wikia.adEngine.utils.math']()
		);
	}

	beforeEach(function () {
		rubiconTier = getRubiconTier();
	});

	it('Creates tier based on price buckets and size id', function () {
		var testCases = [
			{
				sizeId: 203,
				price: 1600,
				expected: '203_tier1600'
			},
			{
				sizeId: 203,
				price: 23,
				expected: '203_tier0020'
			},
			{
				sizeId: 15,
				price: 0,
				expected: '15_tier0000'
			},
			{
				sizeId: 203,
				price: 2500,
				expected: '203_tier2000'
			},
			{
				sizeId: 203,
				price: -1,
				expected: '203_tier0000'
			},
			{
				sizeId: 203,
				price: 3,
				expected: '203_tier0003'
			},
			{
				sizeId: 203,
				price: 17,
				expected: '203_tier0015'
			},
			{
				sizeId: 203,
				price: 237,
				expected: '203_tier0230'
			},
			{
				sizeId: 203,
				price: 1232,
				expected: '203_tier1200'
			}
		];

		testCases.forEach(function (testCase) {
			expect(rubiconTier.create(testCase.sizeId, testCase.price)).toEqual(testCase.expected);
		});
	});

	it('Get open market price from ', function () {
		var testCases = [
			{
				tier: '203_tier1600',
				price: 1600
			},
			{
				tier: '15_tier0000',
				price: 0
			},
			{
				tier: '15_tier0015',
				price: 15
			},
			{
				tier: '15_tier0015NONE',
				price: 15
			},
			{
				tier: '15_tier0015deals',
				price: 0
			}
		];

		testCases.forEach(function (testCase) {
			expect(rubiconTier.parseOpenMarketPrice(testCase.tier)).toEqual(testCase.price);
		});
	});

	it('Get private price from ', function () {
		var testCases = [
			{
				tier: '203_tier1600',
				price: 0
			},
			{
				tier: '15_tier0000',
				price: 0
			},
			{
				tier: '15_tier0015deals',
				price: 15
			},
			{
				tier: '15_tier0000deals',
				price: 0
			},
			{
				tier: '15_tier0015something',
				price: 0
			}
		];

		testCases.forEach(function (testCase) {
			expect(rubiconTier.parsePrivatePrice(testCase.tier)).toEqual(testCase.price);
		});
	});
});
