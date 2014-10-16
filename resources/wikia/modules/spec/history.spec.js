describe("History", function () {
	"use strict";

	// mock window
	var windowMock = {
			document: window.document,
			history: {
				length: 0,
				state: [],
				pushState: function(data, title, url) {
					this.length++;
					this.state.push(data);
				},
				replaceState: function(data) {
					this.state.pop();
					this.state.push(data);
				}
			}
		},
		historyApi = modules['wikia.history'](windowMock);

	it('registers AMD module', function() {
		expect(historyApi).toBeDefined();
		expect(typeof historyApi).toBe('object');
	});

	it('gives nice and clean API', function() {
		expect(typeof historyApi.pushState).toBe('function', 'pushState');
		expect(typeof historyApi.replaceState).toBe('function', 'replaceState');
	});

	it('works with history api', function() {
		var histLen = windowMock.history.length;

		historyApi.pushState({test: 1});
		expect(windowMock.history.length).toBe(histLen + 1);
		expect(windowMock.history.state[histLen].test).toBe(1);

		histLen = windowMock.history.length;
		historyApi.replaceState({test: 2});
		expect(windowMock.history.length).toBe(histLen);
		expect(windowMock.history.state[histLen-1].test).toBe(2);

	});
});
