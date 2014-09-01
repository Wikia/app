require(['jquery', 'wikia.globalnavigation.lazyload'], function($, GlobalNavLazyLoad){
	'use strict';
	var $entryPoint, $hubLinks, $verticals;

	$hubLinks = $('#hubs > .hub-links');
	$verticals = $('#hubs > .hubs');
	$entryPoint = $('#hubsEntryPoint');

	function activateSubmenu(row) {
		var subMenuSelector, vertical;

		vertical = $(row).addClass('active').data('vertical');
		subMenuSelector = '.' + vertical + '-links';

		$(subMenuSelector, $hubLinks).addClass('active');
	}

	function deactivateSubmenu(row) {
		$('> section', $hubLinks).add(row).removeClass('active');
	}

	/**
	 * menuAim is a method from an external module to handle dropdown menus with very good user experience
	 * @see https://github.com/Wikia/js-menu-aim
	 */
	menuAim(
		$verticals.get( 0 ), {
			activeRow:  $verticals.find( '.active' ).get( 0 ),
			rowSelector: 'nav',
			tolerance: 85,
			activate: activateSubmenu,
			deactivate: deactivateSubmenu
		});


	delayedHover(
		$entryPoint.get(0),
		{
			checkInterval: 100,
			maxActivationDistance: 20,
			onActivate: function () {
				$entryPoint.addClass('active');

				if (!GlobalNavLazyLoad.isMenuWorking()) {
					GlobalNavLazyLoad.getHubLinks();
				}
			},
			onDeactivate: function() {
				$entryPoint.removeClass('active');
			}
		}
	);
});
