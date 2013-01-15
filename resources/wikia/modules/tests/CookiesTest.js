/*
 * @test-framework QUnit
 * @test-require-asset resources/wikia/modules/cookies.js
 */

module('Cookies');

test('cookies', function() {
	var testCookieName = 'foobar';
	var testCookieValue = 'baz';
	Wikia.Cookies.set(testCookieName, testCookieValue);
	equal(Wikia.Cookies.get(testCookieName), testCookieValue, 'cookie has string');
	Wikia.Cookies.set(testCookieName, null);
	ok(!Wikia.Cookies.get(testCookieName), 'cookie not set');
});
