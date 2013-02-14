/*
 @test-framework Jasmine
\@test-require-asset resources/wikia/libraries/define.mock.js
 @test-require-asset resources/jquery/jquery-1.8.2.js
 @test-require-asset extensions/wikia/JSMessages/js/JSMessages.js
 */

/*global describe, it*/

describe("JSMessages", function () {
	'use strict';

	var nirvanaMock = {},
		msg = define.getModule(nirvanaMock);

	window.wgMessages = {
		foo: 'bar'
	}

	it('registers AMD module', function() {
		expect(typeof msg).toBe('function');
		expect(typeof msg.get).toBe('function');
		expect(typeof msg.getForContent).toBe('function');
	});

	it('has jQuery API', function() {
		expect(typeof $.msg).toBe('function');
		expect(typeof $.getMessages).toBe('function');
		expect(typeof $.getMessagesForContent).toBe('function');
	});

	it('message is returned', function() {
		expect(msg('foo')).toBe('bar');
	});

	it('default value is returned for unknown message', function() {
		expect(msg('unknown')).toBe('unknown');
	});
});
