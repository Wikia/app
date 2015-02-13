require(
[
	'jquery', 'wikia.window', 'wikia.globalnavigation.lazyload',
	'wikia.menuaim', 'wikia.browserDetect', 'wikia.delayedhover'
],
function ($, w, GlobalNavLazyLoad, menuAim, browserDetect, delayedHover) {
	'use strict';

	var $entryPoint = $('#hubsEntryPoint'),
		$hubs = $('#hubs'),
		$hubLinks,
		$verticals;

	/**
	 * @desc set given global nav section as active
	 * @param {Element} row - nav menu row
	 */
	function activateSubmenu(row) {
		var $row = $(row),
			verticalClass = '.' + $row.data('vertical') + '-links';

		// prevent URL redirection when tapping on section link on touch devices
		if (browserDetect.isTouchScreen()) {
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
		$hubLinks = $hubs.children('.hub-links');
		$verticals = $hubs.children('.hub-list');

		if (browserDetect.isAndroid()) {
			$verticals.addClass('backface-off');
		}

		//Menu-aim should be attached for both touch and not touch screens.
		//It handles opening and closing submenu on click
		menuAim.attach(
			$verticals.get(0), {
				activeRow: $verticals.find('.active').get(0),
				rowSelector: '.hub-link',
				tolerance: 85,
				activate: activateSubmenu,
				deactivate: deactivateSubmenu
			}
		);

		delayedHover.attach(
			$entryPoint.get(0), {
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu,
				activateOnClick: false
			}
		);

		$entryPoint.click(openMenu);
		w.transparentOut.bindClick(closeMenu);
	});
});
