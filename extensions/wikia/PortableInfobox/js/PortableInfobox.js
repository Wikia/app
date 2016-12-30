(function (window, $) {
	'use strict';

	var ImageCollection = {
		init: function ($content) {
			var $imageCollections = $content.find('.pi-image-collection');

			$imageCollections.each(function (index, collection) {
				var $collection = $imageCollections.eq(index),
					$tabs = $collection.find('ul.pi-image-collection-tabs li'),
					$tabContent = $collection.find('.pi-image-collection-tab-content');

				$tabs.click(function () {
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
		init: function ($content) {
			var $collapsibleGroups = $content.find('.pi-collapse');

			$collapsibleGroups.each(function (index, group) {
				var $group = $collapsibleGroups.eq(index),
					$header = $group.find('.pi-header');

				$header.click(function () {
					$group.toggleClass('pi-collapse-closed');
				});
			});
		}
	};

	var CollapsibleData = {
		init: function ($content) {
			var $collapsibleDatas = $content.find('.pi-data-collapse');

			$collapsibleDatas.each(function () {
				var $element = $(this);

				// FIXME scrollHeight is calculated incorrectly so we need to subtract a magic number
				if ($element.get(0).scrollHeight - 38 >= $element.get(0).clientHeight) {
					$element.addClass('pi-data-collapse-closed')
						.on('click', CollapsibleData.onCollapsedDataClick);
				} else {
					$element.removeClass('pi-data-collapse pi-data-collapse-closed');
				}
			});
		},
		onCollapsedDataClick: function (event) {
			event.preventDefault();
			$(this).off('click', CollapsibleData.onCollapsedDataClick)
				.removeClass('pi-data-collapse pi-data-collapse-closed');
		}
	};

	mw.hook('wikipage.content').add(function ($content) {
		ImageCollection.init($content);
		CollapsibleGroup.init($content);
		CollapsibleData.init($content);
	});
})(window, jQuery);
