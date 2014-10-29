(function () {
	'use strict';

	var initMediaGallery = function (data) {
		var gallery, $wrapper, options;

		// fix data format
		if (typeof data.media === 'string') {
			data.media = JSON.parse(data.media);
		}

		$wrapper = $('#' + data.id);
		options = {
			$el: $('<div></div>'),
			$wrapper: $wrapper,
			model: data,
			index: parseInt(data.id),
			// if set, pass the value, otherwise, defaults will be used.
			origVisibleCount: $wrapper.data('visible-count'),
			interval: $wrapper.data('expanded')
		};

		require(['mediaGallery.views.gallery'], function (Gallery) {
			gallery = new Gallery(options).init();
			// Append gallery HTML to DOM and trigger event
			$wrapper.append(gallery.render().$el);
			gallery.$el.trigger('galleryInserted');
		});
	};

	window.Wikia = window.Wikia || {};
	window.Wikia.initMediaGallery = initMediaGallery;

})();
