/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.utils.hooks', function () {

	function getModule(windowMock, host) {
		windowMock.location.host = host;

		return modules['ext.wikia.adEngine.utils.env'](windowMock);
	}

	it('isDevEnvironment returns correct values when run once', function() {
		var testCases = [
			{
				host: 'http://muppet.wikia.com',
				expected: false
			}, {
				host: 'http://muppet.john.wikia-dev.com',
				expected: true
			}
		], windowMock = {
			location: {
				host: ''
			}
		};

		testCases.forEach(function(testCase) {
			var module = getModule(windowMock, testCase.host);

			expect(module.isDevEnvironment()).toBe(testCase.expected);
		});
	});

	it('isDevEnvironment returns correct values when run more than once', function() {
		var testCases = [
			{
				host: 'http://muppet.wikia.com',
				expected: false,
				invocationCount: 5
			}, {
				host: 'http://muppet.john.wikia-dev.com',
				expected: true,
				invocationCount: 5
			}
		], windowMock = {
			location: {
				host: ''
			}
		};

		testCases.forEach(function(testCase) {
			var module = getModule(windowMock, testCase.host);

			for (var i =0; i<testCase.invocationCount; i++) {
				expect(module.isDevEnvironment()).toBe(testCase.expected);
			}
		});
	});
});
