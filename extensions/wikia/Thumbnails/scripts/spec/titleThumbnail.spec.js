describe('titleThumbnail module', function () {
	'use strict';

	var templates = modules['thumbnails.templates.mustache'](),
		Mustache = modules['wikia.mustache'],
		TitleThumbnail = modules['thumbnails.views.titleThumbnail'](templates, Mustache),
		instance,
		thumbnailHtml,
		title = 'Best funny and cute cat videos compilation 2014',
		url = 'http://lizlux.wikia.com/wiki/File:Best_funny_and_cute_cat_videos_compilation_2014';

	// Some mock thumbnail HTML, doesn't really matter except for matching below.
	thumbnailHtml = '<a href="' + url + '" class="video-thumbnail"><img src="#"></a> ';

	instance = new TitleThumbnail({
			model: {
				thumbnail: thumbnailHtml,
				title: title,
				url: url
			}
		});

	it('should be defined', function () {
		expect(TitleThumbnail).toBeDefined();

		expect(typeof instance.render).toBe('function');
		expect(typeof instance.initialize).toBe('function');
		expect(typeof instance.applyEllipses).toBe('function');
	});

	it('should render html', function () {
		var html = '';

		instance.render();
		html = instance.el.innerHTML;

		expect(html).toMatch('class="video-thumbnail"');
		expect(html).toMatch('title="' + title + '"');
		expect(html).toMatch('<a href="' + url + '">' + title + '</a>');
	});
});
