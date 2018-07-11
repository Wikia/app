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
				},
				predict: function () {
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
				},
				predict: function () {
					return false;
				}
			}
		);
	}

	it('Return serialized results', function () {
		var rabbit = getModule();

		expect(rabbit.getAllSerializedResults()).toBe('bar_1');
	});

	it('Return empty results when there are no allowed models', function () {
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

	it('returns empty predictions when there are no allowed models', function () {
		var rabbit = getModule();

		expect(rabbit.getPredictions([]).length).toBe(0);
	});

	it('returns empty predictions when allowed model is disabled', function () {
		var rabbit = getModule();

		expect(rabbit.getPredictions(['foo']).length).toBe(0);
	});

	it('returns prediction for allowed and enabled model', function () {
		var rabbit = getModule();

		expect(rabbit.getPredictions(['bar']).length).toBe(1);
	});
});
