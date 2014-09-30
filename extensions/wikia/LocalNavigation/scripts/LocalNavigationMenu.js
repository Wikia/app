(function($) {
	'use strict';

	var $localNavFirstLevel, $localNavSecondLevel, $localNav, $localNavStart, $window,
		windowWidth, localNavCache = [];

	$localNav = $('#localNavigation');
	$localNavStart = $localNav.find('.first');
	$localNavFirstLevel = $localNavStart.find('> .local-nav-entry');
	$localNavSecondLevel = $localNav.find('.second');
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

	function openSubmenu( row ) {
		$(row).addClass('active');
	}

	function closeSubmenu( row ) {
		$(row).removeClass('active');
	}

	window.menuAim(
		$localNavSecondLevel.get(0),
		{
			activate: openSubmenu,
			deactivate: closeSubmenu,
			rowSelector: '.second-level-row'
		}
	);

	if ( !window.ontouchstart ) {
		window.delayedHover(
			$localNavFirstLevel,
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu,
				activateOnClick: false
			}
		);
	} else {
		$localNavSecondLevel.click(openMenu);
	}

	$(window).load(function(){
		init();
	});

	$(window).resize(recalculateSwap);

})(jQuery);
