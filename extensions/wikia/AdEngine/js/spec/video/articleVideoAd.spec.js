/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.video.articleVideoAd', function () {
	'use strict';

	var FAKE_VAST_URL = 'http://fake.vast.url/test',
		noop = function () {},
		mocks = {
			defaultContext: {
				opts: {
					showAds: true,
					adsFrequency: 3
				}
			},
			adsTracking: {

			},
			adContext: {
				get: function (name) {
					var map = {
						'opts.showAds': true,
						'opts.adsFrequency': 3
					};

					return map[name];
				},
				getContext: function () {
					return mocks.defaultContext;
				}
			},
			slotsContext: {
				isApplicable: noop
			},
			srcProvider: {
				get: function () {
					return 'gpt';
				}
			},
			vastUrlBuilder: {
				build: function () {
					return FAKE_VAST_URL;
				}
			},
			megaAdUnitBuilder: {
				build: function () {
					return 'mega/ad/unit';
				}
			},
			log: noop
	};

	mocks.log.levels = {
		debug: 1
	};

	function getModule() {
		return modules['ext.wikia.adEngine.video.articleVideoAd'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.vastUrlBuilder,
			mocks.megaAdUnitBuilder,
			mocks.srcProvider,
			mocks.adsTracking,
			mocks.vastDebugger,
			mocks.log
		);
	}

	it('should send bid params to VAST builder for first video depth', function () {
		spyOn(mocks.vastUrlBuilder, 'build');
		getModule().buildVastUrl('preroll', 1, 1234567890, {bid: 'TEST_BID', bid_price: 666});

		var arg = mocks.vastUrlBuilder.build.calls.first().args[1];
		expect(Object.keys(arg)).toContain('bid');
		expect(arg.bid).toEqual('TEST_BID');

		expect(Object.keys(arg)).toContain('bid_price');
		expect(arg.bid_price).toEqual(666);
	});

	it('shouldn\'t send bid params to VAST builder for next video depths', function () {
		spyOn(mocks.vastUrlBuilder, 'build');
		getModule().buildVastUrl('preroll', 2, 1234567890, {bid: 'TEST_BID', bid_price: 666});

		var arg = mocks.vastUrlBuilder.build.calls.first().args[1];
		expect(Object.keys(arg)).not.toContain('bid');
		expect(Object.keys(arg)).not.toContain('bid_price');
	});

	it('should pass correlator parameter to VAST builder', function () {
		var correlator = 1234567890;
		spyOn(mocks.vastUrlBuilder, 'build');
		getModule().buildVastUrl('preroll', 1, correlator);

		var arg = mocks.vastUrlBuilder.build.calls.first().args[2];
		expect(arg.correlator).toEqual(correlator);
	});

	it('it should ask if slot is enabled', function () {
		spyOn(mocks.slotsContext, 'isApplicable');

		getModule().shouldPlayPreroll(1);

		expect(mocks.slotsContext.isApplicable.calls.first().args[0]).toEqual('FEATURED');
		expect(mocks.slotsContext.isApplicable.calls.count()).toEqual(1);

	});

	it('should allow to play preroll for first video', function () {
		spyOn(mocks.slotsContext, 'isApplicable').and.returnValue(true);
		expect(getModule().shouldPlayPreroll(1)).toBeTruthy();

	});

	it('should\'t allow to play preroll if slot is disabled', function () {
		spyOn(mocks.slotsContext, 'isApplicable').and.returnValue(false);
		expect(getModule().shouldPlayPreroll(1)).toBeFalsy();
	});
});
