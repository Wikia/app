require(['jquery', 'wikia.window', 'wikia.globalnavigation.lazyload'], function ($, w, GlobalNavLazyLoad) {
	'use strict';

	var $entryPoint,
		$hubLinks,
		$hubs,
		$verticals;

	/**
	 * @desc set given global nav section as active
	 * @param {Element} row - nav menu row
	 */
	function activateSubmenu(row) {
		var $row = $(row),
			verticalClass = '.' + $row.data('vertical') + '-links';

		// prevent URL redirection when tapping on section link on touch devices
		if (w.Wikia.isTouchScreen()) {
			if (!$row.hasClass('active')) {
				event.preventDefault();
			}
		}

		$(verticalClass, $hubLinks)
			.add($row)
			.addClass('active');
	}

	/**
	 * @desc set given global nav section as not active
	 * @param {Element} row - nav menu row
	 */
	function deactivateSubmenu(row) {
		$('> .hub-menu-section', $hubLinks)
			.add(row)
			.removeClass('active');
	}

	/**
	 * @desc opens global nav menu
	 */
	function openMenu() {
		$entryPoint.addClass('active');
		w.transparentOut.show();

		if (!GlobalNavLazyLoad.isMenuWorking()) {
			GlobalNavLazyLoad.getHubLinks();
		}

		$('#globalNavigation').trigger('hubs-menu-opened');
	}

	/**
	 * @desc closes global nav menu
	 */
	function closeMenu() {
		$entryPoint.removeClass('active');
		w.transparentOut.hide();
	}

	$(function () {
		$hubs = $('#hubs');
		$hubLinks = $hubs.find('> .hub-links');
		$verticals = $hubs.find('> .hub-list');
		$entryPoint = $('#hubsEntryPoint');

		w.transparentOut && w.transparentOut.bindClick(closeMenu);

		if (navigator.userAgent.toLowerCase().indexOf('android') > -1) {
			$verticals.addClass('backface-off');
		}

		$entryPoint.on('click', '.hubs-entry-point', function (ev) {
			ev.preventDefault();
			ev.stopPropagation();

			if ($entryPoint.hasClass('active')) {
				closeMenu();
			} else {
				openMenu();
			}
		});

		/**
		 * menuAim is a method from an external module to handle dropdown menus with very good user experience
		 * @see https://github.com/Wikia/js-menu-aim
		 */
		w.menuAim(
			$verticals.get(0), {
				activeRow: $verticals.find('.active').get(0),
				rowSelector: '.hub-link',
				tolerance: 85,
				activate: activateSubmenu,
				deactivate: deactivateSubmenu
			}
		);

		w.transparentOut.bindClick(closeMenu);

		if (!w.ontouchstart) {
			w.delayedHover(
				$entryPoint.get(0), {
					checkInterval: 100,
					maxActivationDistance: 20,
					onActivate: openMenu,
					onDeactivate: closeMenu,
					activateOnClick: false
				}
			);
		} else {
			$entryPoint.click(openMenu);
		}
	});
});
