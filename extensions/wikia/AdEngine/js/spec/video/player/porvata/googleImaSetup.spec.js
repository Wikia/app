/*global beforeEach, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.video.player.porvata.googleImaSetup', function () {
	'use strict';

	function noop() {
	}

	var imaSetup,
		MEGA_AD_UNIT = 'mega/ad/unit',
		mocks = {
			context: {
				get: noop
			},
			browserDetect: {
				isMobile: function () {
					return false;
				}
			},
			vastUrlBuilder: {
				build: noop
			},
			log: noop,
			megaAdUnitBuilder: {
				build: function () {
					return MEGA_AD_UNIT;
				}
			},
			sourcePoint: {
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
				},
				location: {
					href: ''
				}
			}
		};

	function getModule(vastUrlBuilder) {
		return modules['ext.wikia.adEngine.video.player.porvata.googleImaSetup'](
			mocks.context,
			mocks.megaAdUnitBuilder,
			vastUrlBuilder,
			mocks.sourcePoint,
			mocks.browserDetect,
			mocks.log,
			mocks.win
		);
	}

	function megaTurnedOn(name) {
		return name === 'opts.megaAdUnitBuilderEnabled' ? true : undefined;
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

		expect(buildSpy).toHaveBeenCalledWith(slotWidth / slotHeight, 'porvata/foo', {});
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

		expect(buildSpy).toHaveBeenCalledWith(slotWidth / slotHeight, 'porvata/foo', {});
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

	it('createRequest with adsResponse if passed', function () {
		var request = imaSetup.createRequest({
				vastResponse: '<foo xml/>'
			});

		expect(request.adsResponse).toBe('<foo xml/>');
	});

	it('create VAST url with regular adUnit by default', function () {
		spyOn(mocks.vastUrlBuilder, 'build');

		imaSetup.createRequest({
			width: 100,
			height: 100,
			vastTargeting: 'test'
		});

		expect(mocks.vastUrlBuilder.build.calls.first().args[2].adUnit).toBeUndefined();
	});

	it('create VAST url with overwritten custom MEGA adUnit if option is set', function () {
		spyOn(mocks.vastUrlBuilder, 'build');

		imaSetup.createRequest({
			width: 100,
			height: 100,
			vastTargeting: 'test',
			useMegaAdUnitBuilder: true
		});

		expect(mocks.vastUrlBuilder.build.calls.first().args[2].adUnit).toEqual(MEGA_AD_UNIT);
	});

	it('create VAST url with overwritten custom MEGA adUnit if it is set on context (without option)', function () {
		spyOn(mocks.vastUrlBuilder, 'build');
		spyOn(mocks.context, 'get').and.callFake(megaTurnedOn);

		imaSetup.createRequest({
			width: 100,
			height: 100,
			vastTargeting: 'test'
		});

		expect(mocks.vastUrlBuilder.build.calls.first().args[2].adUnit).toEqual(MEGA_AD_UNIT);
	});

	it('create VAST url with default adUnit if option is set to false, even if global enable it', function () {
		spyOn(mocks.vastUrlBuilder, 'build');
		spyOn(mocks.context, 'get').and.callFake(megaTurnedOn);

		imaSetup.createRequest({
			width: 100,
			height: 100,
			vastTargeting: 'test',
			useMegaAdUnitBuilder: false
		});

		expect(mocks.vastUrlBuilder.build.calls.first().args[2].adUnit).toBeUndefined();
	});

	it('pass correct slot targeting params to MEGA adUnit builder', function () {
		spyOn(mocks.vastUrlBuilder, 'build');
		spyOn(mocks.megaAdUnitBuilder, 'build');

		imaSetup.createRequest({
			width: 100,
			height: 100,
			vastTargeting: {
				src: 'test_src',
				pos: 'TEST_SLOT'
			},
			useMegaAdUnitBuilder: true
		});

		expect(mocks.megaAdUnitBuilder.build).toHaveBeenCalledWith('TEST_SLOT', 'test_src');
	});

	[{
		adProduct: 'vuap',
		type: 'bfaa',
		expected: 'UAP_BFAA'
	}, {
		adProduct: 'vuap',
		type: 'bfab',
		expected: 'UAP_BFAB'
	}, {
		adProduct: 'abcd',
		type: 'bfaa',
		expected: 'ABCD'
	}].forEach(function (testCase) {
		it('pass correct param to MEGA ad unit builder for "' + testCase.expected  + '" product', function () {
			spyOn(mocks.vastUrlBuilder, 'build');
			spyOn(mocks.megaAdUnitBuilder, 'build');

			imaSetup.createRequest({
				adProduct: testCase.adProduct,
				type: testCase.type,
				width: 100,
				height: 100,
				vastTargeting: {
					src: 'test_src',
					pos: 'TEST_SLOT'
				},
				useMegaAdUnitBuilder: true
			});

			expect(mocks.megaAdUnitBuilder.build).toHaveBeenCalledWith(testCase.expected, 'test_src');
		});
	});
});
