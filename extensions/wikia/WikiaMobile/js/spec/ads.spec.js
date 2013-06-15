/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Ads module", function () {
	//'use strict';
	// this has to be global?
	postscribe = function() {};

	var ckMock = {
			get: function() {},
			set: function() {}
		},
		parentNode = {
			removeChild: function(){}
		},
		elements = {},
		Element = function(){
			this.parentNode = parentNode;
			this.className = '';
		},
		dartHelper = {
			getMobileUrl: function() {}
		},
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
		ads = modules.ads(ckMock, window, utils, dartHelper);

	it("is defined as a module", function () {
		expect(ads).toBeDefined();
	});

	it("has a public API", function () {
		expect(typeof ads.setupSlot).toEqual('function');
		expect(typeof ads.init).toEqual('function');
		expect(typeof ads.fix).toEqual('function');
		expect(typeof ads.unfix).toEqual('function');
		expect(typeof ads.shouldRequestAd).toEqual('function');
	});

	it("can initialize a top right box Ad", function () {
		ads.setupSlot({name: 'TOP_RIGHT_BOXAD', size: '300x250', wrapper: {}});
		//expect(elements['wkAdPlc'].className).toEqual('footer');
		//expect(ads.getAdType()).toEqual('footer');
	});

});
