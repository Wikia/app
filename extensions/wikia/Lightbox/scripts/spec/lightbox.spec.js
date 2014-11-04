describe('Lightbox', function () {
	'use strict';

	var windowMock = {},
		historyApi = modules['wikia.history'](windowMock);

	it('has access to history.js, a module Lightbox depends on', function () {
		expect(historyApi).toBeDefined();
		expect(typeof historyApi).toBe('object');
	});
	it('history.js has replaceState defined, a function Lightbox depends on', function () {
		expect(historyApi.replaceState).toBeDefined();
		expect(typeof historyApi.replaceState).toBe('function');
	});
});
