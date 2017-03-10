require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	var _track = tracker.buildTrackingFunction({
		category: 'premium-page-header',
		trackingMethod: 'analytics'
	});

	function initTabletSupport() {
		$('.pph-local-nav-container').on('mouseenter', function () {
			var container = $(this);

			// execute this code after all mouse events are done, required for tablets support
			setTimeout(function () {
				$('.pph-local-nav-item-l2 > .pph-click').removeClass('pph-click');
				container.children('a').addClass('pph-click');
			}, 0);
		});

		$('.pph-local-nav-item-l1').on('mouseleave', function () {
			var menuItem = $(this);
			menuItem.children('a').removeClass('pph-click');
		});
	}

	function initTracking() {
		var track = function (element) {
			var data = $(element).data('tracking');
			if (data) {
				_track({
					action: tracker.ACTIONS.CLICK,
					label: data
				});
			}
		};

		$('.pph-local-nav-container > a').on('click', function (e) {
			if (!$(this).hasClass('pph-click')) {
				$(this).addClass('pph-click');
				e.preventDefault();
			} else {
				track(this);
			}
		});
		$('.pph-local-nav-tracking:not(.pph-local-nav-container) a').on('click', track);
	}

	$(function () {
		initTracking();
		initTabletSupport();
	})
});
