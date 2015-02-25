require(
[
	'jquery', 'wikia.window', 'wikia.globalnavigation.lazyload',
	'wikia.menuaim', 'wikia.browserDetect', 'wikia.delayedhover', 'wikia.globalNavigationDropdowns'
],
function ($, w, GlobalNavLazyLoad, menuAim, browserDetect, delayedHover, dropdowns) {
	'use strict';

	var $entryPoint,
		$hubs,
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

	function onDropdownOpen() {
		if (!GlobalNavLazyLoad.isMenuWorking()) {
			GlobalNavLazyLoad.getHubLinks();
		}

		$('#globalNavigation').trigger('hubs-menu-opened');
	}

	$(function () {
		$hubs = $('#hubs');
		$hubLinks = $hubs.children('.hub-links');
		$verticals = $hubs.children('.hub-list');
		$entryPoint = $('#hubsEntryPoint');

		if (browserDetect.isAndroid()) {
			$verticals.addClass('backface-off');
		}

		dropdowns.attachDropdown($entryPoint, {
			onOpen: onDropdownOpen
		});

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
				onActivate: dropdowns.openDropdown,
				onDeactivate: dropdowns.closeDropdown,
				activateOnClick: false
			}
		);
	});
});
