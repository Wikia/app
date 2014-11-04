describe('Lightbox', function () {
	'use strict';

	var lightbox = window.Lightbox,
		history;

	it('should be defined', function () {
		expect(lightbox).toBeDefined();
		expect(typeof lightbox).toBe('object');
	});

	it('should have access to the history library', function () {
		history = window.modules['wikia.history'](window);
		expect(history).toBeDefined();
		expect(typeof history).toBe('object');
	});

	describe('should update the URL when updateUrlState called', function () {
		// seed lightbox with a current key. This is what will be updated in the URL.
		lightbox.current.key = 'testFile.png';

		it('does not currently have a url parameter', function () {
			expect(window.location.href.split('?').length).toBe(1);
		});

		it('adds a parameter to the URL when updateUrlState is called with clear option set to false', function () {
			lightbox.updateUrlState(false);
			window.modules['require,wikia.history'](history);
			expect(window.location.href.split('?').length).toBe(2);
			expect(window.location.href.split('?')[1]).toBe('file=' + lightbox.current.key);
		});

		it('removes the parameter to the URL when updateUrlState is called with clear option set to true', function () {
			lightbox.updateUrlState(true);
			window.modules['require,wikia.history'](history);
			expect(window.location.href.split('?').length).toBe(1);
		});
	});
});
