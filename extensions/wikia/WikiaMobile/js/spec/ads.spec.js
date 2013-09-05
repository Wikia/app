/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Ads module", function () {
	'use strict';

	var cookies = {
			val: 0,
			get: function(){return cookies.val++},
			set: function(){cookies.val = 1}
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
			getMobileUrl: function(){return ''}
		},
		window = {
			document: {
				getElementById: function(name){
					return elements[name] || (elements[name] = new Element());
				}
			},
			Features: {},
			postscribe: function(){}
		},
		ads = modules.ads(cookies, window, dartHelper);

	it("is defined as a module", function () {
		expect(ads).toBeDefined();
	});

	it("is defined as a global", function () {
		expect(window.MobileAd).toBeDefined();
	});

	it("has a public API", function () {
		expect(typeof ads.setupSlot).toEqual('function');
		expect(typeof ads.init).toEqual('function');
		expect(typeof ads.stop).toEqual('function');
	});

	it("can setup an ad slot", function () {
		ads.setupSlot({
			name: 'AD_SLOT',
			size: '100x100',
			wrapper: window.document
		});
	});

	it('can tell if ad should be requested', function(){
		expect(ads.shouldRequestAd()).toBeTruthy();
	});

	it('can stop ads from showing', function(){
		ads.stop();
		expect(ads.shouldRequestAd()).toBeFalsy();
	});
});
