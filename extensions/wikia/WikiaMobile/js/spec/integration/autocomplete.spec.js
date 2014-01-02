/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Autocomplete module", function () {
	'use strict';

	var auto = modules.autocomplete(jQuery);

	it('should be defined', function(){
		expect(auto).toBeDefined();
		expect(typeof auto).toBe('function');
	});

	it('should throw exception', function(){

		var div =  document.createElement('div');

		div.innerHTML = '<input id="input"><div id="list"></div>';

		expect(function(){
			auto();
		}).toThrow();

		expect(function(){
			auto({});
		}).toThrow();

		expect(function(){
			auto({
				list: ''
			});
		}).toThrow();

		expect(function(){
			auto({
				input: div.getElementsByTagName('input')[0]
			});
		}).toThrow();

		expect(function(){
			auto({
				input: div.getElementsByTagName('input')[0],
				list: ''
			});
		}).toThrow();

		expect(function(){
			auto({
				input: div.getElementsByTagName('input')
			});
		}).toThrow();

		expect(function(){
			auto({
				input: div.getElementsByTagName('input')[0],
				list: div.getElementsByTagName('div')
			});
		}).toThrow();

		expect(function(){
			auto({
				input: div.getElementsByTagName('input')[0],
				list: div.getElementsByTagName('div'),
				url: ''
			});
		}).toThrow();
	});

	it('should init itself', function(){
		var div =  document.createElement('div');
		div.innerHTML = '<input id="input"><div id="list"></div><div id="clear"></div> ';

		var input = div.getElementsByTagName('input')[0],
			list = div.getElementsByTagName('div')[0],
			clear = div.getElementsByTagName('div')[1];

		expect(function(){
			auto({
				input: input,
				list: list,
				url: 'wikia.php',
				clear: clear
			});
		}).not.toThrow();

		input.value = 'value';
		list.innerHTML = 'list';
		clear.className = '';

		expect(input.value).toEqual('value');

		fireEvent('click', clear);

		expect(input.value).toEqual('');
		expect(list.innerHTML).toEqual('');
		expect(clear.className).toEqual('hide');
	});
});
