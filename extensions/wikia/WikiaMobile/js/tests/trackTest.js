/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Track module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	async.it('should be defined', function(done){
		require(['track'], function(track){
			expect(track).toBeDefined();
			expect(track.event).toBeDefined();
			expect(typeof track.event).toBe('function');

			done();
		});
	});

	async.it('should have proper action names', function(done){
		require(['track'], function(track){
			expect(track.CLICK).toEqual(WikiaTracker.ACTIONS.CLICK);
			expect(track.SWIPE).toEqual(WikiaTracker.ACTIONS.SWIPE);
			expect(track.SUBMIT).toEqual(WikiaTracker.ACTIONS.SUBMIT);
			expect(track.PAGINATE).toEqual(WikiaTracker.ACTIONS.PAGINATE);
			expect(track.IMAGE_LINK).toEqual(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE);
			expect(track.TEXT_LINK).toEqual(WikiaTracker.ACTIONS.CLICK_LINK_TEXT);

			done();
		});
	});
});