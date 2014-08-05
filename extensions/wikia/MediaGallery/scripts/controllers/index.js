require(['mediaGallery.toggler'], function (Toggler) {
	'use strict';
	$(function () {
		var toggler = new Toggler({
			$el: $('.media-gallery-wrapper')
		});
		toggler.init();
	});
});
