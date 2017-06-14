/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.video.videoFrequencySettings', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: {}
					};
				}
			},
			time: {
				hasTimeUnit: noop,
				guessTimeUnit: noop
			}
		};

	function mockContext(data) {
		spyOn(mocks.adContext, 'getContext').and.returnValue(data);
	}

	function mockWgVar(wgVar) {
		mockContext({
			opts: {
				outstreamVideoFrequencyCapping: wgVar
			}
		});
	}

	function getModule() {
		return modules['ext.wikia.adEngine.video.videoFrequencySettings'](
			mocks.adContext,
			mocks.time
		);
	}

	it('Should correctly parse pv settings', function () {
		expect(getModule().get()).toEqual({pv: [], time: []});
	});

	it('Should correctly parse pv settings', function () {
		mockWgVar(['1/5pv']);
		spyOn(mocks.time, 'hasTimeUnit').and.returnValue(false);

		expect(getModule().get()).toEqual({pv: [{frequency: 1, limit: 5}], time: []});
	});

	it('Should correctly parse pv settings', function () {
		mockWgVar(['1/3min', '3/8pv']);
		spyOn(mocks.time, 'hasTimeUnit').and.returnValues([true, false]);
		spyOn(mocks.time, 'guessTimeUnit').and.returnValue('min');

		expect(getModule().get()).toEqual({
			pv: [{frequency: 3, limit: 8}],
			time: [{frequency: 1, limit: 3, unit: 'min'}]
		});
	});
});

