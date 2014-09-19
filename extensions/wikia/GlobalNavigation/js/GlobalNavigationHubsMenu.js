require( ['jquery', 'wikia.globalnavigation.lazyload'], function( $, GlobalNavLazyLoad ){
	'use strict';
	var $entryPoint, $hubLinks, $hubs, $verticals, $moreLinks;

	function activateSubmenu( row ) {
		var vertical;

		vertical = $( row ).addClass( 'active' ).data( 'vertical' );

		$( '.' + vertical + '-links', $hubLinks ).addClass( 'active' );
		$( '.' + vertical + '-more', $moreLinks ).addClass( 'active' );
	}

	function deactivateSubmenu( row ) {
		$( '> section', $hubLinks ).add( '> a', $moreLinks ).add( row ).removeClass( 'active' );
	}

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

	$(function(){
		$hubs = $( '#hubs' );
		$hubLinks = $hubs.find( '> .hub-links' );
		$verticals = $hubs.find( '> .hub-list' );
		$moreLinks = $hubs.find( '> .hub-more' );
		$entryPoint = $( '#hubsEntryPoint' );

		window.transparentOut && window.transparentOut.bindClick( closeMenu );

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
});
