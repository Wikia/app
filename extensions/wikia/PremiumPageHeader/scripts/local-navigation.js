require(['wikia.window', 'jquery', 'wikia.tracker', 'wikia.abTest'], function (window, $, tracker, abTest) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		category: 'page-header-test-group',
		trackingMethod: 'analytics'
	});

	function initTabletSupport() {
		$('.pph-local-nav-container').on('mouseenter', function () {
			var $container = $(this);

			// execute this code after all mouse events are done, required for tablets support
			setTimeout(function () {
				$('.pph-local-nav-item-l2 > .pph-click').removeClass('pph-click');
				$container.children('a').addClass('pph-click');
			}, 0);
		});

		$('.pph-local-nav-item-l1').on('mouseleave', function () {
			$(this).children('a').removeClass('pph-click');
		});

		$('.pph-local-nav-container > a').on('click', function (event) {
			var $this = $(this);
			if (!$this.hasClass('pph-click')) {
				$this.addClass('pph-click');
				event.preventDefault();
			}
		});
	}

	function initTracking() {
		var linkTrack = function ($element) {
			var data = $element.data('tracking');
			if (data) {
				track({
					action: tracker.ACTIONS.CLICK,
					label: data
				});
			}
		};

		$('.pph-local-nav-container > a').on('click', function () {
			var $this = $(this);
			if ($this.hasClass('pph-click')) {
				linkTrack($this);
			}
		});
		$('.pph-local-nav-tracking:not(.pph-local-nav-container) a').on('click', function () {
			linkTrack($(this));
		});
	}

	$(function () {
		if (abTest.inGroup('PREMIUM_PAGE_HEADER', 'PREMIUM') || window.wgUserName) {
			initTracking();
		}
		initTabletSupport();
	});
});
