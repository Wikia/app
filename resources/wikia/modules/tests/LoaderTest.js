/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/mw.js
 @test-require-asset /resources/wikia/modules/nirvana.js
 @test-require-asset /resources/wikia/modules/loader.js
 */

/*global describe, require*/

describe("Loader Module", function () {
	'use strict';

	var async = new AsyncSpec(this);

	async.it('registers itself', function(done) {
		require(['loader'], function(loader) {
			expect(typeof loader).toBe('function');
			expect(typeof loader.processScript).toBe('function');
			expect(typeof loader.processStyle).toBe('function');

			done();
		});
	});

	async.it('gives meaningful types', function(done) {
		require(['loader'], function(loader) {
			expect(loader.JS).toEqual('js');
			expect(loader.AM_GROUPS).toEqual('amgroups');
			expect(loader.CSS).toEqual('css');
			expect(loader.SCSS).toEqual('scss');
			expect(loader.MULTI).toEqual('multi');
			expect(loader.LIBRARY).toEqual('library');

			done();
		});
	});

	async.it('gives meaningful errors', function(done) {
		require(['loader'], function(loader) {
			expect(loader.NOT_LOADED).toEqual('Some of resources not loaded');
			expect(loader.CORRUPT_FORMAT).toEqual('Wrong object format');

			done();
		});
	});

	async.it('style should be processed', function(done) {
		document.body.innerHTML = '<div class=test></div>';

		require(['loader'], function(loader) {
			var div = document.getElementsByClassName('test')[0];

			expect(div.style.width).toBe('');
			loader.processStyle('.test{width:100px}');
			expect(getComputedStyle(div).width).toBe('100px');

			done();
		});
	});

	async.it('scripts should be processed', function(done) {
		require(['loader'], function(loader) {
			loader.processScript('window.run = true');
			expect(window.run).toBe(true);

			done();
		});
	});
});
