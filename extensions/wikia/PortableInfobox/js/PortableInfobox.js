(function (window, $) {
	'use strict';

	var ImageCollection = {
		init: function() {
			this.setupTabs();
		},
		setupTabs: function() {
			var $imageCollections = $('.pi-image-collection');

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
		init: function() {
			var $collapsibleGroups = $('.pi-collapse');

			$collapsibleGroups.each( function( index, group ) {
				var $group = $collapsibleGroups.eq(index),
					$header = $group.find('.pi-header'),
					title = $group.hasClass('pi-collapse-closed') ? 'Open' : 'Close';

				$header.attr('title', title);

				$header.click( function() {
					this.title = (this.title === 'Open') ? 'Close' : 'Open';
					$group.toggleClass('pi-collapse-closed');
				});
			});
		}
	}

	ImageCollection.init();
	CollapsibleGroup.init();
})(window, jQuery);
