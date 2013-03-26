describe("Event module", function() {

	it("should init with touch events", function() {
		var events = modules.events({
			onorientationchange: null,
			ontouchstart: null,
			ontouchmove: null,
			ontouchend: null,
			ontouchcancel: null
		});

		expect(events).toBeDefined();
		expect(events.size).toBe('orientationchange');
		expect(events.touch).toBe('touchstart');
		expect(events.move).toBe('touchmove');
		expect(events.end).toBe('touchend');
		expect(events.cancel).toBe('touchcancel');
	});

	it('should init with mouse events', function(){
		var events = modules.events({
			onorientationchange: undefined,
			ontouchstart: undefined,
			ontouchmove: undefined,
			ontouchend: undefined,
			ontouchcancel: undefined
		});

		expect(events).toBeDefined();
		expect(events.size).toBe('resize');
		expect(events.touch).toBe('mousedown');
		expect(events.move).toBe('mousemove');
		expect(events.end).toBe('mouseup');
		expect(events.cancel).toBe('mouseup');
	})
});