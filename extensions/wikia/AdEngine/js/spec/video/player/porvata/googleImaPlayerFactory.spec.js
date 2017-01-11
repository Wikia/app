/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		document: {
			createElement: noop
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
		params: {
			container: {
				querySelector: noop
			}
		}
	};

	mocks.log.levels = {};

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory'](
			mocks.imaSetup,
			mocks.document,
			mocks.log
		);
	}

	it('module has correct API', function () {
		var addEventListenerSpy = spyOn(mocks.adsLoaderMock, 'addEventListener'),
			requestAdsSpy = spyOn(mocks.adsLoaderMock, 'requestAds'),
			module = getModule(),
			createdPlayer = module.create(mocks.adDisplayContainer, mocks.adsLoaderMock, mocks.params);

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
