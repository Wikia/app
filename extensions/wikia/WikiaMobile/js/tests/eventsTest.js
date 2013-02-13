/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 */

describe("Event module", function() {

	var async = new AsyncSpec(this);

	async.it("check if events are set", function(done) {

		require(['events'], function(events){
			expect(events).toBeDefined();
			expect(events.click).toMatch('click');
			expect(events.size).toMatch('resize');
			expect(events.touch).toMatch('touchstart');
			expect(events.move).toMatch('touchmove');
			expect(events.end).toMatch('touchend');
			expect(events.cancel).toMatch('touchcancel');

			done();
		})
	});
});