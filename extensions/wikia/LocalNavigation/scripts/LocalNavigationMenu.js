(function($) {
	'use strict';

	var $localNavFirstLevel, $localNavSecondLevel, $localNav, $localNavStart, $window,
		windowWidth, $openedMenu, $openedSubmenu, localNavCache = [], alwaysReturnTrueFunc;

	$localNav = $('#localNavigation');
	$localNavStart = $localNav.find('.first-level-menu');
	$localNavFirstLevel = $localNavStart.find('> .local-nav-entry');
	$localNavSecondLevel = $localNav.find('.second-level-menu');
	$window = $(window);
	windowWidth = $window.width();

	function init(){
		var self, dropdownOffset = 0, secondLvlNavWidth = 0, secondLvlNavOffset = 0,
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

			dropdownOffset = secondLvlNavWidth + secondLvlNavOffset + thirdLvlMaxWidth;

			localNavCache.push({
				width: dropdownOffset,
				menuElement: self
			});

			if ( dropdownOffset > windowWidth ) {
				self.addClass('right');
			} else {
				self.removeClass('right');
			}
		});

		attachMenuAim();
	}

	function recalculateDropdownDirection() {
		var i, arrayLength = localNavCache.length;
		windowWidth = $window.width();

		if ( arrayLength ) {
			for ( i = 0; i < arrayLength; i++ ) {
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
		$(this).addClass('active');
	}

	function closeMenu() {
		$(this).removeClass('active');
	}

	function openSubmenu(row) {
		$(row).addClass('active');
	}

	function closeSubmenu( row ) {
		$(row).removeClass('active');
	}

	function handleOpenMenuClick(event) {
		var $target = $(event.currentTarget);

		event.preventDefault();
		event.stopPropagation();

		if (!$target.hasClass('active')) {
			if ($openedMenu !== undefined) {
				$openedMenu.removeClass('active');
			}
			$target.addClass('active');
		}
		$('body').one('click', handleCloseMenuClick);
		$openedMenu = $target;
	}

	function handleCloseMenuClick(event) {
		var $target = $(event.currentTarget);

		if ($target.closest($localNav).length === 0 && $openedMenu !== undefined) {
			$openedMenu.removeClass('active');
			$openedMenu = undefined;
		}
	}

	function handleSubmenuClick(event) {
		var $target = $(event.target),
			$targetMenuItem;

		$targetMenuItem = $target.closest('.second-level-row');
		event.stopPropagation();

		if (
			!$targetMenuItem.hasClass('active') &&
			$target.closest('.has-more').length > 0 ||
			$target.find('a').first().attr('href') === '#'
		) {
			event.preventDefault();
			if ($openedSubmenu !== undefined) {
				$openedSubmenu.removeClass('active');
			}
			$targetMenuItem.addClass('active');
		}
	}

	function attachMenuAim() {
		var i;

		for ( i = 0; i < $localNavSecondLevel.length; i++ ) {
			window.menuAim(
				$localNavSecondLevel[i],{
					activate: openSubmenu,
					deactivate: closeSubmenu,
					rowSelector: '.second-level-row',
					exitMenu: alwaysReturnTrueFunc,
					submenuDirection: getMenuAimDirection($localNavSecondLevel[i])
				}
			);
		}
	}

	function getMenuAimDirection($localNavSecondLevel) {
		var dropdownDirection = 'right';

		if ($localNavSecondLevel.classList.contains('right')) {
			dropdownDirection = 'left';
		}

		return dropdownDirection;
	}

	alwaysReturnTrueFunc = function() {
		return true;
	};

	if (!window.Wikia.isTouchScreen()) {
		window.delayedHover(
			$localNavFirstLevel,
			{
				onActivate: openMenu,
				onDeactivate: closeMenu,
				activateOnClick: false
			}
		);
	} else {
		$localNavFirstLevel.click(handleOpenMenuClick);
		$localNavSecondLevel.find('.second-level-row').click(handleSubmenuClick);
	}

	$window.on('resize', $.debounce(300, recalculateDropdownDirection));

	init();
})(jQuery);
