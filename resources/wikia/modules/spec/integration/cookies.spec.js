describe("Cookies", function () {
	'use strict';

	// mock cookies
	document.cookie = 'foo=bar';
	document.cookie = 'wikia_beacon_id=mCizgIam7U';

	var windowMock = {
		document: document
	},
		cookies = modules['wikia.cookies'](windowMock);

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

		expect(document.cookie).toContain('foo=bar');
		expect(document.cookie).toContain('wikia_beacon_id=mCizgIam7U');
		expect(document.cookie).toContain('test_cookie=test_value');
		expect(document.cookie).toContain('new_cookie=new_value');
		expect(document.cookie).toContain(';');
	});

	it('sets domain for a cookie', function(){
		expect(cookies.set('test_cookie', 1, {
			domain: 'test.domain'
		})).toBe('test_cookie=1; domain=test.domain');
	});

	it('sets path for a cookie', function(){
		expect(cookies.set('test_cookie', 1, {
			path: '/test/path'
		})).toBe('test_cookie=1; path=/test/path');
	});
});