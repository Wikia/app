require(
	[
		'jquery', 'wikia.window', 'wikia.delayedhover', 'wikia.globalNavigationDropdowns'
	],
	function ($, w, delayedHover, dropdowns) {
		'use strict';

		var $entryPoint,
			$exploreLink;

		/**
		 * Handle click on entry point for logged in users.
		 * Second click on entry point for logged in users is redirecting to user profile page.
		 * This method should be removed after we unify the ux for anon and logged in.
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

			dropdowns.attachDropdown($entryPoint, {
				onClick: onEntryPointClick.bind({$entryPoint: $entryPoint}),
				onClickTarget: $exploreLink.get(0)
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
