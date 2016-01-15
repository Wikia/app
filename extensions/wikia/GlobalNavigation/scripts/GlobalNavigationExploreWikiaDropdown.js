require(
	[
		'jquery', 'wikia.window', 'wikia.delayedhover', 'wikia.globalNavigationDropdowns'
	],
	function ($, w, delayedHover, dropdowns) {
		'use strict';

		var $entryPoint,
			$exploreLink;

		/**
		 * First click on touch devices opens the dropdown.
		 * First click on non-touch screens redirects to the link
		 * Second click on entry point on touch devices redirects to link.
		 * This works because on hover (non-touch screens) class active is added - this way first click redirects to URL
		 * @param {Event} event
		 */
		function onEntryPointClick(event) {
			var $this = $(event.target);

			event.preventDefault();
			event.stopImmediatePropagation();

			if ($entryPoint.hasClass('active')) {
				w.location = $this.attr('href');
			} else {
				dropdowns.openDropdown.call($entryPoint.get(0));
			}
		}

		$(function () {
			$entryPoint = $('#exploreWikiaEntryPoint');
			$exploreLink = $entryPoint.children('a.cell-link');

			dropdowns.attachDropdown($entryPoint,
				{
					onClick: onEntryPointClick.bind({$entryPoint: $entryPoint}),
					onClickTarget: $exploreLink.get(0)
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
