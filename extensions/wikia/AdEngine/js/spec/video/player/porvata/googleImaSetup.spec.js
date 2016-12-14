/*global beforeEach, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.porvata.googleImaSetup', function () {
	'use strict';

	function noop() {
	}

	var imaSetup,
		mocks = {
			vastUrlBuilder: {
				build: noop
			},
			log: noop,
			win: {
				google: {
					ima: {
						AdsRequest: noop
					}
				}
			}
		};

	function getModule(vasUrlBuilder, browserDetect, log, win) {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaSetup'](
			vasUrlBuilder,
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
			request = imaSetup.createRequest({
				width: 100,
				height: 100,
				vastTargeting: 'porvata/foo'
			});

		expect(request.adTagUrl).toBe('foo/bar');

		expect(buildSpy).toHaveBeenCalledWith(100 / 100, 'porvata/foo');
	});
});
