/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Loader module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	async.it('should be defined', function(done){
		require(['loader'], function(loader){
			expect(loader).toBeDefined();

			expect(typeof loader.show).toBe('function');
			expect(typeof loader.hide).toBe('function');
			expect(typeof loader.remove).toBe('function');

			done();
		});
	});

	async.it('should show/hide/remove loader', function(done){

		var body = document.body;

		require(['loader'], function(loader){
			expect(body.children.length).toBe(0);

			loader.show(body);

			expect(body.children.length).toBe(1);

			loader.remove(body);

			expect(body.children.length).toBe(0);

			loader.show(body);

			expect(body.children.length).toBe(1);
			expect(body.children[0].className).toBe('wkMblLdr');

			loader.remove(body);

			done();
		});
	});

	async.it('should throw', function(done){
		require(['loader'], function(loader){
			expect(function(){
				loader.show();
			}).toThrow();

			expect(function(){
				loader.show(document.body);
			}).not.toThrow();

			loader.remove(document.body);

			done();
		});
	});

	async.it('should accept options', function(done){

		var body = document.body;

		require(['loader'], function(loader){
			loader.show(body, {
				center: true
			});

			expect(body.children[0].className).toMatch('cntr');

			loader.remove(body);

			loader.show(body, {
				size: '50px'
			});

			expect(body.children[0].children[0].style.width).toMatch('50px');
			expect(body.children[0].children[0].style.height).toMatch('50px');

			loader.remove(body);

			loader.show(body, {
				size: '10px'
			});

			expect(body.children[0].children[0].style.width).toMatch('10px');
			expect(body.children[0].children[0].style.height).toMatch('10px');

			loader.remove(body);

			loader.show(body, {
				center: true,
				size: '20px'
			});

			expect(body.children[0].className).toMatch('cntr');
			expect(body.children[0].children[0].style.width).toMatch('20px');
			expect(body.children[0].children[0].style.height).toMatch('20px');

			loader.remove(body);

			done();
		});
	});
});