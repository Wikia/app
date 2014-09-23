/* global modules */
describe('MediaGalleries gallery', function () {
	'use strict';

	var Gallery,
		Media,
		Caption,
		templates,
		tracker,
		instance,
		options,
		model = [
			{
				caption: 'My caption',
				linkHref: '/wiki/File:440.jpeg',
				thumHtml: 'thumbHTML',
				thumbUrl: 'http://vignette.wikia-dev.com/lizlux/6/62/440.jpeg'
			},
			{
				caption: 'Another caption',
				linkHref: '/wiki/File:500.jpeg',
				thumHtml: 'thumbHTML',
				thumbUrl: 'http://vignette.wikia-dev.com/lizlux/6/62/440.jpeg'
			}
		];

	beforeEach(function () {
		options = {
			$el: $('<div></div>'),
			$wrapper: $('.media-gallery-wrapper'),
			model: model,
			oVisible: 8
		};
		tracker = modules['wikia.tracker']();
		templates = modules['mediaGallery.templates.mustache'];
		Caption = modules['mediaGallery.views.caption']();
		Media = modules['mediaGallery.views.media'](Caption, templates);
		Gallery = modules['mediaGallery.views.gallery'](Media, templates, tracker);
	});

	it('should export a function', function () {
		expect(typeof Gallery).toBe('function');
	});

	it('should create media', function () {
		instance = new Gallery(options);
		expect(instance.media.length).toBe(2);
	});
});
