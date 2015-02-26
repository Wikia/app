/*global describe,modules,it,expect,spyOn*/

describe('ext.wikia.adEngine.adDecoratorLegacyParamFormat', function () {
	'use strict';

	var ERROR = false;

	function noop() {
		return;
	}

	function testParams(testName, paramIn, expectedParamOut) {
		it(testName, function () {
			var decorator,
				mocks = {
					log: noop,
					fillInSlot: noop
				},
				decoratedFillInSlot;

			spyOn(mocks, 'fillInSlot');
			spyOn(mocks, 'log');

			decorator = modules['ext.wikia.adEngine.adDecoratorLegacyParamFormat'](mocks.log);
			decoratedFillInSlot = decorator(mocks.fillInSlot);

			decoratedFillInSlot(paramIn);
			if (expectedParamOut) {
				expect(mocks.fillInSlot).toHaveBeenCalled();
				expect(mocks.fillInSlot.calls.count()).toEqual(1);
				expect(mocks.fillInSlot.calls.argsFor(0)).toEqual([expectedParamOut]);
			} else {
				expect(mocks.fillInSlot).not.toHaveBeenCalled();
				expect(mocks.log).toHaveBeenCalled();
			}
		});
	}

	testParams('accepts old school array with just the slot name', ['a'], {slotName: 'a'});
	testParams('accepts old school array with slot name and provider', ['b', null, null, 'AdEngine'], {slotName: 'b'});
	testParams('accepts just the string and converts to slot name', 'c', {slotName: 'c'});
	testParams('accepts simple regular params', {slotName: 'd'}, {slotName: 'd'});
	testParams(
		'accepts regular params with onSuccess and onError',
		{slotName: 'e', onSuccess: noop, onError: noop},
		{slotName: 'e', onSuccess: noop, onError: noop}
	);

	testParams('rejects empty object', {}, ERROR);
	testParams('rejects object with no slotName key in it', {a: 'b'}, ERROR);
	testParams('rejects empty array', [], ERROR);
	testParams('rejects array with a non-string 1st item (number)', [100], ERROR);
	testParams('rejects array with a non-string 1st item (boolean)', [false], ERROR);
	testParams('rejects undefined', undefined, ERROR);
});
