/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/pager.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Pager module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	async.it('should be defined', function(done){
		require(['pager'], function(p){
			expect(p).toBeDefined();
			expect(typeof p).toBe('function');

			done();
		});
	});

	async.it('should throw', function(done){
		require(['pager'], function(p){
			expect(function(){
				p();
			}).toThrow();

			expect(function(){
				p({
					container: ''
				});
			}).toThrow();

			expect(function(){
				p({
					pages: ''
				});
			}).toThrow();

			expect(function(){
				p({
					container: '',
					pages: ''
				});
			}).toThrow();

			done();
		});
	});

	async.it('should return helper functions', function(done){

		document.body.innerHTML = '<div></div>';

		require(['pager'], function(p){
			var pager = p({
				container: document.getElementsByTagName('div')[0],
				pages: ['1','2']
			});

			expect(typeof pager.prev).toBe('function');
			expect(typeof pager.next).toBe('function');
			expect(typeof pager.reset).toBe('function');
			expect(typeof pager.cleanup).toBe('function');
			expect(typeof pager.getCurrent).toBe('function');

			done();
		});
	});

	async.it('should return current page', function(done){

		document.body.innerHTML = '<div></div>';

		require(['pager'], function(p){
			var pager = p({
				container: document.getElementsByTagName('div')[0],
				pages: ['<div>one</div>','<div>two</div>', '<div>three</div>']
			});

			expect(pager.getCurrent().innerHTML).toBe('one');

			done();
		});
	});


});