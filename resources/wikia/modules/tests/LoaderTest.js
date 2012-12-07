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
});
