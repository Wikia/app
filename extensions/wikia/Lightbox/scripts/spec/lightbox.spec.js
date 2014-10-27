describe('Lightbox', function () {
	'use strict';

	var windowMock = {},
		historyApi = modules['wikia.history'](windowMock);

	it('has access to the history.js, a module it depends on', function () {
		expect(historyApi).toBeDefined();
		expect(typeof historyApi).toBe('object');
	});
	it('history.js has replaceState defined, a function it depends on', function () {
		expect(historyApi.replaceState).toBeDefined();
		expect(typeof historyApi.replaceState).toBe('function');
	});
});
