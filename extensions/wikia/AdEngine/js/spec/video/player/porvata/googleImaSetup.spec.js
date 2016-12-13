describe('ext.wikia.adEngine.video.porvata.googleImaSetup', function () {
	'use strict';

	var mocks = {
		vastUrlBuilder: {
			build: noop
		}
	};

	function noop() {
	}

	function logMock() {
	}

	function getModule(vasUrlBuilder, browserDetect, log, win) {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaSetup'](vasUrlBuilder, browserDetect, log, win);
	}

	logMock.levels = {};

	it('buildVastUrl - vast URL in params', function () {
		var
			module = getModule(mocks.vastUrlBuilder, {}, logMock, {});

		expect(module.buildVastUrl({
			vastUrl: 'foo/bar'
		})).toBe('foo/bar');
	});

	it('buildVastUrl - vast URL not in params', function () {
		var buildSpy = spyOn(mocks.vastUrlBuilder, 'build').and.returnValue('foo/bar'),
			module = getModule(mocks.vastUrlBuilder, {}, logMock, {});

		expect(module.buildVastUrl({
			width: 100,
			height: 100,
			vastTargeting: 'porvata/foo'
		})).toBe('foo/bar');

		expect(buildSpy).toHaveBeenCalledWith(100 / 100, 'porvata/foo');
	});
});
