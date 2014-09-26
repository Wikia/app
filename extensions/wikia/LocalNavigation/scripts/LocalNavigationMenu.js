(function($) {
	'use strict';
	var $entryPoints, $localNavStart, $localNav;

	$localNav = $('#localNavigation');
	$entryPoints = $localNav.find('.local-nav-entry');
	$localNavStart = $localNav.find('.first');

	function openMenu() {
		var $target;
		$target = $(this);

		$target.addClass( 'active' );
	}

	function closeMenu() {
		var $target;
		$target = $(this);

		$target.removeClass( 'active' );
	}

	window.menuAim(
		$localNavStart.get( 0 ), {
			activeRow:  $localNavStart.find( '.active' ).get( 0 ),
			rowSelector: '.local-nav-entry',
			tolerance: 85,
		});

	if ( !window.ontouchstart ) {
		window.delayedHover(
			$entryPoints,
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu,
				activateOnClick: false
			}
		);
	} else {
		$entryPoints.click(openMenu);
	}

})(jQuery);
