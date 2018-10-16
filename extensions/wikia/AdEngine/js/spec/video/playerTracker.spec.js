/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.playerTracker', function () {
	'use strict';

	function noop() {
	}

	var autoplay = '0';
	var mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: {
							playerTracking: true
						}
					};
				}
			},
			adLogicPageParams: {
				getPageLevelParams: function () {
					return {
						pv: '7',
						skin: 'oasis'
					};
				}
			},
			adTracker: {
				trackDW: noop
			},
			browserDetect: {
				getOS: function () {
					return 'Fake';
				},
				getBrowser: function () {
					return 'Foo 9';
				}
			},
			geo: {
				getCountryCode: function () {
					return 'XY';
				}
			},
			log: noop,
			bidHelper: {
				transformPriceFromBid: function (bid) {
					return bid.cpm;
				}
			},
			slotTargeting: {
				getWikiaSlotId: function (slotName, src) {
					return slotName + '-' + src;
				}
			},
			featuredVideoCookieService: {
				getAutoplay: function() {
					return autoplay;
				}
			},
			window: {
				pvUID: 'superFooUniqueID'
			}
		},
		tracker;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.playerTracker'](
			mocks.adContext,
			mocks.adLogicPageParams,
			mocks.adTracker,
			mocks.slotTargeting,
			mocks.browserDetect,
			mocks.geo,
			mocks.log,
			mocks.window,
			mocks.bidHelper,
			undefined,
			undefined,
			mocks.featuredVideoCookieService
		);
	}

	function getTrackedValue(columnName) {
		return mocks.adTracker.trackDW.calls.mostRecent().args[0][columnName];
	}

	mocks.log.levels = {
		debug: 'debug'
	};

	beforeAll(function () {
		spyOn(mocks.adTracker, 'trackDW');
	});

	beforeEach(function () {
		mocks.adTracker.trackDW.calls.reset();

		autoplay = '0';
		tracker = getModule();
	});

	it('Do not track data when tracking is disabled', function () {
		tracker.track({
			trackingDisabled: true
		}, 'fooPlayer', 'barEvent');

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Do not track data when adProduct is not passed', function () {
		tracker.track({}, 'fooPlayer', 'barEvent');

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Do not track data when playerName is not passed', function () {
		tracker.track({
			adProduct: 'uap'
		}, null, 'barEvent');

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Do not track data when eventName is not passed', function () {
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer');

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Track data to player-info table', function () {
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'barEvent');

		expect(mocks.adTracker.trackDW.calls.mostRecent().args[1]).toEqual('adengplayerinfo');
	});

	it('Track data with available data', function () {
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('ad_product')).toEqual('uap');
		expect(getTrackedValue('pv_unique_id')).toEqual('superFooUniqueID');
		expect(getTrackedValue('pv_number')).toEqual('7');
		expect(getTrackedValue('player')).toEqual('fooPlayer');
		expect(getTrackedValue('event_name')).toEqual('barEvent');
		expect(getTrackedValue('country')).toEqual('XY');
		expect(getTrackedValue('skin')).toEqual('oasis');
		expect(getTrackedValue('ad_error_code')).toBeFalsy();
		expect(getTrackedValue('price')).toEqual(-1);
		expect(getTrackedValue('wsi')).toEqual('(none)');
		expect(getTrackedValue('browser')).toEqual('Fake Foo 9');
		expect(getTrackedValue('user_block_autoplay')).toEqual(1);
	});

	it('Track data with slot name', function () {
		tracker.track({
			adProduct: 'uap',
			slotName: 'TOP_LEADERBOARD'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('position')).toEqual('top_leaderboard');
	});

	it('Track data with error code when it is passed', function () {
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'adError', 401);

		expect(getTrackedValue('ad_error_code')).toEqual(401);
	});

	it('Track data with creative data when it is passed', function () {
		tracker.track({
			adProduct: 'uap',
			lineItemId: 78,
			creativeId: 92
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('line_item_id')).toEqual(78);
		expect(getTrackedValue('creative_id')).toEqual(92);
	});

	it('Track data with Rubicon data for rubicon ad product', function () {
		tracker.track({
			adProduct: 'rubicon',
			slotName: 'TOP_LEADERBOARD',
			bid: {
				bidderCode: 'rubicon',
				creativeId: 'foo89',
				cpm: 123
			}
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('vast_id')).toEqual('foo89');
		expect(getTrackedValue('price')).toEqual(123);
	});

	it('Track data with Beachfront data for beachfront ad product', function () {
		tracker.track({
			adProduct: 'beachfront',
			slotName: 'TOP_LEADERBOARD',
			bid: {
				bidderCode: 'beachfront',
				creativeId: 'w1k14',
				cpm: 456
			}
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('vast_id')).toEqual('w1k14');
		expect(getTrackedValue('price')).toEqual(456);
	});

	it('Track data with AppNexus data for appnexusAst ad product', function () {
		tracker.track({
			adProduct: 'appnexusAst',
			slotName: 'TOP_LEADERBOARD',
			bid: {
				bidderCode: 'appnexusAst',
				creativeId: '87765',
				cpm: 789
			}
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('vast_id')).toEqual('87765');
		expect(getTrackedValue('price')).toEqual(789);
	});

	it('Track data with wsi when src is available', function () {
		tracker.track({
			adProduct: 'uap',
			slotName: 'TLB',
			src: 'gpt'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('wsi')).toEqual('TLB-gpt');
	});

	it('Track data with wsi when different src is available', function () {
		tracker.track({
			adProduct: 'uap',
			slotName: 'MR',
			src: 'remnant'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('wsi')).toEqual('MR-remnant');
	});

	it('should set user_block_autoplay to 0 if featuredVideoAutoplay cookie is "1"', function () {
		autoplay = '1';
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('user_block_autoplay')).toEqual(0);
	});

	it('should set user_block_autoplay to -1 if featuredVideoCookie returns null', function () {
		autoplay = null;
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('user_block_autoplay')).toEqual(-1);
	});

	it('should set user_block_autoplay to -1 if featuredVideoCookie returns undefined', function () {
		// Cookie should be null if not present but let's be more bulletproof
		autoplay = undefined;
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('user_block_autoplay')).toEqual(-1);
	});

	it('should not set user_block_autoplay if cookies module is not present', function () {
		var serviceBefore = mocks.featuredVideoCookieService;

		mocks.featuredVideoCookieService = undefined;
		autoplay = undefined;

		tracker = getModule();
		tracker.track({
			adProduct: 'uap'
		}, 'fooPlayer', 'barEvent');

		expect(getTrackedValue('user_block_autoplay')).toBeUndefined();

		mocks.featuredVideoCookieService = serviceBefore;
	});
});
