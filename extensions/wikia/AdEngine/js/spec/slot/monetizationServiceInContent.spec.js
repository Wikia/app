/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.slot.monetizationServiceInContent', function () {
	'use strict';

	var mocks, monetizationServiceInContent;

	beforeEach(function () {
		mocks.window.adslots2 = [];
	});

	function noop() {
		return;
	}

	function returnEmpty() {
		return {};
	}

	mocks = {
		adContext: {
			getContext: function () {
				return {
					providers: mocks.getAdContextProviders()
				};
			}
		},
		getAdContextProviders: returnEmpty,
		log: noop,
		window: {
			adslots2: []
		}
	};

	monetizationServiceInContent = modules['ext.wikia.adEngine.slot.monetizationServiceInContent'](
		mocks.adContext,
		jQuery,
		mocks.log,
		mocks.window
	);

	it('Init: Monetization Service off, Not add incontent slot', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({monetizationService: false});
		spyOn(jQuery.fn, 'before');
		spyOn(jQuery.fn, 'append');
		monetizationServiceInContent.init();
		expect(jQuery.fn.before).not.toHaveBeenCalled();
		expect(jQuery.fn.append).not.toHaveBeenCalled();
		expect(mocks.window.adslots2).toEqual([]);
	});

	var testCases = [
		{size: 0, expectAppend: true},
		{size: 1, expectAppend: true},
		{size: 2, expectAppend: false},
		{size: 3, expectAppend: false},
		{size: 5, expectAppend: false},
		{size: 7, expectAppend: false},
		{size: 10, expectAppend: false}
	];

	Object.keys(testCases).forEach(function (key) {
		it('Init: Monetization Service on, add incontent slot. Test: ' + key, function () {
			var testCase = testCases[key];

			spyOn(mocks, 'getAdContextProviders').and.returnValue({monetizationService: true});
			spyOn(jQuery.fn, 'before');
			spyOn(jQuery.fn, 'append');
			spyOn(jQuery.fn, 'size').and.returnValue(testCase.size);
			monetizationServiceInContent.init();
			if (testCase.expectAppend) {
				expect(jQuery.fn.before).not.toHaveBeenCalled();
				expect(jQuery.fn.append).toHaveBeenCalled();
			} else {
				expect(jQuery.fn.before).toHaveBeenCalled();
				expect(jQuery.fn.append).not.toHaveBeenCalled();
			}
			expect(mocks.window.adslots2).toEqual(['MON_IN_CONTENT']);
		});
	});
});
