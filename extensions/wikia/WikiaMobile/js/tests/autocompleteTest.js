/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/autocomplete.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Autocomplete module", function () {
	'use strict';

	var async = new AsyncSpec(this);

	function fire(event, element){
		var evt = document.createEvent("HTMLEvents");
		evt.initEvent(event, true, true); // event type,bubbling,cancelable
		return !element.dispatchEvent(evt);
	}

	async.it('should be defined', function(done){
		require(['autocomplete'], function(autocomplete){
			expect(autocomplete).toBeDefined();
			expect(typeof autocomplete).toBe('function');
			done();
		});
	});

	async.it('should throw exception', function(done){
		document.body.innerHTML = '<input id="input"><div id="list"></div>';

		require(['autocomplete'], function(autocomplete){
			expect(function(){
				autocomplete();
			}).toThrow();

			expect(function(){
				autocomplete({});
			}).toThrow();

			expect(function(){
				autocomplete({
					list: ''
				});
			}).toThrow();

			expect(function(){
				autocomplete({
					input: document.getElementById('input')
				});
			}).toThrow();

			expect(function(){
				autocomplete({
					input: document.getElementById('input'),
					list: ''
				});
			}).toThrow();

			expect(function(){
				autocomplete({
					input: document.getElementsByTagName('input')
				});
			}).toThrow();

			expect(function(){
				autocomplete({
					input: document.getElementById('input'),
					list: document.getElementsByTagName('div')
				});
			}).toThrow();

			expect(function(){
				autocomplete({
					input: document.getElementById('input'),
					list: document.getElementsByTagName('div'),
					url: ''
				});
			}).toThrow();

			done();
		});
	});

	async.it('should init itself', function(done){
		document.body.innerHTML = '<input id="input"><div id="list"></div><div id="clear"></div> ';

		var input = document.getElementById('input'),
			list = document.getElementById('list'),
			clear = document.getElementById('clear');

		require(['autocomplete'], function(autocomplete){

			expect(function(){
				autocomplete({
					input: input,
					list: document.getElementById('list'),
					url: 'wikia.php',
					clear: document.getElementById('clear')
				});
			}).not.toThrow();

			input.value = 'value';
			list.innerHTML = 'list';
			clear.className = '';

			expect(input.value).toEqual('value');

			fire('click', clear);

			expect(input.value).toEqual('');
			expect(list.innerHTML).toEqual('');
			expect(clear.className).toEqual('clsIco hide');

			done();
		});

	});

});
