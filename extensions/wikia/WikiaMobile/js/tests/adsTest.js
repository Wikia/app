/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/libraries/zepto/zepto-0.8.js
 @test-require-asset /resources/wikia/modules/cookies.js
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/features.js
 @test-require-asset /resources/wikia/libraries/DOMwriter/domwriter.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/ads.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Test ads module", function () {
	'use strict';
	var module,
		async = new AsyncSpec(this);

	async.it("is defined as a module", function (done) {
		//required markup for correct initialization of the ads module
		document.body.innerHTML = '<aside id=wkAdPlc><div id=wkAdCls></div><div id=wkAdWrp></div></aside><div id=wkFtr></div>';

		require(['ads'], function (ads) {
			expect(ads).toBeDefined();
			done();
		});
	});

	async.it("has a public API", function (done) {
		require(['ads'], function(module){
			expect(typeof module.setupSlot).toEqual('function');
			expect(typeof module.init).toEqual('function');
			expect(typeof module.fix).toEqual('function');
			expect(typeof module.unfix).toEqual('function');
			expect(typeof module.dismiss).toEqual('function');
			expect(typeof module.getAdType).toEqual('function');
			done();
		});
	});

	async.it("can initialize a footer Ad", function (done) {
		require(['ads'], function(module){
			module.init('footer');
			expect(module.getAdType()).toEqual('footer');
			done();
		});

	});

	async.it("ad slot is removed after dismiss", function (done) {
		require(['ads'], function(module){
			expect(document.getElementById('wkAdPlc')).toBeDefined();
			module.dismiss();

			expect(document.getElementById('wkAdPlc')).toBe(null);
			expect(document.getElementById('wkAdCls')).toBe(null);
			expect(document.getElementById('wkFtr')).toBeDefined();

			done();
		});
	});
});
