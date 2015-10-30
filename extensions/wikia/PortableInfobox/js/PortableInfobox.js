(function (window, $) {
	'use strict';

	var ImageCollection = {
		init: function() {
			this.setupTabs();
		},
		setupTabs: function() {
			$('.pi-image-collection-tabs').on('click', 'li', function() {
				var $tab = $(this),
					$tabs = $tab.parent().children(),
					$contens = $tab.parent().parent().children(),
					newTabIndex = $tab.index(),
					oldTabIndex = $tab.parent().find('.current').index();
				$tabs.eq(oldTabIndex).removeClass('current');
				$tabs.eq(newTabIndex).addClass('current');
				$contens.eq(oldTabIndex+1).removeClass('current');
				$contens.eq(newTabIndex+1).addClass('current');
			});
		}
	};

	var CollapsibleGroup = {
		init: function() {
			var $collapsibleGroups = $('.pi-collapse');

			$collapsibleGroups.each( function( index, group ) {
				var $group = $collapsibleGroups.eq(index),
					$header = $group.find('.pi-header');

				$header.click( function() {
					$group.toggleClass('pi-collapse-closed');
				});
			});
		}
	}

	ImageCollection.init();
	CollapsibleGroup.init();
})(window, jQuery);
