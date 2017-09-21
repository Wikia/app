/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		document: {
			createElement: function () {
				return {
					setAttribute: noop
				};
			}
		},
		adsLoaderMock: {
			addEventListener: noop,
			requestAds: noop
		},
		adDisplayContainer: {
			initialize: noop
		},
		imaSetup: {
			getRenderingSettings: noop,
			createRequest: function () {
				return 'foo';
			}
		},
		log: noop,
		moatVideoTracker: {
			init: noop()
		},
		videoSettings: {
			getParams: function() {
				return {
					container: {
						querySelector: noop
					}
				};
			},
			isAutoPlay: function() {
				return false;
			}
		},
		win: {
			google: {
				ima: {
					AdEvent: {
						Type: {
							RESUMED: 'foo',
							STARTED: 'foo',
							PAUSED: 'foo',
							COMPLETE: 'foo'
						}
					},
					AdError: {
						ErrorCode: {
							VAST_EMPTY_RESPONSE: 1009
						}
					},
					AdErrorEvent: {
						Type: {
							AD_ERROR: 'foo'
						}
					},
					AdsManagerLoadedEvent: {
						Type: {
							ADS_MANAGER_LOADED: 'foo'
						}
					},
					ViewMode: {}
				}
			}
		}
	};

	mocks.log.levels = {};

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory'](
			mocks.imaSetup,
			mocks.moatVideoTracker,
			mocks.document,
			mocks.log,
			mocks.win
		);
	}

	it('module has correct API', function () {
		var addEventListenerSpy = spyOn(mocks.adsLoaderMock, 'addEventListener'),
			requestAdsSpy = spyOn(mocks.adsLoaderMock, 'requestAds'),
			module = getModule(),
			createdPlayer = module.create(mocks.adDisplayContainer, mocks.adsLoaderMock, mocks.videoSettings);

		expect(typeof createdPlayer.addEventListener).toBe('function');
		expect(typeof createdPlayer.dispatchEvent).toBe('function');
		expect(typeof createdPlayer.getAdsManager).toBe('function');
		expect(typeof createdPlayer.getStatus).toBe('function');
		expect(typeof createdPlayer.playVideo).toBe('function');
		expect(typeof createdPlayer.reload).toBe('function');
		expect(typeof createdPlayer.resize).toBe('function');

		expect(addEventListenerSpy).toHaveBeenCalled();
		expect(requestAdsSpy).toHaveBeenCalledWith('foo');
	});
});
