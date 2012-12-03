/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/uniqueId.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/

describe("uniqueId", function () {
	'use strict';

	var async = new AsyncSpec(this);

	async.it('returns a string', function(done) {
		require(['uniqueId'], function(uniqueId) {
			var res = uniqueId();

			expect(typeof res).toBe('string');
			expect(res.length).toBe(13);

			done();
		});
	});

	async.it('returns different values each time', function(done) {
		require(['uniqueId'], function(uniqueId) {
			var res = uniqueId();

			expect(res !== uniqueId()).toBe(true);

			done();
		});
	});

	async.it('handles prefix', function(done) {
		require(['uniqueId'], function(uniqueId) {
			var res = uniqueId('foo');

			expect(typeof res).toBe('string');
			expect(res.length).toBe(16);
			expect(/^foo/.test(res)).toBe(true);

			done();
		});
	});

	async.it('handles more_prefix parameter', function(done) {
		require(['uniqueId'], function(uniqueId) {
			var res = uniqueId('foo', true);

			expect(typeof res).toBe('string');
			expect(/^foo/.test(res)).toBe(true);
			expect(/\./.test(res)).toBe(true);

			done();
		});
	});
});
