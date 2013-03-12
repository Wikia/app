/*global describe, it, runs, waitsFor, expect, require, document*/
describe("throbber module", function () {
	'use strict';

	var throbber = modules.throbber();

	it('should be defined', function(){
		expect(throbber).toBeDefined();

		expect(typeof throbber.show).toBe('function');
		expect(typeof throbber.hide).toBe('function');
		expect(typeof throbber.remove).toBe('function');
	});

	it('should show/hide/remove throbber', function(){
		var body = getBody();

		expect(body.children.length).toBe(0);

		throbber.show(body);

		expect(body.children.length).toBe(1);

		throbber.remove(body);

		expect(body.children.length).toBe(0);

		throbber.show(body);

		expect(body.children.length).toBe(1);
		expect(body.children[0].className).toBe('wkMblThrobber');

		throbber.remove(body);
	});

	it('should throw', function(){
		expect(function(){
			throbber.show();
		}).toThrow();

		expect(function(){
			throbber.show(document.body);
		}).not.toThrow();

		throbber.remove(document.body);
	});

	it('should accept options', function(){

		var body = getBody();

		throbber.show(body, {
			center: true
		});

		expect(body.children[0].className).toMatch('cntr');

		throbber.remove(body);

		throbber.show(body, {
			size: '50px'
		});

		expect(body.children[0].children[0].style.width).toMatch('50px');
		expect(body.children[0].children[0].style.height).toMatch('50px');

		throbber.remove(body);

		throbber.show(body, {
			size: '10px'
		});

		expect(body.children[0].children[0].style.width).toMatch('10px');
		expect(body.children[0].children[0].style.height).toMatch('10px');

		throbber.remove(body);

		throbber.show(body, {
			center: true,
			size: '20px'
		});

		expect(body.children[0].className).toMatch('cntr');
		expect(body.children[0].children[0].style.width).toMatch('20px');
		expect(body.children[0].children[0].style.height).toMatch('20px');

		throbber.remove(body);
	});
});
