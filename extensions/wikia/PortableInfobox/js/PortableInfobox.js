(function (window, $) {
	'use strict';

	var ImageCollection = {
		init: function() {
			this.setupTabs();
		},
		setupTabs: function() {
			var $imageCollection = $('.pi-image-collection'),
				$tabs = $('ul.pi-image-collection-tabs li'),
				$tabContent = $('.pi-image-collection-tab-content');

			$tabs.first().addClass('current');
			$tabContent.first().addClass('current');

			$imageCollection.on('click', 'ul.pi-image-collection-tabs li', function( event ) {
				var $target = $(this),
					tabId = $target.attr('data-pi-tab');

				$tabs.removeClass('current');
				$tabContent.removeClass('current');

				$target.addClass('current');
				$('#' + tabId).addClass('current');
			});

		}
	};

	ImageCollection.init();
})(window, jQuery);
