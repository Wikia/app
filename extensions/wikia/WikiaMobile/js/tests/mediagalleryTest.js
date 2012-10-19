/*
 @test-framework Jasmine
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.wikiamobile.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/layout.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/lazyload.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/pager.js
 @test-require-asset /resources/wikia/modules/thumbnailer.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/modal.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/media.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/mediagallery.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Media Gallery module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	window.wgStyleVersion = 123456789;
	window.Features = {};

	async.it('should be defined', function(done){
		require(['mediagallery'], function(mg){

			expect(mg).toBeDefined();

			expect(typeof mg.init).toBe('function');
			expect(typeof mg.open).toBe('function');

			done();
		});
	});
});