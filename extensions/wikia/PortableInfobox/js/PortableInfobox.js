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
			var $collapsibleDatas = $content.find('.pi-data-collapse'),
				magicNumber = 0;

			if ($collapsibleDatas.length) {
				// We assume that every collapsible data field has the same paddings
				// This is being done to avoid multiple DOM queries
				magicNumber = CollapsibleData.getMagicNumber($collapsibleDatas.eq(0));
			}

			$collapsibleDatas.each(function () {
				var $wrapper = $(this);

				if ($wrapper.get(0).scrollHeight - magicNumber >= $wrapper.outerHeight()) {
					$wrapper.addClass('pi-data-collapse-closed')
						.on('click', CollapsibleData.onCollapsedDataClick);
				} else {
					$wrapper.removeClass('pi-data-collapse pi-data-collapse-closed');
				}
			});
		},
		getMagicNumber: function ($wrapper) {
			var $label = $wrapper.find('.pi-data-label'),
				$value = $wrapper.find('.pi-data-value'),
				verticalPaddingWrapper = $wrapper.outerHeight() - $wrapper.height(),
				verticalPaddingLabel = $label.outerHeight() - $label.height(),
				verticalPaddingValue = $value.outerHeight() - $value.height(),
				maxInnerPadding = Math.max(verticalPaddingLabel, verticalPaddingValue);

			return verticalPaddingWrapper + maxInnerPadding;
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
