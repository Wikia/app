/*
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 */

describe("Event module", function() {

	var events = modules.events();

	it("check if events are set", function(done) {
		expect(events).toBeDefined();
		expect(events.size).toMatch('resize');
		expect(events.touch).toMatch('touchstart');
		expect(events.move).toMatch('touchmove');
		expect(events.end).toMatch('touchend');
		expect(events.cancel).toMatch('touchcancel');
	});
});