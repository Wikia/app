describe("Event module", function() {

	var events = modules.events();

	it("check if events are set", function(done) {
		expect(events).toBeDefined();
		expect(events.size).toMatch(/resize/);
		expect(events.touch).toMatch(/touchstart|mousedown/);
		expect(events.move).toMatch(/touchmove|mousemove/);
		expect(events.end).toMatch(/touchend|mouseup/);
		expect(events.cancel).toMatch(/touchcancel|mouseup/);
	});
});