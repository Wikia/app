/*global describe, it, runs, waitsFor, expect, require, document*/
ddescribe("Ads module", function () {
	'use strict';

	//required markup for correct initialization of the ads module
	getBody().innerHTML = '<aside id=wkAdPlc><div id=wkAdCls></div><div id=wkAdWrp></div></aside><div id=wkFtr></div>';

	var domwriter = {
			addEventListener: function(){},
			removeEventListener: function(){}
		},
		cookies = {

		},
		track = {

		},
		log = {

		},
		window = {
			WikiaDartMobileHelper: function(){
				return function(){};
			},
			document: document
		},
		utils = function(func){
			func();
		},
		ads = modules.ads(domwriter, cookies, track, log, window, utils);

	it("is defined as a module", function () {
		expect(ads).toBeDefined();
	});

	it("has a public API", function () {
		expect(typeof ads.setupSlot).toEqual('function');
		expect(typeof ads.init).toEqual('function');
		expect(typeof ads.fix).toEqual('function');
		expect(typeof ads.unfix).toEqual('function');
		expect(typeof ads.dismiss).toEqual('function');
		expect(typeof ads.getAdType).toEqual('function');
	});

	it("can initialize a footer Ad", function () {
		ads.init('footer');
		expect(ads.getAdType()).toEqual('footer');
	});

	it("ad slot is removed after dismiss", function (done) {
		var doc = window.document;

		expect(doc.getElementById('wkAdPlc')).toBeDefined();
		ads.dismiss();

		expect(doc.getElementById('wkAdPlc')).toBe(null);
		expect(doc.getElementById('wkAdCls')).toBe(null);
		expect(doc.getElementById('wkFtr')).toBeDefined();
	});
});
