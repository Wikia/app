/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/modal.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/media.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/layout.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Layout module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	window.Features = {};
	window.wgStyleVersion = 123;

	async.it('should be defined', function(done){
		document.body.innerHTML = '<div id="mw-content-text"></div>';

		require(['layout'], function(layout){
			expect(layout).toBeDefined();
			expect(typeof layout.getPageWidth).toBe('function');

			done();
		});
	});

	async.it('should return page width', function(done){
		require(['layout'], function(layout){
			expect(layout.getPageWidth()).toBe(1008);

			done();
		});
	});
});