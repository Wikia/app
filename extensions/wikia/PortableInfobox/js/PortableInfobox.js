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
		verticalPadding: 0,
		init: function ($content) {
			var $collapsibleDatas = $content.find(
					'.portable-infobox > .pi-data-collapse, ' +
					'.pi-group:not(.pi-collapse-closed) > .pi-data-collapse'
				),
				$collapsedGroups = $content.find('.pi-group.pi-collapse-closed');

			if ($collapsibleDatas.length) {
				// We assume that every collapsible data field has the same paddings
				// This is being done to avoid multiple DOM queries
				CollapsibleData.verticalPadding = CollapsibleData.getVerticalPadding($collapsibleDatas.eq(0));
			}

			$collapsibleDatas.each(CollapsibleData.handleCollapsibleData);
			$collapsedGroups.each(function () {
				$(this).on('click', CollapsibleData.onCollapsedGroupClick);
			});
		},
		getVerticalPadding: function ($wrapper) {
			var $label = $wrapper.find('.pi-data-label'),
				$value = $wrapper.find('.pi-data-value'),
				verticalPaddingWrapper = $wrapper.outerHeight() - $wrapper.height(),
				verticalPaddingLabel = $label.outerHeight() - $label.height(),
				verticalPaddingValue = $value.outerHeight() - $value.height(),
				maxInnerPadding = Math.max(verticalPaddingLabel, verticalPaddingValue);

			return verticalPaddingWrapper + maxInnerPadding;
		},
		handleCollapsibleData: function () {
			var $wrapper = $(this);

			if ($wrapper.get(0).scrollHeight - CollapsibleData.verticalPadding >= $wrapper.outerHeight()) {
				$wrapper.addClass('pi-data-collapse-closed')
					.on('click', CollapsibleData.onCollapsedDataClick);
			} else {
				$wrapper.removeClass('pi-data-collapse pi-data-collapse-closed');
			}
		},
		onCollapsedDataClick: function (event) {
			event.preventDefault();
			$(this).off('click', CollapsibleData.onCollapsedDataClick)
				.removeClass('pi-data-collapse pi-data-collapse-closed');
		},
		onCollapsedGroupClick: function () {
			var $group = $(this),
				$collapsibleDatas = $group.find('.pi-data-collapse');

			$collapsibleDatas.each(CollapsibleData.handleCollapsibleData);
			$group.off('click', CollapsibleData.onCollapsedGroupClick);
		}
	};

	mw.hook('wikipage.content').add(function ($content) {
		ImageCollection.init($content);
		CollapsibleGroup.init($content);
		CollapsibleData.init($content);
	});
})(window, jQuery);
