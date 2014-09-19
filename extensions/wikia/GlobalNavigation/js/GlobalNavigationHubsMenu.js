require( ['jquery', 'wikia.globalnavigation.lazyload'], function( $, GlobalNavLazyLoad ){
	'use strict';
	var $entryPoint, $hubLinks, $hubs, $verticals;

	function activateSubmenu( row ) {
		var subMenuSelector, vertical;

		vertical = $( row ).addClass( 'active' ).data( 'vertical' );
		subMenuSelector = '.' + vertical + '-links';

		$( subMenuSelector, $hubLinks ).addClass( 'active' );
	}

	function deactivateSubmenu( row ) {
		$( '> section', $hubLinks ).add( row ).removeClass( 'active' );
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
		$entryPoint = $( '#hubsEntryPoint' );

		window.transparentOut && window.transparentOut.bindClick( closeMenu );

		$entryPoint.on('click touchstart', '.hubs-entry-point', function(ev) {
			ev.preventDefault();
			ev.stopPropagation();

			if ( $entryPoint.hasClass('active') ) {
				closeMenu();
			} else {
				openMenu();
			}
		});

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
					onDeactivate: closeMenu,
					activateOnClick: false
				}
			);
		} else {
			$entryPoint.click(openMenu);
		}
	});
});
