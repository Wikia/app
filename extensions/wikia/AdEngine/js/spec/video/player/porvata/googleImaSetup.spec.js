/*global beforeEach, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.googleImaSetup', function () {
	'use strict';

	function noop() {
	}

	var imaSetup,
		mocks = {
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
						AdsRequest: noop
					}
				}
			}
		};

	function getModule(vastUrlBuilder, browserDetect, log, win) {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaSetup'](
			vastUrlBuilder,
			mocks.recoveryHelper,
			browserDetect,
			log,
			win
		);
	}

	mocks.log.levels = {};

	beforeEach(function () {
		imaSetup = getModule(mocks.vastUrlBuilder, {}, mocks.log, mocks.win);
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
});
