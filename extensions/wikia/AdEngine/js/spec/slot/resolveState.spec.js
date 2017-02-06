/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.resolveState', function () {
	'use strict';

	var mocks = {
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
					aspectRatio: 1,
					resolveState: {
						aspectRatio: 2,
						imageSrc: 'newImage.png'
					},
					backgroundImage: {
						src: 'oldImage.png'
					}
				},
				INCORRECT: {
					aspectRatio: 1,
					resolveState: {
						aspectRatio: 0,
						image: ''
					}
				},
				EMPTY: {}
			}
		},
		testCases = [
			{
				params: data.PARAMS.CORRECT,
				queryParam: null,
				expected: true
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: null,
				expected: false
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: 'true',
				expected: true
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: true,
				expected: true
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: 'blocked',
				expected: false
			},
			{
				params: data.PARAMS.CORRECT,
				queryParam: 'blocked',
				expected: false
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: 'a',
				expected: false
			},
			{
				params: data.PARAMS.INCORRECT,
				queryParam: '1',
				expected: false
			}

		];

	mocks.log.levels = {debug: ''};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.resolveState'](mocks.log, mocks.QueryString);
	}

	testCases.forEach(function (testCase) {
		var testName = 'Should return ' + testCase.expected + ' when params: ' + JSON.stringify(testCase.params) +
			' and resolvedState query param equals: ' + testCase.queryParam;

		it(testName, function () {
			spyOn(mocks.qs, 'getVal');
			var rs = getModule();
			mocks.qs.getVal.and.returnValue(testCase.queryParam);
			expect(rs.hasResolvedState(testCase.params)).toEqual(testCase.expected);
		});
	});

	it('Should update params aspect ratio', function () {
		var rs = getModule();

		expect(rs.updateAd(data.PARAMS.CORRECT).aspectRatio).toEqual(data.PARAMS.CORRECT.resolveState.aspectRatio);
	});

	it('Should update image src', function () {
		var params = data.PARAMS.CORRECT,
			rs = getModule();

		expect(rs.updateAd(params).backgroundImage.src).toEqual(params.resolveState.imageSrc);
	});

});
