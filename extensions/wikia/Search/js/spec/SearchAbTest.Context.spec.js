// unit tests
describe('SearchAbTest.Context', function() {
	var logMock = function() {};
	logMock.levels = { debug: 13 };
	function getQueryStringMock( returnedParameters ) {
		returnedParameters = returnedParameters || {};
		return function() { return { getVals: function() { return returnedParameters;} }; };
	}

	it("returns a dummy if 'Wikia' is not loaded", function() {
		var windowMock = { };
		var groupProvider = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock() );
		expect(typeof groupProvider).toBe('object');
		expect(groupProvider.getAbTestGroups()).toEqual([]);
	});

	it("returns a dummy A/B tests are not loaded", function() {
		var windowMock = { Wikia: { } };
		var groupProvider = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock() );
		expect(typeof groupProvider).toBe('object');
		expect(groupProvider.getAbTestGroups()).toEqual([]);
	});

	it("returns properly search related groups", function() {
		var windowMock = { Wikia: { AbTest: {
			getExperiments: function() {
				return [
					{ name: 'foo', group: { id: 111 } },
					{ name: 'sEaRch ', group: { id: 13 } }
				];
			}
		} } };
		var groupProvider = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock() );
		expect(typeof groupProvider).toBe('object');
		expect(groupProvider.getAbTestGroups()).toEqual([ 13 ]);
	});

	it("does not fail when there are no parameters", function() {
		var windowMock = { location: { url: "" } };
		var windowContext = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock({}) );
		expect(typeof windowContext).toBe('object');
		expect(windowContext.getQueryParameters()).toEqual({});
	});

	it("does not fail when there are no parameters and location.url is null", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { location: { url: null } };
		var windowContext = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock({}) );
		expect(typeof windowContext).toBe('object');
		expect(windowContext.getQueryParameters()).toEqual({});
	});

	it("returns query string parameters", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { Wikia: { AbTest: {} }, location: { search: "?a=x&b=1" } };
		var windowContext = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock({ a: 'x', b: '1'}) );
		expect(typeof windowContext).toBe('object');
		expect(windowContext.getQueryParameters()).toEqual({ a: 'x', b: '1'});
	});

	it("does not break if query string has some unset values", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { Wikia: { AbTest: {} }, location: { search: "?a&b=1" } };
		var windowContext = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock({ 'a': undefined, b: '1' }) );
		expect(typeof windowContext).toBe('object');
		expect(windowContext.getQueryParameters()).toEqual({ a: undefined, b: '1'});
	});

	it("returns correctly A/B testing parameters", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { Wikia: { AbTest: {} }, location: { search: "dummy" } };
		var windowContext = modules['SearchAbTest.Context']( windowMock, logMock, getQueryStringMock({ 'search': 'asd', 'x': undefined, 'AbTest.SEARCH_DESIGN_1': 'NEW_DESIGN', ab: '105' }) );
		expect(typeof windowContext).toBe('object');
		expect(windowContext.getAbTestParameters()).toEqual({ 'AbTest.SEARCH_DESIGN_1': 'NEW_DESIGN', ab: '105' });
	});
});
