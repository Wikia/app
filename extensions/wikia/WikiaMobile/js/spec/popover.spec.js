/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Popover module", function () {
	'use strict';

	var pop = modules.popover({
		show: function(){},
		hide: function(){}
	});

	it('should be defined as module', function(){
		expect(pop).toBeDefined();
		expect(typeof pop).toBe('function');
	});

	it('should throw exception', function(){
		getBody().innerHTML = '<div id="popover"></div>';

		expect(function(){
			pop();
		}).toThrow();

		expect(function(){
			pop({
				on: document.getElementById('asd')
			});
		}).toThrow();
	});

	it('should set position correctly', function(){
		getBody().innerHTML = '<div id="popover"></div>';

		var container = document.getElementById('popover'),
			p = pop({
				on: container,
				create: 'TESTTHIS',
				position: 'top'
			});

		fireEvent('click', container);

		expect(container.className).toMatch('top');

		getBody().innerHTML = '<div id="popover"></div>';
		container = document.getElementById('popover');

		p = pop({
			on: container,
			create: 'TESTTHIS',
			position: 'left'
		});

		fireEvent('click', container);

		expect(container.className).toMatch('left');

		getBody().innerHTML = '<div id="popover"></div>';
		container = document.getElementById('popover');

		p = pop({
			on: container,
			create: 'TESTTHIS',
			position: 'right'
		});

		fireEvent('click', container);

		expect(container.className).toMatch('right');

		getBody().innerHTML = '<div id="popover"></div>';
		container = document.getElementById('popover');

		p = pop({
			on: container,
			create: 'TESTTHIS',
			position: 'bottom'
		});

		fireEvent('click', container);

		expect(container.className).toMatch('bottom');

		getBody().innerHTML = '<div id="popover"></div>';
		container = document.getElementById('popover');

		var p = pop({
			on: container,
			create: 'TESTTHIS'
		});

		fireEvent('click', container);

		expect(container.className).toMatch('bottom');
	});

	it('should open/close popover', function(){
		getBody().innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		var p = pop({
			on: container
		});

		fireEvent('click', container);

		expect(container.innerHTML).toBe('<div class="ppOvr" style="top: 13px; "></div>');

		p.open();

		expect(container.className).toMatch('on');

		p.close();

		expect(container.className).not.toMatch('on');
	});

	it('should set a text of popover', function(){
		getBody().innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		pop({
			on: container,
			create: 'TESTTHIS'
		});

		fireEvent('click', container);

		expect(container.innerText).toBe('TESTTHIS');
	});

	it('should set a text of popover with a function', function(){
		getBody().innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		pop({
			on: container,
			create: function(cnt){
				cnt.innerText = 'TESTTHIS';
			}
		});

		fireEvent('click', container);

		expect(container.innerText).toBe('TESTTHIS');
	});

	it('should change content', function(){
		getBody().innerHTML = '<div id="popover"></div>';
		var container = document.getElementById('popover');

		var p = pop({
			on: container,
			create: 'TESTTHIS'
		});

		fireEvent('click', container);

		expect(container.innerText).toBe('TESTTHIS');

		p.changeContent(function(cnt){
				cnt.innerText = 'TEXTTHISNUMBET2';
		});

		expect(container.innerText).toBe('TEXTTHISNUMBET2');
	});

	it('should run onopen callback', function(){
		getBody().innerHTML = '<div id="popover"></div>';

		var container = document.getElementById('popover'),
			options = {
				on: container,
				create: 'TESTTHIS',
				open: function(){}
			};

		spyOn(options, 'open');

		pop(options);

		fireEvent('click', container);

		expect(options.open).toHaveBeenCalled();
	});

	it('should run onclose callback', function(){
		getBody().innerHTML = '<div id="popover"></div>';

		var container = document.getElementById('popover'),
			options = {
				on: container,
				create: 'TESTTHIS',
				close: function(){}
			};

		spyOn(options, 'close');

		pop(options);

		fireEvent('click', container);
		fireEvent('click', container);

		expect(options.close).toHaveBeenCalled();
	});
});
