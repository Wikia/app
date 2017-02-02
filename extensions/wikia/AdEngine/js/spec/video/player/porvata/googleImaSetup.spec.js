/*global beforeEach, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.googleImaSetup', function () {
	'use strict';

	function noop() {
	}

	var imaSetup,
		mocks = {
			browserDetect: {
				isMobile: function () {
					return false;
				}
			},
			vastUrlBuilder: {
				build: noop
			},
			log: noop,
			recoveryHelper: {
				getSafeUri: function (url) {
					return url;
				}
			},
			win: {
				google: {
					ima: {
						AdsRequest: noop,
						AdsRenderingSettings: noop
					}
				}
			}
		};

	function getModule(vastUrlBuilder) {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaSetup'](
			vastUrlBuilder,
			mocks.recoveryHelper,
			mocks.browserDetect,
			mocks.log,
			mocks.win
		);
	}

	mocks.log.levels = {};

	beforeEach(function () {
		imaSetup = getModule(mocks.vastUrlBuilder);
	});

	it('createRequest with adTagUrl - vast URL in params', function () {
		var request = imaSetup.createRequest({
			vastUrl: 'foo/bar'
		});

		expect(request.adTagUrl).toBe('foo/bar');
	});

	it('createRequest with adTagUrl - vast URL not in params', function () {
		var buildSpy = spyOn(mocks.vastUrlBuilder, 'build').and.returnValue('foo/bar'),
			slotWidth  = 100,
			slotHeight = 100,
			request = imaSetup.createRequest({
				width: slotWidth,
				height: slotHeight,
				vastTargeting: 'porvata/foo'
			});

		expect(request.adTagUrl).toBe('foo/bar');

		expect(buildSpy).toHaveBeenCalledWith(slotWidth / slotHeight, 'porvata/foo');
	});

	it('createRequest with adTagUrl - vast URL not in params', function () {
		var buildSpy = spyOn(mocks.vastUrlBuilder, 'build').and.returnValue('foo/bar'),
			slotWidth  = 100,
			slotHeight = 100,
			request = imaSetup.createRequest({
				width: slotWidth,
				height: slotHeight,
				vastTargeting: 'porvata/foo'
			});

		expect(request.adTagUrl).toBe('foo/bar');

		expect(buildSpy).toHaveBeenCalledWith(slotWidth / slotHeight, 'porvata/foo');
	});

	it('getRenderingSettings - setup default values', function () {
		var settings = imaSetup.getRenderingSettings();

		expect(settings.uiElements.length).toBe(0);
		expect(settings.enablePreloading).toBeTruthy();
		expect(settings.loadVideoTimeout).toBe(15000);
		expect(settings.bitrate).toBe(68000);
	});

	it('getRenderingSettings - setup video timeout using parameters', function () {
		var settings = imaSetup.getRenderingSettings({
			loadVideoTimeout: 10000
		});

		expect(settings.loadVideoTimeout).toBe(10000);
	});
});
