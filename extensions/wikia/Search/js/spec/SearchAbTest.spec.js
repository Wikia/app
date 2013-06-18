/*
 @test-require-asset resources/jquery/jquery-1.8.2.js
 @test-require-asset extensions/wikia/Search/js/SearchAbTest.js
 */

// unit tests
describe('SearchAbTest.WindowUtil', function() {
	var windowMock = { location: { search: "?asd" } };

	it("is an object", function() {
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
	});

	it("does not fail when there are no parameters", function() {
		var windowMock = { location: { search: "" } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getQueryParameters()).toEqual({});
	});

	it("does not fail when query string is '?'", function() {
		var windowMock = { location: { search: "?" } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getQueryParameters()).toEqual({});
	});

	it("does not fail when there are no parameters and location.search is null", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { location: { search: null } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getQueryParameters()).toEqual({});
	});

	it("does not fail when one argument is provided multiple times", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { location: { search: "?a=1&a=2" } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getQueryParameters()).toEqual({ a: '2' });
	});

	it("returns query string parameters", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { location: { search: "?a=x&b=1" } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getQueryParameters()).toEqual({ a: 'x', b: '1'});
	});

	it("does not break if query string has some unset values", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { location: { search: "?a&b=1" } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getQueryParameters()).toEqual({ a: undefined, b: '1'});
	});

	it("returns correctly A/B testing parameters", function() {
		// not realy sure if that can occur so I prefer to check.
		var windowMock = { location: { search: "?search=querystring&page=2&fulltext=Search&crossWikia=1&ns1=1&rank=default&limit=7&ab=105&AbTest.SEARCH_DESIGN_1=NEW_DESIGN" } };
		var windowUtil = modules['SearchAbTest.WindowUtil']( windowMock );
		expect(typeof windowUtil).toBe('object');
		expect(windowUtil.getAbTestingParameters()).toEqual({ 'AbTest.SEARCH_DESIGN_1': 'NEW_DESIGN', ab: '105'});
	});
});

// unit tests
describe('SearchAbTest.GroupProvider', function() {
	var logMock = function() {};

	it("returns a dummy if wikia is not loaded", function() {
		var windowMock = { };
		var groupProvider = modules['SearchAbTest.GroupProvider']( windowMock, logMock );
		expect(typeof groupProvider).toBe('object');
		expect(groupProvider.getGroups()).toEqual([]);
	});

	it("returns a dummy A/B tests are not loaded", function() {
		var windowMock = { Wikia: { } };
		var groupProvider = modules['SearchAbTest.GroupProvider']( windowMock, logMock );
		expect(typeof groupProvider).toBe('object');
		expect(groupProvider.getGroups()).toEqual([]);
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
		var groupProvider = modules['SearchAbTest.GroupProvider']( windowMock, logMock );
		expect(typeof groupProvider).toBe('object');
		expect(groupProvider.getGroups()).toEqual([ 13 ]);
	});
});
