describe("History", function () {
	"use strict";

	// mock window
	var windowMock = {
			document: {
				title: 'title'
			},
			location: 'location',
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
		historyApi = modules['wikia.history'](windowMock),
		windowMockNotWorking = {
			document: {
				title: 'title'
			},
			location: 'location',
			history: {
				length: 0,
				state: []
			}
		},
		historyApiNotWorking = modules['wikia.history'](windowMockNotWorking);

	it('registers AMD module', function() {
		expect(historyApi).toBeDefined();
		expect(typeof historyApi).toBe('object');
	});

	it('gives nice and clean API', function() {
		expect(typeof historyApi.pushState).toBe('function', 'pushState');
		expect(typeof historyApi.replaceState).toBe('function', 'replaceState');
	});

	it('works with history API pushState', function() {
		var testData = [
				{param: {test: 1}, result: true, value: 1},
				{param: {test: 2}, result: true, value: 2}
			],
			histLen = windowMock.history.length;

		testData.forEach(function (data) {
			var result = historyApi.pushState(data.param);

			expect(result).toBe(data.result);
			expect(windowMock.history.length).toBe(histLen + 1);
			expect(windowMock.history.state[histLen].test).toBe(data.value);

			histLen = windowMock.history.length;
		});
	});

	it('works with history API replaceState', function() {
		var testData = [
				{param: {test: 1}, result: true, value: 1},
				{param: {test: 2}, result: true, value: 2}
			],
			histLen = windowMock.history.length;

		testData.forEach(function (data) {
			var result = historyApi.replaceState(data.param);

			expect(result).toBe(data.result);
			expect(windowMock.history.length).toBe(histLen);
			expect(windowMock.history.state[histLen - 1].test).toBe(data.value);

			histLen = windowMock.history.length;
		});

	});

	it('fails to work without history API pushState', function(){
		var testData = [
				{param: {test: 1}, result: false},
				{param: {test: 2}, result: false}
			];

		testData.forEach(function (data) {
			var result = historyApiNotWorking.pushState(data.param);

			expect(result).toBe(data.result);
		});
	});

	it('fails to work without history API replaceState', function(){
		var testData = [
			{param: {test: 1}, result: false},
			{param: {test: 2}, result: false}
		];

		testData.forEach(function (data) {
			var result = historyApiNotWorking.replaceState(data.param);

			expect(result).toBe(data.result);
		});
	});
});
