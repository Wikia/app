/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.resolvedState', function () {
	'use strict';

	var BIG_IMAGE = 'bigImage.png',
		BIG_IMAGE_2 = 'bigImage2.png',
		DEFAULT_IMAGE = 'oldImage.png',
		RESOLVED_IMAGE = 'resolvedImage.png',
		RESOLVED_IMAGE_2 = 'resolvedImage2.png',
		mocks = {
			log: function () {},
			qs: {
				getVal: function () {
				}
			},
			QueryString: function () {
				return mocks.qs;
			}
		},
		data = {
			PARAMS: {
				CORRECT: {
					imageSrc: BIG_IMAGE,
					aspectRatio: 1,
					resolvedState: {
						aspectRatio: 2,
						imageSrc: RESOLVED_IMAGE
					},
					backgroundImage: {
						src: DEFAULT_IMAGE
					}
				},
				CORRECT_WITH_TWO_ASSETS: {
					leftImageSrc: BIG_IMAGE,
					rightImageSrc: BIG_IMAGE_2,
					aspectRatio: 1,
					resolvedState: {
						aspectRatio: 2,
						leftImageSrc: RESOLVED_IMAGE,
						rightImageSrc: RESOLVED_IMAGE_2
					},
					backgroundLeftImage: {
						src: DEFAULT_IMAGE
					},
					backgroundRightImage: {
						src: DEFAULT_IMAGE
					}
				},
				INCORRECT: {
					aspectRatio: 1,
					imageSrc: BIG_IMAGE,
					resolvedState: {
						aspectRatio: 0,
						imageSrc: ''
					},
					backgroundImage: {
						src: DEFAULT_IMAGE
					}
				},
				EMPTY: {}
			}
		},
		testCases = [
			{
				params: data.PARAMS.CORRECT,
				queryParam: null,
				expected: RESOLVED_IMAGE
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: null,
				expected: BIG_IMAGE
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: 'true',
				expected: ''
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: true,
				expected: ''
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: 'blocked',
				expected: BIG_IMAGE
			},
			{
				params: data.PARAMS.CORRECT,
				queryParam: 'blocked',
				expected: BIG_IMAGE
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: 'a',
				expected: BIG_IMAGE
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: '1',
				expected: ''
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: '0',
				expected: BIG_IMAGE
			},
			{
				params: data.PARAMS.CORRECT_WITH_TWO_ASSETS,
				queryParam: '0',
				expectedLeftImage: BIG_IMAGE,
				expectedRightImage: BIG_IMAGE_2,
				twoAssets: true
			},
			{
				params: data.PARAMS.CORRECT_WITH_TWO_ASSETS,
				queryParam: null,
				expectedLeftImage: RESOLVED_IMAGE,
				expectedRightImage: RESOLVED_IMAGE_2,
				twoAssets: true
			}
		];

	mocks.log.levels = {debug: ''};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.resolvedState'](mocks.log, mocks.QueryString);
	}

	testCases.forEach(function (testCase) {
		var testName = 'Should return ' + testCase.expected + ' when params: ' + JSON.stringify(testCase.params) +
			' and resolvedState query param equals: ' + testCase.queryParam;

		it(testName, function () {
			spyOn(mocks.qs, 'getVal');
			var rs = getModule();
			mocks.qs.getVal.and.returnValue(testCase.queryParam);

			if (testCase.twoAssets) {
				expect(testCase.expectedLeftImage).toEqual(rs.setImage(testCase.params).backgroundLeftImage.src);
				expect(testCase.expectedRightImage).toEqual(rs.setImage(testCase.params).backgroundRightImage.src);
			} else {
				expect(testCase.expected).toEqual(rs.setImage(testCase.params).backgroundImage.src);
			}
		});
	});

	it('Should update params aspect ratio', function () {
		var rs = getModule();

		expect(rs.setImage(data.PARAMS.CORRECT).aspectRatio).toEqual(data.PARAMS.CORRECT.resolvedState.aspectRatio);
	});

	it('Should update image src', function () {
		var params = data.PARAMS.CORRECT,
			rs = getModule();

		expect(rs.setImage(params).backgroundImage.src).toEqual(params.resolvedState.imageSrc);
	});

	it('Should not update image if there is no background image (template without backgroundImage)', function () {
		var params = {},
			rs = getModule();

		expect(rs.setImage(params)).toEqual(params);
	});

});
