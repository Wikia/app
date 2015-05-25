/*global describe, it, expect, modules, spyOn*/
describe('AdLogicPageViewCounter', function () {
	'use strict';

	var cacheKey = 'adEngine_pageViewCounter',
		dateNow = new Date(2000, 10, 29, 21, 59, 13, 456),         // 2000-11-29 21:59:13.456 ("now")
		since0 = dateNow.getTime(),
		ttl0 = 24 * 3600 * 1000,
		since1 = new Date(2000, 10, 29, 11, 45, 7, 231).getTime(), // 2000-11-29 11:45:07.456 (earlier "today")
		ttl1 = since1 + ttl0 - dateNow.getTime(),
		since2 = new Date(1999, 10, 29, 11, 45, 7, 231).getTime(), // 1999-11-29 11:45:07.456 ("past")
		since3 = new Date(2003, 10, 29, 11, 45, 7, 231).getTime(); // 2003-11-29 11:45:07.456 ("future")

	function testPvCounter(name, cachedVal, expectedPv, expectedSince, expectedTtl) {
		it('increment ' + name, function () {
			var cacheMock = {
					get: function (id) {
						if (id === cacheKey) {
							return cachedVal;
						}
					},
					set: function () {
						return;
					}
				},
				windowMock = { wgNow: dateNow},
				pvCounter;

			pvCounter = modules['ext.wikia.adEngine.adLogicPageViewCounter'](cacheMock, windowMock);

			spyOn(cacheMock, 'set');
			pvCounter.increment();
			expect(pvCounter.get()).toBe(expectedPv);

			expect(cacheMock.set).toHaveBeenCalled();
			expect(cacheMock.set.calls.first().args[1]).toEqual({pvs: expectedPv, since: expectedSince});
			expect(cacheMock.set.calls.first().args[2]).toBe(expectedTtl);
			expect(cacheMock.set.calls.first().args[3].getTime()).toBe(dateNow.getTime());
		});
	}

	testPvCounter('clear cache', undefined, 1, since0, ttl0);
	testPvCounter('hot cache', {pvs: 33, since: since1}, 34, since1, ttl1);
	testPvCounter('clear cache, check ttl', undefined, 1, since0, ttl0);
	testPvCounter('hot cache, check ttl', {pvs: 14, since: since1}, 15, since1, ttl1);
	testPvCounter('safe-check for date in the past', {pvs: 14, since: since2}, 1, since0, ttl0);
	testPvCounter('safe-check for date in the future', {pvs: 14, since: since3}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted "since" val in cache 1', {pvs: 14, since: 'aaa'}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted "since" val in cache 2', {pvs: 14, since: undefined}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted "since" val in cache 3', {pvs: 14, since: {a: true}}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted "pvs" val in cache 1', {pvs: 'aaa', since: since1}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted "pvs" val in cache 2', {pvs: undefined, since: since1}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted "pvs" val in cache 3', {pvs: {a: true}, since: since1}, 1, since0, ttl0);
	testPvCounter('safe-check for corrupted val in cache 1', 'aaa', 1, since0, ttl0);
	testPvCounter('safe-check for corrupted val in cache 2', {a: true}, 1, since0, ttl0);
});
