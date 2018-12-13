(function (window, $) {
	'use strict';

	var ImageCollection = {
		init: function($content) {
			var $imageCollections = $content.find('.pi-image-collection');

			$imageCollections.each( function( index ) {
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

			$collapsibleGroups.each( function( index ) {
				var $group = $collapsibleGroups.eq(index),
					$header = $group.find('.pi-header:first');

				$header.click( function() {
					$group.toggleClass('pi-collapse-closed');

					// SUS-3245: lazy-load any images in the un-collapsed section
					$(window).trigger('scroll');
				});
			});
		}
	};

	var Panel = {
		init: function($content) {
			var $panels = $content.find('.pi-panel');

			$panels.each( function( index ) {
				var $panel = $panels.eq(index),
					$toggles = $panel.find('.pi-section-navigation');

				$toggles.on('click', function(e) {
					var toggle = e.target.closest('.pi-section-tab');

					if (toggle !== null) {
						var $newActiveToggle = $(toggle),
							newRef = $newActiveToggle.attr('data-ref'),
							$oldActiveToggle = $toggles.find('.pi-section-active'),
							$oldActiveContent = $panel.find('.pi-section-content.pi-section-active'),
							$newActiveContent = $panel.find('.pi-section-content[data-ref=' + newRef + ']');

						$oldActiveToggle.removeClass('pi-section-active');
						$oldActiveContent.removeClass('pi-section-active');

						$newActiveToggle.addClass('pi-section-active');
						$newActiveContent.addClass('pi-section-active');
					}
				})
			});
		}
	};

	mw.hook('wikipage.content').add(function($content) {
		ImageCollection.init($content);
		CollapsibleGroup.init($content);
		Panel.init($content);
	});
})(window, jQuery);
