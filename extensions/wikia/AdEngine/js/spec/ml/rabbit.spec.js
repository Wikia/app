/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.modelFactory', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.rabbit'](
			{
				getName: function () {
					return 'foo';
				},
				getResult: function () {
					return 'foo_1';
				},
				isEnabled: function () {
					return false;
				}
			},
			{
				getName: function () {
					return 'bar';
				},
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

		expect(rabbit.getAllSerializedResults()).toBe('bar_1');
	});

	it('Return empty results when there is no allowed models', function () {
		var rabbit = getModule();

		expect(rabbit.getResults([]).length).toBe(0);
	});

	it('Return empty results when allowed model is disabled', function () {
		var rabbit = getModule();

		expect(rabbit.getResults(['foo']).length).toBe(0);
	});

	it('Return result for allowed and enabled model', function () {
		var rabbit = getModule();

		expect(rabbit.getResults(['bar']).length).toBe(1);
	});
});
