/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Pager module", function () {
	'use strict';
	var p = modules.pager();

	it('should be defined', function(){
		expect(p).toBeDefined();
		expect(typeof p).toBe('function');
	});

	it('should throw', function(done){
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
	});

	it('should return helper functions', function(){

		getBody().innerHTML = '<div></div>';

		var pager = p({
			container: document.getElementsByTagName('div')[0],
			pages: ['1','2']
		});

		expect(typeof pager.prev).toBe('function');
		expect(typeof pager.next).toBe('function');
		expect(typeof pager.reset).toBe('function');
		expect(typeof pager.cleanup).toBe('function');
		expect(typeof pager.getCurrent).toBe('function');
	});

	it('should return current page', function(){

		getBody().innerHTML = '<div></div>';

		var pager = p({
			container: document.getElementsByTagName('div')[0],
			pages: ['<div>one</div>','<div>two</div>', '<div>three</div>']
		});

		expect(pager.getCurrent().innerHTML).toBe('one');
	});


});