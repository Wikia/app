/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/Wikia.utils.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.api.js
 @test-require-asset /resources/wikia/modules/loader.js
 */

/*global describe, require, spyOn*/

describe("Loader Module", function () {
	'use strict';

	var async = new AsyncSpec(this),
		windowMock = {
			document: window.document
		},
		mwMock = undefined,
		nirvanaMock = {},
		loader = define.getModule(windowMock, mwMock, nirvanaMock);

	window.wgCdnRootUrl = '';
	window.wgAssetsManagerQuery = "/__am/%4$d/%1$s/%3$s/%2$s";
	window.wgStyleVersion = ~~(Math.random()*99999);

	it('registers itself', function() {
		expect(typeof loader).toBe('function');
		expect(typeof loader.processScript).toBe('function');
		expect(typeof loader.processStyle).toBe('function');
	});

	it('gives meaningful types', function() {
		expect(loader.JS).toEqual('js');
		expect(loader.AM_GROUPS).toEqual('amgroups');
		expect(loader.CSS).toEqual('css');
		expect(loader.SCSS).toEqual('scss');
		expect(loader.MULTI).toEqual('multi');
		expect(loader.LIBRARY).toEqual('library');
	});

	it('gives meaningful errors', function() {
		expect(loader.NOT_LOADED).toEqual('Some of resources not loaded');
		expect(loader.CORRUPT_FORMAT).toEqual('Wrong object format');
	});

	it('style should be processed', function() {
		document.body.innerHTML = '<div class=test></div>';

		var div = document.getElementsByClassName('test')[0];

		expect(div.style.width).toBe('');
		loader.processStyle('.test{width:100px}');
		expect(getComputedStyle(div).width).toBe('100px');
	});

	it('scripts should be processed', function() {
		loader.processScript('window.run = true');
		expect(window.run).toBe(true);
	});

	it('support deferred', function() {
			expect(typeof loader('some/path').then).toBe('function');
			expect(typeof loader('some/path').done).toBe('function');
			expect(typeof loader('some/path').fail).toBe('function');
	});

	async.it('should fire on fail callback', function(done) {
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
		});
	});

	async.it('RL module is properly loaded', function(done) {
		var mwMock = {
			loader: {
				use: function(use) {
					expect(JSON.stringify(use)).toEqual('["jquery.mustache"]');

					// mock and return deferred object
					return {
						done: function(cb) {
							cb();

							return {
								fail:function() {}
							};
						}
					};
				}
			}
		},
		loader = define.getModule(windowMock, mwMock, nirvanaMock);

		// check calls to this function
		spyOn(mwMock.loader, 'use').andCallThrough();

		loader({
			type: loader.LIBRARY,
			resources: ['mustache']
		}).
		done(function() {
			expect(mwMock.loader.use).toHaveBeenCalled();
			done();
		});
	});

	async.it('Facebook library is properly initialized when lazy loaded', function(done) {
		var windowMock = {
			document: window.document,
			onFBloaded:  function() {}
		},
		loader = define.getModule(windowMock, mwMock, nirvanaMock);

		// check calls to this function
		spyOn(windowMock, 'onFBloaded').andCallThrough();

		loader({
			type: loader.LIBRARY,
			resources: ['facebook']
		}).
		done(function() {
			expect(windowMock.onFBloaded).toHaveBeenCalled();
			done();
		});
	});
});
