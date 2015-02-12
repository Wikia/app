/* global modules */
describe('MediaGalleries gallery', function () {
	'use strict';

	var i,
		Gallery,
		Media,
		Toggler,
		Caption,
		templates,
		instance,
		options,
		bucky,
		tracker = {
			buildTrackingFunction: function () {
				return $.noop;
			},
			ACTIONS: {
				CLICK: 'click'
			}
		},
		mediaData = {
			caption: 'My caption',
			linkHref: '/wiki/File:440.jpeg',
			thumHtml: 'thumbHTML',
			thumbUrl: 'http://vignette.wikia-dev.com/lizlux/6/62/440.jpeg'
		},
		model = {
			media: []
		};

	$.fn.startThrobbing = $.noop;
	$.fn.stopThrobbing = $.noop;

	// Create an abitrary data model
	for (i = 0; i < 4; i+=1) {
		model.media.push(mediaData);
	}

	beforeEach(function () {
		options = {
			$el: $('<div></div>'),
			$wrapper: $('.media-gallery-wrapper'),
			model: model,
			idx: 0,
			origVisibleCount: 1,
			interval: 2
		};

		spyOn(Mustache, 'render').and.returnValue('okay');
		bucky = modules['bucky.mock'];
		templates = modules['mediaGallery.templates.mustache'];
		Toggler = modules['mediaGallery.views.toggler'](templates);
		Caption = modules['mediaGallery.views.caption']();
		Media = modules['mediaGallery.views.media'](Caption, templates);
		Gallery = modules['mediaGallery.views.gallery'](Media, Toggler, tracker, bucky);

		instance = new Gallery(options).init();
	});

	it('should export a function', function () {
		expect(typeof Gallery).toBe('function');
	});

	it('should create media', function () {
		expect(instance.media.length).toBe(model.media.length);
	});

	it('should render with parameters', function () {
		// passing values to render
		instance.render(1);
		expect(instance.visibleCount).toBe(1);
		instance.render(2);
		expect(instance.visibleCount).toBe(3);
	});

	it('should render without parameters', function () {
		// not passing value, default interval should be used
		instance.render();
		expect(instance.visibleCount).toBe(options.origVisibleCount);
	});

	it('should init toggler', function () {
		// recreate instance with different options
		options.origVisibleCount = 2;
		instance = new Gallery(options);
		instance.init();

		expect(instance.toggler).toBeDefined();
	});

	it('should not init toggler', function () {
		// recreate instance with different options
		options.origVisibleCount = 4;
		instance = new Gallery(options);
		instance.init();

		expect(instance.toggler).not.toBeDefined();
	});

	it('should show more and show less', function () {
		instance.showMore();
		expect(instance.visibleCount).toBe(options.interval);
		spyOn(instance, 'scrollToTop');
		instance.showLess();
		expect(instance.visibleCount).toBe(options.origVisibleCount);
	});

	it('should not error at arbitrary render count', function () {
		instance.render(model.media.length + 2);
		expect(instance.media.length).toBe(model.media.length);
	});
});
