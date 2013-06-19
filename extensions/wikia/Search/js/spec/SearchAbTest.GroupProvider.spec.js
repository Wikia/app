// unit tests
describe('SearchAbTest.GroupProvider', function() {
	var logMock = function() {};
	logMock.levels = { debug: 13 };

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
