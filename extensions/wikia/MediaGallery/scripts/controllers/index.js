alert('go!');
require(['mediaGallery.toggler'], function (Toggle) {
	'use strict';

	$(function () {
		var toggler = new Toggle({
			$el: $('.media-gallery-wrapper')
		});
		toggler.init();
	});
});