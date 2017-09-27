/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.modelFactory', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.rabbit'](
			{
				getResult: function () {
					return 'foo_1';
				},
				isEnabled: function () {
					return false;
				}
			},
			{
				getResult: function () {
					return 'bar_1';
				},
				isEnabled: function () {
					return true;
				}
			}
		);
	}

	it('Return serialized results', function () {
		var rabbit = getModule();

		expect(rabbit.getSerializedResults()).toBe('bar_1');
	});
});
