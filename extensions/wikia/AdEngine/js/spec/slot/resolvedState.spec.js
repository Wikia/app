/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.resolvedState', function () {
	'use strict';

	function createCorrectParams() {
		return {
			imageSrc: BIG_IMAGE,
			aspectRatio: ASPECT_RATIO,
			resolvedState: {
				aspectRatio: RESOLVED_STATE_ASPECT_RATIO,
				imageSrc: RESOLVED_IMAGE
			},
			backgroundImage: {
				src: DEFAULT_IMAGE
			}
		}
	}

	function createIncorrectParams() {
		return {
			aspectRatio: 1,
			imageSrc: BIG_IMAGE,
			resolvedState: {
				aspectRatio: 0,
				imageSrc: ''
			},
			backgroundImage: {
				src: DEFAULT_IMAGE
			}
		}
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

	var AD_ID = 12345,
		ASPECT_RATIO = 1,
		BIG_IMAGE = 'bigImage.png',
		BIG_IMAGE_2 = 'bigImage2.png',
		CACHE_STANDARD_TIME = 24,
		DEFAULT_IMAGE = 'oldImage.png',
		RESOLVED_STATE_ASPECT_RATIO = 2,
		RESOLVED_IMAGE = 'resolvedImage.png',
		RESOLVED_IMAGE_2 = 'resolvedImage2.png',
		mocks = {
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
			win: {}
		},
		testCases = [
			{
				params: createCorrectParams(),
				queryParam: null,
				expected: RESOLVED_IMAGE
			},
			{
				params: createCorrectParams(),
				queryParam: 'blocked',
				expected: BIG_IMAGE
			},
			{
				params: createCorrectParams(),
				queryParam: 'true',
				expected: RESOLVED_IMAGE
			},
			{
				params: createCorrectParams(),
				queryParam: 'a',
				expected: RESOLVED_IMAGE
			},
			{
				params: createCorrectParams(),
				queryParam: '0',
				expected: BIG_IMAGE
			},
			{
				params: createIncorrectParams(),
				queryParam: 'true',
				expected: BIG_IMAGE
			},
			{
				params: createIncorrectParams(),
				queryParam: 'blocked',
				expected: BIG_IMAGE
			},
			{
				params: createIncorrectParams(),
				queryParam: '1',
				expected: BIG_IMAGE
			}
		],
		testCasesWithTwoAssets = [
			{
				params: createCorrectParamsWithTwoAssets(),
				queryParam: '0',
				expectedImage1: BIG_IMAGE,
				expectedImage2: BIG_IMAGE_2
			},
			{
				params: createCorrectParamsWithTwoAssets(),
				queryParam: null,
				expectedImage1: RESOLVED_IMAGE,
				expectedImage2: RESOLVED_IMAGE_2
			}
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

	testCases.forEach(function (testCase) {
		var testName = 'Should return ' + testCase.expected + ' when params: ' + JSON.stringify(testCase.params) +
			' and resolvedState query param equals: ' + testCase.queryParam;

		it(testName, function () {
			spyOn(mocks.qs, 'getVal');
			var rs = getModule();
			mocks.qs.getVal.and.returnValue(testCase.queryParam);

			expect(testCase.expected).toEqual(rs.setImage(testCase.params).backgroundImage.src);
		});
	});

	testCasesWithTwoAssets.forEach(function (testCase) {
		var testName = 'Should return ' + testCase.expectedImage1 + ' and ' + testCase.expectedImage2 +
			' when params: ' + JSON.stringify(testCase.params) + ' and resolvedState query param equals: ' +
			testCase.queryParam;

		it(testName, function () {
			spyOn(mocks.qs, 'getVal');
			var rs = getModule();
			mocks.qs.getVal.and.returnValue(testCase.queryParam);

			expect(testCase.expectedImage1).toEqual(rs.setImage(testCase.params).image1.element.src);
			expect(testCase.expectedImage2).toEqual(rs.setImage(testCase.params).image2.element.src);
		});
	});

	it('Should update params aspect ratio', function () {
		var rs = getModule();

		expect(rs.setImage(createCorrectParams()).aspectRatio).toEqual(RESOLVED_STATE_ASPECT_RATIO);
	});

	it('Should update image src', function () {
		var params = createCorrectParams(),
			rs = getModule();

		expect(rs.setImage(params).backgroundImage.src).toEqual(params.resolvedState.imageSrc);
	});

	it('Should not update image if there is no background image (template without backgroundImage)', function () {
		var params = {},
			rs = getModule();

		expect(rs.setImage(params)).toEqual(params);
	});

	it('should use default state resources when no information about seen ad was stored for add with one image', function () {
		spyOn(mocks.cache, 'get');
		spyOn(mocks.cache, 'set');

		mocks.cache.get.and.returnValue(null);

		var rs = getModule(),
			actual = rs.setImage(createCorrectParams());

		expect(mocks.cache.set).toHaveBeenCalled();
		expect(actual.aspectRatio).toEqual(ASPECT_RATIO);
		expect(actual.backgroundImage.src).toEqual(BIG_IMAGE);
	});

	it('should use resolved state resources when information about seen ad was stored for add with one image', function () {
		spyOn(mocks.cache, 'get');
		spyOn(mocks.cache, 'set');

		mocks.cache.get.and.returnValue({
			lastSeenDate: new Date()
		});

		var rs = getModule(),
			actual = rs.setImage(createCorrectParams());

		expect(mocks.cache.set).not.toHaveBeenCalled();
		expect(actual.aspectRatio).toEqual(RESOLVED_STATE_ASPECT_RATIO);
		expect(actual.backgroundImage.src).toEqual(RESOLVED_IMAGE);
	});

	it('should use default state resources when no information about seen ad was stored using split template', function () {
		spyOn(mocks.cache, 'get');
		spyOn(mocks.cache, 'set');

		mocks.cache.get.and.returnValue(null);

		var rs = getModule(),
			actual = rs.setImage(createCorrectParamsWithTwoAssets());

		expect(mocks.cache.set).toHaveBeenCalled();
		expect(actual.aspectRatio).toEqual(ASPECT_RATIO);
		expect(actual.image1.element.src).toEqual(BIG_IMAGE);
		expect(actual.image2.element.src).toEqual(BIG_IMAGE_2);
	});

	it('should use resolved state resources when information about seen ad was stored using split template', function () {
		spyOn(mocks.cache, 'get');
		spyOn(mocks.cache, 'set');

		mocks.cache.get.and.returnValue({
			lastSeenDate: new Date()
		});

		var rs = getModule(),
			actual = rs.setImage(createCorrectParamsWithTwoAssets());

		expect(mocks.cache.set).not.toHaveBeenCalled();
		expect(actual.aspectRatio).toEqual(RESOLVED_STATE_ASPECT_RATIO);
		expect(actual.image1.element.src).toEqual(RESOLVED_IMAGE);
		expect(actual.image2.element.src).toEqual(RESOLVED_IMAGE_2);
	});
});
