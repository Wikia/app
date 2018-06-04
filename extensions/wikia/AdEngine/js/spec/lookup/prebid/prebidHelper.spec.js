/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.prebidHelper', function () {
	'use strict';

	function noop() {}

	function mockContext(map) {
		spyOn(mocks.adContext, 'get').and.callFake(function (name) {
			return map[name];
		});
	}

	var mocks = {
		adContext: {
			get: noop
		},
		adapters: [
			{
				prepareAdUnit: function () {
					return {
						code: 'TOP_LEADERBOARD',
						sizes: [[728, 90], [970, 250]],
						bids: [
							{
								bidder: 'indexExchange',
								params: {
									id: '1',
									siteID: 183423
								}
							}
						]
					};
				},
				getSlots: function () {
					return {
						TOP_LEADERBOARD: {
							sizes: [
								[728, 90],
								[970, 250]
							],
							id: '1',
							siteID: 183423
						}
					};
				},
				isEnabled: function () {
					return true;
				}
			}, {
				prepareAdUnit: function () {
					return {
						code: 'TOP_LEADERBOARD',
						sizes: [[728, 90], [970, 250]],
						bids: [
							{
								bidder: 'appnexus',
								params: {
									placementId: '5823300'
								}
							}
						]
					};
				},
				getSlots: function () {
					return {
						TOP_LEADERBOARD: {
							sizes: [
								[728, 90],
								[970, 250]
							],
							placementId: '5823300'
						}
					};
				},
				isEnabled: function () {
					return true;
				}
			}
		],
		adaptersRegistry: {
			getAdapters: function () {
			}
		},
		prebidVersionCompatibility: noop,
		win: {
			pbjs: {
				version: 'v1.11'
			}
		}
	};

	function getPrebidHelper() {
		spyOn(mocks.adaptersRegistry, 'getAdapters').and.returnValue(mocks.adapters);

		mockContext({
			'opts.isNewPrebidEnabled': true
		});

		return modules['ext.wikia.adEngine.lookup.prebid.prebidHelper'](
			mocks.adContext,
			mocks.adaptersRegistry,
			mocks.prebidVersionCompatibility,
			mocks.win
		);
	}

	it('SetupAdUnits returns data in correct shape', function () {
		var prebidHelper = getPrebidHelper(),
			result = prebidHelper.setupAdUnits();

		expect(result).toEqual([{
			code: 'TOP_LEADERBOARD',
			sizes: [
				[728, 90], [970, 250]
			],
			bids: [{
				bidder: 'indexExchange',
				params: {
					id: '1',
					siteID: 183423
				}
			}]
		}, {
			code: 'TOP_LEADERBOARD',
			sizes: [
				[728, 90], [970, 250]
			],
			bids: [{
				bidder: 'appnexus',
				params: {
					placementId: '5823300'
				}
			}]
		}]);
	});
});
