/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Ads module", function () {
	'use strict';

	var domwriter = {
			addEventListener: function(){},
			removeEventListener: function(){}
		},
		cookies = {},
		track = {},
		log = {},
		parentNode = {
			removeChild: function(){}
		},
		elements = {},
		Element = function(){
			this.parentNode = parentNode;
			this.className = '';
		},
		dartHelper = function(){},
		window = {
			document: {
				getElementById: function(name){
					return elements[name] || (elements[name] = new Element());
				}
			},
			Features: {}
		},
		utils = function(func){
			func();
		},
		ads = modules.ads(domwriter, cookies, track, log, window, utils, dartHelper);

	it("is defined as a module", function () {
		expect(ads).toBeDefined();
	});

	it("has a public API", function () {
		expect(typeof ads.setupSlot).toEqual('function');
		expect(typeof ads.init).toEqual('function');
		expect(typeof ads.fix).toEqual('function');
		expect(typeof ads.unfix).toEqual('function');
		expect(typeof ads.getAdType).toEqual('function');
	});

	it("can initialize a footer Ad", function () {
		ads.init('footer');

		expect(elements['wkAdPlc'].className).toEqual('footer');
		expect(ads.getAdType()).toEqual('footer');
	});

	it("can initialize a interstital Ad", function(){
		ads.init('interstitial');

		expect(elements['wkAdPlc'].className).toEqual('interstitial');
		expect(ads.getAdType()).toEqual('interstitial');
	});

	it("will not do anything with wrong Ad type passed", function(){
		ads.init('TEST');

		expect(elements['wkAdPlc'].className).not.toEqual('TEST');
		expect(ads.getAdType()).not.toEqual('TEST');
	});
});
