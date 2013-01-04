/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/Wikia.utils.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.api.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/mw.js
 @test-require-asset /resources/wikia/modules/ajax.js
 @test-require-asset /resources/wikia/modules/nirvana.js
 @test-require-asset /resources/wikia/modules/loader.js
 */

/*global describe, require*/

describe("Loader Module", function () {
	'use strict';

	var async = new AsyncSpec(this);

	window.wgCdnRootUrl = '';
	window.wgAssetsManagerQuery = "/__am/%4$d/%1$s/%3$s/%2$s";
	window.wgStyleVersion = ~~(Math.random()*99999);

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

	async.it('support deferred', function(done) {
		require(['loader'], function(loader) {

			expect(typeof loader('some/path').then).toBe('function');
			expect(typeof loader('some/path').done).toBe('function');
			expect(typeof loader('some/path').fail).toBe('function');

			done();
		});
	});

	async.it('should fire on fail callback', function(done) {
		require(['loader'], function(loader) {

			var path = 'some/path/asd',
				someOtherPath = 'and/thi/thiss.js';

			loader(path, someOtherPath)

			.done(function(){
				//if this runs there is something wrong
				//email someone!!! :)
				expect(false).toBe(true);
				done();
			})

			.fail(function(resources){

				expect(resources).toBeDefined();
				expect(resources.value.error).toEqual(loader.NOT_LOADED);
				expect(resources.value.resources[1].type).toEqual('js');

				done();
			})
		});
	});
});
