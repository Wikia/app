describe("LyricFind.Tracker", function () {
	'use strict';

	var windowMock = {
			wgServer: 'http://localhost',
			wgScriptPath: ''
		},
		tracker = modules.LyricFindTracker(windowMock, jQuery);

	it('registers AMD module exposing a function', function() {
		expect(typeof tracker).toBe('function');
	});

	it('returns an image', function() {
		expect(tracker() instanceof Image).toBe(true);
	});

	it('generates a proper tracking URL', function() {
		var amgId = 123,
			gracenoteId = 456,
			title = 'LyricFind:Paradise_Lost:Forever_Failure',
			px = tracker(amgId, gracenoteId, title);

		expect(px instanceof Image).toBe(true);

		expect(px.src).toContain('/wikia.php?controller=LyricFind&method=track');
		expect(px.src).toContain('title=' + encodeURIComponent(title));
		expect(px.src).toContain('amgid=' + amgId);
		expect(px.src).toContain('gracenoteid=' + gracenoteId);
	});
});
