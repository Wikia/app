/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.resolvedState', function () {
	'use strict';

	var AD_ID = 12345,
		ASPECT_RATIO = 1,
		BIG_IMAGE = 'bigImage.png',
		BIG_IMAGE_2 = 'bigImage2.png',
		CACHE_STANDARD_TIME = 24,
		DEFAULT_IMAGE = 'oldImage.png',
		RESOLVED_STATE_ASPECT_RATIO = 2,
		RESOLVED_IMAGE = 'resolvedImage.png',
		RESOLVED_IMAGE_2 = 'resolvedImage2.png';

	function createCorrectParams() {
		return {
			aspectRatio: ASPECT_RATIO,
			resolvedStateAspectRatio: RESOLVED_STATE_ASPECT_RATIO,
			image1: {
				element: {
					src: DEFAULT_IMAGE
				},
				defaultStateSrc: BIG_IMAGE,
				resolvedStateSrc: RESOLVED_IMAGE
			}
		};
	}

	function createIncorrectParams() {
		return {
			aspectRatio: ASPECT_RATIO,
			resolvedStateAspectRatio: 0,
			image1: {
				element: {
					src: DEFAULT_IMAGE
				},
				defaultStateSrc: BIG_IMAGE,
				resolvedStateSrc: ''
			}
		};
	}

	function createCorrectParamsWithTwoAssets() {
		return {
			aspectRatio: ASPECT_RATIO,
			resolvedStateAspectRatio: RESOLVED_STATE_ASPECT_RATIO,
			image1: {
				element: {
					src: DEFAULT_IMAGE
				},
				defaultStateSrc: BIG_IMAGE,
				resolvedStateSrc: RESOLVED_IMAGE
			},
			image2: {
				element: {
					src: DEFAULT_IMAGE
				},
				defaultStateSrc: BIG_IMAGE_2,
				resolvedStateSrc: RESOLVED_IMAGE_2
			}
		};
	}

	var mocks = {
			log: function () {
			},
			qs: {
				getVal: function () {
				}
			},
			QueryString: function () {
				return mocks.qs;
			},
			uapContext: {
				getUapId: function () {
					return AD_ID;
				}
			},
			cache: {
				CACHE_STANDARD: CACHE_STANDARD_TIME,
				get: function () {
					return [];
				},
				set: function () {
				}
			},
			videoSettings: {
				getParams: function () {
					return {};
				},
				isResolvedState: function () {
					return false;
				}
			},
			win: {}
		},
		blockingUrlParams = [
			false,
			'blocked',
			'false',
			'0'
		], forcingUrlParams = [
			true,
			'true',
			'1'
		];

	mocks.log.levels = {debug: ''};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.resolvedState'](
			mocks.uapContext,
			mocks.cache,
			mocks.log,
			mocks.QueryString,
			mocks.win
		);
	}

	blockingUrlParams.forEach(function (params) {
		it('should not be in resolved state when is not blocked by query param ' + params, function () {
			spyOn(mocks.qs, 'getVal');

			mocks.qs.getVal.and.returnValue(params);

			var rs = getModule();

			expect(rs.isResolvedState()).toEqual(false);
		});
	});

	forcingUrlParams.forEach(function (params) {
		it('should be in resolved state when is forced by query param ' + params, function () {
			spyOn(mocks.qs, 'getVal');

			mocks.qs.getVal.and.returnValue(params);

			var rs = getModule();

			expect(rs.isResolvedState()).toEqual(true);
		});
	});

	it('should not be in resolved state when no information about seen ad was stored', function () {
		spyOn(mocks.cache, 'get');
		spyOn(mocks.cache, 'set');

		mocks.cache.get.and.returnValue(null);

		var rs = getModule();

		expect(rs.isResolvedState()).toEqual(false);
	});

	it('should be in resolved state when information about seen ad was stored', function () {
		spyOn(mocks.cache, 'get');
		spyOn(mocks.cache, 'set');

		mocks.cache.get.and.returnValue({
			lastSeenDate: new Date()
		});


		var rs = getModule();

		expect(rs.isResolvedState()).toEqual(true);
	});

	it('should not modify params if template does not support resolved state', function() {
		spyOn(mocks.videoSettings, 'getParams');

		var params = createIncorrectParams(),
			rs = getModule();

		mocks.videoSettings.getParams.and.returnValue(params);

		rs.setImage(mocks.videoSettings);

		expect(params.aspectRatio).toEqual(ASPECT_RATIO);
		expect(params.image1.element.src).toEqual(DEFAULT_IMAGE);
	});

	it('should use default state resources when no information about seen ad was stored for add with one image', function () {
		spyOn(mocks.videoSettings, 'isResolvedState');
		spyOn(mocks.videoSettings, 'getParams');
		spyOn(mocks.cache, 'set');

		var params = createCorrectParams(),
			rs = getModule();

		mocks.videoSettings.getParams.and.returnValue(params);
		mocks.videoSettings.isResolvedState.and.returnValue(false);

		rs.setImage(mocks.videoSettings);

		expect(mocks.cache.set).toHaveBeenCalled();
		expect(params.aspectRatio).toEqual(ASPECT_RATIO);
		expect(params.image1.element.src).toEqual(BIG_IMAGE);
	});

	it('should use resolved state resources when information about seen ad was stored for add with one image', function () {
		spyOn(mocks.videoSettings, 'isResolvedState');
		spyOn(mocks.videoSettings, 'getParams');
		spyOn(mocks.cache, 'set');

		var params = createCorrectParams(),
			rs = getModule();

		mocks.videoSettings.getParams.and.returnValue(params);
		mocks.videoSettings.isResolvedState.and.returnValue(true);

		rs.setImage(mocks.videoSettings);

		expect(mocks.cache.set).not.toHaveBeenCalled();
		expect(params.aspectRatio).toEqual(RESOLVED_STATE_ASPECT_RATIO);
		expect(params.image1.element.src).toEqual(RESOLVED_IMAGE);
	});

	it('should use default state resources when no information about seen ad was stored using split template', function () {
		spyOn(mocks.videoSettings, 'isResolvedState');
		spyOn(mocks.videoSettings, 'getParams');
		spyOn(mocks.cache, 'set');

		var rs = getModule(),
			params = createCorrectParamsWithTwoAssets();

		mocks.videoSettings.getParams.and.returnValue(params);
		mocks.videoSettings.isResolvedState.and.returnValue(false);

		rs.setImage(mocks.videoSettings);

		expect(mocks.cache.set).toHaveBeenCalled();
		expect(params.aspectRatio).toEqual(ASPECT_RATIO);
		expect(params.image1.element.src).toEqual(BIG_IMAGE);
		expect(params.image2.element.src).toEqual(BIG_IMAGE_2);
	});

	it('should use resolved state resources when information about seen ad was stored using split template', function () {
		spyOn(mocks.videoSettings, 'isResolvedState');
		spyOn(mocks.videoSettings, 'getParams');
		spyOn(mocks.cache, 'set');

		var rs = getModule(),
			params = createCorrectParamsWithTwoAssets();

		mocks.videoSettings.getParams.and.returnValue(params);
		mocks.videoSettings.isResolvedState.and.returnValue(true);

		rs.setImage(mocks.videoSettings);

		expect(mocks.cache.set).not.toHaveBeenCalled();
		expect(params.aspectRatio).toEqual(RESOLVED_STATE_ASPECT_RATIO);
		expect(params.image1.element.src).toEqual(RESOLVED_IMAGE);
		expect(params.image2.element.src).toEqual(RESOLVED_IMAGE_2);
	});
});
