require(['jquery', 'wikia.tracker', 'wikia.abTest'], function ($, tracker, abTest) {

	var trackingCategory;

	if (abTest.inGroup('PREMIUM_PAGE_HEADER', 'CONTROL') && !window.wgUserName) {
		trackingCategory = 'page-header-control';
	} else if (abTest.inGroup('PREMIUM_PAGE_HEADER', 'PREMIUM') || window.wgUserName) {
		trackingCategory = 'page-header-test-group';
	}

	var track = tracker.buildTrackingFunction({
		category: trackingCategory,
		trackingMethod: 'analytics'
	});

	function trackClick(label) {
		track({
			action: tracker.ACTIONS.CLICK,
			label: label
		});
	}

	function initBottomCategoriesTracking() {
		// categories-in
		$('.special-categories').on('click', function () {
			trackClick('categories-in');
		});
		// categories-<number>
		$('#articleCategories').find('li.category a').on('click', function () {
			var index = $('#articleCategories').find('li.category:not(.hidden)').index($(this).closest('.category'));
			trackClick('categories-' + index);
		});
		// categories-more - n/a
		// categories-more-<number> - n/a
	}

	function initBottomInterlangTracking() {
		// interwiki-dropdown - n/a
		// interwiki-<lang code>
		$('.WikiaArticleInterlang a').on('click', function () {
			var data = $(this).data('tracking');
			if (data) {
				trackClick(data);
			}
		});
	}

	$(function () {
		initBottomCategoriesTracking();
		initBottomInterlangTracking();
	});
});
