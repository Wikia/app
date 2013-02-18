/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/cookies.js
 */

describe("Cookies", function () {
	'use strict';

	// mock cookies
	document.cookie = 'foo=bar';
	document.cookie = 'wikia_beacon_id=mCizgIam7U';

	var cookies = define.getModule();

	it('registers AMD module', function() {
		expect(typeof cookies).toBe('object');

		expect(typeof cookies.get).toBe('function');
		expect(typeof cookies.set).toBe('function');
	});

	it('gets cookie value', function() {
		expect(cookies.get('wikia_beacon_id')).toBe('mCizgIam7U');
		expect(cookies.get('foo')).toBe('bar');
		expect(cookies.get('notExistingCookie')).toBe(null);
	});

	//it('sets cookie value', function() {});
	it('sets cookie value', function() {
		expect(cookies.set('test_cookie', 'test_value')).toBe('test_cookie=test_value');
		expect(cookies.set('new_cookie', 'new_value')).toBe('new_cookie=new_value');
		expect(cookies.get('test_cookie')).toBe('test_value');
		expect(cookies.get('new_cookie')).toBe('new_value');
		expect(document.cookie).toBe('foo=bar; wikia_beacon_id=mCizgIam7U; test_cookie=test_value; new_cookie=new_value')
	})
});
