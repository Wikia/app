require( ['jquery', 'wikia.globalnavigation.lazyload'], function( $, GlobalNavLazyLoad ){
	'use strict';
	var $entryPoint, $hubLinks, $hubs, $verticals;

	$hubs = $( '#hubs' );
	$hubLinks = $hubs.find( '> .hub-links' );
	$verticals = $hubs.find( '> .hub-list' );
	$entryPoint = $( '#hubsEntryPoint' );

	function activateSubmenu( row ) {
		var subMenuSelector, vertical;

		vertical = $( row ).addClass( 'active' ).data( 'vertical' );
		subMenuSelector = '.' + vertical + '-links';

		$( subMenuSelector, $hubLinks ).addClass( 'active' );
	}

	function deactivateSubmenu( row ) {
		$( '> section', $hubLinks ).add( row ).removeClass( 'active' );
	}

	/**
	 * menuAim is a method from an external module to handle dropdown menus with very good user experience
	 * @see https://github.com/Wikia/js-menu-aim
	 */
	window.menuAim(
		$verticals.get( 0 ), {
			activeRow:  $verticals.find( '.active' ).get( 0 ),
			rowSelector: 'nav',
			tolerance: 85,
			activate: activateSubmenu,
			deactivate: deactivateSubmenu
		});

	function openMenu() {
		$entryPoint.addClass( 'active' );
		window.transparentOut.show();

		if (!GlobalNavLazyLoad.isMenuWorking()) {
			GlobalNavLazyLoad.getHubLinks();
		}
	}

	function closeMenu() {
		$entryPoint.removeClass( 'active' );
		window.transparentOut.hide();
	}

	window.transparentOut.bindClick(closeMenu);

	if ( !window.touchstart ) {
		window.delayedHover(
			$entryPoint.get( 0 ),
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu
			}
		);
	} else {
		$entryPoint.click(openMenu);
	}
});
