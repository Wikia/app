/*global beforeEach, describe, DOMParser, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.vastLogger', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		instantGlobals: {
			wgPorvataVastLoggerConfig: [
				'1_2_error',
				'78_34_init'
			]
		},
		log: noop,
		win: {
			XMLHttpRequest: noop,
			DOMParser: DOMParser
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

		logger.logVast(null, {}, {
			'event_name': 'error',
			'vulcan_advertiser': '5',
			'vulcan_network': '5',
			'ad_error_code': '1000',
			'position': 'TLB',
			'browser': 'Foo'
		});

		expect(mocks.request.post).not.toHaveBeenCalled();
	});

	it('Do not log if event name is not listed in config', function () {
		var logger = getVastLogger();

		logger.logVast(null, {}, {
			'event_name': 'ready',
			'vulcan_advertiser': '2',
			'vulcan_network': '1',
			'ad_error_code': '1000',
			'position': 'TLB',
			'browser': 'Foo'
		});

		expect(mocks.request.post).not.toHaveBeenCalled();
	});

	it('Log basic info', function () {
		var logger = getVastLogger(),
			sentData;

		logger.logVast(null, {}, {
			'event_name': 'error',
			'vulcan_advertiser': '2',
			'vulcan_network': '1',
			'ad_error_code': '1000',
			'position': 'TLB',
			'browser': 'Foo'
		});

		sentData = mocks.request.post.calls.mostRecent().args[0];
		expect(sentData).toContain('advertiser_id=2');
		expect(sentData).toContain('network_id=1');
		expect(sentData).toContain('event_name=error');
		expect(sentData).toContain('ad_error_code=1000');
		expect(sentData).toContain('position=TLB');
		expect(sentData).toContain('browser=Foo');
	});

	it('Log nested vast uri', function () {
		var logger = getVastLogger(),
			sentData;

		logger.logVast(null, {
			vastResponse: '<Ad><VASTAdTagURI><![CDATA[//foo.link]]></VASTAdTagURI></Ad>'
		}, {
			'event_name': 'init',
			'vulcan_advertiser': '34',
			'vulcan_network': '78'
		});

		sentData = mocks.request.post.calls.mostRecent().args[0];
		expect(sentData).toContain('vast_url=%2F%2Ffoo.link');
	});

	it('Log ad info details', function () {
		var logger = getVastLogger(),
			sentData;

		logger.logVast(getMockPlayerWithAd(), {
			vastResponse: '<Ad><VASTAdTagURI><![CDATA[//foo.link]]></VASTAdTagURI></Ad>'
		}, {
			'event_name': 'init',
			'vulcan_advertiser': '34',
			'vulcan_network': '78'
		});

		sentData = mocks.request.post.calls.mostRecent().args[0];
		expect(sentData).toContain('ad_system=DFP');
		expect(sentData).toContain('advertiser=Wikia');
		expect(sentData).toContain('content_type=video/mp4');
		expect(sentData).toContain('media_url=%2F%2Fbar.example');
	});
});
