/*
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/tracker.stub.js
 @test-require-asset /resources/wikia/modules/tracker.js
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
			expect(track.CLICK).toEqual(Wikia.Tracker.ACTIONS.CLICK);
			expect(track.SWIPE).toEqual(Wikia.Tracker.ACTIONS.SWIPE);
			expect(track.SUBMIT).toEqual(Wikia.Tracker.ACTIONS.SUBMIT);
			expect(track.PAGINATE).toEqual(Wikia.Tracker.ACTIONS.PAGINATE);
			expect(track.IMAGE_LINK).toEqual(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE);
			expect(track.TEXT_LINK).toEqual(Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT);

			done();
		});
	});
});