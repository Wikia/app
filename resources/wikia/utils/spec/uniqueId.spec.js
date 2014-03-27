/*global describe, it, runs, waitsFor, expect, require, document*/
describe("uniqueId", function () {
	'use strict';

	var uniqueId = modules['wikia.uniqueId']();

	it('returns a string', function() {
		expect(typeof uniqueId()).toBe('string');
		expect(uniqueId().length).toBe(13);
	});

	it('returns different values each time', function() {
		expect(uniqueId() !== uniqueId()).toBe(true);
	});

	it('handles prefix', function() {
		var res = uniqueId('foo');

		expect(typeof res).toBe('string');
		expect(res.length).toBe(16);
		expect(/^foo/.test(res)).toBe(true);
	});

	it('handles more_prefix parameter', function() {
		var res = uniqueId('foo', true);

		expect(typeof res).toBe('string');
		expect(/^foo/.test(res)).toBe(true);
		expect(/\./.test(res)).toBe(true);
	});
});
