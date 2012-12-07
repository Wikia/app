/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/cache.js
 */

/*global describe, it, runs, waitsFor, expect, require*/
describe("Cache", function () {
	'use strict';

	var async = new AsyncSpec(this);

	async.it('Set then get', function(done) {
		require(['cache'], function(cache) {
			cache.set('a1', 'some-value');
			expect(cache.get('a1')).toBe('some-value');

			cache.set('a2', {'x': 'y', '123': 456});
			expect(cache.get('a2').x).toBe('y');
			expect(cache.get('a2')['123']).toBe(456);

			cache.set('a3', false);
			expect(cache.get('a3')).toBe(false);

			cache.set('a4', null);
			expect(cache.get('a4')).toBe(null);

			cache.set('a5', 0);
			expect(cache.get('a5')).toBe(0);

			cache.set('a6', '');
			expect(cache.get('a6')).toBe('');

			cache.set('a7', {});
			expect(JSON.stringify(cache.get('a7'))).toBe('{}');

			cache.set('a8', []);
			expect(JSON.stringify(cache.get('a8'))).toBe('[]');

			done();
		});
	});

	async.it('Gets from localStoragey', function(done) {
		require(['cache'], function(cache) {
			localStorage.setItem('wkch_val_b1', JSON.stringify('some-value'));
			expect(cache.get('b1')).toBe('some-value');

			localStorage.setItem('wkch_val_b2', JSON.stringify({'x': 'y', '123': 456}));
			expect(cache.get('b2').x).toBe('y');
			expect(cache.get('b2')['123']).toBe(456);

			localStorage.setItem('wkch_val_b3', JSON.stringify(false));
			expect(cache.get('b3')).toBe(false);

			localStorage.setItem('wkch_val_b4', JSON.stringify(null));
			expect(cache.get('b4')).toBe(null);

			localStorage.setItem('wkch_val_b5', JSON.stringify(0));
			expect(cache.get('b5')).toBe(0);

			localStorage.setItem('wkch_val_b6', JSON.stringify(''));
			expect(cache.get('b6')).toBe('');

			localStorage.setItem('wkch_val_b7', JSON.stringify({}));
			expect(JSON.stringify(cache.get('b7'))).toBe('{}');

			localStorage.setItem('wkch_val_b8', JSON.stringify([]));
			expect(JSON.stringify(cache.get('b8'))).toBe('[]');

			done();
		});
	});

	async.it('Sets to localStorage', function(done) {
		require(['cache'], function(cache) {
			cache.set('c1', 'some-value');
			expect(localStorage.getItem('wkch_val_c1')).toBe(JSON.stringify('some-value'));

			cache.set('c2', {'x': 'y', '123': 456});
			expect(localStorage.getItem('wkch_val_c2')).toBe(JSON.stringify({'x': 'y', '123': 456}));

			cache.set('c3', false);
			expect(localStorage.getItem('wkch_val_c3')).toBe(JSON.stringify(false));

			cache.set('c4', null);
			expect(localStorage.getItem('wkch_val_c4')).toBe(JSON.stringify(null));

			cache.set('c5', 0);
			expect(localStorage.getItem('wkch_val_c5')).toBe(JSON.stringify(0));

			cache.set('c6', '');
			expect(localStorage.getItem('wkch_val_c6')).toBe(JSON.stringify(''));

			cache.set('c7', {});
			expect(localStorage.getItem('wkch_val_c7')).toBe(JSON.stringify({}));

			cache.set('c8', []);
			expect(localStorage.getItem('wkch_val_c8')).toBe(JSON.stringify([]));

			done();
		});
	});

	async.it('Get from localStorage then set', function(done) {
		require(['cache'], function(cache) {
			localStorage.setItem('wkch_val_d', JSON.stringify('some-value'));
			expect(cache.get('d')).toBe('some-value');

			cache.set('d', 'new-value');
			expect(cache.get('d')).toBe('new-value');
			expect(localStorage.getItem('wkch_val_d')).toBe(JSON.stringify('new-value'));

			done();
		});
	});

	async.it('Get returns the value that was set last', function(done) {
		require(['cache'], function(cache) {
			cache.set('e', 'some-value');
			cache.set('e', 'other-value');
			expect(cache.get('e')).toBe('other-value');

			done();
		});
	});

	async.it('Value expires after given TTL', function(done) {
		require(['cache'], function(cache) {
			var fakeNowTimestamp = 8723687632
				, fakeNow = {getTime: function() {return fakeNowTimestamp;}}
				, anHourLater = {getTime: function() {return fakeNowTimestamp + 3600 * 1000;}}
				, twoHoursLater = {getTime: function() {return fakeNowTimestamp + 2 * 3600 * 1000;}};

			cache.set('f', 'some-value', 3601, fakeNow);
			expect(cache.get('f', anHourLater)).toBe('some-value');
			expect(cache.get('f', twoHoursLater)).toBe(null);

			done();
		});
	});
});
