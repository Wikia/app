/*global beforeEach, describe, DOMParser, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.vastLogger', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		instantGlobals: {
			wgPorvataVastLoggerConfig: [
				'2_error',
				'34_init'
			]
		},
		log: noop,
		win: {
			XMLHttpRequest: noop
		},
		request: {
			post: noop
		}
	};

	mocks.log.levels = {};

	function getVastLogger() {
		return modules['ext.wikia.adEngine.video.player.porvata.vastLogger'](
			mocks.instantGlobals,
			mocks.log,
			mocks.win
		);
	}

	function getMockPlayerWithAd() {
		return {
			ima: {
				getAdsManager: function () {
					return {
						getCurrentAd: function () {
							return {
								getAdSystem: function () {
									return 'DFP';
								},
								getAdvertiserName: function () {
									return 'Wikia';
								},
								getContentType: function () {
									return 'video/mp4';
								},
								getMediaUrl: function () {
									return '//bar.example';
								}
							};
						}
					};
				}
			}
		};
	}

	beforeEach(function () {
		mocks.win.XMLHttpRequest.prototype.open = noop;
		mocks.win.XMLHttpRequest.prototype.setRequestHeader = noop;
		mocks.win.XMLHttpRequest.prototype.send = function (data) {
			mocks.request.post(data);
		};
		spyOn(mocks.request, 'post');
	});

	it('Do not log if advertiser and network is not listed in config', function () {
		var logger = getVastLogger();

		logger.logVast(null, {
			bid: {
				rubiconAdvertiserId: '5'
			}
		}, {
			'event_name': 'error',
			'ad_error_code': '1000',
			'position': 'TLB',
			'browser': 'Foo'
		});

		expect(mocks.request.post).not.toHaveBeenCalled();
	});

	it('Do not log if event name is not listed in config', function () {
		var logger = getVastLogger();

		logger.logVast(null, {
			bid: {
				rubiconAdvertiserId: '2'
			}
		}, {
			'event_name': 'ready',
			'ad_error_code': '1000',
			'position': 'TLB',
			'browser': 'Foo'
		});

		expect(mocks.request.post).not.toHaveBeenCalled();
	});

	it('Log basic info', function () {
		var logger = getVastLogger(),
			sentData;

		logger.logVast(null, {
			bid: {
				rubiconAdvertiserId: '2'
			}
		}, {
			'event_name': 'error',
			'ad_error_code': '1000',
			'position': 'TLB',
			'browser': 'Foo'
		});

		sentData = mocks.request.post.calls.mostRecent().args[0];
		expect(sentData).toContain('advertiser_id=2');
		expect(sentData).toContain('event_name=error');
		expect(sentData).toContain('ad_error_code=1000');
		expect(sentData).toContain('position=TLB');
		expect(sentData).toContain('browser=Foo');
	});

	it('Log vast URL', function () {
		var logger = getVastLogger(),
			sentData;

		logger.logVast(null, {
			vastUrl: '//foo.example',
			bid: {
				rubiconAdvertiserId: '34'
			}
		}, {
			'event_name': 'init'
		});

		sentData = mocks.request.post.calls.mostRecent().args[0];
		expect(sentData).toContain('vast_url=%2F%2Ffoo.example');
	});

	it('Log ad info details', function () {
		var logger = getVastLogger(),
			sentData;

		logger.logVast(getMockPlayerWithAd(), {
			vastUrl: '//foo.example',
			bid: {
				rubiconAdvertiserId: '34'
			}
		}, {
			'event_name': 'init'
		});

		sentData = mocks.request.post.calls.mostRecent().args[0];
		expect(sentData).toContain('ad_system=DFP');
		expect(sentData).toContain('advertiser=Wikia');
		expect(sentData).toContain('content_type=video/mp4');
		expect(sentData).toContain('media_url=%2F%2Fbar.example');
	});
});
