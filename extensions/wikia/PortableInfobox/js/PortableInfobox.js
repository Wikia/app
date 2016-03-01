(function (window, $) {
	'use strict';

	var ImageCollection = {
		init: function($content) {
			var $imageCollections = $content.find('.pi-image-collection');

			$imageCollections.each( function( index, collection ) {
				var $collection = $imageCollections.eq(index),
					$tabs = $collection.find('ul.pi-image-collection-tabs li'),
					$tabContent = $collection.find('.pi-image-collection-tab-content');

				$tabs.click( function() {
					var $target = $(this),
						tabId = $target.attr('data-pi-tab');

					$tabs.removeClass('current');
					$tabContent.removeClass('current');

					$target.addClass('current');
					$collection.find('#' + tabId).addClass('current');
				});
			});
		}
	};

	var CollapsibleGroup = {
		init: function($content) {
			var $collapsibleGroups = $content.find('.pi-collapse');

			$collapsibleGroups.each( function( index, group ) {
				var $group = $collapsibleGroups.eq(index),
					$header = $group.find('.pi-header');

				$header.click( function() {
					$group.toggleClass('pi-collapse-closed');
				});
			});
		}
	};

	mw.hook('wikipage.content').add(function($content) {
		ImageCollection.init($content);
		CollapsibleGroup.init($content);
	});
})(window, jQuery);
