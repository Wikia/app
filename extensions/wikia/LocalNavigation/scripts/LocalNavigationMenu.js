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
		var self, secondLvlNavWidth = 0, secondLvlNavOffset = 0,
			thirdLvlWidth = 0, thirdLvlMaxWidth = 0;

		$localNavSecondLevel.each(function(){
			self = $(this);
			secondLvlNavWidth = self.outerWidth();
			secondLvlNavOffset = self.offset().left;

			$('> li', self).each(function(){
				thirdLvlWidth = $('> ul', this).outerWidth();
				if ( thirdLvlWidth > thirdLvlMaxWidth ) {
					thirdLvlMaxWidth = thirdLvlWidth;
				}
			});

			localNavCache.push({
				width: secondLvlNavWidth + secondLvlNavOffset + thirdLvlMaxWidth,
				menuElement: self
			});

			if ( secondLvlNavWidth + secondLvlNavOffset + thirdLvlMaxWidth > windowWidth ) {
				self.addClass('right');
			} else {
				self.removeClass('right');
			}
		});

		attachMenuAim();
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

	function attachMenuAim() {
		var i, alwaysTrueFunc;

		alwaysTrueFunc = function() {
			return true;
		};

		for (i=0; i<$localNavSecondLevel.length; i++ ) {
			window.menuAim(
				$localNavSecondLevel[i],{
					activate: openSubmenu,
					deactivate: closeSubmenu,
					rowSelector: '.second-level-row',
					exitMenu: alwaysTrueFunc
				}
			);
		}
	}

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

	$window.resize(function(){
		window.Wikia.EventsHelper.waitForFinalEvent(recalculateSwap, 300, 'localNavigation');
	});

	init();
})(jQuery);
