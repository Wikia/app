require(
	[
		'jquery', 'wikia.window', 'wikia.delayedhover', 'wikia.globalNavigationDropdowns'
	],
	function ($, w, delayedHover, dropdowns) {
		'use strict';

		var $entryPoint;

		function onDropdownOpen() {
		}

		$(function () {
			$entryPoint = $('#exploreWikiaEntryPoint');

			dropdowns.attachDropdown($entryPoint, {
				onOpen: onDropdownOpen
			});

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
