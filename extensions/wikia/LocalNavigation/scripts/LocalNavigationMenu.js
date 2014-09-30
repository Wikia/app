(function($) {
	'use strict';
	var $entryPoints, $localNavStart, $localNav, $window,
		windowWidth, localNavCache = [];

	$localNav = $('#localNavigation');
	$entryPoints = $localNav.find('.local-nav-entry');
	$localNavStart = $localNav.find('.first');
	$window = $(window);
	windowWidth = $window.width();

	function init(){
		var secondLvlNav, secondLvlNavWidth = 0, secondLvlNavOffset = 0,
			thirdLvlWidth = 0, thirdLvlMaxWidth = 0;

		$('> li', $localNavStart).each(function(i){
			secondLvlNav = $('> ul', this);
			secondLvlNavWidth = secondLvlNav.outerWidth();
			secondLvlNavOffset = secondLvlNav.offset().left;

			$('> li', secondLvlNav).each(function(){
				thirdLvlWidth = $('> ul', this).outerWidth();
				if ( thirdLvlWidth > thirdLvlMaxWidth ) {
					thirdLvlMaxWidth = thirdLvlWidth;
				}
			});

			localNavCache.push({
				width: secondLvlNavWidth + secondLvlNavOffset + thirdLvlMaxWidth,
				menuElement: secondLvlNav
			});

			if ( secondLvlNavWidth + secondLvlNavOffset + thirdLvlMaxWidth > windowWidth ) {
				secondLvlNav.addClass('right');
			} else {
				secondLvlNav.removeClass('right');
			}
		});
	}

	function recalculateSwap() {
		var i, arrayLength = localNavCache.length;
		windowWidth = $window.width();

		if ( arrayLength ) {
			for (i = 0; i < arrayLength; i++ ) {
				if ( localNavCache[i].width > windowWidth ) {
					localNavCache[i].menuElement.addClass('right');
				} else {
					localNavCache[i].menuElement.removeClass('right');
				}
			}
		} else {
			init();
		}
	}

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

	$(window).load(function(){
		init();
	});

	$(window).resize(recalculateSwap);

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
