/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.prebidHelper', function () {
	'use strict';

	var mocks = {
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
				getAdapters: function() {}
			},
			instartLogic: {
				isBlocking: function() {
					return false;
				}
			}
		};

	function getPrebidHelper() {
		spyOn(mocks.adaptersRegistry, 'getAdapters').and.returnValue(mocks.adapters);

		return modules['ext.wikia.adEngine.lookup.prebid.prebidHelper'](
			mocks.adaptersRegistry,
			mocks.instartLogic
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
