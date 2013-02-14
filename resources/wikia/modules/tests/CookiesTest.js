/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/cookies.js
 */

describe("Cookies", function () {
	'use strict';

	// mock cookies
	document.cookie = 'wikia_beacon_id=mCizgIam7U; foo=bar';

	var cookies = define.getModule();

	it('registers AMD module', function() {
		expect(typeof cookies).toBe('object');

		expect(typeof cookies.get).toBe('function');
		expect(typeof cookies.set).toBe('function');
	});

	it('gets cookie value', function() {
		expect(cookies.get('wikia_beacon_id')).toBe('mCizgIam7U');
		// expect(cookies.get('foo')).toBe('bar'); // FIXME
		expect(cookies.get('notExistingCookie')).toBe(null);
	});

	// TODO
	//it('sets cookie value', function() {});
});
