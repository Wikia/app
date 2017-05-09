describe('ext.wikia.recirculation.utils', function () {
	'use strict';

	function createRecirculationItem(source, isVideo) {
		return jQuery('<div>', {
			'html': jQuery('<a>', { html: 'Link' }),
			'data-index': 0,
			'data-source': source,
			'class': (isVideo) ? 'is-video' : ''
		});
	}

	function getUtils() {
		return modules['ext.wikia.recirculation.utils'](jQuery);
	}

	describe('buildLabel', function () {
		var utils = getUtils();

		it('should return a string', function () {
			var source = 'fandom',
				isVideo = true,
				position = 'rail',
				clickedLink = createRecirculationItem(source, isVideo).find('a').get();

			var label = utils.buildLabel(clickedLink, position);

			expect(typeof label).toBe('string');
		});

		it('should seperate sections with "="', function () {
			var source = 'fandom',
				isVideo = true,
				position = 'rail',
				clickedLink = createRecirculationItem(source, isVideo).find('a').get();

			var label = utils.buildLabel(clickedLink, position),
				sections = label.split('=');

			expect(sections.length).toBeGreaterThan(1);
		});

		it('should format the label in the proper order', function () {
			var source = 'fandom',
				isVideo = true,
				position = 'rail',
				clickedLink = createRecirculationItem(source, isVideo).find('a').get();

			var label = utils.buildLabel(clickedLink, position),
				sections = label.split('='),
				slot = 'slot-1',
				video = 'video';

			expect(sections[0]).toEqual(position);
			expect(sections[1]).toEqual(slot);
			expect(sections[2]).toEqual(source);
			expect(sections[3]).toEqual(video);
		});

		it('should set source to undefined when recirculation item has no source', function () {
			var source = '',
				isVideo = true,
				position = 'rail',
				clickedLink = createRecirculationItem(source, isVideo).find('a').get();

			var label = utils.buildLabel(clickedLink, position),
				sections = label.split('=');

			expect(sections[2]).toEqual('undefined');
		});

		it('should report when the recirculation item is a video', function () {
			var source = 'fandom',
				isVideo = true,
				position = 'rail',
				clickedLink = createRecirculationItem(source, isVideo).find('a').get();

			var label = utils.buildLabel(clickedLink, position),
				sections = label.split('=');

			expect(sections[3]).toEqual('video');
		});

		it('should report when the recirculation item is not a video', function () {
			var source = 'fandom',
				isVideo = false,
				position = 'rail',
				clickedLink = createRecirculationItem(source, isVideo).find('a').get();

			var label = utils.buildLabel(clickedLink, position),
				sections = label.split('=');

			expect(sections[3]).toEqual('not-video');
		});
	});
});
