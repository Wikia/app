/*
 @test-framework Jasmine
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.wikiamobile.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/modal.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/media.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Media module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	window.Features = {};

	async.it('should be defined', function(done){
		require(['media'], function(media){
			expect(media).toBeDefined();

			expect(typeof media.openModal).toBe('function');
			expect(typeof media.getImages).toBe('function');
			expect(typeof media.getCurrent).toBe('function');
			expect(typeof media.hideShare).toBe('function');
			expect(typeof media.init).toBe('function');
			expect(typeof media.cleanup).toBe('function');

			done();
		});
	});

	async.it('should init', function(done){

		document.body.innerHTML = '';

		require(['media'], function(media){
			media.init();

			done();
		});
	});
});