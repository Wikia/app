describe('ext.wikia.adEngine.video.porvata.googleImaPlayerFactory', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		browserDetect: {
			isMobile: noop
		},
		document: {
			createElement: noop
		},
		window: {
			google: {
				ima: {
					AdEvent: {
						Type: {}
					}
				}
			}
		},
		adsLoaderMock: {
			addEventListener: noop,
			requestAds: noop
		},
		adsRenderingSettings: {},
		adsRequestUrl: 'foo',
		adDisplayContainer: {
			initialize: noop
		}
	};

	function logMock() {
	}

	logMock.levels = {};

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory'](mocks.browserDetect, mocks.document, logMock, mocks.window);
	}

	it('module has correct API', function () {
		var addEventListenerSpy = spyOn(mocks.adsLoaderMock, 'addEventListener'),
			requestAdsSpy = spyOn(mocks.adsLoaderMock, 'requestAds'),
			module = getModule(),
			createdPlayer = module.create(mocks.adsRequestUrl, mocks.adDisplayContainer, mocks.adsLoaderMock, mocks.adsRenderingSettings);

		expect(typeof createdPlayer.addEventListener).toBe('function');
		expect(typeof createdPlayer.dispatchEvent).toBe('function');
		expect(typeof createdPlayer.getAdsManager).toBe('function');
		expect(typeof createdPlayer.getStatus).toBe('function');
		expect(typeof createdPlayer.playVideo).toBe('function');
		expect(typeof createdPlayer.reload).toBe('function');
		expect(typeof createdPlayer.resize).toBe('function');

		expect(addEventListenerSpy).toHaveBeenCalled();
		expect(requestAdsSpy).toHaveBeenCalledWith(mocks.adsRequestUrl);
	});
});
