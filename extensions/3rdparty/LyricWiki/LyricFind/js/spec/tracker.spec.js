describe("LyricFind.Tracker", function () {
	'use strict';

	var windowMock = {
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

		expect(px.src).toContain([
			windowMock.wgScriptPath + '/wikia.php?controller=LyricFind&method=track',
			'title=' + encodeURIComponent(title),
			'amgid=' + amgId,
			'gracenoteid=' + gracenoteId,
			'rand='
		].join('&'));
	});
});
