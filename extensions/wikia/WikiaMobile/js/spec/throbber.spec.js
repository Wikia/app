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
		var parentElement = {
				removeChild: function(){}
			},
			throb = undefined,
			element = {
				getElementsByClassName: function(){
					if(throb) {
						return [throb];
					}else{
						throb = {
							style: {},
							parentElement: parentElement
						};
						return [];
					}
				},
				insertAdjacentHTML: function(where, html){
					this.html = html;
				}
			};

		throbber.show(element);

		expect(element.html).toBe('<div class="wkMblThrobber"><span ></span></div>');

		spyOn(parentElement, 'removeChild');

		throbber.remove(element);

		expect(parentElement.removeChild).toHaveBeenCalled();

		throbber.show(element);

		expect(throb.style.display).toBe('block');
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
		var parentElement = {
				removeChild: function(){
					element.html = '';
					throb = undefined;
				}
			},
			throb = undefined,
			element = {
				getElementsByClassName: function(){
					if(throb) {
						return [throb];
					}else{
						throb = {
							style: {},
							parentElement: parentElement
						};
						return [];
					}
				},
				insertAdjacentHTML: function(where, html){
					this.html = html;
				}
			};

		throbber.show(element, {
			center: true
		});

		expect(element.html).toMatch('cntr');

		throbber.remove(element);

		throbber.show(element, {
			size: '50px'
		});

		expect(element.html).toMatch('height:50px');
		expect(element.html).toMatch('width:50px');

		throbber.remove(element);

		throbber.show(element, {
			size: '10px'
		});

		expect(element.html).toMatch('height:10px');
		expect(element.html).toMatch('width:10px');

		throbber.remove(element);

		throbber.show(element, {
			center: true,
			size: '20px'
		});

		expect(element.html).toMatch('cntr');
		expect(element.html).toMatch('height:20px');
		expect(element.html).toMatch('width:20px');

		throbber.remove(element);
	});
});
